<?php
if ($task['nb_metadata'] > 0):
    $custom_fields = $this->task->metadataTypeModel->getAllInScope($task['project_id']);
?>  
    <br>
    <?php foreach ($custom_fields as $custom_field): ?>
        <?php if (!empty($this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '')) && $custom_field['footer_inc'] == 1): ?>
                <span class="metamagik-footer-title"><strong>  <?= $custom_field['beauty_name'] ?>: </strong></span>
                <?php if ($custom_field['data_type'] == 'textarea'): ?>
                <span class="metamagik-footer-value-md"><?= $this->text->markdown($this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '')) ?></span>
                <?php elseif ($custom_field['data_type'] == 'number'): ?>
                <span class="metamagik-footer-value"><?= $custom_field['options'].$this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '') ?></span>
                <?php elseif ($custom_field['data_type'] == 'date'): ?>
                <?php $date = strtotime($this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '')); ?>
                <span class="metamagik-footer-value"><?= $this->dt->date($date) ?></span>
                <?php else: ?>
                <span class="metamagik-footer-value"><?= $this->task->taskMetadataModel->get($task['id'], $custom_field['human_name'], '') ?></span>
                <?php endif ?>
        <?php endif ?>
    <?php endforeach ?>
<?php endif ?>
