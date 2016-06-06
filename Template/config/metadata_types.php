<div class="page-header">
    <h2><?= t('Metadata Types') ?></h2>
</div>

<form id="metadata-type-creation-form" method="post" action="<?= $this->url->href('MetadataTypesController', 'config', array('plugin' => 'Metadata')) ?>" autocomplete="off">
    <?= $this->form->label(t('Name'), 'human_name') ?>
    <?= $this->form->text('human_name', $values, $errors, array('required')) ?>

    <?= $this->form->label(t('Type'), 'data_type') ?>
    <?= $this->form->select('data_type', array(
        '' => '--',
        'text' => 'Text',
        'integer' => 'Integer'
    ), $values, $errors, array('required')) ?>


    <?= $this->form->checkbox('is_required', 'Is required?', '1', []) ?>

    <?= $this->form->label(t('Attached Entity'), 'attach_to') ?>
    <?= $this->form->select('attached_to', array(
        '' => '--',
        'user' => 'User',
        'project' => 'Project',
        'task' => 'Task'
    ), $values, $errors, array('required')) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
    </div>

    <?= $this->form->csrf() ?>
</form>
<hr>
<?php if(!empty($types)): ?>
    <table class="table-stripped">
        <tr>
            <th>Friendly Name</th>
            <th>Type</th>
            <th>Required</th>
            <th>Entity</th>
        </tr>
        <?php foreach($types as $type): ?>
            <tr>
                <td><?= $type['human_name'] ?></td>
                <td><?= $type['data_type'] ?></td>
                <td><?= $type['is_required'] ?></td>
                <td><?= $type['attached_to'] ?></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php else: ?>
    <div class="listing">
        <?= t('No types have been defined yet.') ?>
    </div>
<?php endif ?>

