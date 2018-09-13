

<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
if (empty($metadata)): 
?>
    <p class="alert"><?= t('No metadata') ?></p>
<?php else: ?>
<div class="accordion-title">
        <h3><a href="#" class="fa accordion-toggle"></a> <?= t('MetaMagik') ?></h3>
    </div>
<div class="accordion-content">
  <?php foreach ($metadata as $key => $value): ?>
    <p><?= $key ?></p>
    <p><?= $value ?></p>
    <?php endforeach ?>
</div>

<?php endif ?>
