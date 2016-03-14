    
            <form method="post" action="<?= $this->url->href('metadata', 'add', array('plugin' => 'metadata' )) ?>" autocomplete="off">
            
            
            <?= $this->form->csrf() ?>
            <?= $this->form->hidden('id', array('id' => $id)) ?>
            <?= $this->form->hidden('type', array('type' => $type)) ?>
            
            <?= $this->form->text('key', array(), array(), array('required', 'placeholder="'.t('Key').'"')) ?>
            <?= $this->form->text('value', array(), array(), array('required', 'placeholder="'.t('Value').'"')) ?>
            
            <input type="submit" value="<?= t('Add') ?>" class="btn btn-blue"/>
        </form>
    