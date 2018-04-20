<?php
/**
 * In category order table view
 */
?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		var fixHelper = function(e, ui) {
			ui.children().each(function() {
				$(this).width($(this).width());
			});
			return ui;
		};
		$("#sortit tbody").sortable({
			helper: fixHelper,
			placeholder: "ui-state-highlight"
		}).disableSelection();
		$(".remove").click(function(){
			var r=confirm("<?php $this->tsure; ?>");
			if (r==true){
				$(this).parent().parent().remove();
			}
		});
	});
</script>
<style type="text/css">
#sortit tbody tr{cursor:move;}
.ui-state-highlight { 
	height: 1.5em; line-height: 1.2em; 
	border: 2px solid #fcefa1;
	background: #fbf9ee;
	color: #363636;
}
.remove{display:none;
	color: red;
	font-size: small;
	cursor: pointer;
}
.ui-sortable-helper{background: #999898;}
.pname:hover .remove{display:block;}
</style>
<tr class="form-field">
	<th scope="row" valign="top"><label for="in_cat_order"><?php $this->label ?></label></th>
	<td>
		<legend>
		<label for="clear_in_cat_order"><?php $this->labelClear ?>
			<input style="width:auto !important;" type="checkbox" class="ckb" name="clear_in_cat_order" value="1">
		</label>
		</legend>
		<table class="widefat" id="sortit">
			<thead>
				<tr>
    				<th style="width: 5%; text-align: center;"><?php $this->tid; ?></th>
    				<th><?php $this->tname; ?></th>
    				<th style="width: 15%;"><?php $this->tthumb; ?></th>
				</tr>
			</thead>
			<tfoot>
			    <tr>
			    	<th style="width: 5%; text-align: center;"><?php $this->tid; ?></th>
    				<th><?php $this->tname; ?></th>
    				<th style="width: 15%;"><?php $this->tthumb; ?></th>
			    </tr>
			</tfoot>
			<?php $this->rows; ?>			
		</table>
	</td>
</tr>