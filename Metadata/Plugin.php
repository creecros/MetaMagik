<?php

namespace Kanboard\Plugin\Metadata;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        //$this->template->hook->attach('template:layout:head', 'theme:layout/head');
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