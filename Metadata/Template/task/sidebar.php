<?php if ($this->user->hasProjectAccess('metadata', 'index', $project['id'])): ?>
    <li>
        <?= $this->url->link(t('Metadata'), 'metadata', 'task', array('plugin' => 'metadata', 'task_id' => $task['id'], 'project_id' => $task['project_id'])) ?>
    </li>
<?php endif ?>