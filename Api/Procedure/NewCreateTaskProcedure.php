<?php

namespace Kanboard\Plugin\MetaMagik\Api\Procedure;

use Kanboard\Api\Authorization\SubtaskAuthorization;
use Kanboard\Api\Authorization\ProjectAuthorization;
use Kanboard\Api\Authorization\TaskAuthorization;
use Kanboard\Api\Procedure\BaseProcedure;
use Kanboard\Filter\TaskProjectFilter;
use Kanboard\Model\TaskModel;


/**
 * CreateTask bypass Meta API controller
 *
 * @package  Kanboard\Plugin\MetaMagik
 * @author   Craig Crosby
 */
class NewCreateTaskProcedure extends BaseProcedure
{
    public function createTaskMeta($title, $project_id, $color_id = '', $column_id = 0, $owner_id = 0, $creator_id = 0,
                               $date_due = '', $description = '', $category_id = 0, $score = 0, $swimlane_id = null, $priority = 0,
                               $recurrence_status = 0, $recurrence_trigger = 0, $recurrence_factor = 0, $recurrence_timeframe = 0,
                               $recurrence_basedate = 0, $reference = '', array $tags = array(), $date_started = '',
                               $time_spent = null, $time_estimated = null)
    {
        ProjectAuthorization::getInstance($this->container)->check($this->getClassName(), 'createTaskMeta', $project_id);

        if ($owner_id !== 0 && ! $this->projectPermissionModel->isAssignable($project_id, $owner_id)) {
            return false;
        }

        if ($this->userSession->isLogged()) {
            $creator_id = $this->userSession->getId();
        }

        $values = array(
            'title' => $title,
            'project_id' => $project_id,
            'color_id' => $color_id,
            'column_id' => $column_id,
            'owner_id' => $owner_id,
            'creator_id' => $creator_id,
            'date_due' => $date_due,
            'description' => $description,
            'category_id' => $category_id,
            'score' => $score,
            'swimlane_id' => $swimlane_id,
            'recurrence_status' => $recurrence_status,
            'recurrence_trigger' => $recurrence_trigger,
            'recurrence_factor' => $recurrence_factor,
            'recurrence_timeframe' => $recurrence_timeframe,
            'recurrence_basedate' => $recurrence_basedate,
            'reference' => $reference,
            'priority' => $priority,
            'tags' => $tags,
            'date_started' => $date_started,
            'time_spent' => $time_spent,
            'time_estimated' => $time_estimated,
        );

        list($valid, ) = $this->taskValidator->validateCreation($values);

        return $valid ? $this->taskCreationModel->create($values, true) : false;
    }

}