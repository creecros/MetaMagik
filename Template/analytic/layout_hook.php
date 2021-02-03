        <li <?= $this->app->checkMenuSelection('AnalyticExtensionController', 'fieldTotalDistribution', 'metaMagik') ?>>
            <?= $this->modal->replaceLink(t('Custom field total distribution for open tasks'), 'AnalyticExtensionController', 'fieldTotalDistribution', array('plugin' => 'metaMagik', 'project_id' => $project['id'])) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('AnalyticExtensionController', 'fieldTotalDistributionRange', 'metaMagik') ?>>
            <?= $this->modal->replaceLink(t('Custom field total distribution with date range'), 'AnalyticExtensionController', 'fieldTotalDistributionRange', array('plugin' => 'metaMagik', 'project_id' => $project['id'])) ?>
        </li>