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
        
        foreach ($metasettings as $setting) {
            if ($setting['attached_to'] == 'task') {
            $metaisset = $this->taskMetadataModel->exists($values['id'], $setting['human_name']);
            if (!$metaisset) {
                $this->taskMetadataModel->save($values['id'], [$setting['human_name'] => '']);
            }
            
            if (!isset($values['id'])) {
               $html .= $this->helper->form->label($setting['human_name'], 'metamagikkey_' . $setting['human_name']);
               $html .= $this->helper->form->text('metamagikkey_' . $setting['human_name'], $values, $errors, $attributes, 'form-input-small'); 
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
