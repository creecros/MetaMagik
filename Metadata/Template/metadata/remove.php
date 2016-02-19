<div class="page-header">
    <h2><?= t('Remove Metadata') ?></h2>
</div>

<div class="confirm">
    <p class="alert alert-info">
        <?= t('Do you really want to remove this metadata?') ?>
    </p>

    <p><strong><?= $key; ?></strong></p>

    <div class="form-actions">
        <?= $this->url->link(t('Yes'), 'metadata', 'remove', array('plugin' => 'metadata','id' => $id, 'type' => $type, 'key' => $key), true, 'btn btn-red') ?>
    </div>
</div>