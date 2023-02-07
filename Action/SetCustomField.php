<?php

namespace Kanboard\Plugin\MetaMagik\Action;

use Kanboard\Model\TaskModel;
use Kanboard\Plugin\MetaMagik\Model\MetadataTypeModel;
use Kanboard\Action\Base;
use Kanboard\Controller\BaseController;

class SetCustomField extends Base
{
    /**
     * Set Custom Field on Column Move
     *
     * @access public
     * @return string
     */
    public function getDescription()
    {
        return t('Set a value for a custom field when a task moves to a cloumn.');
    }

    /**
     * Get the list of compatible events
     *
     * @access public
     * @return array
     */
    public function getCompatibleEvents()
    {
        return array(
            TaskModel::EVENT_MOVE_COLUMN,
        );
    }

    /**
     * Get the required parameter for the action (defined by the user)
     *
     * @access public
     * @return array
     */
    public function getActionRequiredParameters()
    {
        return array(
            'column_id' => t('Column'),
            'metakey' => $this->metadataTypeModel->getNameListInScope($this->request->getIntegerParam('project_id')),
            'metavalue' => t('Value to change Custom Field to:'),
        );
    }

    /**
     * Get the required parameter for the event
     *
     * @access public
     * @return string[]
     */
    public function getEventRequiredParameters()
    {
        return array(
            'task_id',
            'task' => array(
                'project_id',
                'column_id',
            ),
        );
    }

    /**
     * Execute the action (assign the given user)
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    public function doAction(array $data)
    {
        $values = array(
            'key' => $this->getParam('metakey'),
            'value' => $this->getParam('metavalue'),
        );

        return $this->taskMetadataModel->save($data['task_id'], [$values['key'] => $values['value']]);
    }

    /**
     * Check if the event data meet the action condition
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasRequiredCondition(array $data)
    {
        return $data['task']['column_id'] == $this->getParam('column_id');
    }
}