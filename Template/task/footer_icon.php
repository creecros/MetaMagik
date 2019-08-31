<?php
if ($task['nb_metadata'] > 0):
?>
        <span title="<?= t('Metadata') ?>" class="tooltip" data-href="<?= $this->url->href('MetadataController', 'task_footer', ['plugin' => 'metaMagik', 'task_id' => $task['id'], 'project_id' => $task['project_id']]) ?>">
            <i class="fa fa-plus-square-o fa-fw"></i><?= $task['nb_metadata'] ?>
        </span>
<?php endif ?>
