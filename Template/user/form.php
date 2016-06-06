<h2><?= $form_headline ?></h2>
<form method="post" action="<?= $this->url->href('MetadataController', 'saveUser', array('plugin' => 'metadata', 'user_id' => $user['id'])) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?= $this->form->text('key', $values, array(), array('required', 'placeholder="'.t('Key').'"')) ?>
    <?= $this->form->text('value', $values, array(), array('required', 'placeholder="'.t('Value').'"')) ?>
    
    <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
</form>