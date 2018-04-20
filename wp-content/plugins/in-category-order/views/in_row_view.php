<?php
/**
 * In category order row view
 */
?>
<tr>
	<td><?php $this->id; ?></td>
	<td class="pname">
		<?php $this->name; ?>
		<input type="hidden" name="in_cat_order[]" style="width:60%;" value="<?php $this->id; ?>">
		<br />
		<span class="remove"><?php $this->tremove; ?></span>
    </td>
    <td><?php $this->thumb; ?></td>
<tr>