<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $subscription->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $subscription->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Subscriptions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="subscriptions form large-10 medium-9 columns">
    <?= $this->Form->create($subscription) ?>
    <fieldset>
        <legend><?= __('Edit Subscription') ?></legend>
        <?php
            echo $this->Form->input('member_id', ['options' => $members, 'empty' => FALSE]);
            echo $this->Form->input('year1');
            echo $this->Form->input('batch');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
