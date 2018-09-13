<?php

namespace Kanboard\Plugin\MetaMagik\Model;

use Kanboard\Model\TaskFinderModel;
use Kanboard\Model\TaskMetadataModel;
use Kanboard\Model\MetadataModel;
use Kanboard\Model\TaskTagModel;
use Kanboard\Model\TaskModel;
use Kanboard\Core\Base;

/**
 * Task Modification
 *
 * @package  Kanboard\Model
 * @author   Frederic Guillot
 */
class NewTaskModificationModel extends Base
{
    /**
     * Update a task
     *
     * @access public
     * @param  array     $values
     * @param  boolean   $fire_events
     * @return boolean
     */
    public function update(array $values, $fire_events = true)
    {
        $task = $this->taskFinderModel->getById($values['id']);

        $this->updateTags($values, $task);
        $this->updateMeta($values, $task);
        $this->prepare($values);
        $result = $this->db->table(TaskModel::TABLE)->eq('id', $task['id'])->update($values);

        if ($fire_events && $result) {
            $this->fireEvents($task, $values);
        }

        return $result;
    }

    /**
     * Fire events
     *
     * @access protected
     * @param  array $task
     * @param  array $changes
     */
    protected function fireEvents(array $task, array $changes)
    {
        $events = array();

        if ($this->isAssigneeChanged($task, $changes)) {
            $events[] = TaskModel::EVENT_ASSIGNEE_CHANGE;
        } elseif ($this->isModified($task, $changes)) {
            $events[] = TaskModel::EVENT_CREATE_UPDATE;
            $events[] = TaskModel::EVENT_UPDATE;
        }

        if (! empty($events)) {
            $this->queueManager->push($this->taskEventJob
                ->withParams($task['id'], $events, $changes, array(), $task)
            );
        }
    }

    /**
     * Return true if the task have been modified
     *
     * @access protected
     * @param  array $task
     * @param  array $changes
     * @return bool
     */
    protected function isModified(array $task, array $changes)
    {
        $diff = array_diff_assoc($changes, $task);
        unset($diff['date_modification']);
        return count($diff) > 0;
    }

    /**
     * Return true if the field is the only modified value
     *
     * @access protected
     * @param  array  $task
     * @param  array  $changes
     * @return bool
     */
    protected function isAssigneeChanged(array $task, array $changes)
    {
        $diff = array_diff_assoc($changes, $task);
        unset($diff['date_modification']);
        return isset($changes['owner_id']) && $task['owner_id'] != $changes['owner_id'] && count($diff) === 1;
    }

    /**
     * Prepare data before task modification
     *
     * @access protected
     * @param  array  $values
     */
    protected function prepare(array &$values)
    {
        $values = $this->dateParser->convert($values, array('date_due'), true);
        $values = $this->dateParser->convert($values, array('date_started'), true);

        $this->helper->model->removeFields($values, array('id'));
        $this->helper->model->resetFields($values, array('date_due', 'date_started', 'score', 'category_id', 'time_estimated', 'time_spent'));
        $this->helper->model->convertIntegerFields($values, array('priority', 'is_active', 'recurrence_status', 'recurrence_trigger', 'recurrence_factor', 'recurrence_timeframe', 'recurrence_basedate'));

        $values['date_modification'] = time();

        $this->hook->reference('model:task:modification:prepare', $values);
    }

    /**
     * Update tags
     *
     * @access protected
     * @param  array  $values
     * @param  array  $original_task
     */
    protected function updateTags(array &$values, array $original_task)
    {
        if (isset($values['tags'])) {
            $this->taskTagModel->save($original_task['project_id'], $values['id'], $values['tags']);
            unset($values['tags']);
        }
    }
    
    protected function updateMeta(array &$values, array $original_task)
    {
        $metadoublecheck = $this->metadataTypeModel->getAll();
        foreach ($metadoublecheck as $check) {
            $exists = array_key_exists('metamagikkey_' . $check['human_name'], $values);
            if (!$exists) { 
                $existsdoublecheck = array_key_exists('metamagikkey_' . $check['human_name'] . '[]', $values);
                if (!$existsdoublecheck) { $values['metamagikkey_' . $check['human_name']] = ''; }
            }
        }
        
        $keys = array();
        foreach ($values as $key => $value) {
            $pos = strpos($key, 'metamagikkey_');
            if ($pos === false) {
            } else {
                $realkey = str_replace('metamagikkey_', '', $key);
                $keyval = $values[$key];
                if (empty($keyval)) { $keyval = ''; }
                if (!is_array($keyval)) {
                $this->taskMetadataModel->save($original_task['id'], [$realkey => $keyval]);
                unset($values[$key]);
                } else {
                    $key_imploded = array();
                    foreach ($keyval as $k => $v) {
                    if ($v) { array_push($key_imploded, implode(',', $v)); }
                    }
                    $keys_extracted = implode(',', $key_imploded);
                    if (empty($keys_extracted)) { $keys_extracted = ''; }
                    $this->taskMetadataModel->save($original_task['id'], [$realkey => $keys_extracted]);
                    unset($values[$key]);
                }
            }
        }           
    }
}
