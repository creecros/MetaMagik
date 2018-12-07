<div class="page-header">
    <h2><?= t('Metadata') ?></h2>
</div>


<?php if (empty($metadata)): ?>
    <p class="alert"><?= t('No metadata') ?></p>
<?php else: ?>
    <table class="table-small table-fixed">
    <tr>
        <th class="column-40"><?= t('Key') ?></th>
        <th class="column-40"><?= t('Value') ?></th>
        <?php if ($this->user->hasProjectAccess('metadata', 'index', $task['project_id'])): ?>
        <th class="column-20"><?= t('Action') ?></th>
        <?php endif ?>
    </tr>
    <?php foreach ($metadata as $key => $value): ?>
    <?php if (!empty($value)): ?>
    <tr>
        <td><?= $key ?></td>
        <td><?= $value ?></td>
        <?php if ($this->user->hasProjectAccess('metadata', 'index', $task['project_id'])): ?>
        <td>
            <ul>
                <li>
                    <?= $this->modal->small('remove', t('Remove'), 'MetadataController', 'confirmTask', ['plugin' => 'metaMagik', 'task_id' => $task['id'], 'project_id' => $project['id'], 'key' => $key], false, 'popover') ?>
                </li>
                <li>
                    <?= $this->modal->small('edit', t('Edit'), 'MetadataController', 'editTask', ['plugin' => 'metaMagik', 'task_id' => $task['id'], 'project_id' => $project['id'], 'key' => $key], false, 'popover') ?>
                </li>
            </ul>
        </td>
        <?php endif ?>
    </tr>
    <?php endif ?>
    <?php endforeach ?>
    </table>
<?php endif ?>

<?php if ($add_form): ?>
<?= $this->render('metaMagik:task/form', ['task' => $task, 'project' => $project, 'form_headline' => t('Add Metadata'), 'values' => []]) ?>
<?php endif ?>
