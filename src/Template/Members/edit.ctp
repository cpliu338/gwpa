
    <?= $this->Form->create($member, ['role'=>'form']) ?>
        <legend><?= __('Edit Member') ?></legend>
        <?php
            echo $this->Form->input('name1',['class'=>'form-control']);
            echo $this->Form->input('name2',['class'=>'form-control']);
            echo $this->Form->input('sex',['class'=>'form-control']);
            echo $this->Form->input('stream',['class'=>'form-control']);
            echo $this->Form->input('rank',['class'=>'form-control', 'id'=>'rank', 'type'=>'text']);
            echo $this->Form->input('division',['class'=>'form-control', 'id'=>'division', 'type'=>'text']);
            echo $this->Form->input('post',['class'=>'form-control']);
            echo $this->Form->input('email',['class'=>'form-control']);
        ?>
    <?= $this->Form->button(__('Edit'),['class'=>'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

<?= $this->element('choices')?>
