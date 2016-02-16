<?php if ($this->user->isAdmin() ) { ?>
    <li>
        <?= $this->url->link(t('Metadata'), 'metadata', 'user', array('plugin' => 'metadata', 'user_id' => $user['id'])) ?>
    </li>
<?php } ?>
