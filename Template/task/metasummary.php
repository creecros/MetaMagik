
<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
$custom_fields = $this->task->metadataTypeModel->getAll();
if ($_SESSION['user']['role'] == 'app-admin') { $edits = true; } else { $edits = false; }
if (empty($custom_fields)): 
?>
<?php else: ?>
<section class="accordion-section <?= empty($metadata) ? 'accordion-collapsed' : '' ?>">
<div class="accordion-title">
        <h3><a href="#" class="fa accordion-toggle"></a> <?= t('MetaMagik') ?></h3>
    </div>
<div class="accordion-content">
        <?= $this->render('metaMagik:task/metatable', array(
            'custom_fields' => $custom_fields,
            'task' => $task,
            'editable' => $edits
        )) ?>
</div>

</section>
<?php endif ?>
