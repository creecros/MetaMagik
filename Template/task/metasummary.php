

<?php 
$metadata = $this->task->taskMetadataModel->getAll($task['id']);
uksort($metadata, 'strcasecmp');
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
        <tr>
  <?php foreach ($metadata as $key => $value): ?>
        <?php if (!empty($value)): ?>
        <td>
        <i class="fa fa-arrows-alt draggable-row-handle" title="<?= t('Change position') ?>"></i>&nbsp;
        <strong><?= $key ?></strong>
                </td>
                <td><?= $value ?></td>
        <?php endif ?>
    <?php endforeach ?>
        </tr>
        </table>
</div>
</section>
<?php endif ?>
