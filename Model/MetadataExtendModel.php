<?php

namespace Kanboard\Plugin\MetaMagik\Model;

use Kanboard\Model\MetadataModel;

/**
 * Task Metadata
 *
 * @package  Kanboard\Model
 * @author   Frederic Guillot
 */
class MetadataExtendModel extends MetadataModel
{
    const TABLE = 'task_has_metadata';
    /**
     * Get the table
     *
     * @abstract
     * @access protected
     * @return string
     */
    protected function getTable()
    {
        return 'task_has_metadata';
    }

    /**
     * Define the entity key
     *
     * @access protected
     * @return string
     */
    protected function getEntityKey()
    {
        return 'task_id';
    }
}