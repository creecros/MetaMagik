<li <?= $this->app->checkMenuSelection('MetadataTypes', 'config', 'Metadata') ?>>
    <?= $this->url->link(t('Custom Fields'), 'MetadataTypesController', 'config', ['plugin' => 'MetaMagik']) ?>
</li>
