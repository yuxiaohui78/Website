<?php

global $more_types_settings, $wp_taxonomies, $more_types;

$types  = $more_types_settings->data;

if (!$this->navigation || $this->navigation == 'post_types') {

	echo '<p>';
	_e('Here you can create your own post types. Additional post types can be used to extend what WordPress can do, beyond the scope of posts and pages.', 'more-plugins');
	echo '</p>';

	$titles = array(__('Post type', 'more-plugins'), __('Based on', 'more-plugins'), __('Actions', 'more-plugins'));
//	if (!empty($types['plugin'])) {
		$nbr = 0;
		$title = __('More Types post types', 'more-plugins');
		$caption = __('Post types created with More Types or has been overridden from other sources.', 'more-plugins') . '</p>';
		$more_types_settings->table_header($titles);
		echo '<caption><h3>' . $title . '</h3><p>' . $caption . '</p></caption>';
		$ancestor_keys = array();
		$class = '';
		foreach ($types['_plugin'] as $name => $tax) {

//			if (!$name) continue;
			if ($a = $tax['ancestor_key']) $ancestor_keys[] = $a;
			$label = $tax['labels']['singular_name'];
			$type = $tax['hierarchical'] ? 'Page' : 'Post';
			$keys = '_plugin,' . $name;
			$warning = ($class) ? '<em>' . __('*', 'more-plugins') . '</em>' : '';
			$edit_link = array('navigation' => 'post_type', 'keys' => $keys);
			$delete_link = array('action' => 'delete', 'action_keys' => $keys, 'class' => 'more-common-delete');
			$export_link = array('navigation' => 'export', 'keys' => $keys);
			$data = array(
				$more_types_settings->settings_link($label, $edit_link) . $warning,
				$type,
				$more_types_settings->settings_link(__('Edit', 'more-plugins'), $edit_link) . ' | ' .
				$more_types_settings->settings_link(__('Delete', 'more-plugins'), $delete_link) . ' | ' .
				$more_types_settings->settings_link(__('Export', 'more-plugins'), $export_link) . 
				$more_types_settings->updown_link($nbr, count($types['_plugin']))
			);
	
			$more_types_settings->table_row($data, $nbr++, $class);
		}
		if (empty($types['_plugin'])) {
			$data = array(__('No post types', 'more-plugins'), '-', '');
			$more_types_settings->table_row($data, $nbr++, $class);	
		}
	
	
	
		// Files!
//		foreach ($data_file as $key => $item) {
//			$b = ucfirst($item['capability_type']);
//			if (!$item['other'])
//				$data = array($item['label'], $b, __('Generated by a file - no actions', 'more-plugins'));
//			else $data = array($item['label'], $b, __('Not generated by this plugin - no actions', 'more-plugins'));
//			$more_types_settings->table_row($data, $nbr++);
//		}
	
		$more_types_settings->table_footer($titles);
	
		$new_key = '_plugin,'. $more_types_settings->add_key;
		$options = array('action' => 'add', 'navigation' => 'post_type', 'keys' => $new_key, 'class' => 'button-primary');
		echo '<p>' . $more_types_settings->settings_link('Add new Post Type', $options) . '</p>';

	
//	$options = array('title' => __('Add Post Type', 'more-plugins'), 'action' => 'add', 'navigation' => 'post_type');
//	$more_types_settings->add_button($options);



	$nbr = 0;

	if (!empty($types['_plugin_saved'])) {

		$title = __('Saved post types', 'more-plugins');
		$caption = __('Post types from files created with More Types.', 'more-plugins');

		$more_types_settings->table_header($titles);
		echo '<caption><h3>' . $title . '</h3><p>' . $caption . '</p></caption>';
	
		foreach ($types['_plugin_saved'] as $name => $tax) {
			$label = $tax['labels']['singular_name'];
			$keys = '_plugin_saved,' . $name;
			$type = $tax['hierarchical'] ? 'Page' : 'Post';

			// Is this overwritten?
			$class = (in_array($name, $ancestor_keys)) ? 'disabled' : false;
			if (!$class) $class = (array_key_exists($name, $types['_plugin'])) ? 'disabled' : false ;
			
			$edit_link = array('navigation' => 'post_type', 'keys' => $keys);
			$delete_link = array('action' => 'delete', 'action_keys' => $keys, 'class' => 'more-common-delete');
			$export_link = array('navigation' => 'export', 'keys' => $keys);
			$data = array(
				$label . $warning,
				$type,
				$more_types_settings->settings_link(__('Override', 'more-plugins'), $edit_link) . ' | ' .
 				// $more_types_settings->settings_link(__('Disable', 'more-plugins'), $delete_link) . ' | ' .
				$more_types_settings->settings_link(__('Export', 'more-plugins'), $export_link) 
				// $more_types_settings->updown_link($nbr, count($data_stored))
			);
			if ($class == 'disabled') 
				$data = array($label, $type, __('Overridden above', 'more-plugins'));	
			$more_types_settings->table_row($data, $nbr++, $class);
		}	
		
		$more_types_settings->table_footer($titles);
	}
	$nbr = 0;

	if (!empty($types['_other'])) {
		$title = __('Post types create elsewhere', 'more-plugins'); 
		$caption = __('Post types created in functions.php or by other plugins.', 'more-plugins');

		$more_types_settings->table_header($titles);
		echo '<caption><h3>' . $title . '</h3><p>' . $caption . '</p></caption>';

		foreach ($types['_other'] as $name => $tax) {
			$label = $tax['labels']['singular_name'];
			$keys = '_other,' . $name;

			// Is this overwritten?
			$class = (in_array($name, $ancestor_keys)) ? 'disabled' : false;
			if (!$class) $class = (array_key_exists($name, $types['_plugin'])) ? 'disabled' : false ;

			$warning = ($class) ? '<em>' . __('*', 'more-plugins') . '</em>' : '';
			$type = $tax['hierarchical'] ? 'Page' : 'Post';
			$edit_link = array('navigation' => 'post_type', 'keys' => $keys);
			$delete_link = array('action' => 'delete', 'action_keys' => $keys, 'class' => 'more-common-delete');
			$export_link = array('navigation' => 'export', 'keys' => $keys);
			$data = array(
				$label . $warning,
				$type,
				$more_types_settings->settings_link(__('Override', 'more-plugins'), $edit_link) . ' | ' .
				// $more_types_settings->settings_link(__('Disable', 'more-plugins'), $delete_link) . ' | ' .
				$more_types_settings->settings_link(__('Export', 'more-plugins'), $export_link) 
				//  $more_types_settings->updown_link($nbr, count($data_stored))
			);
			if ($class == 'disabled') 
				$data = array($label, $type,  __('Overridden above', 'more-plugins'));	

			$more_types_settings->table_row($data, $nbr++, $class);
		}	
		
		$more_types_settings->table_footer($titles);	
	}	
	$nbr = 0;

	if (!empty($types['_default'])) {
		$title = __('Default post types', 'more-plugins'); 
		$caption = __('Built-in post types. Please note - when messing with these defaults, prepare to die (but then, we\'re all going to anyway, eventually).', 'more-plugins');
		$more_types_settings->table_header($titles);
		echo '<caption><h3>' . $title . '</h3><p>' . $caption . '</p></caption>';

		foreach ($types['_default'] as $name => $tax) {

			// Is this overwritten?
			$class = (in_array($name, $ancestor_keys)) ? 'disabled' : false;
			if (!$class) $class = (array_key_exists($name, $types['_plugin'])) ? 'disabled' : false ;
			
			$keys = '_default,' . $name;
			$label = $tax['labels']['singular_name'];
			$warning = ($class) ? '<em>' . __('*', 'more-plugins') . '</em>' : '';
			$type = $tax['hierarchical'] ? 'Page' : 'Post';
			$edit_link = array('navigation' => 'post_type', 'keys' => $keys);
			$hide_link = array('action' => 'disable', 'action_keys' => $keys, 'class' => 'more-common-delete');
			$export_link = array('navigation' => 'export', 'keys' => $keys);
			$data = array(
				$label . $warning,
				$type,
				$more_types_settings->settings_link(__('Override', 'more-plugins'), $edit_link) . ' | ' .
				// $more_types_settings->settings_link(__('Disable', 'more-plugins'), $hide_link) . ' | ' .
				$more_types_settings->settings_link(__('Export', 'more-plugins'), $export_link)  
				// $more_types_settings->updown_link($nbr, count($data_stored))
			);
			if ($class == 'disabled')
				$data = array($label, $type,  __('Overridden above', 'more-plugins'));	
			$more_types_settings->table_row($data, $nbr++, $class);
			
		}	
		
		$more_types_settings->table_footer($titles);
	}

} else if ($this->navigation == 'post_type') {

	// Set up the navigation
	$navtext = $more_types_settings->get_val('labels,singular_name');
	if (!$navtext) $navtext = __('Add new', 'more-plugins');
	$more_types_settings->navigation_bar(array($navtext));

	$more_types_settings->settings_form_header(array('navigation' => 'post_types', 'action' => 'save'));

	// print_r($more_types_settings->data['default']);

?>
	<table class="form-table">
	
	<?php

		$comment = __('This is the singular name of the post type, e.g. \'Review\'.', 'more-plugins');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Post type name singular', 'more-plugins'), $more_types_settings->settings_input('labels,singular_name') . $comment);
		$more_types_settings->setting_row($row);

		$comment = __('This is the plural name of the post type, e.g. \'Reviews\'.', 'more-plugins');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Post type name plural', 'more-plugins'), $more_types_settings->settings_input('labels,name') . $comment);
		$more_types_settings->setting_row($row);

		$row = array(__('Description', 'more-plugins'), $more_types_settings->settings_textarea('description'));
		$more_types_settings->setting_row($row);

		$comment = __('Enables post type items to be children of other items of the same post type. In a standard WordPress installation, posts are not heirarchical whilst pages are. If you want this post type ot behave like posts, set hierarchical to false.', 'more-plugins');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Hierarchical', 'more-plugins'), $more_types_settings->settings_bool('hierarchical') . $comment);
		$more_types_settings->setting_row($row);

/*
		$comment = __('Inherit capabilities from either post/page,', 'more-plugins');
		$comment = $more_types_settings->format_comment($comment);
		$type = array('post' => 'Post', 'page' => 'Page');
		$row = array(__('Based on', 'more-plugins'), $more_types_settings->settings_radiobuttons('capability_type', $type) . $comment);
		$more_types_settings->setting_row($row);
*/

		$comment = __('Specify a URL for a custom menu icon. The standard size is 16 &times; 16 pixels', 'more-plugins');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Menu icon', 'more-plugins'), $more_types_settings->settings_input('menu_icon') . $comment);
		$more_types_settings->setting_row($row);

		$templates = $more_types_settings->get_templates();
		$comment = __('Select a template that handles this post type.', 'more-plugins');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Post type template', 'more-plugins'), $more_types_settings->settings_select('template', $templates) . $comment);
		$more_types_settings->setting_row($row);





//		$types = $more_types_settings->get_post_types();
//		$row = array(__('Available to', 'more-plugins'), $more_types_settings->checkbox_list('object_type', $types));
//		$more_types_settings->setting_row($row);


		$comment = __('These are the input boxes available to this post type.', 'more-plugins');
		$comment = $more_types_settings->format_comment($comment);
		$boxes = $more_types_settings->get_boxes();
		$row = array(__('Features', 'more-plugins'), $more_types_settings->checkbox_list('supports', $boxes) . $comment);
		$more_types_settings->setting_row($row);


		$title =  __('Additional boxes', 'more-plugins');
		// The other boxes
		/*
		global $wp_meta_boxes;
		$data = $wp_meta_boxes;
		$boxes = array();
		foreach ((array) $data as $data1) {
			foreach ((array) $data1 as $data2) {
				foreach ((array) $data2 as $data3) {
					foreach ((array) $data3 as $box) {
						 if ($title = $box['title']) {
							 $boxes[$box['id']] = $title;
						 }
					}
				}
			}						
		}
		*/
		$box_data = $more_types->get_existing_boxes();

		// Reform the box data
		$boxes = array();
		foreach ($box_data as $k => $b) $boxes[$k] = $b['title'];
		if (!empty($boxes)) $row = array(__('Additional boxes', 'more-plugins'), $more_types_settings->checkbox_list('boxes', $boxes));
		else {
			$comment = sprintf(__('There are no additional content boxes - but you can create new ones with our plugin More Fields %s!', 'more-plugins'), '<a href="http://wordpress.org/extend/plugins/more-fields/">More Fields</a>');
			$comment = $more_types_settings->format_comment($comment);
			$row = array(__('Additional boxes', 'more-plugins'), $comment);
		}
		$more_types_settings->setting_row($row);


		$tax = array();
		$stax = array();		
		$mytax = $more_types_settings->get_val('taxonomies');
		foreach($wp_taxonomies as $taxonomy) {
			if (!trim($taxonomy->label)) continue;
			$tax[$taxonomy->name] = $taxonomy->label;
			if (in_array($taxonomy->name, (array) $mytax)) $stax[] = $taxonomy;
		}
		// sprintf(_n('%d Plugin Update', '%d Plugin Updates', $plugin_update_count)
		// 		add_meta_box( "add-{$id}", sprintf( __('Add %s'), $tax->label ), 'wp_nav_menu_item_taxonomy_metabox', 'nav-menus', 'side', 'default', $tax );

//		$comment = sprintf(__('%d Plugin Update', '%d Plugin Updates', $plugin_update_count)
		$comment = sprintf(__('You can create more taxonomies to use with your post types using our plugin %s!', 'more-plugins'), '<a href="http://wordpress.org/extend/plugins/more-taxonomies/">More Taxonomies</a>');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Taxonomies', 'more-plugins'), $more_types_settings->checkbox_list('taxonomies', $tax) . $comment);
		$more_types_settings->setting_row($row);

		//	$comment = __('Admin menu position. This should be a number where a small number puts it high up in the menu. E.g. 4 will place the menu item just below \'Posts\'', 'more-plugins');
		//	$comment = $more_types_settings->format_comment($comment);
		foreach ($stax as $t) {
			$tname = $t->name;
			if ($t->hierarchical) {
				$terms = get_terms($t->name, 'orderby=count&hide_empty=0');
				$ltax = array();
				$comment = __('Check the taxonomy item that will selected by default when creating new posts of this post type.', 'more-plugins');
				$comment = $more_types_settings->format_comment($comment);
				foreach ($terms as $term) $ltax[$term->slug] = $term->name;
				$row = array(__('Default ' . $t->labels->name , 'more-plugins'), $more_types_settings->checkbox_list('default_taxonomy_' . $tname, $ltax) . $comment);
			} else {
				$comment = __('Enter the taxonomy item that will selected by default when creating new posts of this post type.', 'more-plugins');
				$comment .= ' ' . __('Comma separate each taxonomy value, e.g. ', 'more-plugins') . '<code>birds, bees, aeroplanes</code>';
				$comment = $more_types_settings->format_comment($comment);
				$row = array(__('Default ' . $t->labels->name , 'more-plugins'), $more_types_settings->settings_input('default_taxonomy_' . $tname) . $comment);
			}
			$more_types_settings->setting_row($row);
		}

	?>

	</table>

<div class="more-plugins-advanced-settings">
	<h3 class="more-advanced-settings-toggle"><a href="#">Advanced settings <span>show/hide</span></a></h3>
	<div class="more-advanced-settings" style="display: none;">
	<table class="form-table">
	
	<?php
			$comment = __('Show this post type in the admin menu.', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$row = array(__('Show in menu', 'more-plugins'), $more_types_settings->settings_bool('show_in_menu') . $comment);
			$more_types_settings->setting_row($row);

			$comment = __('Enables archive pages for this post type.', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$row = array(__('Has archive', 'more-plugins'), $more_types_settings->settings_bool('has_archive') . $comment);
			$more_types_settings->setting_row($row);
	
			$comment = __('Admin menu position. This should be a number where a small number puts it high up in the menu. E.g. 4 will place the menu item just below \'Posts\'', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$row = array(__('Menu position', 'more-plugins'), $more_types_settings->settings_input('menu_position') . $comment);
			$more_types_settings->setting_row($row);

			$comment = __('Make this post type exportable', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$row = array(__('Enable export', 'more-plugins'), $more_types_settings->settings_bool('can_export') . $comment);
			$more_types_settings->setting_row($row);
	
			$comment = __('Use permalinks for this post-type', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$pl = $more_types_settings->permalink_warning();
			$row = array(__('Enable permalinks', 'more-plugins'), $more_types_settings->settings_bool('rewrite_bool') . $comment . $pl);
			$more_types_settings->setting_row($row);

			$comment = __('Enable revisions for this post type', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$row = array(__('Enable Revisions', 'more-plugins'), $more_types_settings->settings_bool('revisions') . $comment);
			$more_types_settings->setting_row($row);

			$comment = __('The permalink base for this post type', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$pl = $more_types_settings->permalink_warning();
			$row = array(__('Permalink base', 'more-plugins'), $more_types_settings->settings_input('rewrite_slug') . $comment . $pl);
			$more_types_settings->setting_row($row);		
		
			$comment = __('Allows visitors to query this type.', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$row = array(__('Publically queryable', 'more-plugins'), $more_types_settings->settings_bool('publicly_queryable') . $comment);
			$more_types_settings->setting_row($row);

			$comment = __('Exclude this post type when a visitor searches the website for content.', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$row = array(__('Exclude from search', 'more-plugins'), $more_types_settings->settings_bool('exclude_from_search') . $comment);
			$more_types_settings->setting_row($row);
			
			$comment = __('Show posts of this type in the admin UI. Setting this to false  hides this post type for all users.', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$row = array(__('Show in admin', 'more-plugins'), $more_types_settings->settings_bool('public') . $comment);
			$more_types_settings->setting_row($row);

			$comment = __('Whether to generate a default UI for managing this post type', 'more-plugins');
			$comment = $more_types_settings->format_comment($comment);
			$row = array(__('Show UI', 'more-plugins'), $more_types_settings->settings_bool('show_ui') . $comment);
			$more_types_settings->setting_row($row);
	
		?>
		
		
		<caption>
			<?php _e('User capabilities for this post type.' ,'more-plugins'); ?>
		</caption>
	<?php
// 		'array' => array('supports', 'more_type_cap', 'more_edit_cap', 'more_others_cap', 'more_others_cap', 'more_delete_cap', 'taxonomies')

		$roles = $more_types_settings->get_roles();

		$comment = __('User roles capable of editing own objects from this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Edit capability', 'more-plugins') . $comment, $more_types_settings->checkbox_list('more_edit_cap', $roles) );
		$more_types_settings->setting_row($row);

		$comment = __('User roles capable of editing own multiple objects from this post type.');
		$comment = $more_types_settings->format_comment($comment);		
		$row = array(__('Edit multiple', 'more-plugins') . $comment, $more_types_settings->checkbox_list('more_edit_type_cap', $roles));
		$more_types_settings->setting_row($row);

		$comment = __('User roles capable of editing other users objects from this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Edit not owned by user', 'more-plugins') . $comment, $more_types_settings->checkbox_list('more_edit_others_cap', $roles));
		$more_types_settings->setting_row($row);

		$comment = __('User roles capable of publishing objects from this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Publish capability', 'more-plugins') . $comment, $more_types_settings->checkbox_list('more_publish_others_cap', $roles));
		$more_types_settings->setting_row($row);	

		$comment = __('User roles capable of deleting objects from this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Delete capability', 'more-plugins') . $comment, $more_types_settings->checkbox_list('more_delete_cap', $roles));
		$more_types_settings->setting_row($row);
	
		$comment = __('User roles capable of reading objects from this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__('Read capability', 'more-plugins') . $comment, $more_types_settings->checkbox_list('more_read_cap', $roles));
		$more_types_settings->setting_row($row);

		$comment = __('The text that will appear for this post type in the admin menu');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__("'Menu name", 'more-plugins') . $comment, $more_types_settings->settings_input('labels,menu_name'));
		$more_types_settings->setting_row($row);

		$comment = __('The text that will appear in links to add new items of this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__("'Add New' text", 'more-plugins') . $comment, $more_types_settings->settings_input('labels,add_new'));
		$more_types_settings->setting_row($row);

		$comment = __('The text that will appear in links to add new items of this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__("'Add New Item' text", 'more-plugins') . $comment, $more_types_settings->settings_input('labels,add_new_item'));
		$more_types_settings->setting_row($row);

		$comment = __('The text that will appear in links to add new items of this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__("'Edit Item' text", 'more-plugins') . $comment, $more_types_settings->settings_input('labels,edit_item'));
		$more_types_settings->setting_row($row);

		$comment = __('The text that will appear in links to add new items of this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__("'New Item' text", 'more-plugins') . $comment, $more_types_settings->settings_input('labels,new_item'));
		$more_types_settings->setting_row($row);

		$comment = __('The text that will appear in links to add new items of this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__("'View Item' text", 'more-plugins') . $comment, $more_types_settings->settings_input('labels,view_item'));
		$more_types_settings->setting_row($row);

		$comment = __('The text that will appear in links to add new items of this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__("'Search Item' text", 'more-plugins') . $comment, $more_types_settings->settings_input('labels,search_items'));
		$more_types_settings->setting_row($row);

		$comment = __('The text that will appear in links to add new items of this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__("'Not found' text", 'more-plugins') . $comment, $more_types_settings->settings_input('labels,not_found'));
		$more_types_settings->setting_row($row);

		$comment = __('The text that will appear in links to add new items of this post type.');
		$comment = $more_types_settings->format_comment($comment);
		$row = array(__("'Not found in Trash' text", 'more-plugins') . $comment, $more_types_settings->settings_input('labels,not_found_in_trash'));
		$more_types_settings->setting_row($row);


	?>

	</table>
	</div>
</div>
	
	<?php $more_types_settings->settings_save_button(); ?>

	<?php
}

global $wp_roles;
	echo '<pre>';
	//print_r($more_types_settings->data);
	echo '</pre>';



?>
