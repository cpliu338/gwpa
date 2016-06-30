<?php $this->start('script');?>
<script>
    var json = <?= $json?>;
    function updateTable() {
        var tr;
        $("tbody").empty();
        for (var i = 0; i < json.length; i++) {
            tr = $('<tr class=""/>');
            tr.data('row', i);
            tr.append("<td>" + json[i].account + "</td>");
            tr.append("<td>" + json[i].amount + "</td>");
            an = $('<a class="editable"/>');
            an.text(json[i].detail).html();
            an.data("row", i);
            td = $('<td/>');
            td.html(an);
            tr.append(td); //"<td>" + json[i].detail + "</td>");
            $('tbody').append(tr);
        }
        $(".editable").click(function() {
            //alert('Clicked');
            pull($(this).parents('tr').data("row"));
        });
    }
    
    function pull($rowno) {
        if ($rowno < json.length) {
            $('#account-id').val(json[$rowno].account);
            $('#amount').val(json[$rowno].amount);
            $('#detail').val(json[$rowno].detail);
        }
        else {
            $rowno = json.length;
            $('#account-id').val('');
            $('#amount').val('0.00');
            $('#detail').val('Row no'+$rowno);
        }
        $('#edit-dialog').data('row', $rowno);
    }
    
    function push() {
        $rowno = $('#edit-dialog').data('row');
        if ($rowno >= json.length) {
            $rowno = json.length;
            json.push({});
        }
        json[$rowno].account = $('#account-id').val();
        json[$rowno].amount = $('#amount').val();
        json[$rowno].detail = $('#detail').val();
    }
    
    $(document).ready(function () {
        updateTable();
        $("#update").click(function() {
            push();
            updateTable();
        });
        $("#confirm").click(function() {
            /*alert(JSON.stringify(json));*/
            $("#objects").val(JSON.stringify(json));
            $("#form1").submit();
        });
    });
    $(function() {
    var availableAccounts = [
    // note the quotes in front and end
        '<?= join("','", $accounts)?>'
    ];
    $( "#account-id" ).autocomplete({
      source: availableAccounts
    });
  });
</script>
<?php $this->end();?>
<?php
    $this->assign('title', 'Entries');
?>
    <table class="table">
        <thead>
            <tr>
                <th>Account</th>
                <th>Amount</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr><td>
<script>
    document.write('<a id="add" data-row="' + json.length + '" class="editable">');
    document.write('Add</a>');
</script>
            </td></tr>
        </tfoot>
    </table>
<form class="form-horizontal" method="post" accept-charset="utf-8" action="/entries/transact/<?= $ref?>" id="form1" role="form">
    <div style="display:none;"><input type="hidden" name="_method" value="PUT"></div>
    <div class="input number required">
        <label class="control-label" for="ref">Ref</label>
        <input class="form-control" type="number" name="ref" readonly="true" id="ref" value="<?=$ref?>">
    </div>
    <div class="input required">
        <label class="control-label" for="ref"><?= __('incurred_on')?></label>
        <input class="form-control" name="incurred_on" required="required" id="incurred_on" value="<?=$incurred_on->i18nFormat("yyyy-MM-dd")?>">
    </div>
    <input type="hidden" name="objects" id="objects" value=""/>
    <button id="confirm" class="btn btn-primary">Confirm</button>
    <?= $this->Html->link('Cancel and return to Entries', '/entries', [ 'class'=>"btn btn-link"])?>
</form>
<div id="edit-dialog">
    <div class="input">
        <label class="control-label" for="account-id">Account id</label>
        <input class="form-control" type="text" name="account_id[0]" required="required" id="account-id" value="">
    </div>
    <div class="input number">
        <label class="control-label" for="amount">Amount</label>
        <input class="form-control" type="number" name="amount[0]" step="0.01" id="amount" value="">
    </div>
    <div class="input text required">
        <label class="control-label" for="detail">Detail</label>
        <input class="form-control" type="text" name="detail[0]" required="required" maxlength="255" id="detail" value="">
    </div>
    <button class="btn btn-default" id="update">Update</button>
</div>
<script>
    $("#incurred_on").datetimepicker({
        format: 'Y-m-d',
        timepicker:false
    });
</script>