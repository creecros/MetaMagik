<table
       class="metadata-table table-striped table-scrolling"
       data-save-position-url="<?= $this->url->href('MetadataTypesController', 'movePosition', array('task_id' => $task['id'])) ?>"
>
<thead>
        <tr>
          <th><?= t('Custom Field') ?></th>
          <th><?= t('Value') ?></th>
        </tr>
</thead>
<tbody>
  <?php foreach ($custom_fields as $custom_field): ?>
        <?php if (!empty($this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], ''))): ?>
        <tr data-metadata-id="<?= $custom_field['id'] ?>">
                  <td><i class="fa fa-arrows-alt draggable-row-handle ui-sortable-handle" title="Change metadata position"></i>&nbsp;<strong><?= $custom_field['human_name'] ?></strong></td>
                  <td><?= $this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '') ?></td>
        </tr>
        <?php endif ?>
    <?php endforeach ?>
</tbody>
</table>
