
    <form id="form1" action="/members" method="get" class="form-horizontal">
        <input size="30" id="name" name="name" placeholder="Surname then space then part of name" value="<?=$filter?>">
        <input type="button" id="reset" value="Reset" class="btn btn-link"/>
        <input type="submit" class="btn btn-primary" value="Filter"/>
    </form>
    <table width="100%" class="table table-striped">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('name1') ?></th>
            <th><?= $this->Paginator->sort('name2') ?></th>
            <th><?= $this->Paginator->sort('sex') ?></th>
            <th><?= $this->Paginator->sort('stream') ?></th>
            <th><?= $this->Paginator->sort('rank') ?></th>
            <th><?= $this->Paginator->sort('division') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($members as $member): ?>
        <tr>
            <td><?= $this->Number->format($member->id) ?></td>
            <td><?= h($member->name1) ?></td>
            <td><?= h($member->name2) ?></td>
            <td><?= h($member->sex) ?></td>
            <td><?= h($member->stream) ?></td>
            <td><?= h($member->rank) ?></td>
            <td><?= h($member->division) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $member->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $member->id]) ?>
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
    $(document).ready(function() {
        $("#reset").click(function() {
            $("#name").val("");
        });
    });
</script>