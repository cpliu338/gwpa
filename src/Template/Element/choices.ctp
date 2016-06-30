<script>
  $(function() {
    var availableRanks = [
<?php foreach ($ranks as $rank): ?>
     "<?= $rank->rank?>",
<?php endforeach; ?>
    ];
    $( "#rank" ).autocomplete({
      source: availableRanks
    });
    var availableDivisions = [
<?php foreach ($divisions as $division): ?>
     "<?= $division->division?>",
<?php endforeach; ?>
    ];
    $( "#division" ).autocomplete({
      source: availableDivisions
    });
  });
</script>
