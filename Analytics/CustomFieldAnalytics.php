<?php

namespace Kanboard\Plugin\MetaMagik\Analytics;

use Kanboard\Core\Base;
use Kanboard\Model\TaskMetadataModel;
use Kanboard\Model\TaskModel;
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

    public function build_norange($project_id)
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

    public function build_range($project_id, $from, $to)
    {
        $metrics = array();
        $total = 0;
        $fields = $this->metadataTypeModel->getAllInScope($project_id);
        $tasks = $this->getTasks($project_id, $from, $to);

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
    
    /**
     * Get date range of tasks created 
     *
     * @access private
     * @param  integer $project_id
     * @return array
     */
    private function getTasks($project_id, $from, $to)
    {
        return $this->db
            ->table(TaskModel::TABLE)
            ->eq('project_id', $project_id)
            ->gte('date_creation', strtotime($from))
            ->lte('date_creation', strtotime($to))
            ->asc('id')
            ->findAll();
    }

}