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
         $html .= $this->helper->form->label($key, $key);
         $html .= $this->helper->form->text($key, $values, $errors, $attributes, 'form-input-small');
        }

        return $html;
    }

}
