<li <?= $this->app->checkMenuSelection('MetadataTypes', 'config', 'Metadata') ?>>
    <?= $this->url->link(t('Metadata Types'), 'MetadataTypes', 'config', array('plugin' => 'Metadata')) ?>
</li>