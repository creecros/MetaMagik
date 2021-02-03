<?php

namespace Kanboard\Plugin\MetaMagik\Analytics;

use Kanboard\Core\Base;
use Kanboard\Model\TaskMetadataModel;
use Kanboard\Model\TaskFinderModel;
use Kanboard\Plugin\MetaMagik\Model\MetadataTypeModel;

/**
 * Custom Field Numeric Total Analytic Distribution
 *
 * @package  MetaMagik
 * @author   Craig Crosby
 */
class CustomFieldAnalytics extends Base
{

    public function build($project_id)
    {
        $metrics = array();
        $total = 0;
        $fields = $this->metadataTypeModel->getAllInScope($project_id);
        $tasks = $this->taskFinderModel->getAll($project_id);

        foreach ($fields as $field) {
            
        $field_total = 0;
            
            foreach ($tasks as $task) {
                if (!empty($this->taskMetadataModel->get($task['id'], $field['human_name'], '')) && $field['data_type'] === 'number' ) {
                    $field_total += $this->taskMetadataModel->get($task['id'], $field['human_name'], '');
                    $total += $this->taskMetadataModel->get($task['id'], $field['human_name'], '');
                }

            }
            
            if ($field_total !== 0) {
                $metrics[] = array(
                    'column_title' => $field['human_name'],
                    'nb_tasks' => $field_total,
                );
            }
            
        }

        if ($total === 0) {
            return array();
        }

        foreach ($metrics as &$metric) {
            $metric['percentage'] = round(($metric['nb_tasks'] * 100) / $total, 2);
        }

        return $metrics;
    }
}