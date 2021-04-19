<?php

namespace Kanboard\Plugin\MetaMagik\Model;

use Kanboard\Core\Base;

/**
 * Class Kanboard\Plugin\MetaMagik\Model;
 *
 * @author Craig Crosby <creecros@gmail.com>
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
    
    public function getType($id)
    {
        return $this->db->table(self::TABLE)
            ->eq('id', $id)
            ->findOne();
    }
    
    
    /**
     * Return all metadata types in scope.
     *
     * @return array
     */
    public function getAllInScope($scope)
    {
        $metadataTypes = $this->db->table(self::TABLE)
            ->beginOr()
            ->eq('attached_to', 0)
            ->eq('attached_to', $scope)
            ->closeOr()
            ->asc('position')
            ->findAll();

        return $metadataTypes;
    }

    public function getAllInColumn($column_number, $scope)
    {
        $metadataTypes = $this->db->table(self::TABLE)
            ->eq('column_number', $column_number)
            ->beginOr()
            ->eq('attached_to', 0)
            ->eq('attached_to', $scope)
            ->closeOr()
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
    
    public function getScope($id)
    {
        return $this->db->table(self::TABLE)
            ->eq('id', $id)
            ->findAllByColumn('attached_to');
    }  
    
    public function getReqs($scope)
    {
        return $this->db->table(self::TABLE)
            ->beginOr()
            ->eq('attached_to', 0)
            ->eq('attached_to', $scope)
            ->closeOr()
            ->eq('is_required', true)
            ->findAllByColumn('human_name');
    }  
    
    public function changePosition($id, $position, $column_number)
    {

        if ($position < 1 || ($position > $this->db->table(self::TABLE)->eq('column_number', $column_number)->count() && $this->db->table(self::TABLE)->eq('column_number', $column_number)->count() > 0)) {
            return false;
        }
        
        $ids = $this->db->table(self::TABLE)->eq('column_number', $column_number)->neq('id', $id)->asc('position')->findAllByColumn('id');
        $offset = 1;
        $results = array();

        foreach ($ids as $current_id) {
            if ($offset == $position) {
                $offset++;
            }

            $results[] = $this->db->table(self::TABLE)->eq('id', $current_id)->update(array('position' => $offset));
            $offset++;
        }

        $results[] = $this->db->table(self::TABLE)->eq('id', $id)->update(array('position' => $position, 'column_number' => $column_number));
        return !in_array(false, $results, true);
    }
    
}
