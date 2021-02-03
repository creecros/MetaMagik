<?php

namespace Kanboard\Plugin\MetaMagik\Controller;

use Kanboard\Filter\TaskProjectFilter;
use Kanboard\Model\TaskModel;
use Kanboard\Plugin\MetaMagik\Analytics\CustomFieldAnalytics;
use Kanboard\Controller\BaseController;

/**
 * Custom Field Analytic Controller
 *
 * @package  MetaMagik
 * @author   Craig Crosby
 */
class AnalyticExtensionController extends BaseController
{
    /**
     * Show custom field values as distribution graph
     *
     * @access public
     */
    public function fieldTotalDistribution()
    {
        
        $project = $this->getProject();
        
        $this->response->html($this->helper->layout->analytic('metaMagik:analytic/custom_field_totals', array(
            'project' => $project,
            'metrics' => $this->customFieldAnalytics->build_norange($project['id']),
            'title' => t('Custom Field Total distribution'),
        )));
    }
    /**
     * Show custom field values as distribution graph with range
     *
     * @access public
     */
    public function fieldTotalDistributionRange()
    {
        
        $project = $this->getProject();
        list($from, $to) = $this->getDates();
        
        $this->response->html($this->helper->layout->analytic('metaMagik:analytic/custom_field_totals_range', array(
            'values' => array(
                'from' => $from,
                'to' => $to,
            ),
            'project' => $project,
            'metrics' => $this->customFieldAnalytics->build_range($project['id'], $from, $to),
            'title' => t('Custom Field Total distribution'),
        )));
    }
    
    private function getDates()
    {
        $values = $this->request->getValues();

        $from = $this->request->getStringParam('from', date('Y-m-d', strtotime('-1week')));
        $to = $this->request->getStringParam('to', date('Y-m-d'));

        if (! empty($values)) {
            $from = $this->dateParser->getIsoDate($values['from']);
            $to = $this->dateParser->getIsoDate($values['to']);
        }

        return array($from, $to);
    }
    
}