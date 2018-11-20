<div class="page-header">
    <h2><?= t('Custom Fields') ?></h2>
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
        'users'   => 'User List',
        'table'   => 'Key-value from DB',
        'number'  => 'Number',
    ], $values, $errors, ['required']) ?>
    
    <?= $this->form->label(t('Options - comma seperated list for dropdown, radio, or checkbox group. 255 chars max.'), 'options') ?>
    <?= $this->form->text('options', $values, $errors) ?>

    <?= $this->form->label(t('Column'), 'column_number') ?>
    <?= $this->form->select('column_number', [
        '1' => '1',
        '2' => '2',
        '3' => '3',
    ], $values, $errors, ['required']) ?>

    <?= $this->form->label(t('Required'), 'is_required') ?>
    <?= $this->form->checkbox('is_required', t('Required'), 1, true) ?>

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
<table
       class="metadata-table table-striped table-scrolling"
       data-save-position-url="<?= $this->url->href('MetadataTypesController', 'movePosition', array('plugin' => 'metaMagik')) ?>"
>
    <thead>
        <tr>
            <th><?= t('Field Name') ?></th>
            <th><?= t('Type') ?></th>
            <th><?= t('Options') ?></th>
            <th><?= t('Action') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($types as $type): 
        $key = $type['id']
        ?>
            <tr data-metadata-id="<?= $type['id'] ?>">
                <td>
                    <i class="fa fa-arrows-alt draggable-row-handle ui-sortable-handle" title="Change metadata position"></i>&nbsp;
                    <?= $type['human_name'] ?>
                </td>
                <td><?= $type['data_type'] ?></td>
                <td><?= $type['options'] ?></td>
                <td>
                   <ul>
                        <li>
                            <?= $this->modal->small('remove', t('Remove'), 'MetadataTypesController', 'confirmTask', ['plugin' => 'metaMagik', 'key' => $key], false, 'popover') ?>
                        </li>
                    </ul>
                </td>
            </tr>
        <?php endforeach ?>
</tbody>
</table>
<?php else: ?>
    <div class="listing">
        <?= t('No types have been defined yet.') ?>
    </div>
<?php endif ?>

