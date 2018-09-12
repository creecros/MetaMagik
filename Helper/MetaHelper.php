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
         $html .= $this->helper->form->text('metamagikkey' . $key, $values, $errors, $attributes, 'form-input-small');
        }

        return $html;
    }

}
