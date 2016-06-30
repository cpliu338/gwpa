    <?= $this->Form->create($account, ['role'=>'form']) ?>
        <legend><?= __('Edit Account') ?></legend>
        <?php
            echo $this->Form->input('name',['class'=>'form-control']);
            echo $this->Form->input('code',['class'=>'form-control']);
            echo $this->Form->input('remark',['class'=>'form-control']);
            /*
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
             */
        ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
