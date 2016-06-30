<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Subscription'), ['action' => 'edit', $subscription->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Subscription'), ['action' => 'delete', $subscription->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subscription->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Subscriptions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subscription'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="subscriptions view large-10 medium-9 columns">
    <h2><?= h($subscription->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Member') ?></h6>
            <p><?= $subscription->has('member') ? $this->Html->link($subscription->member->id, ['controller' => 'Members', 'action' => 'view', $subscription->member->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($subscription->id) ?></p>
            <h6 class="subheader"><?= __('Year1') ?></h6>
            <p><?= $this->Number->format($subscription->year1) ?></p>
            <h6 class="subheader"><?= __('Batch') ?></h6>
            <p><?= $this->Number->format($subscription->batch) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($subscription->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($subscription->updated_at) ?></p>
        </div>
    </div>
</div>
