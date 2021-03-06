        <h3><?= $year ?>
            
        </h3>
<?php foreach ($years as $year): ?>
    <?= $this->Html->link($year, ['action'=>'index', $year]) ?>
<?php endforeach; ?>
<p>Plain text <?= $this->Html->link("Report", ['action'=>'report', $year]) ?> for Labour Dept Audit</p>
    <table class="table">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('Members.division','Division') ?></th>
            <th><?= $this->Paginator->sort('Members.name1','Name1') ?></th>
            <th><?= $this->Paginator->sort('Members.name2','Name2') ?></th>
            <th><?= $this->Paginator->sort('batch') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($subscriptions as $subscription): ?>
        <tr>
            <td><?= h($subscription->member->division) ?></td>
            <td><?= h($subscription->member->name1) ?></td>
            <td><?= h($subscription->member->name2) ?></td>
            <td><?= $this->Number->format($subscription->batch) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $subscription->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $subscription->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subscription->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subscription->id)]) ?>
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

<script>
$(function() {
   $("#year").change(function() {
     $("#form1").submit();
   });
 });
</script>