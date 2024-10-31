<h1><?=__('Multilingual options');?></h1>
<form method="post">

<table class="form-table">
<?php
 	/*
	<tr>
		<th><label for="automatic_lang_redirection"><?=__('Automatic redirection');?></label></th>
		<td><select style="width:100px;" name="automatic_lang_redirection" class="regular-text"><option value="yes"><?=__('Yes');?></option><option value="no" <?=$auto_default;?>><?=__('No');?></option></select><small><?=__('Automatically redirect to the translated content');?></small></td>
	</tr>

	<tr>
		<th><label for="automatic_lang_redirection"><?=__('Redirect by sessions');?></label></th>
		<td><select style="width:100px;" name="session_lang_redirection" class="regular-text"><option value="yes"><?=__('Yes');?></option><option value="no" <?=$sess_default;?>><?=__('No');?></option></select><small><?=__('Redirect only if the user has created his session');?></small></td>
	</tr>
	<tr>
	*/
?>
		<th><label for="show_lang_warnings"><?=__('Show warnings');?></label></th>
		<td><select style="width:100px;" name="show_lang_warnings" class="regular-text"><option value="yes"><?=__('Yes');?></option><option value="no" <?=$warn_default;?>><?=__('No');?></option></select><small><?=__('Show a small warning in the top of the posts which has a posible translation');?></small></td>
	</tr>
	<tr>
		<th><label for="show_alternatves_box"><?=__('Show alteratives');?></label></th>
		<td><select style="width:100px;" name="show_alternatives_box" class="regular-text"><option value="yes"><?=__('Yes');?></option><option value="no" <?=$alt_default;?>><?=__('No');?></option></select><small><?=__('Show a box with some alternatives for the post in other languages under each post');?></small></td>
	</tr>
</table>
<p class="submit">
	<input type="submit" class="button-primary" value="<?=__('Change');?>" />
</p>
</form>
