<div class="wrap">
<h2>Twit-update</h2>

<form method="post" action="options.php">
<?php settings_fields('twit-opt');?>
<table class="form-table">
<tr valign="top">
<th scope="row">Twitter login</th>
<td><input type="text" name="twit_mail" value="<?php echo get_option('twit_mail'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Twitter password</th>
<td><input type="password" name="twit_pass" value="<?php echo get_option('twit_pass'); ?>" /></td>
</tr>

<tr valign="top">
<td><input type="checkbox" name="twit_new" value="1" <?php if( get_option('twit_new')=="1") echo "checked=\"1\"" ?> /> Let people know when I post.<br/>
<input type="checkbox" name="twit_edit" value="1" <?php if( get_option('twit_edit')=="1") echo "checked=\"1\"" ?>/> Let people know when I edit.
</td>
</tr>

<tr valign="top">
<th scope="row">New post message</th>What this amazing plugin will do is post to twitter every time you edit a post.

<td><input type="text" name="twit_new_m" value="<?php echo get_option('twit_new_m'); ?>" /></td>

<tr valign="top">
<th scope="row">Edited post message</th>

<td><input type="text" name="twit_edit_m" value="<?php echo get_option('twit_edit_m'); ?>" /><br/>Variables: [n] post name, [url] post url, [a] author, [c] comment count, [o] original post date, [l] date last modified, [all] post content, [some] post excerpt</td>

</tr>

<tr valign="top">
<td><input type="checkbox" name="twit_cred" value="1" <?php if( get_option('twit_cred')=="1") echo "checked=\"1\"" ?> /> Do not include backlink(bottom of page)
</td>
</tr>

</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>