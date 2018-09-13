<?php

namespace Kanboard\Plugin\MetaMagik\Helper;

use Kanboard\Plugin\MetaMagik\Model\MetadataTypeModel;
use Kanboard\Core\Base;

/**
 * Meta helper
 *
 */
class MetaHelper extends Base
{
    

    public function renderMetaFields(array $values, array $errors = array(), array $attributes = array())
    {
        $metasettings = $this->metadataTypeModel->getAll();
        $html = '';
        $meta_opt = array();
        
        if (isset($values['id'])) {
            foreach ($metasettings as $setting) {
                if ($setting['attached_to'] == 'task') {
                    $metaisset = $this->taskMetadataModel->exists($values['id'], $setting['human_name']);
                        if (!$metaisset) {
                         $this->taskMetadataModel->save($values['id'], [$setting['human_name'] => '']);
                        }
                 }
            }
        } else {        
            foreach ($metasettings as $setting) {
                if ($setting['attached_to'] == 'task') {
                     
                    if ($setting['data_type'] == 'text') {
                        $html .= $this->helper->form->label($setting['human_name'], 'metamagikkey_' . $setting['human_name']);
                        $html .= $this->helper->form->text('metamagikkey_' . $setting['human_name'], $values, $errors, $attributes, 'form-input-small'); 
                        $meta_opt = array();
                    } else if ($setting['data_type'] == 'list') {
                        $opt_explode = explode(',', $setting['options']);
                        foreach ($opt_explode as $key => $value) {
                            $meta_opt[$value] = $value;
                        }
                        $html .= $this->helper->form->label($setting['human_name'], 'metamagikkey_' . $setting['human_name']);
                        $html .= $this->helper->form->select('metamagikkey_' . $setting['human_name'], $meta_opt, $values, $errors, $attributes, 'form-input-small'); 
                        $meta_opt = array();
                    } else if ($setting['data_type'] == 'radio') {
                        $opt_explode = explode(',', $setting['options']);
                        foreach ($opt_explode as $key => $value) {
                            $meta_opt[$value] = $value;
                        }
                        $html .= $this->helper->form->label($setting['human_name'], 'metamagikkey_' . $setting['human_name']);
                        $html .= $this->helper->form->radios('metamagikkey_' . $setting['human_name'], $meta_opt, $values); 
                        $meta_opt = array();
                    } else if ($setting['data_type'] == 'check') {
                        $opt_explode = explode(',', $setting['options']);
                        foreach ($opt_explode as $key => $value) {
                            $meta_opt[$value] = $value;
                        }
                        $html .= $this->helper->form->label($setting['human_name'], 'metamagikkey_' . $setting['human_name']);
                        $html .= $this->helper->form->checkboxes('metamagikkey_' . $setting['human_name'], $meta_opt, $values); 
                        $meta_opt = array();
                    }

                }
            }
        }
        
        $meta_opt = array();
        $meta_type = array();
        $meta_deopt = array();
        $metadata = $this->taskMetadataModel->getAll($values['id']);
        
        foreach ($metasettings as $setting) {
            $metaisset = $this->taskMetadataModel->exists($values['id'], $setting['human_name']);
            $key = $setting['human_name'];
            if ($metaisset) { 
                $meta_deopt[$key] = $setting['options']; 
                $meta_type[$key] = $setting['data_type'];
            }
        }

        
        foreach ($metadata as $key => $value) {
         $values['metamagikkey_' . $key] = $metadata[$key];
         
         if ($meta_type[$key] == 'text') { 
             $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);
             $html .= $this->helper->form->text('metamagikkey_' . $key, $values, $errors, $attributes, 'form-input-small');
             $meta_opt = array();
         } else if ($meta_type[$key] == 'list') {
             $opt_explode = explode(',', $meta_deopt[$key]);
             foreach ($opt_explode as $name => $value) {
                            $meta_opt[$value] = $value;
             }
             $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);
             $html .= $this->helper->form->select('metamagikkey_' . $key, $meta_opt, $values, $errors, $attributes, 'form-input-small'); 
             $meta_opt = array();
         } else if ($meta_type[$key] == 'radio') {
             $opt_explode = explode(',', $meta_deopt[$key]);
             foreach ($opt_explode as $name => $value) {
                            $meta_opt[$value] = $value;
             }
             $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);
             $html .= $this->helper->form->radios('metamagikkey_' . $key, $meta_opt, $values); 
             $meta_opt = array();
         } else if ($meta_type[$key] == 'check') {
             $opt_explode = explode(',', $meta_deopt[$key]);
             foreach ($opt_explode as $name => $value) {
                            $meta_opt[$value] = $value;
             }
             $values['metamagikkey_' . $key] = implode(',', $values['metamagikkey_' . $key]);
             $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);
             $html .= $this->helper->form->checkboxes('metamagikkey_' . $key, $meta_opt, $values); 
             $meta_opt = array();
         }
        }

        return $html;
    }
    
}
