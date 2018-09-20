

<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
if (empty($metadata)): 
?>
<?php else: ?>
<section class="accordion-section <?= empty($metadata) ? 'accordion-collapsed' : '' ?>">
<div class="accordion-title">
        <h3><a href="#" class="fa accordion-toggle"></a> <?= t('MetaMagik') ?></h3>
    </div>
<div class="accordion-content">
  <?php foreach ($metadata as $key => $value): ?>
        <?php if (!empty($value)): ?>
        <p><strong><?= $key ?><?= t(': ') ?></strong><?= $value ?></p>
        <?php endif ?>
    <?php endforeach ?>

</div>
</section>
<?php endif ?>
