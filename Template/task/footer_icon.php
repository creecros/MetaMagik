<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
if (count(array_filter($metadata)) > 0):
?>
        <span title="<?= t('Metadata') ?>" class="tooltip" data-href="<?= $this->url->href('MetadataController', 'task_footer', ['plugin' => 'metaMagik', 'task_id' => $task['id'], 'project_id' => $task['project_id']]) ?>">
            <i class="fa fa-plus-square-o fa-fw"></i><?= count(array_filter($metadata)) ?>
        </span>
<?php endif ?>
