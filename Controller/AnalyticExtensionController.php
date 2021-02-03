<?php

namespace Kanboard\Plugin\MetaMagik\Controller;

use Kanboard\Filter\TaskProjectFilter;
use Kanboard\Model\TaskModel;
use Kanboard\Plugin\MetaMagik\Analytics\CustomFieldAnalytics;
use Kanboard\Controller\BaseController;

/**
 * Project Analytic Controller
 *
 * @package  Kanboard\Controller
 * @author   Frederic Guillot
 */
class AnalyticExtensionController extends BaseController
{
    /**
     * Show tasks distribution graph
     *
     * @access public
     */
    public function fieldTotalDistribution()
    {
        
        $project = $this->getProject();
        
        $this->response->html($this->helper->layout->analytic('metaMagik:analytic/custom_field_totals', array(
            'project' => $project,
            'metrics' => $this->customFieldAnalytics->build($project['id']),
            'title' => t('Custom Field Total distribution'),
        )));
    }
}