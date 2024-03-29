<?php

namespace Kanboard\Plugin\MetaMagik\Model;

use Kanboard\Plugin\MetaMagik\Model\MetadataTypeModel;
use Kanboard\Model\TaskFinderModel;
use Kanboard\Model\TaskMetadataModel;
use Kanboard\Model\MetadataModel;
use Kanboard\Model\TaskTagModel;
use Kanboard\Model\TaskModel;
use Kanboard\Model\TaskPositionModel;
use Kanboard\Model\SwimlaneModel;
use Kanboard\Core\Base;

/**
 * Task Creation
 *
 */
class NewTaskCreationModel extends Base
{
    /**
     * Create a task
     *
     * @access public
     * @param  array    $values   Form values
     * @return integer
     */
    public function create(array $values, $api_request = false)
    {
        $position = empty($values['position']) ? 0 : $values['position'];
        $tags = array();
        $metaholder = array();
        
        $origValues = array_merge(array(), $values);
        
        if (isset($values['tags'])) {
            $tags = $values['tags'];
            unset($values['tags']);
        }
        
        if (!$api_request) { 
            
            $metaholder = $this->hideMeta($values); 
            
            foreach ($metaholder as $key => $value){
                unset($values[$key]);
            }
        }
        
        $this->prepare($values);
        $task_id = $this->db->table(TaskModel::TABLE)->persist($values);
        
        $values = $origValues;
        
        if ($task_id !== false) {
            if ($position > 0 && $values['position'] > 1) {
                $this->taskPositionModel->movePosition($values['project_id'], $task_id, $values['column_id'], $position, $values['swimlane_id'], false);
            }
            
            if (! empty($tags)) {
                $this->taskTagModel->save($values['project_id'], $task_id, $tags);
            }
            
            if (!$api_request) { $this->createMeta($metaholder, $task_id); }
            
            $this->queueManager->push($this->taskEventJob->withParams(
                $task_id,
                array(TaskModel::EVENT_CREATE_UPDATE, TaskModel::EVENT_CREATE),
                array(),
                $origValues
                ));
        }
        
        $this->hook->reference('model:task:creation:aftersave', $task_id);
        
        return (int) $task_id;
    }
    
    /**
     * Prepare data
     *
     * @access protected
     * @param  array    $values    Form values
     */
    protected function prepare(array &$values)
    {
        $values = $this->dateParser->convert($values, array('date_due'), true);
        $values = $this->dateParser->convert($values, array('date_started'), true);
        
        $this->helper->model->removeFields($values, array('another_task', 'duplicate_multiple_projects'));
        $this->helper->model->resetFields($values, array('creator_id', 'owner_id', 'date_due', 'date_started', 'score', 'category_id', 'time_estimated', 'time_spent'));
        
        if (empty($values['column_id'])) {
            $values['column_id'] = $this->columnModel->getFirstColumnId($values['project_id']);
        }
        
        if (empty($values['color_id'])) {
            $values['color_id'] = $this->colorModel->getDefaultColor();
        }
        
        if (empty($values['title'])) {
            $values['title'] = t('Untitled');
        }
        
        if ($this->userSession->isLogged() && empty($values['creator_id'])) {
        $values['creator_id'] = $this->userSession->getId();
        }
        
        $values['swimlane_id'] = empty($values['swimlane_id']) ? $this->swimlaneModel->getFirstActiveSwimlaneId($values['project_id']) : $values['swimlane_id'];
        $values['date_creation'] = time();
        $values['date_modification'] = $values['date_creation'];
        $values['date_moved'] = $values['date_creation'];
        $values['position'] = $this->taskFinderModel->countByColumnAndSwimlaneId($values['project_id'], $values['column_id'], $values['swimlane_id']) + 1;
        
        $this->hook->reference('model:task:creation:prepare', $values);
    }
    
    protected function hideMeta(array &$values)
    {
        $keys = array();
        foreach ($values as $key => $value) {
            $pos = strpos($key, 'metamagikkey_');
            if ($pos === false) {
            } else {
                $keys[$key] = $values[$key];
            }
        }
        return $keys;
    }
    
    protected function createMeta(array &$metaholder, $task_id)
    {
        $metadoublecheck = $this->metadataTypeModel->getAll();
        foreach ($metadoublecheck as $check) {
            $exists = array_key_exists('metamagikkey_' . $check['human_name'], $metaholder);
            if (!$exists) {
                $existsdoublecheck = array_key_exists('metamagikkey_' . $check['human_name'] . '[]', $metaholder);
                if (!$existsdoublecheck) { $metaholder['metamagikkey_' . $check['human_name']] = ''; }
            }
        }
        
        foreach ($metaholder as $key => $value) {
            $realkey = str_replace('metamagikkey_', '', $key);
            $keyval = $metaholder[$key];
            if (empty($keyval)) { $keyval = ''; }
            if (!is_array($keyval)) {
                $this->taskMetadataModel->save($task_id, [$realkey => $keyval]);
                unset($metaholder[$key]);
            } else {
                $key_imploded = array();
                foreach ($keyval as $k => $v) {
                    if ($v) { array_push($key_imploded, implode(',', $v)); }
                }
                $keys_extracted = implode(',', $key_imploded);
                if (empty($keys_extracted)) { $keys_extracted = ''; }
                $this->taskMetadataModel->save($task_id, [$realkey => $keys_extracted]);
                unset($metaholder[$key]);
            }
        }
        
        
    }
}
