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
        $metadata = $this->taskMetadataModel->getAll($values['id']);
        $html = '';
        
        foreach ($metasettings as $setting) {
            $metaisset = $this->taskMetadataModel->exists($values['id'], $setting['human_name']);
            if (!$metaisset) {
                $this->taskMetadataModel->save($values['id'], [$setting['human_name'] => '']);
            }

        }
        
        
        foreach ($metadata as $key => $value) {
         $values['metamagikkey_' . $key] = $metadata[$key];
         $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);
         $html .= $this->helper->form->text('metamagikkey_' . $key, $values, $errors, $attributes, 'form-input-small');
        }

        return $html;
    }
    
}
