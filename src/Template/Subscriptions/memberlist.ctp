<h2><?= "$yr $division members"?></h2>
<div class="subscriptions index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <tbody>
    <?php foreach ($subscriptions as $subscription): ?>
        <tr>
            <td><?= h($subscription->member->name1) ?></td>
            <td><?= h($subscription->member->name2) ?></td>
            <td><?= h($subscription->member->post) ?></td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
</div>
<nav>
    <?php foreach ($members as $member): ?>
    <?php $div = $member['Members']->division;?>
    <?php 
    if ($div != $division) {
        echo $this->Html->link($div,['action'=>'memberlist', $defaultYear, '?'=>['div'=>$div]]);
    }
    ?>
    <?php endforeach; ?>
</nav>
