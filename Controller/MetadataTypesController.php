<?php

namespace Kanboard\Plugin\MetaMagik\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\MetaMagik\Model\MetadataTypeModel;

/**
 * Class MetadataTypes.
 *
 */
class MetadataTypesController extends BaseController
{
    /**
     * Action to list and save Metadata types in the config section.
     */
    public function config()
    {
        $errors = [];
        $values = [];

        if ($this->request->isPost()) {
            $values = $this->request->getValues();

            $validation_errors = $this->validateValues($values);

            if (!$validation_errors) {
                $values['human_name'] = $this->fixHumanName($values['human_name']); 
                $machine_name = $this->createMachineName($values['human_name']);
                $values['machine_name'] = $machine_name;
                $type_id = $this->db->table(MetadataTypeModel::TABLE)->persist($values);
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

        $metadataTypes = $this->metadataTypeModel->getAll();

        $this->response->html($this->helper->layout->config('MetaMagik:config/metadata_types', [
            'values' => $values,
            'errors' => $errors,
            'types'  => $metadataTypes,
            'title'  => t('Settings').' &gt; '.t('Custom Fields'),
        ]));
    }

    /**
     * Validate form input values.
     *
     * @param array $values The data from the form
     *
     * @return array|bool
     */
    private function validateValues($values)
    {
        $errors = [];
        
        if (strpos($values['human_name'], ' ')) {
            $errors['human_name'] = [t('Please, do not use spaces.')];
        }
        
        if (strpos($values['human_name'], '.')) {
            $errors['human_name'] = [t('Please, do not use periods.')];
        }
        
        if ($values['human_name'] == '') {
            $errors['human_name'] = [t('This cannot be empty.')];
        }

        if ($values['data_type'] == '') {
            $errors['data_type'] = [t('You need to select an option.')];
        }

        if ($values['attached_to'] == '') {
            $errors['attached_to'] = [t('You need to select an option.')];
        }

        return empty($errors) ? false : $errors;
    }

    /**
     * Create a machine name of the metadata type
     * from the friendly name inserted by the user.
     *
     * @param string $human_name The human name of the metadata type
     *
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
        $machine_name = preg_replace('/[\s]/', '_', $machine_name);

        return $machine_name;
    }
    
    private function fixHumanName($human_name = '')
    {
        // Remove special characters
        $human_name = preg_replace('/[^A-Za-z0-9_\s-]/', '', $human_name);
        // Cleanup multiple dashes or whitespaces
        $human_name = preg_replace('/[\s-]+/', ' ', $human_name);
        // Replace whitespaces with underscores
        $human_name = preg_replace('/[\s]/', '_', $human_name);

        return $human_name;
    }
    
    public function confirmTask()
    {
        $key = $this->request->getStringParam('key');
        $this->response->html($this->template->render('metaMagik:config/remove', [
                    'key'     => $key,
        ]));
    }
    
     public function removeTask()
    {
        $key = $this->request->getStringParam('key');
        $this->metadataTypeModel->remove($key);
         
        return $this->response->redirect($this->helper->url->to('MetadataTypesController', 'config', ['plugin' => 'metaMagik']));

    }
    
    public function movePosition()
    {
        $values = $this->request->getJson();

        if (! empty($values) && $_SESSION['user']['role'] == 'app-admin') {
            $result = $this->metadataTypeModel->changePosition($values['id'], $values['position'], $values['columnnumber']);
            $this->response->json(array('result' => $result));
        } else {
            throw new AccessForbiddenException();
        }
    }
    

}
