<br><br>
<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
$custom_fields = $this->task->metadataTypeModel->getAll();
$set = $this->task->metadataTypeModel->existsInTask($task['id']);
if ($_SESSION['user']['role'] == 'app-admin') { $edits = true; } else { $edits = false; }
if (!$set): 
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
