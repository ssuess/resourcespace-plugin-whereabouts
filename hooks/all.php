<?php 

function HookWhereaboutsDatabase_pruneDbprune(){
	sql_query("delete from resource_keyword where whereabouts_ref > 0 and whereabouts_ref not in (select note_id from whereabouts)");
	echo sql_affected_rows() . " orphaned whereabouts_ref resource-keyword relationships deleted.<br/><br/>";
}

function HookWhereaboutsAllAfterreindexresource($ref){
	// make sure annotation indexing isn't lost when doing a reindex.
	$notes=sql_query("select * from whereabouts where ref='$ref'");
	global $pagename;

	foreach($notes as $note){
		#Add annotation to keywords
		$keywordtext = substr(strstr($note['note'],": "),2); # don't add the username to the keywords

		add_keyword_mappings($ref,i18n_get_indexable($keywordtext),-1,false,false,"whereabouts_ref",$note['note_id']);
	}
}

function HookWhereaboutsAllModifyselect(){
return (" ,r.whereabouts_count ");

}

function HookWhereaboutsAllRemoveannotations(){
	global $ref;
	
	sql_query("delete from whereabouts where ref='$ref'");
	sql_query("update resource set whereabouts_count=0 where ref='$ref'");	
	sql_query("delete from resource_keyword where resource='$ref' and whereabouts_ref>0");;
}

function HookWhereaboutsAllAdditionalheaderjs(){
	global $baseurl,$k,$baseurl_short,$css_reload_key;
?>
<script  type="text/javascript">
    
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
    
</script>
<script language="javascript">
	jQuery(window).load(function(){
jQuery("#addnote").live("click",function(){
var who_to = encodeURIComponent(jQuery("#who_to").val());
if(jQuery("#actualDate").length == 0) {
var date_movement = jQuery("#date_movement").val();
} else {
//get date from date field
var myinputDate = new Date(jQuery("#date_movement").val());
//get today's date
var mytodaysDate = new Date();
//call setHours to take the time out and compare
if(myinputDate.setHours(0,0,0,0) == mytodaysDate.setHours(0,0,0,0))
{
var date_movement = (jQuery.now()/1000);
} else {
var date_movement = (jQuery("#actualDate").val()/1000);
}}
var mylocation = encodeURIComponent(jQuery("#mylocation").val());
var notetext = encodeURIComponent(jQuery("textarea[name='notetext']").val());
var ref = jQuery("#ref").val();
var userref = jQuery("#userref").val();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'who_to='+ who_to + '&mylocation='+ mylocation + '&date_movement='+ date_movement + '&notetext='+ notetext + '&ref='+ ref + '&userref='+ userref;
if(who_to==''||notetext=='')
{
alert("Please Fill Out All Fields");
}
else
{
// AJAX Code To Submit Form.
jQuery.ajax({
type: "POST",
url: "<?php echo $baseurl_short?>plugins/whereabouts/pages/save.php",
data: dataString,
cache: false,
success: function(result){
jQuery( "#whereaboutnotes" ).load( "<?php echo $baseurl_short?>plugins/whereabouts/pages/get.php?ref=" + encodeURIComponent(ref), function() {
  //alert( "Load was performed." );
  jQuery("#who_to").val("");  
if ( jQuery( "#actualDate" ).length ) {  
jQuery("#actualDate").val(""); 
jQuery("#date_movement").val("");
 } else {
jQuery("#date_movement").val(jQuery.now()/1000);
 }
  jQuery("#mylocation").val("");
  jQuery("textarea[name='notetext']").val("");
});}
});
}
return false;
});

jQuery(".deletenote").live("click",function(){
var noteid = jQuery(this).attr('id');
var ref = jQuery("#ref").val();
// Returns successful data submission message when the entered information is stored in database.
var dataString = 'noteid='+ noteid + '&ref='+ ref;
// AJAX Code To Submit Form.
jQuery.ajax({
type: "POST",
url: "<?php echo $baseurl_short?>plugins/whereabouts/pages/delete.php",
data: dataString,
cache: false,
success: function(result){
jQuery( "#whereaboutnotes" ).load( "<?php echo $baseurl_short?>plugins/whereabouts/pages/get.php?ref=" + encodeURIComponent(ref), function() {
  //alert( "Load was performed." );
});}
});
return false;
});

});
</script>
<?php }

?>
