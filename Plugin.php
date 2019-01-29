<?php

namespace Kanboard\Plugin\MetaMagik;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\MetaMagik\Helper\MetaHelper;
use Kanboard\Plugin\MetaMagik\Export\MetaTaskExport;
use Kanboard\Plugin\MetaMagik\Model\NewTaskModificationModel;
use Kanboard\Plugin\MetaMagik\Model\NewTaskCreationModel;
use Kanboard\Plugin\MetaMagik\Model\NewTaskDuplicationModel;
use Kanboard\Plugin\MetaMagik\Model\NewTaskProjectDuplicationModel;
use Kanboard\Plugin\MetaMagik\Filter\MetaFieldFilter;
use Kanboard\Plugin\MetaMagik\Filter\MetaValueFilter;
use Kanboard\Core\Security\Role;

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
        $this->container['taskDuplicationModel'] = $this->container->factory(function ($c) {
            return new NewTaskDuplicationModel($c);
        });        
        $this->container['taskProjectDuplicationModel'] = $this->container->factory(function ($c) {
            return new NewTaskProjectDuplicationModel($c);
        });
        
        //Project
        $this->template->hook->attach('template:project:sidebar', 'metaMagik:project/sidebar');

        //Task
        $this->template->hook->attach('template:task:sidebar:information', 'metaMagik:task/sidebar');
        $this->template->hook->attach('template:board:task:icons', 'metaMagik:task/footer_icon');
        $this->template->hook->attach('template:task:form:first-column', 'metaMagik:task/rendermeta1');
        $this->template->hook->attach('template:task:form:second-column', 'metaMagik:task/rendermeta2');
        $this->template->hook->attach('template:task:form:third-column', 'metaMagik:task/rendermeta3');
        $this->template->hook->attach('template:task:details:bottom', 'metaMagik:task/metasummary');
        
        $this->template->setTemplateOverride('project_header/dropdown', 'metaMagik:project_header/dropdown');
        $this->template->setTemplateOverride('export/tasks', 'metaMagik:export/tasks');
        
        //Routes
        $this->route->addRoute('export/metatasks/:project_id', 'NewExportController', 'tasks');
        
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
        
        //java
        $this->hook->on('template:layout:js', array('template' => 'plugins/MetaMagik/Assets/js/meta-drag-and-drop.js'));
        
        //Roles
        $this->projectAccessMap->add('metadata', 'index', Role::PROJECT_MEMBER);
        $this->projectAccessMap->add('MetadataController', array('saveUser', 'saveTask', 'saveProject', 'removeUser', 'removeTask', 'removeProject', 'confirmUser', 'confirmTask', 'confirmProject', 'editUser', 'editTask', 'editProject'), Role::PROJECT_MEMBER);
        $this->projectAccessMap->add('MetadataTypesController', '*', Role::PROJECT_MEMBER);
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
            'Plugin\MetaMagik\Export' => [
                'MetaTaskExport',
            ],
        ];
    }

    public function getPluginName()
    {
        return 'metaMagik';
    }

    public function getPluginDescription()
    {
        return t('Custom Task Fields and Manage Metadata');
    }

    public function getPluginAuthor()
    {
        return 'Craig Crosby + BlueTeck';
    }

    public function getPluginVersion()
    {
        return '1.2.5';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/creecros/MetaMagik';
    }
}
