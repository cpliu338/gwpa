    <table class="table table-striped">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('code') ?></th>
            <th><?= $this->Paginator->sort('remark') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($accounts as $account): ?>
        <tr>
            <td><?= $this->Number->format($account->id) ?></td>
            <td><?= h($account->name) ?></td>
            <td><?= h($account->code) ?></td>
            <td><?= h($account->remark) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $account->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $account->id]) ?>
                <!-- $this->Form->postLink(__('Delete'), ['action' => 'delete', $account->id], ['confirm' => __('Are you sure you want to delete # {0}?', $account->id)]) -->
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
