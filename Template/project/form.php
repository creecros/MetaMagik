<h2><?= $form_headline ?></h2>
<form method="post" action="<?= $this->url->href('MetadataController', 'saveProject', ['plugin' => 'metadata', 'project_id' => $project['id']]) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?= $this->form->text('key', $values, [], ['required', 'placeholder="'.t('Key').'"']) ?>
    <?= $this->form->text('value', $values, [], ['required', 'placeholder="'.t('Value').'"']) ?>
    
    <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
</form>