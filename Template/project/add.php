<form method="post" action="<?= $this->url->href('metadata', 'addProject', array('plugin' => 'metadata', 'project_id' => $project['id'])) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?= $this->form->text('key', array(), array(), array('required', 'placeholder="'.t('Key').'"')) ?>
    <?= $this->form->text('value', array(), array(), array('required', 'placeholder="'.t('Value').'"')) ?>
    
    <input type="submit" value="<?= t('Add') ?>" class="btn btn-blue"/>
</form>