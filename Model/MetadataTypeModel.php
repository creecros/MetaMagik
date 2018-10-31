<?php

namespace Kanboard\Plugin\MetaMagik\Model;

use Kanboard\Core\Base;

/**
 * Class MetadataType.
 *
 * @author Daniele Lenares <daniele.lenares@gmail.com>
 */
class MetadataTypeModel extends Base
{
    /**
     * SQL table name for MetadataType.
     *
     * @var string
     */
    const TABLE = 'metadata_types';

    /**
     * Return all metadata types.
     *
     * @return array
     */
    public function getAll()
    {
        $metadataTypes = $this->db->table(self::TABLE)
            ->asc('human_name')
            ->findAll();

        return $metadataTypes;
    }
    
     public function remove($id)
    {
        return $this->db->table(self::TABLE)
            ->eq('id', $id)
            ->remove();
    }
}
