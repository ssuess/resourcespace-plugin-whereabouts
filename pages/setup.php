<?php
#
# Whereabouts setup page
#

// Do the include and authorization checking ritual -- don't change this section.
include '../../../include/db.php';
include_once '../../../include/general.php';
include '../../../include/authenticate.php'; if (!checkperm('a')) {exit ($lang['error-permissiondenied']);}


// Specify the name of this plugin and the heading to display for the page.
$plugin_name = 'whereabouts';
$plugin_page_heading = $lang['whereabouts_configuration'];

// Build the $page_def array of descriptions of each configuration variable the plugin uses.

//$page_def[] = config_add_text_list_input('whereabouts_ext_exclude', $lang['extensions_to_exclude']);
$page_def[] = config_add_multi_rtype_select('whereabouts_rt_exclude', $lang['resource_types_to_exclude']);
//$page_def[] = config_add_boolean_select('whereabouts_debug', $lang['whereaboutsdebug']);
$page_def[] = config_add_boolean_select('whereabouts_use_datepicker', $lang['whereabouts_use_datepicker']);
$page_def[] = config_add_boolean_select('whereabouts_show_maps', $lang["whereabouts_show_maps"]);
$page_def[] = config_add_boolean_select('whereabouts_show_maps_all', $lang["whereabouts_show_maps_all"]);
$page_def[] = config_add_text_input('whereabouts_google_static_apikey', $lang["whereabouts_google_static_apikey"]);
$page_def[] = config_add_text_input('whereabouts_google_static_zoomlevel', $lang["whereabouts_google_static_zoomlevel"]);
$page_def[] = config_add_boolean_select('whereabouts_use_wholist', $lang["whereabouts_use_wholist"]);
$page_def[] = config_add_text_input('whereabouts_wholist', $lang["whereabouts_wholist"]);
//$page_def[] = config_add_multi_group_select('whereabouts_admin_edit_access', $lang["whereabouts_admin_edit_access"]);

// Do the page generation ritual -- don't change this section.
$upload_status = config_gen_setup_post($page_def, $plugin_name);
include '../../../include/header.php';?><script  type="text/javascript">
    
jQuery(document).ready(function () {
    toggleFields(); //call this first so we start out with the correct visibility depending on the selected form values
    //this will call our toggleFields function every time the selection value of our underAge field changes
    jQuery("#whereabouts_show_maps").change(function () {
        toggleFields();
    });
    jQuery("#whereabouts_use_wholist").change(function () {
        toggleFields();
    });

});
//this toggles the visibility of our parent permission fields depending on the current selected value of the underAge field
function toggleFields() {
    if (jQuery('#whereabouts_show_maps').val()==1) {
            jQuery('#whereabouts_show_maps_all').parent().show();
            jQuery('#whereabouts_google_static_apikey').parent().show();
            jQuery('#whereabouts_google_static_zoomlevel').parent().show();
               } else {
            jQuery('#whereabouts_show_maps_all').parent().hide();
            jQuery('#whereabouts_google_static_apikey').parent().hide();
            jQuery('#whereabouts_google_static_zoomlevel').parent().hide();
            }
            
     if (jQuery('#whereabouts_use_wholist').val()==1) {
            jQuery('#whereabouts_wholist').parent().show();
               } else {
            jQuery('#whereabouts_wholist').parent().hide();
            }        
}
    
</script><?php
config_gen_setup_html($page_def, $plugin_name, $upload_status, $plugin_page_heading);
include '../../../include/footer.php';
?>