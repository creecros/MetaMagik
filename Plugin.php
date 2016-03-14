<?php

namespace Kanboard\Plugin\Metadata;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        //Project
        $this->template->hook->attach('template:project:sidebar', 'metadata:project/sidebar');

        //Task
        $this->template->hook->attach('template:task:sidebar', 'metadata:task/sidebar');

        //User
        $this->template->hook->attach('template:user:sidebar:information', 'metadata:user/sidebar');

        // Translation
        $this->on('app.bootstrap', function($container) {
            Translator::load($container['config']->getCurrentLanguage(), __DIR__.'/Locale');
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
