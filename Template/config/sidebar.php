<li <?= $this->app->checkMenuSelection('MetadataTypes', 'config', 'Metadata') ?>>
    <?= $this->url->link(t('Metadata Types'), 'MetadataTypesController', 'config', array('plugin' => 'Metadata')) ?>
</li>