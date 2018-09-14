<div class="page-header">
    <h2><?= t('Remove Metadata Task Field') ?></h2>
</div>

<div class="confirm">
    <p class="alert alert-info">
        <?= t('Do you really want to remove this metadata?') ?>
    </p>

    <p><strong><?= $key; ?></strong></p>

    <div class="form-actions">
        <?= $this->url->link(t('Yes'), 'MetadataTypeController', 'removeTask', ['plugin' => 'metaMagik', 'id' => $key], true, 'btn btn-red') ?>
        <?= t('or') ?>
        <?= $this->url->link(t('cancel'), 'MetadataTypeController', 'config', ['plugin' => 'metaMagik']) ?>
    </div>
</div>
