    <ul>
        <li>
        <i class="fa fa-plus-square-o fa-fw"></i>
        <?= $this->url->link(t('Metadata'), 'MetadataController', 'task', ['plugin' => 'metaMagik', 'task_id' => $task['id'], 'project_id' => $task['project_id']]) ?>
        </li>
    </ul>
