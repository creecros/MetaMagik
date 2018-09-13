<div class="page-header">
    <h2><?= t('Metadata') ?></h2>
</div>


<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
if (empty($metadata)): 
?>
    <p class="alert"><?= t('No metadata') ?></p>
<?php else: ?>
<div class="meta-summary-container color-<?= $task['color_id'] ?>">
    <table class="table-small table-fixed">
    <tr>
        <th class="column-40"><?= t('Key') ?></th>
        <th class="column-40"><?= t('Value') ?></th>
        <th class="column-20"><?= t('Action') ?></th>
    </tr>
    <?php foreach ($metadata as $key => $value): ?>
    <tr>
        <td><?= $key ?></td>
        <td><?= $value ?></td>
        <td>
            <ul>
                <li>
                    <?= $this->url->link(t('Remove'), 'MetadataController', 'confirmTask', ['plugin' => 'metaMagik', 'task_id' => $task['id'], 'project_id' => $project['id'], 'key' => $key], false, 'popover') ?>
                </li>
                <li>
                    <?= $this->url->link(t('Edit'), 'MetadataController', 'editTask', ['plugin' => 'metaMagik', 'task_id' => $task['id'], 'project_id' => $project['id'], 'key' => $key], false, 'popover') ?>
                </li>
            </ul>
        </td>
    </tr>
    <?php endforeach ?>
    </table>
</div>
<?php endif ?>
