<?php use Cake\I18n\Time;?>

<table cellpadding="0" cellspacing="5">
<thead>
	<tr>
		<th><?= h('incurred_on')?></th>
		<th>account_code</th>
		<th><?= h('account_name')?></th>
		<th>Ref</th>
		<th>amount</th>
		<th>detail</th>
	</tr>
</thead>
<tbody>
<?php foreach ($entries as $entry): ?>
	<tr>
		<td><?= h($entry->incurred_on->i18nFormat('yyyy-MM-dd')) ?></td>
		<td><?= $entry->account->code?></td>
		<td><?= $entry->account->name?></td>
		<td><?= $entry->ref?></td>
		<td><?= $entry->amount?></td>
		<td><?= $entry->detail?>
		</td>
	</tr>

<?php endforeach; ?>
</tbody>
</table>
