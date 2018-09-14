<?php

namespace Kanboard\Plugin\MetaMagik;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\MetaMagik\Helper\MetaHelper;
use Kanboard\Plugin\MetaMagik\Model\NewTaskModificationModel;
use Kanboard\Plugin\MetaMagik\Model\NewTaskCreationModel;
use Kanboard\Plugin\MetaMagik\Filter\MetaFieldFilter;
use Kanboard\Plugin\MetaMagik\Filter\MetaValueFilter;



class Plugin extends Base
{
    public function initialize()
    {
        //Helpers
        $this->helper->register('metaHelper', '\Kanboard\Plugin\MetaMagik\Helper\MetaHelper');
        
        //Models
        $this->container['taskModificationModel'] = $this->container->factory(function ($c) {
            return new NewTaskModificationModel($c);
        });
        $this->container['taskCreationModel'] = $this->container->factory(function ($c) {
            return new NewTaskCreationModel($c);
        });
        
        //Project
        $this->template->hook->attach('template:project:sidebar', 'metaMagik:project/sidebar');

        //Task
        $this->template->hook->attach('template:task:sidebar:information', 'metaMagik:task/sidebar');
        $this->template->hook->attach('template:board:task:icons', 'metaMagik:task/footer_icon');
        $this->template->hook->attach('template:task:form:first-column', 'metaMagik:task/rendermeta');
        $this->template->hook->attach('template:task:show:before-description', 'metaMagik:task/metasummary');
        
        //Filters
        $this->container->extend('taskLexer', function($taskLexer, $c) {
            $taskLexer->withFilter(MetaFieldFilter::getInstance()->setDatabase($c['db']));
            return $taskLexer;
        });
        
        $this->container->extend('taskLexer', function($taskLexer, $c) {
            $taskLexer->withFilter(MetaValueFilter::getInstance()->setDatabase($c['db']));
            return $taskLexer;
        });

        //User
        $this->template->hook->attach('template:user:sidebar:information', 'metaMagik:user/sidebar');

        // Add link to new plugin settings
        $this->template->hook->attach('template:config:sidebar', 'metaMagik:config/sidebar');
    }

    public function onStartup()
    {
        // Translation
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getClasses()
    {
        return [
            'Plugin\MetaMagik\Model' => [
                'MetadataTypeModel',
            ],
        ];
    }

    public function getPluginName()
    {
        return 'metaMagik';
    }

    public function getPluginDescription()
    {
        return t('Manage Metadata');
    }

    public function getPluginAuthor()
    {
        return 'Craig Crosby';
    }

    public function getPluginVersion()
    {
        return '0.0.1';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/creecros/MetaMagik';
    }
}
