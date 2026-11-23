<?php

namespace Kanboard\Plugin\TaskTimeTracking\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\TaskTimeTracking\Model\TaskTimeTrackingModel;

class TaskTimeTrackingController extends BaseController
{
    public function start()
    {
        $this->toggle(true);
    }

    public function stop()
    {
        $this->toggle(false);
    }

    private function toggle($isStart)
    {
        $taskId = $this->request->getIntegerParam('task_id');
        $task = $this->taskFinderModel->getById($taskId);

        if (!$task) {
            $this->response->redirect($this->helper->url->to('DashboardController', 'show'));
            return;
        }

        $model = new TaskTimeTrackingModel($this->container);
        $userId = $this->userSession->getId();

        if ($isStart) {
            if ($model->hasSubtasks($taskId)) {
                $this->flash->failure(t('Timer is disabled because the task has subtasks'));
            } elseif ($model->start($taskId, $userId)) {
                $this->flash->success(t('Timer started'));
            } else {
                $this->flash->failure(t('Timer is already running'));
            }
        } else {
            $seconds = $model->stop($taskId, $userId);

            if ($seconds === false) {
                $this->flash->failure(t('No active timer'));
            } else {
                $this->flash->success(
                    t('Timer stopped') . ' (+' . round($seconds / 3600, 2) . ' h ' . t('added to time spent') . ')'
                );
            }
        }

        $this->response->redirect($this->helper->url->to('TaskViewController', 'show', [
            'task_id'    => $taskId,
            'project_id' => $task['project_id'],
        ]));
    }
}
