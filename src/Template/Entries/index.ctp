<?php use Cake\I18n\Time;?>

    <h2>From: <form id="form1" action="/entries" method="get">
        <input name="since" required="required" id="since" value="<?=$period['incurred_on >=']->i18nFormat("YYYY-MM-dd")?>">
    To: <?= $period['incurred_on <=']->i18nFormat("YYYY-MM-dd") ?></h2>
    </form>
    <table class="table table-striped">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('incurred_on') ?></th>
            <th><?= $this->Paginator->sort('ref') ?></th>
            <th><?= $this->Paginator->sort('account_id') ?></th>
            <th><?= $this->Paginator->sort('amount') ?></th>
            <th><?= $this->Paginator->sort('detail') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($entries as $entry): ?>
        <tr>
            <td><?= h($entry->incurred_on->i18nFormat('YYYY-MM-dd')) ?></td>
            <td><?= h($entry->ref) ?></td>
            <td>
                <?= $entry->has('account') ? $this->Html->link($entry->account->name, ['controller' => 'Accounts', 'action' => 'view', $entry->account->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($entry->amount) ?></td>
            <td>
                <?= $this->Html->link($entry->detail, ['action' => 'transact', $entry->ref]) ?>
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
    $("#since").datetimepicker({
        format: 'Y-m-d',
        timepicker:false,
        onChangeDateTime:function(dp,$input){
            $("#form1").submit();
        }
    });
</script>