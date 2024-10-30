<?php
/*
Plugin Name: BlackPiggy
Plugin URI: http://www.blackpiggy.com
Description: E-commerce Widget connect to BlackPiggy community http://www.blackpiggy.com
Author: Manuel Gilioli
Version: 0.9
Author URI: http://www.blackpiggy.com
*/

/* Copyright 2005 Manuel Gilioli (email: manuel.gilioli@blackpiggy.com)
   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.
   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU General Public License for more details.
   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'blackpiggy_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'blackpiggy_remove' );

function blackpiggy_install() {
/* Creates new database field */
add_option("blackpiggy_data", '9999', '', 'yes');
}

function blackpiggy_remove() {
/* Deletes the database field */
delete_option('blackpiggy_dat');
}


add_action( 'wp_head', 'blackpiggy_load_into_head' );
function blackpiggy_load_into_head(){
?><script text="text/javascript" src="http://www.blackpiggy.com/mpe/widget/start/<?php echo get_option('blackpiggy_data'); ?>">
</script><?php
}


add_action('admin_menu', 'blackpiggy_admin_menu');
function blackpiggy_admin_menu() {
    $page_title = 'BlackPiggy Setting';
    $menu_title = 'BlackPiggy';
    $capability = 'administrator';
    $menu_slug = 'blackpiggy-settings';
    $function = 'blackpiggy_settings';
    add_options_page($page_title, $menu_title, $capability, $menu_slug, $function);
}

function blackpiggy_settings() {
    if (!current_user_can('administrator')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
	?>
<div>
<h2>BlackPiggy Settings</h2>
<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table width="510">
<tr valign="top">
<th width="92" scope="row">Enter id deal</th>
<td width="406">
<input name="blackpiggy_data" type="text" id="blackpiggy_data"
value="<?php echo get_option('blackpiggy_data'); ?>" />
</td>
</tr>
</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="blackpiggy_data" />

<p>
<input type="submit" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>
<?php
}

add_filter( 'plugin_action_links', 'blackpiggy_set_plugin_meta', 10, 2 );
function blackpiggy_set_plugin_meta($links, $file) {
if ( $file == plugin_basename(__FILE__) )
      $links[] = '<a href="' . admin_url( 'options-general.php?page=blackpiggy-settings' ) . '">Settings</a>';
return $links;
}



?>
