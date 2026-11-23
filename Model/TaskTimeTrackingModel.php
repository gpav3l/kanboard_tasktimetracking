<?php

namespace Kanboard\Plugin\TaskTimeTracking\Model;

use Kanboard\Core\Base;

class TaskTimeTrackingModel extends Base
{
    const TABLE = 'task_time_tracking';

    public function getActiveTimer($taskId, $userId)
    {
        return $this->db->table(self::TABLE)
        ->eq('task_id', $taskId)
        ->eq('user_id', $userId)
        ->isNull('end')
        ->findOne();
    }

    public function hasSubtasks($taskId)
    {
        return $this->db->table('subtasks')
        ->eq('task_id', $taskId)
        ->count() > 0;
    }

    public function start($taskId, $userId)
    {
        if ($this->hasSubtasks($taskId)) {
            return false; // timer disabled for tasks with subtasks
        }

        if ($this->getActiveTimer($taskId, $userId)) {
            return false;
        }

        return $this->db->table(self::TABLE)->insert([
            'task_id' => $taskId,
            'user_id' => $userId,
            'start'   => time(),
        ]);
    }

    /**
     * Stops the active timer, adds elapsed time to tasks.time_spent (hours).
     * Returns elapsed seconds, or false if there was no active timer.
     */
    public function stop($taskId, $userId)
    {
        $active = $this->getActiveTimer($taskId, $userId);
        if (!$active) {
            return false;
        }

        $now = time();

        $this->db->table(self::TABLE)
        ->eq('id', $active['id'])
        ->update(['end' => $now]);

        $seconds = max(0, $now - (int) $active['start']);

        $task = $this->db->table('tasks')->eq('id', $taskId)->findOne();
        $currentHours = $task ? (float) $task['time_spent'] : 0;

        $this->db->table('tasks')
        ->eq('id', $taskId)
        ->update(['time_spent' => round($currentHours + $seconds / 3600, 4)]);

        return $seconds;
    }

    public function getTotalSeconds($taskId)
    {
        $rows = $this->db->table(self::TABLE)
        ->eq('task_id', $taskId)
        ->notNull('end')
        ->findAll();

        $total = 0;
        foreach ($rows as $row) {
            $total += $row['end'] - $row['start'];
        }
        return $total;
    }
}
