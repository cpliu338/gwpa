    <h2><?= h($account->name) ?> (<?= h($account->code) ?>)</h2>
    <div class="row">
    <div class="column large-12">
    <form id="form1" action="<?= $this->Url->build(["controller"=>'accounts','action'=>"view", $account->id])?>" method="get">
        <h4><?= __('Related Entries since') ?>
        <input name="since" required="required" id="since" value="<?=$period['incurred_on >=']->i18nFormat("yyyy-MM-dd")?>">
        </h4>
    </form>
    <?php if (!empty($entries)): ?>
    <table class="table table-striped">
        <tr>
            <th><?= __('Ref') ?></th>
            <th><?= __('Incurred On') ?></th>
            <th><?= __('Amount') ?></th>
            <th><?= __('Balance') ?></th>
            <th><?= __('Detail') ?></th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>B/F</td>
            <td><?= $total ? $this->Number->precision($total,2) : $this->Number->precision(0,2) ?></td>
            <td></td>
        </tr>
        <?php foreach ($entries as $entry): ?>
        <tr>
            <td><?= $this->Html->link($entry->ref, ['controller'=>'entries','action'=>'transact',$entry->ref]) ?></td>
            <td><?= h($entry->incurred_on->i18nFormat('yyyy-MM-dd')) ?></td>
            <td><?= $this->Number->precision($entry->amount,2)?></td>
            <td><?php $total+=$entry->amount;?><?= $this->Number->precision($total,2) ?></td>
            <td><?= h($entry->detail) ?></td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>    </div>
</div>
<div class="related row">

<script>
    $("#since").datetimepicker({
        format: 'Y-m-d',
        timepicker:false,
        onChangeDateTime:function(dp,$input){
            $("#form1").submit();
        }
    });
</script>