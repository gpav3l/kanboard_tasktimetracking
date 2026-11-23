<?php

namespace Kanboard\Plugin\TaskTimeTracking\Helper;

use Kanboard\Core\Base;
use Kanboard\Plugin\TaskTimeTracking\Model\TaskTimeTrackingModel;

class TaskTimeTrackingHelper extends Base
{
    private function model()
    {
        return new TaskTimeTrackingModel($this->container);
    }

    public function getActiveTimer($taskId)
    {
        return $this->model()->getActiveTimer($taskId, $this->userSession->getId());
    }

    public function getTotalSeconds($taskId)
    {
        return $this->model()->getTotalSeconds($taskId);
    }

    public function hasSubtasks($taskId)
    {
        return $this->model()->hasSubtasks($taskId);
    }
}
