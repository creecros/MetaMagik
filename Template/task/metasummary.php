

<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
uksort($metadata, 'strcasecmp');
$i = 0;
if (empty($metadata)): 
?>
<?php else: ?>
<section class="accordion-section <?= empty($metadata) ? 'accordion-collapsed' : '' ?>">
<div class="accordion-title">
        <h3><a href="#" class="fa accordion-toggle"></a> <?= t('MetaMagik') ?></h3>
    </div>
<div class="accordion-content">
        <table>
        <tr>
          <th><?= t('Custom Field') ?></th>
          <th><?= t('Value') ?></th>
        </tr>
        
  <?php foreach ($metadata as $key => $value): ?>
        <?php if (!empty($value)): ?>
                <tr id="<?php $i++ ?>">
        <td>
        <i class="fa fa-arrows-alt draggable-row-handle" title="<?= t('Change position') ?>"></i>&nbsp;
        <strong><?= $key ?></strong>
                </td>
                <td><?= $value ?></td>
                        </tr>
        <?php endif ?>
    <?php endforeach ?>
        
        </table>
</div>
</section>
<?php endif ?>
