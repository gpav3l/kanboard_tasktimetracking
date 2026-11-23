<?php

namespace Kanboard\Plugin\TaskTimeTracking;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        $this->helper->register('taskTimeTracking', '\Kanboard\Plugin\TaskTimeTracking\Helper\TaskTimeTrackingHelper');

        $this->route->addRoute('task/:task_id/timer/start', 'TaskTimeTrackingController', 'start', 'TaskTimeTracking');
        $this->route->addRoute('task/:task_id/timer/stop', 'TaskTimeTrackingController', 'stop', 'TaskTimeTracking');

        $this->template->hook->attach('template:task:sidebar:information', 'TaskTimeTracking:task/sidebar');
    }

    public function getPluginName()
    {
        return 'TaskTimeTracking';
    }

    public function getPluginDescription()
    {
        return 'Start/stop time tracking directly on tasks';
    }

    public function getPluginAuthor()
    {
        return 'Pavel Gorbokonenko + Ai';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getCompatibleVersion()
    {
        return '>=1.2.57';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/yourname/kanboard-task-timetracking';
    }
}
