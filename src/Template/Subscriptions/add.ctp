    <form method="get" role="form" class="form-inline">
        <select name="div" class="form-control">
<?php foreach ($divisions as $division): ?>
            <option value="<?= $division->division ?>" <?php if ($div==$division->division) echo 'selected'?>><?= $division->division ?></option>
<?php endforeach;?>
        </select>
        <select name="year" class="form-control">
<?php 
    $y = $year;
    for ($y=$year-2; $y<$year+3; $y++) {
        echo "<option value='$y'";
        if ($year == $y) {echo " selected";}
        echo ">$y</option>";
    }
?>
        </select>
        <button class="btn btn-default" type="submit" >Go</button>
    </form>
    <div>
    </div>
<?php foreach ($subscriptions as $subscription): ?>
    <span title="id:<?= $subscription->id?>"><?= $subscription->member->name?> (<?= $subscription->batch?>)</span>
<?php endforeach;?>
    <div class="select v2">
<?php foreach ($members as $member): ?>
	<div class="member option" id="member_<?=$member->id?>">
	   <?=$member->name?>
        </div>
<?php endforeach;?>
    </div>
    <?= $this->Form->create($subscriptions, ['role'=>'form']) ?>
    <fieldset>
        <legend><?= __('Add Subscription') ?></legend>
        <?php
            echo $this->Form->input('ids', ['class'=>'form-control', 'type' => 'text', 'id'=>'pick']);
            echo $this->Form->input('year1', ['class'=>'form-control', 'value'=>$year]);
            echo $this->Form->input('batch', ['class'=>'form-control', 'value'=>$maxbatch]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class'=>'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

<script>
  $(document).on("ready page:change", function() {
    return $(".v2 .option").click(function() {
      var pick;
      pick = "";
      $(this).toggleClass("active");
      $(".v2 .active").each(function() {
        return pick += $(this).attr('id').substring(7) + ",";
      });
      return $("#pick").val(pick);
    });
  });
</script>