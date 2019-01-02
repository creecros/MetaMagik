<?php

namespace Kanboard\Plugin\MetaMagik\Helper;

use Kanboard\Core\Base;
use Kanboard\Model\UserModel;

/**
 * Meta helper
 *
 */
class MetaHelper extends Base
{

    public function renderMetaTextField($key, $value, array $errors = array(), array $attributes = array())
    {
        $html = "";
        $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);
        $html .= $this->helper->form->text('metamagikkey_' . $key, ['metamagikkey_' . $key => $value], $errors, $attributes, 'form-input-small');
        return $html;
    }
    
    public function renderDateField($key, $value, array $errors = array(), array $attributes = array())
    {
        $html = "";
        $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);
        $html .= $this->helper->form->input('date', 'metamagikkey_' . $key, ['metamagikkey_' . $key => $value], $errors, $attributes, 'form-input-small');
        return $html;
    }

    public function renderMetaNumberField($key, $value, array $errors = array(), array $attributes = array())
    {
        $html = "";
        $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);
        $html .= $this->helper->form->number('metamagikkey_' . $key, ['metamagikkey_' . $key => $value], $errors, $attributes, 'form-input-small');
        return $html;
    }

    public function renderMetaListField($key, $values, array $list, $type, array $errors = array(), array $attributes = array())
    {
        $map_list = [];
        foreach ($list as $name => $value) {
            $map_list[$value] = $value;
        }

        $html = "";
        $html .= $this->helper->form->label($key, 'metamagikkey_' . $key);

        switch ($type){
            case "radio": $html .= $this->helper->form->radios('metamagikkey_' . $key, $map_list, $values); break;
            case "list": $html .= $this->helper->form->select('metamagikkey_' . $key, $map_list, $values, $errors, $attributes, 'form-input-small'); break;
            case "check": $html .= $this->helper->form->checkboxes('metamagikkey_' . $key . '[]', $map_list, $values); break;
        }

        return $html;
    }

    public function renderMetaUsersField($key, $value, array $errors = array(), array $attributes = array()){
        $aux_user = new UserModel($this->container);
        $users_table = $aux_user->getActiveUsersList(false);
        $users = [];
        foreach ($users_table as $name => $valuex) {
            $users[] = $valuex;
        }
        return $this->renderMetaListField($key, $value, $users, 'list', $errors, $attributes);
    }

    public function renderMetaTableField($key, $value, $table_name, $keycolumn, $valuecolumn, array $errors = array(), array $attributes = array()){
        $meta_opt[''] = '';
        $aux_table = $this->db->table($table_name)->columns($keycolumn, $valuecolumn)->findAll();
        foreach ($aux_table as $valuex) {
            $meta_opt[$valuex[$keycolumn]] = $valuex[$valuecolumn];
        }
        return $this->renderMetaListField($key, $value, $meta_opt, 'list', $errors, $attributes);
    }

    public function renderMetaFields(array $values, $column_number, array $errors = array(), array $attributes = array())
    {
        $metasettings = $this->metadataTypeModel->getAllInColumn($column_number);
        $html = '';

        if (isset($values['id'])) {
        $metadata = $this->taskMetadataModel->getAll($values['id']);
            foreach ($metasettings as $setting) {
                if ($setting['attached_to'] == 'task') {
                    $metaisset = $this->taskMetadataModel->exists($values['id'], $setting['human_name']);
                    if (!$metaisset) {
                        $this->taskMetadataModel->save($values['id'], [$setting['human_name'] => '']);
                    }
                }
            }
        } else {
            $metadata = array();
        }

        foreach ($metasettings as $setting) {
            $key = $setting['human_name'];
            if (isset($values['id']) && $setting['data_type'] !== 'check') {
                if (isset($metadata[$key])) { $values['metamagikkey_' . $key] = $metadata[$key]; }
            } elseif (isset($values['id']) && $setting['data_type'] == 'check') {
                if (isset($metadata[$key])) {
                    $wtf = explode(',', $metadata[$key]);
              
                    foreach ($wtf as $key_fix) {
                        $values['metamagikkey_' . $key . '[]'][$key_fix] = $key_fix;
                    } 
                }
            }
            
            $new_attributes = $attributes;
            if($setting['is_required']) {
                $new_attributes['required'] = "required";
            }
            if ($setting['data_type'] == 'text') {
                $html .= $this->renderMetaTextField($key, isset($metadata[$key]) ? $metadata[$key] : "", $errors, $new_attributes);
            } elseif ($setting['data_type'] == 'number') {
                $html .= $this->renderMetaNumberField($key, isset($metadata[$key]) ? $metadata[$key] : "", $errors, $new_attributes);
            } elseif ($setting['data_type'] == 'date') {
                $html .= $this->renderDateField($key, isset($metadata[$key]) ? $metadata[$key] : "", $errors, $new_attributes);
            } else if ($setting['data_type'] == 'table') {
                $opt_explode = explode(',', $setting['options']);
                $html .= $this->renderMetaTableField($key, $values, $opt_explode[0], $opt_explode[1], $opt_explode[2], $errors, $new_attributes);
            } elseif ($setting['data_type'] == 'users') {
                $html .= $this->renderMetaUsersField($key, $values, $errors, $new_attributes);
            } elseif ($setting['data_type'] == 'list' || $setting['data_type'] == 'radio' || $setting['data_type'] == 'check') {
                $opt_explode = explode(',', $setting['options']);
                $html .= $this->renderMetaListField($key, $values, $opt_explode, $setting['data_type'], $errors, $new_attributes);
            }
        }

        return $html;
    }

}
