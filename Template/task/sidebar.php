<?php
$active      = $this->helper->taskTimeTracking->getActiveTimer($task['id']);
$total       = $this->helper->taskTimeTracking->getTotalSeconds($task['id']);
$hasSubtasks = $this->helper->taskTimeTracking->hasSubtasks($task['id']);

$params = ['plugin' => 'TaskTimeTracking', 'task_id' => $task['id']];
?>

<div class="sidebar-section">
<h3><?= t('Time tracking') ?></h3>

<?php if ($active): ?>
<p><?= t('Running since') ?> <?= date('H:i:s', $active['start']) ?></p>
<a href="<?= $this->url->href('TaskTimeTrackingController', 'stop', $params) ?>"
class="btn btn-red"><?= t('Stop timer') ?></a>

<?php elseif ($hasSubtasks): ?>
<button class="btn btn-blue" disabled><?= t('Start timer') ?></button>
<p><em><?= t('Timer is disabled because the task has subtasks') ?></em></p>

<?php else: ?>
<a href="<?= $this->url->href('TaskTimeTrackingController', 'start', $params) ?>"
class="btn btn-blue"><?= t('Start timer') ?></a>
<?php endif ?>

<p><?= t('Total tracked:') ?> <?= gmdate('H:i:s', $total) ?></p>
</div>
