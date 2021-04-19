<form id="metadata-type-creation-form" method="post" action="<?= $this->url->href('MetadataTypesController', 'updateType', ['plugin' => 'MetaMagik']) ?>" autocomplete="off">
    <input type="hidden" id="id" name="id" value="<?= $values['id'] ?>">
    <input type="hidden" id="old_name" name="old_name" value="<?= $values['human_name'] ?>">
    <?= $this->form->label(t('Name'), 'human_name') ?>
    <?= $this->form->text('human_name', $values, $errors, ['required']) ?>
    <p><?= e('You may not use spaces, but underscores will be converted to spaces for field labels, for those who care.') ?></p>
    <?= $this->form->label(t('Type'), 'data_type') ?>
    <?= $this->form->select('data_type', [
        ''        => '--',
        'text'    => 'Text',
        'textarea'    => 'Text Area',
        'list'    => 'Dropdown List',
        'radio'   => 'Radio List',
        'check'   => 'Checkbox Group',
        'users'   => 'User List',
        'table'   => 'Key-value from DB',
        'columneqcriteria'   => 'Column from DB, based on equals Criteria',
        'number'  => 'Number',
        'date'  => 'Date',
    ], $values, $errors, ['required']) ?>
    
    <?= $this->form->label(t('Options'), 'options') ?>
    <?= $this->form->text('options', $values, $errors) ?>
    <p><?= e('Example: <code>value1,value2,value3</code> for list types. For Key-value from DB: <code>tablename,keycolumn,valuecolumn</code>.') ?></p>
    <p><?= e('Example: For Column from DB, based on equals Criteria: <code>tablename,criteria_column,criteria,value_column</code>.') ?></p>
    <p><?= e('Example: For Numbers, anything in the Options field will show up before the value, for instance, to add a dollar sign before the number.') ?></p>

    <?= $this->form->label(t('Column'), 'column_number') ?>
    <?= $this->form->select('column_number', [
        '1' => '1',
        '2' => '2',
        '3' => '3',
    ], $values, $errors, ['required']) ?>

    <?= $this->form->label(t('Required'), 'is_required') ?>
    <?= $this->form->checkbox('is_required', t('Required'), 1, $values['is_required']) ?>
    
    <?= $this->form->label(t('Include as Footer Icon?'), 'footer_inc') ?>
    <?= $this->form->checkbox('footer_inc', t('Include'), 1, $values['footer_inc']) ?>
    
    <?php $projects = $this->task->projectModel->getAllByStatus(1);
          $projectList = array(0 => 'Global'); ?>
    <?php 
          foreach($projects as $project) { 
            $projectList[$project['id']] = $project['name'];
          } 
    ?>

    <?= $this->form->label(t('Project scope:'), 'attach_to') ?>
    <?= $this->form->select('attached_to', $projectList, $values, $errors, ['required']) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
    </div>

    <?= $this->form->csrf() ?>
</form>