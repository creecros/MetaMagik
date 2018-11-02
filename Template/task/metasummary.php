
<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
$i = 0;
if (empty($metadata)): 
?>
<?php else: ?>
<section class="accordion-section <?= empty($metadata) ? 'accordion-collapsed' : '' ?>">
<div class="accordion-title">
        <h3><a href="#" class="fa accordion-toggle"></a> <?= t('MetaMagik') ?></h3>
    </div>
<div class="accordion-content">
<table class="metadata-table table-striped table-scrolling">
<thead>
        <tr>
          <th><?= t('Custom Field') ?></th>
          <th><?= t('Value') ?></th>
        </tr>
</thead>
<tbody>
  <?php foreach ($metadata as $key => $value): ?>
        <?php if (!empty($value)): ?>
        <tr data-subtask-id="<?= $i++ ?>">
                  <td><i class="fa fa-arrows-alt draggable-row-handle ui-sortable-handle" title="Change subtask position"></i>&nbsp;<strong><?= $key ?></strong></td>
                  <td><?= $value ?></td>
        </tr>
        <?php endif ?>
    <?php endforeach ?>
</tbody>
</table>
</div>

</section>
<?php endif ?>
