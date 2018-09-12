<?php

namespace Kanboard\Plugin\MetaMagik\Helper;

use Kanboard\Core\Base;

/**
 * Meta helper
 *
 */
class MetaHelper extends Base
{

    public function renderMetaFields(array $values, array $errors = array(), array $attributes = array())
    {
        $metadata = $this->taskMetadataModel->getAll($values['id']);
        $html = '';
        
        foreach ($metadata as $key => $value) {
         $values['metamagikkey_' . $key] = $metadata[$key];
         $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);
         $html .= $this->helper->form->text('metamagikkey_' . $key, $values, $errors, $attributes, 'form-input-small');
        }

        return $html;
    }

    public function createMetaFields(array $values, array $errors = array(), array $attributes = array())
    {
        $metadata = $this->metadataTypeModel->getAll();
        $html = '';
        
        foreach ($metadata as $meta) {
         $values['metamagikkey_' . $meta] = $meta['human_name'];
         $html .= $this->helper->form->label($meta['human_name'], 'metamagikkey_' . $meta);
         $html .= $this->helper->form->text('metamagikkey_' . $meta, $values, $errors, $attributes, 'form-input-small');
        }

        return $html;
    }    
    
}
