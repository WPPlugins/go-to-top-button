<div class="wrap">
<?php
global $wpdb;
	$table = $wpdb->prefix . "gtt";


// Save settings
if( isset($_POST['action']) && $_POST['action'] == 'edit' && check_admin_referer( 'gtt-update-settings')) {
	// Validate & sanitize post fields
	if($_POST['gtt_color']) $gtt_color = sanitize_text_field($_POST['gtt_color']); else $gtt_color = '#548dbf';
	$allowed_positions = array('bottom_right', 'top_right', 'bottom_left', 'top_left');
	if(in_array($_POST['gtt_position'], $allowed_positions)) $gtt_position = sanitize_text_field( $_POST['gtt_position'] ); else $gtt_position = 'bottom_right';
	if($_POST['gtt_transparent']) $gtt_transparent = intval($_POST['gtt_transparent']); else $gtt_transparent = '70';
	if($_POST['gtt_size']) $gtt_size = intval($_POST['gtt_size']); else $gtt_size = '40';
	if($_POST['gtt_corners']) $gtt_corners = intval($_POST['gtt_corners']); else $gtt_corners = '5';
	if($_POST['gtt_icon']) $gtt_icon = preg_replace("/[^0-9]/", "", $_POST['gtt_icon']); else $gtt_icon = '000';
	if($_POST['gtt_icon_color']) $gtt_icon_color = sanitize_text_field($_POST['gtt_icon_color']); else $gtt_icon_color = '#FFFFFF';
// Store settings to DB
$query = "UPDATE $table SET `gtt_color` = '$gtt_color', `gtt_position` = '$gtt_position', `gtt_transparent` = '$gtt_transparent', `gtt_size` = '$gtt_size', `gtt_corners` = '$gtt_corners', `gtt_icon` = '$gtt_icon', `gtt_icon_color` = '$gtt_icon_color'";
	mysql_query($query);
	?>
	<div id="message" class="updated notice is-dismissible"><p><?php _e( 'Settings saved', 'gototop' );?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e( 'Hide this message', 'gototop' );?></span></button></div>
	<?php
}

	// Get settings from DB
	$set = $wpdb->get_results("SELECT * FROM $table");
?>

<div id="icon-options-general" class="icon32"><br /></div>
<h2><?php _e( 'Button settings', 'gototop' );?></h2>

<div id="poststuff" class="bsr-poststuff">
  <div id="post-body" class="metabox-holder columns-2">
    <div id="post-body-content">
      <div class="postbox">
        <div class="inside">

<form action="" method="post">

<table class="form-table">
	<tbody>
	<tr>
		<th scope="row"><?php _e( 'Button color', 'gototop' );?></th>
		<td>
		<input type="text" name="gtt_color" value="<?=$set[0]->gtt_color?>" class="my-color-field" data-default-color="#548dbf" />
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Arrow color', 'gototop' );?></th>
		<td>
		<input type="text" name="gtt_icon_color" value="<?=$set[0]->gtt_icon_color?>" class="my-color-field" data-default-color="#FFFFFF" />
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Transparency', 'gototop' );?></th>
		<td>
		<input type="number" min="10" max="100" step="10" name="gtt_transparent" value="<?=$set[0]->gtt_transparent?>" /> %
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Button size', 'gototop' );?></th>
		<td>
		<input type="number" min="20" max="200" step="1" name="gtt_size" value="<?=$set[0]->gtt_size?>" /> px
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Border radius', 'gototop' );?></th>
		<td>
		<input type="number" min="2" max="100" step="1" name="gtt_corners" value="<?=$set[0]->gtt_corners?>" /> px
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Arrow type', 'gototop' );?></th>
		<td>

			<table>
				<tr>
					<td><span class="flaticon-000"></span></td>
					<td><span class="flaticon-002"></span></td>
					<td><span class="flaticon-003"></span></td>
					<td><span class="flaticon-004"></span></td>
					<td><span class="flaticon-005"></span></td>
					<td><span class="flaticon-006"></span></td>
					<td><span class="flaticon-007"></span></td>
					<td><span class="flaticon-008"></span></td>
					<td><span class="flaticon-00a"></span></td>
					<td><span class="flaticon-00b"></span></td>
					<td><span class="flaticon-00d"></span></td>
				</tr>
				<tr>
					<td><input type="radio" name="gtt_icon" value="000"<?php if($set[0]->gtt_icon == '000') echo ' checked="checked"'?> /></td>
					<td><input type="radio" name="gtt_icon" value="002"<?php if($set[0]->gtt_icon == '002') echo ' checked="checked"'?> /></td>
					<td><input type="radio" name="gtt_icon" value="003"<?php if($set[0]->gtt_icon == '003') echo ' checked="checked"'?> /></td>
					<td><input type="radio" name="gtt_icon" value="004"<?php if($set[0]->gtt_icon == '004') echo ' checked="checked"'?> /></td>
					<td><input type="radio" name="gtt_icon" value="005"<?php if($set[0]->gtt_icon == '005') echo ' checked="checked"'?> /></td>
					<td><input type="radio" name="gtt_icon" value="006"<?php if($set[0]->gtt_icon == '006') echo ' checked="checked"'?> /></td>
					<td><input type="radio" name="gtt_icon" value="007"<?php if($set[0]->gtt_icon == '007') echo ' checked="checked"'?> /></td>
					<td><input type="radio" name="gtt_icon" value="008"<?php if($set[0]->gtt_icon == '008') echo ' checked="checked"'?> /></td>
					<td><input type="radio" name="gtt_icon" value="00a"<?php if($set[0]->gtt_icon == '00a') echo ' checked="checked"'?> /></td>
					<td><input type="radio" name="gtt_icon" value="00b"<?php if($set[0]->gtt_icon == '00b') echo ' checked="checked"'?> /></td>
					<td><input type="radio" name="gtt_icon" value="00d"<?php if($set[0]->gtt_icon == '00d') echo ' checked="checked"'?> /></td>
				</tr>
			</table>
</td>
	</tr>
	<tr>
		<th scope="row"><?php _e( 'Button location', 'gototop' );?></th>
		<td>
		<select name="gtt_position">
			<option value="bottom_right"<?php if($set[0]->gtt_position == 'bottom_right') echo ' selected="selected"';?>><?php _e( 'Bottom Right', 'gototop' );?></option>
			<option value="bottom_left"<?php if($set[0]->gtt_position == 'bottom_left') echo ' selected="selected"';?>><?php _e( 'Bottom Left', 'gototop' );?></option>
			<option value="top_right"<?php if($set[0]->gtt_position == 'top_right') echo ' selected="selected"';?>><?php _e( 'Top Right', 'gototop' );?></option>
			<option value="top_left"<?php if($set[0]->gtt_position == 'top_left') echo ' selected="selected"';?>><?php _e( 'Top Left', 'gototop' );?></option>
		</select>
		</td>
	</tr>
<tr>
<td colspan="2">
	<input type="hidden" name="action" value="edit" />
	<?php wp_nonce_field('gtt-update-settings'); ?>
	<input name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Settings', 'gototop' );?>" type="submit">
	</td>
	</tr>	
	</tbody>
	</table>	
</form>

</div>
</div>
</div>

<div id="postbox-container-1" class="postbox-container">

  <div class="postbox">
    <h3><span><?php _e('Like this plugin?', 'gototop');?></span></h3>
    <div class="inside">
      <ul>
        <li><a href="https://wordpress.org/support/view/plugin-reviews/go-to-top-button" target="_blank"><?php _e('Rate it on WordPress.org','gototop');?></a></li>
        <li><a href="https://twitter.com/wpcoderu" target="_blank"><?php _e('Follow me on Twitter','gototop');?></a></li>
        <li><a href="http://wpcode.ru/campaign/donate/" target="_blank"><?php _e('Donate','gototop');?></a></li>
      </ul>
    </div> <!-- .inside -->
  </div> <!-- .postbox -->
</div> <!-- .postbox-container -->
</div>
</div>
</div>