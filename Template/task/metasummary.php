<br><br>
<?php 
$custom_fields = $this->task->metadataTypeModel->getAllInScope($task['project_id']);
$set = $this->task->metadataTypeModel->existsInTask($task['id']);
if ($_SESSION['user']['role'] == 'app-admin') { $edits = true; } else { $edits = false; }
if (!$set): 
?>
<?php else: ?>
<details class="accordion-section" <?= empty($custom_fields) ? 'accordion-collapsed' : 'open' ?>>
<summary class="accordion-title">
        <h3><?= t('Custom Fields') ?></h3>
    </summary>
<div class="accordion-content">
        <article class="markdown">
		<?= $this->render('metaMagik:task/metatable', array(
            'custom_fields' => $custom_fields,
            'task' => $task,
            'editable' => $edits,
            'printlayout' => (!isset($printlayout)) ? false : $printlayout
        )) ?>
		</article>
</div>

</details>
<?php endif ?>
