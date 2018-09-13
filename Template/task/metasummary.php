

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
       <div class="task-summary-container color-<?= $task['color_id'] ?>">
        <div class="task-summary-columns">
            <div class="task-summary-column">
  <?php 
        $rows = 0;
        foreach ($metadata as $key => $value): 
        $rows += 1; 
  ?>
        <?php if ($rows <= 3): ?>
        <p><strong><?= $key ?><?= t(': ') ?></strong><?= $value ?></p>
        <?php else: ?>
                </div>
                <div class="meta-summary-column">
                        <p><strong><?= $key ?><?= t(': ') ?></strong><?= $value ?></p>
    <?php endforeach ?>
     </div>
   </div>
</div>
</section>
<?php endif ?>
