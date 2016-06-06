<div class="page-header">
    <h2><?= t('Metadata') ?></h2>
</div>


<?php if (empty($metadata)): ?>
    <p class="alert"><?= t('No metadata') ?></p>
<?php else: ?>
    <table class="table-small table-fixed">
    <tr>
        <th class="column-40"><?= t('Key') ?></th>
        <th class="column-40"><?= t('Value') ?></th>
        <th class="column-20"><?= t('Action') ?></th>
    </tr>
    <?php foreach ($metadata as $key => $value): ?>
    <tr>
        <td><?= $key ?></td>
        <td><?= $value ?></td>
        <td>
            <ul>
                <li>
                    <?= $this->url->link(t('Remove'), 'MetadataController', 'confirmUser', array('plugin' => 'metadata','user_id' => $user['id'], 'key' => $key ), false, 'popover') ?>
                </li>
                <li>
                    <?= $this->url->link(t('Edit'), 'MetadataController', 'editUser', array('plugin' => 'metadata','user_id' => $user['id'], 'key' => $key ), false, 'popover') ?>
                </li>
            </ul>
        </td>
    </tr>
    <?php endforeach ?>
    </table>
<?php endif ?>


<?= $this->render('metadata:user/form', array('user' => $user, 'form_headline' => t('Add Metadata'), 'values' => array())) ?>