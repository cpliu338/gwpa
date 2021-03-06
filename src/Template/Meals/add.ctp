<form method="post">
	<input name="washers" id="washers"
	value ="<?= $dt->i18nFormat('yyyy-MM-dd HH:mm:ss')?>">
    </input>
    <input name="eaters"  id="eaters"
           value ="<?= $dt->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT])?>">
    </input>
    <button id="submit" type="submit">Submit</button>
</form>
        <div class="drop" id="wash">
        <div class="drag mobiledraganddrop1drag" id="CP">
                <p>CP</p>
        </div>
                <div style="clear: both;"><p>Wash and eat</p></div>
        </div>
        <div class="drop" id="eat">
        <div class="drag mobiledraganddrop1drag" id="CP">
                <p>Cindy</p>
        </div>
                <div style="clear: both;"><p>Eat only</p></div>
        </div>
    <div class="drop" id="out">
            <div style="clear: both;"><p>Absent</p></div>
    </div>
        <div class="drag" id="Peter">
                <p>Peter</p>
        </div>
        <div class="drag" id="James">
                <p>James</p>
        </div>
<script>
$(document).ready(function() {
    $(".drag").mobiledraganddrop({ targets: ".drop", status: "#status"});
    $("form").submit(function(e){
        var v = [];
        $("#wash").children(".drag").each(function(){
            v.push($(this).attr("id"));
        });
        $("#washers").val(v.join());
        v = [];
        $("#eat").children(".drag").each(function(){
            v.push($(this).attr("id"));
        });
        $("#eaters").val(v.join());
        $("#submit").text("Please wait...");
        $("#submit").prop("disabled",true);
        //e.preventDefault();
    });
});
</script>
<?php $this->start('css')?>
<style type="text/css">
		.drag, .drag2 {
			float: left;
			width: 21%;
			background-color: Green;
			color: White;
			margin: 10px 2%;
			cursor: move;
			text-align: center;
			-moz-border-radius: 1em;
			-webkit-border-radius: 1em;
			border-radius: 1em;
		}
		
		.selected {
			background-color: Yellow;
			color: Black;
		}
		
		.drop {
			background-color: Blue;
			color: White;
			margin: 3px;
			padding: 10px;
			-moz-border-radius: 1em;
			-webkit-border-radius: 1em;
			border-radius: 1em;
		}

		.active {
			background-color: orange;
			cursor: crosshair;
		}
</style>
<?php $this->end()?>
<?= $this->Html->script(['mobiledragdrop']) ?>