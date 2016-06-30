<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Entry'), ['action' => 'edit', $entry->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Entry'), ['action' => 'delete', $entry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $entry->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Entries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Entry'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="entries view large-10 medium-9 columns">
    <h2><?= h($entry->detail) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Account') ?></h6>
            <p><?= $entry->has('account') ? $this->Html->link($entry->account->name, ['controller' => 'Accounts', 'action' => 'view', $entry->account->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Detail') ?></h6>
            <p><?= h($entry->detail) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($entry->id) ?></p>
            <h6 class="subheader"><?= __('Ref') ?></h6>
            <p><?= $this->Number->format($entry->ref) ?></p>
            <h6 class="subheader"><?= __('Amount') ?></h6>
            <p><?= $this->Number->format($entry->amount) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Incurred On') ?></h6>
            <p><?= h($entry->incurred_on) ?></p>
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($entry->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($entry->updated_at) ?></p>
        </div>
    </div>
</div>
