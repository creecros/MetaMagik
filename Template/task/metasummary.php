

<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
if (empty($metadata)): 
?>
    <p class="alert"><?= t('No metadata') ?></p>
<?php else: ?>
<button class="accordion"><?= t('Section 1') ?></button>
<div class="panel">
  <?php foreach ($metadata as $key => $value): ?>
    <p><?= $key ?></p>
    <p><?= $value ?></p>
    <?php endforeach ?>
</div>

<?php endif ?>
