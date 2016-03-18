<div class="page-header">
    <h2><?= t('Remove Metadata') ?></h2>
</div>

<div class="confirm">
    <p class="alert alert-info">
        <?= t('Do you really want to remove this metadata?') ?>
    </p>

    <p><strong><?= $key; ?></strong></p>

    <div class="form-actions">
        <?= $this->url->link(t('Yes'), 'metadata', 'removeUser', array('plugin' => 'metadata','user_id' => $user['id'], 'key' => $key), true, 'btn btn-red') ?>
        <?= t('or') ?>
        <?= $this->url->link(t('cancel'), 'metadata', 'user', array('plugin' => 'metadata', 'user_id' => $user['id'])) ?>
    </div>
</div>
