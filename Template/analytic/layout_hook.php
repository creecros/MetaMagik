        <li <?= $this->app->checkMenuSelection('AnalyticExtensionController', 'fieldTotalDistribution', 'metaMagik') ?>>
            <?= $this->modal->replaceLink(t('Custom field total distribution'), 'AnalyticExtensionController', 'fieldTotalDistribution', array('plugin' => 'metaMagik', 'project_id' => $project['id'])) ?>
        </li>