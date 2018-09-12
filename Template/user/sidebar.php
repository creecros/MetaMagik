<?php if ($this->user->isAdmin()) {
    ?>
    <li>
        <?= $this->url->link(t('Metadata'), 'MetadataController', 'user', ['plugin' => 'metaMagik', 'user_id' => $user['id']]) ?>
    </li>
<?php 
} ?>
