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
    public function project($id = 0)
    {
        if($id == 0){
            $project = $this->getProject();
        }else{
            $project = $this->project->getById($id);
        }
        
        $metadata = $this->projectMetadata->getAll($project['id']);
        
        $this->response->html($this->helper->layout->project('metadata:metadata/metadata', array('title' => t('Metadata'), 
                                                                                                 'project' => $project,
                                                                                                 'type' => 'project',
                                                                                                 'id' => $project['id'],
                                                                                                 'metadata' => $metadata )));
    }
    
    public function task($id = 0)
    {
        if($id == 0){
            $project = $this->getProject();
            $task = $this->getTask();
        }else{
            $task = $this->taskFinder->getById($id);
            $project = $this->project->getById($task['project_id']);
        }
        
        $metadata = $this->taskMetadata->getAll($task['id']);
        
        $this->response->html($this->helper->layout->task('metadata:metadata/metadata', array('title' => t('Metadata'), 
                                                                                              'task' => $task,  
                                                                                              'project' => $project,
                                                                                              'type' => 'task',
                                                                                              'id' => $task['id'],
                                                                                              'metadata' => $metadata)));
    }
    
    public function user($id = 0)
    {
        if($id == 0 ){
            $user = $this->getUser();
        }else{
            $user = $this->user->getById($id);
        }
        $metadata = $this->userMetadata->getAll($user['id']);
        
        $this->response->html($this->helper->layout->user('metadata:metadata/metadata', array('title' => t('Metadata'), 
                                                                                              'user' => $user,
                                                                                              'type' => 'user',
                                                                                              'id' => $user['id'],
                                                                                              'metadata' => $metadata)));
    }
    
    public function add()
    {
        
        $values = $this->request->getValues();
        
        switch ($values['type']){
            case 'project':
                $this->projectMetadata->save($values['id'], [$values['key'] => $values['value']]);
                $this->response->redirect($this->project($values['id']));
                break;
            case 'task':
                $this->taskMetadata->save($values['id'], [$values['key'] => $values['value']]);
                $this->response->redirect($this->task($values['id']));
                break;
            case 'user':
                $this->userMetadata->save($values['id'], [$values['key'] => $values['value']]);
                $this->response->redirect($this->user($values['id']));
                break;
        }
        
        
    }
    
    public function confirm()
    {
        $type = $this->request->getStringParam('type');
        $id = $this->request->getStringParam('id');
        $key = $this->request->getStringParam('key');

        $this->response->html($this->template->render('metadata:metadata/remove', array(
            'id' => $id,
            'type' => $type,
            'key' => $key,
        )));
    }
    
    public function remove()
    {
        
        $type = $this->request->getStringParam('type');
        $id = $this->request->getStringParam('id');
        $key = $this->request->getStringParam('key');
        
        switch ($type){
            case 'project':
                $this->projectMetadata->remove($id, $key);
                $this->response->redirect($this->project($id));
                break;
            case 'task':
                $this->taskMetadata->remove($id, $key);
                $this->response->redirect($this->task($id));
                break;
            case 'user':
                $this->userMetadata->remove($id, $key);
                $this->response->redirect($this->user($id));
                break;
        }
        
        
    }
}