<?php

namespace Kanboard\Plugin\Metadata;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        //Project
        $this->template->hook->attach('template:project:sidebar', 'metadata:dashboard/sidebar');
        //Task
        
        //User
    }
    
    public function getPluginName()
    {
        return 'Overwrite Translation';
    }
    public function getPluginDescription()
    {
        return t('Manage Metadata');
    }
    public function getPluginAuthor()
    {
        return 'BlueTeck';
    }
    public function getPluginVersion()
    {
        return '1.0.0';
    }
}