<div class="page-header">
    <h2><?= t('Task Metadata Types') ?></h2>
</div>

<form id="metadata-type-creation-form" method="post" action="<?= $this->url->href('MetadataTypesController', 'config', ['plugin' => 'MetaMagik']) ?>" autocomplete="off">
    <?= $this->form->label(t('Name'), 'human_name') ?>
    <?= $this->form->text('human_name', $values, $errors, ['required']) ?>

    <?= $this->form->label(t('Type'), 'data_type') ?>
    <?= $this->form->select('data_type', [
        ''        => '--',
        'text'    => 'Text',
        'list'    => 'Dropdown List',
        'radio'   => 'Radio List',
        'check'   => 'Checkbox Group',    
    ], $values, $errors, ['required']) ?>
    
    <?= $this->form->label(t('Options - comma seperated list for dropdown, radio, or checkbox group. 255 chars max.'), 'options') ?>
    <?= $this->form->text('options', $values, $errors) ?>


    <?= $this->form->checkbox('is_required', 'Is required?', '1', []) ?>

    <?= $this->form->label(t('Attached Entity'), 'attach_to') ?>
    <?= $this->form->select('attached_to', [
        ''        => '--',
        //'user'    => 'User',
        //'project' => 'Project',
        'task'    => 'Task',
    ], $values, $errors, ['required']) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
    </div>

    <?= $this->form->csrf() ?>
</form>
<hr>
<?php if (!empty($types)): ?>
    <table class="table-stripped">
        <tr>
            <th>Field Name</th>
            <th>Type</th>
            <th>Required</th>
            <th>Options</th>
            <th>Action</th>
        </tr>
        <?php foreach ($types as $type): ?>
            <tr>
                <td><?= $type['human_name'] ?></td>
                <td><?= $type['data_type'] ?></td>
                <td><?= $type['is_required'] ?></td>
                <td><?= $type['options'] ?></td>
                <td>
                   <ul>
                        <li>
                            <?= $this->modal->small('remove', t('Remove'), 'MetadataTypesController', 'confirmTask', ['plugin' => 'metaMagik', 'id' => $type['id']], false, 'popover') ?>
                        </li>
                    </ul>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
<?php else: ?>
    <div class="listing">
        <?= t('No types have been defined yet.') ?>
    </div>
<?php endif ?>

