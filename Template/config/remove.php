<div class="page-header">
    <h2><?= t('Remove Metadata Task Field') ?></h2>
</div>

<div class="confirm">
    <p class="alert alert-info">
        <?= t('Do you really want to remove this metadata?') ?>
    </p>

    <p><strong><?= $key; ?></strong></p>

    <div class="form-actions">
        <?= $this->url->link(t('Yes'), 'MetadataTypesController', 'removeTask', ['plugin' => 'metaMagik', 'key' => $key], true, 'btn btn-red') ?>
    </div>
</div>
