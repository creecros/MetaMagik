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
            ->asc('position')
            ->findAll();

        return $metadataTypes;
    }

    public function getAllInColumn($column_number)
    {
        $metadataTypes = $this->db->table(self::TABLE)
            ->eq("column_number",$column_number)
            ->asc('position')
            ->findAll();

        return $metadataTypes;
    }

     public function remove($id)
    {
        return $this->db->table(self::TABLE)
            ->eq('id', $id)
            ->remove();
    }
    
    public function existsInTask($task_id)
    {
        $cf = $this->getAll();  
        $set = false;
        foreach ($cf as $f) {
            if ($this->taskMetadataModel->exists($task_id, $f['human_name'])) {
                $set = true;
                break;
            }
        }
        
        return $set;
    }                
 
    public function changePosition($id, $position)
    {
        if ($position < 1 || $position > $this->db->table(self::TABLE)->count()) {
            return false;
        }

        $ids = $this->db->table(self::TABLE)->neq('id', $id)->asc('position')->findAllByColumn('id');
        $offset = 1;
        $results = array();

        foreach ($ids as $current_id) {
            if ($offset == $position) {
                $offset++;
            }

            $results[] = $this->db->table(self::TABLE)->eq('id', $current_id)->update(array('position' => $offset));
            $offset++;
        }

        $results[] = $this->db->table(self::TABLE)->eq('id', $id)->update(array('position' => $position));

        return !in_array(false, $results, true);
    }
    
}
