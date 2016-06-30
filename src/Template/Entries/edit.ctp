<?php $this->start('script');?>
<script>
        var json = <?=$related_entries?>;
// http://stackoverflow.com/questions/5524045/jquery-non-ajax-post
function postForm(action, method, input) {
    'use strict';
    var form;
    form = $('<form />', {
        action: action,
        method: method,
        style: 'display: none;'
    });
    if (typeof input !== 'undefined' && input !== null) {
        $.each(input, function (name, value) {
            $('<input />', {
                type: 'hidden',
                name: name,
                value: value
            }).appendTo(form);
        });
    }
    form.appendTo('body').submit();
}
function jqueryPost(action, method, input) {
    "use strict";
    var form;
    form = $('<form />', {
        action: action,
        method: method,
        style: 'display: none;'
    });
    if (typeof input !== 'undefined') {

        $.each(input, function (name, value) {

            if( typeof value === 'object' ) {

                $.each(value, function(objName, objValue) { 

                    $('<input />', {
                        type: 'hidden',
                        name: name + '[]',
                        value: objValue
                    }).appendTo(form);
                } );      
            }
            else {

                $('<input />', {
                    type: 'hidden',
                    name: name,
                    value: value
                }).appendTo(form);
            }
        });
    }
    form.appendTo('body').submit();
}
$(document).ready(function () {
//        console.log( "document loaded" );
        var tr;
        for (var i = 0; i < json.length; i++) {
            tr = $('<tr/>');
            tr.append("<td>" + json[i].incurred_on + "</td>");
            tr.append("<td>" + json[i].amount + "</td>");
            tr.append("<td>" + json[i].detail + "</td>");
            $('tbody').append(tr);
        }
    });
    $(document).ready(function () {
		$("#postit").click(function() {
			var obj = [
				{'amount':json[0].amount, 'detail':json[0].detail},
				{'amount':json[1].amount, 'detail':json[1].detail},
			];
			jqueryPost('/entries/transact', 'post', obj);
		});
    });
</script>
<?php $this->end();?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $entry->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $entry->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Entries'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?></li>
    </ul>
</div>
<?php debug($related_entries);?>
<div class="entries form large-10 medium-9 columns">
    <table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Amount</th>
        <th>Detail</th>
    </tr>
    </thead>
    <tbody></tbody>
    </table>
    <p><input id="postit" type="button" value="Confirm"/></p>
    <?= $this->Form->create($entry) ?>
    <fieldset>
        <legend><?= __('Edit Entry') ?></legend>
        <?php
            echo $this->Form->input('ref');
            echo $this->Form->input('incurred_on', ['empty' => true, 'default' => '']);
            echo $this->Form->input('account_id', ['options' => $accounts, 'empty' => true]);
            echo $this->Form->input('amount');
            echo $this->Form->input('detail');
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
