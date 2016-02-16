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
        //$project = $this->getProject();
        $this->response->html($this->helper->layout->project('metadata:project/metadata', array('title' => t('Metadata')), 'project/sidebar'));
    }
    
    public function task()
    {
        //$project = $this->getProject();
        $this->response->html($this->helper->layout->project('metadata:task/metadata', array('title' => t('Metadata')), 'task/sidebar'));
    }
    
    public function user()
    {
        //$project = $this->getProject();
        $this->response->html($this->helper->layout->project('metadata:user/metadata', array('title' => t('Metadata')), 'user/sidebar'));
    }
}