<?php if ($printlayout): ?>
<div class="task-summary-container color-<?= $task['color_id'] ?>" width="100%" style="padding-top:1px;vertical-align:top">
    <?php for ($i = 1; $i <=4; $i++): ?>
<div class="column" width="30%">
<table style="padding:1px;vertical-align:top">


  <?php foreach ($custom_fields as $custom_field): ?>
        <?php if (!empty($this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '')) && $custom_field['column_number'] == $i): ?>
        <tr>
                  <td style="padding-top:10px;vertical-align:top"><strong><?= $custom_field['beauty_name'] ?>:</strong>
                <?php if ($custom_field['data_type'] == 'textarea'): ?>
                  <?= $this->text->markdown($this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '')) ?></td>
                <?php elseif ($custom_field['data_type'] == 'number'): ?>
                  <?= $custom_field['options'].$this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '') ?></td>
                <?php elseif ($custom_field['data_type'] == 'date'): ?>
                <?php $date = strtotime($this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '')); ?>
                <?= $this->dt->date($date) ?></td>
                <?php else: ?>
                  <?= $this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '') ?></td>
                <?php endif ?>
        </tr>
        <?php endif ?>
    <?php endforeach ?>
</table>
</div>
<?php endfor ?>
</div>
<style>
.column {
    display:inline-table;
    padding-left: 25px;
    padding-right:65px;
    padding-top:5px;
    padding-bottom:5px;
    vertical-align:top;
}
</style>
<?php else: ?>
<style>
.column {
    float: left;
    width: 30%;
    padding: 10px;
}
    .row:after {
    content: "";
    display: table;
    clear: both;
}
</style>
<div class="row">
<?php for ($i = 1; $i <=3; $i++): ?>
<div class="column">
<table
       id="<?= $i ?>" 
       class="table-striped table-scrolling"
       data-save-position-url="<?= $this->url->href('MetadataTypesController', 'movePosition', array('plugin' => 'metaMagik')) ?>"
>
<thead>
        <tr>
          <th><?= t('Custom Field') ?></th>
          <th><?= t('Value') ?></th>
        </tr>
</thead>
<tbody id="<?= $i ?>" class="connected">
            <tr class="disabled">
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>
            </tr>
  <?php foreach ($custom_fields as $custom_field): ?>
        <?php if (!empty($this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '')) && $custom_field['column_number'] == $i): ?>
        <tr data-metadata-id="<?= $custom_field['id'] ?>">
                  <td><strong><?= $custom_field['beauty_name'] ?></strong></td>
                <?php if ($custom_field['data_type'] == 'textarea'): ?>
                  <td><?= $this->text->markdown($this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '')) ?></td>
                <?php elseif ($custom_field['data_type'] == 'number'): ?>
                  <td><?= $custom_field['options'].$this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '') ?></td>
                <?php elseif ($custom_field['data_type'] == 'date'): ?>
                <?php $date = strtotime($this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '')); ?>
                <td><?= $this->dt->date($date) ?></td>
                <?php else: ?>
                  <td><?= $this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '') ?></td>
                <?php endif ?>
        </tr>
        <?php endif ?>
    <?php endforeach ?>
</tbody>
</table>
</div>
<?php endfor ?>
</div>
<?php endif ?>
