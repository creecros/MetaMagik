
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script> 
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
        <div class="container text-center">
        <table>
                <thead>
        <tr>
          <th><?= t('Custom Field') ?></th>
          <th><?= t('Value') ?></th>
        </tr>
                </thead>
                <tbody>
  <?php foreach ($metadata as $key => $value): ?>
        <?php if (!empty($value)): ?>
                <tr id="<?= $i++ ?>">
        <td>
        <strong><?= $key ?></strong>
                </td>
                <td><?= $value ?></td>
                        </tr>
        <?php endif ?>
    <?php endforeach ?>
                </tbody>
        </table>
</div>
        </div>
<script type="text/javascript">
  $('tbody').sortable();
</script>
</section>
<?php endif ?>
