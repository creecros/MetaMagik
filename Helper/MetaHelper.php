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
                     $html .= $this->helper->form->label($setting['human_name'], 'metamagikkey_' . $setting['human_name']);
                    if ($setting['data_type'] == 'text') {
                        $html .= $this->helper->form->text('metamagikkey_' . $setting['human_name'], $values, $errors, $attributes, 'form-input-small'); 
                    } else if ($setting['data_type'] == 'list') {
                        $opt_explode = explode(',', $setting['options']);
                        foreach ($opt_explode as $key => $value) {
                            $meta_opt[$value] = $value;
                        }
                        $html .= $this->helper->form->select('metamagikkey_' . $setting['human_name'], $meta_opt, $values, $errors, $attributes, 'form-input-small'); 
                    } else if ($setting['data_type'] == 'radio') {

                    } else if ($setting['data_type'] == 'check') {

                    }

                }
            }
        }
        
        $metadata = $this->taskMetadataModel->getAll($values['id']);

        
        foreach ($metadata as $key => $value) {
         $values['metamagikkey_' . $key] = $metadata[$key];
         $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);
         $html .= $this->helper->form->text('metamagikkey_' . $key, $values, $errors, $attributes, 'form-input-small');
        }

        return $html;
    }
    
}
