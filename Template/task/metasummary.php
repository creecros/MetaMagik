<br><br>
<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
$custom_fields = $this->task->metadataTypeModel->getAllInScope($task['project_id']);
$set = $this->task->metadataTypeModel->existsInTask($task['id']);
if ($_SESSION['user']['role'] == 'app-admin') { $edits = true; } else { $edits = false; }
if (!$set): 
?>
<?php else: ?>
<details class="accordion-section <?= empty($metadata) ? 'accordion-collapsed' : '' ?>">
<summary class="accordion-title">
        <?= t('MetaMagik') ?>
    </summary>
<div class="accordion-content">
        <article class="markdown">
		<?= $this->render('metaMagik:task/metatable', array(
            'custom_fields' => $custom_fields,
            'task' => $task,
            'editable' => $edits
        )) ?>
		</article>
</div>

</details>
<?php endif ?>
