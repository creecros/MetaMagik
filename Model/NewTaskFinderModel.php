<?php

namespace Kanboard\Plugin\MetaMagik\Model;

use Kanboard\Model\TaskFinderModel;

/**
 * New Task Finder model
 * Extends original Model
 *
 * @package  Kanboard\Plugin\MetaMagik\Model
 */
class NewTaskFinderModel extends TaskFinderModel
{
    const METADATA_TABLE = 'task_has_metadata';

    /**
     * Extended query
     *
     * @access public
     * @return \PicoDb\Table
     */
    public function getExtendedQuery()
    {
        // add subquery to original Model, changing only what we want
        return parent::getExtendedQuery()
            ->subquery('(SELECT COUNT(*) FROM '.self::METADATA_TABLE.' WHERE task_id=tasks.id)', 'nb_metadata');
    }
}
