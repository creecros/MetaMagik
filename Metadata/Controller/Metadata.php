<?php
namespace Kanboard\Plugin\Metadata\Controller;
use Kanboard\Controller\Base;
/**
 * Metadata
 *
 * @package controller
 * @author  BlueTeck
 */
class Metadata extends Base
{
    /**
     * index page
     *
     * @access public
     */
    public function project()
    {
        $project = $this->getProject();
        
        $metadata = $this->projectMetadata->getAll($project['id']);
        
        $this->response->html($this->helper->layout->project('metadata:metadata/metadata', array('title' => t('Metadata'), 
                                                                                                 'project' => $project,
                                                                                                 'metadata' => $metadata )));
    }
    
    public function task()
    {
        $project = $this->getProject();
        $task = $this->getTask();
        
        $metadata = $this->taskMetadata->getAll($task['id']);
        
        $this->response->html($this->helper->layout->task('metadata:metadata/metadata', array('title' => t('Metadata'), 
                                                                                              'task' => $task,  
                                                                                              'project' => $project,
                                                                                              'metadata' => $metadata)));
    }
    
    public function user()
    {
        $user = $this->getUser();
        
        $metadata = $this->userMetadata->getAll($user['id']);
        
        $this->response->html($this->helper->layout->user('metadata:metadata/metadata', array('title' => t('Metadata'), 
                                                                                              'user' => $user,
                                                                                              'metadata' => $metadata)));
    }
}