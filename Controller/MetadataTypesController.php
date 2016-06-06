<?php

namespace Kanboard\Plugin\Metadata\Controller;

use Kanboard\Controller\Base;
use Kanboard\Plugin\Metadata\Model\MetadataType;

/**
 * Class MetadataTypes
 *
 * @package Kanboard\Plugin\Metadata\Controller
 * @author Daniele Lenares <daniele.lenares@gmail.com>
 */
class MetadataTypes extends Base
{
    /**
     * Action to list and save Metadata types in the config section
     *
     * @access public
     */
    public function config()
    {
        $errors = array();
        $values = array();

        if ($this->request->isPost()) {
            $values = $this->request->getValues();

            $validation_errors = $this->validateValues($values);

            if(!$validation_errors) {
                $machine_name = $this->createMachineName($values['human_name']);
                $values['machine_name'] = $machine_name;
                $type_id = $this->metadataType->persist(MetadataType::TABLE, $values);
                if ($type_id) {
                    $this->flash->success(t('Metadata type created successfully.'));
                } else {
                    $this->flash->failure(t('Error saving the metadata type. Retry.'));
                }
            } else {
                $errors = $validation_errors;
                $this->flash->failure(t('There are errors in your submission.'));
            }
        }

        $metadataTypes = $this->metadataType->getAll();

        $this->response->html($this->helper->layout->config('Metadata:config/metadata_types', array(
            'values' => $values,
            'errors' => $errors,
            'types' => $metadataTypes,
            'title' => t('Settings').' &gt; '.t('Metadata Types'),
        )));
    }


    /**
     * Validate form input values
     *
     * @access private
     * @param array $values The data from the form
     * @return array|bool
     */
    private function validateValues($values)
    {
        $errors = array();

        if ($values['human_name'] == '') {
            $errors['human_name'] = array(t('This cannot be empty.'));
        }

        if ($values['data_type'] == '') {
            $errors['data_type'] = array(t('You need to select an option.'));
        }

        if ($values['attached_to'] == '') {
            $errors['attached_to'] = array(t('You need to select an option.'));
        }

        return empty($errors) ? false : $errors;
    }


    /**
     * Create a machine name of the metadata type
     * from the friendly name inserted by the user
     *
     * @access private
     * @param string $human_name The human name of the metadata type
     * @return string
     */
    private function createMachineName($human_name = '')
    {
        $machine_name = strtolower($human_name);
        // Remove special characters
        $machine_name = preg_replace('/[^a-z0-9_\s-]/', '', $machine_name);
        // Cleanup multiple dashes or whitespaces
        $machine_name = preg_replace('/[\s-]+/', ' ', $machine_name);
        // Replace whitespaces with underscores
        $machine_name = preg_replace('/[\s]/', "_", $machine_name);

        return $machine_name;
    }
}