<?php

namespace Kanboard\Plugin\Metadata\Model;

use Kanboard\Model\Base;

/**
 * Class MetadataType
 *
 * @package Kanboard\Plugin\Metadata\Model
 * @author Daniele Lenares <daniele.lenares@gmail.com>
 */
class MetadataType extends Base
{
    /**
     * SQL table name for MetadataType
     *
     * @var string
     */
    const TABLE = 'metadata_types';

    /**
     * Return all metadata types
     *
     * @access public
     * @return array
     */
    public function getAll()
    {
        $metadataTypes = $this->db->table(self::TABLE)->findAll();
        return $metadataTypes;
    }

}
