<?php 

function HookWhereaboutsEditAddcollapsiblesection() { 
	global $collapsible_sections,$ref,$userref,$whereabouts_rt_exclude,$resource,$whereabouts_show_maps_all,$whereabouts_show_maps,$whereabouts_google_apikey,$lang,$whereabouts_use_wholist,$whereabouts_wholist,$whereabouts_use_datepicker,$whereabouts_google_static_zoomlevel;
	$notes=sql_query("select * from whereabouts where ref='$ref' ORDER by date_movement DESC");
	if (in_array($resource['resource_type'],$whereabouts_rt_exclude)){return false;}
	if ($ref<0){return false;}
?><h2  <?php if($collapsible_sections){echo'class="CollapsibleSectionHead"';}?> id="WhereaboutsSectionHead"><?php echo $lang['whereabouts']; ?></h2><?php
?><div <?php if($collapsible_sections){echo'class="CollapsibleSection"';}?> id="WhereaboutsSection">


<form><input type="hidden" id="userref" value="<?php echo $userref; ?>"><input type="hidden" id="ref" value="<?php echo $ref; ?>">
<table class="headertable"><tr>
    <th class="datetime"><?php echo $lang['whereabouts_date_header']; ?></th>
    <th class="whoto"><?php echo $lang['whereabouts_whoto_header']; ?></th> 
    <th class="note"><?php echo $lang['whereabouts_note_header']; ?></th>
    <th class="mylocation"><?php echo $lang['whereabouts_location_header']; ?></th>
    <th class="actions"><?php echo $lang['whereabouts_action_header']; ?></th>
  </tr>
  <tr>
    <td valign="top"><?php if (!$whereabouts_use_datepicker) { ?><input type="hidden" id="date_movement" name="date_movement" value="<?php echo time(); ?>"><?php echo date("Y-d-m H:i");?>
    <?php } else { ?><script>
  jQuery(function() {
    jQuery( "#date_movement" ).datepicker({
            altFormat : '@',
            altField: "#actualDate"
        });
  });
</script>
    <input type="hidden" id="actualDate"><input type="text" id="date_movement"><?php } ?></td>
    <td valign="top"><?php if ($whereabouts_use_wholist) {
        $whoarr=explode(",",$whereabouts_wholist); ?>
        <select name="who_to" id="who_to">
  <option selected="selected">Choose one</option>
  <?php
    foreach($whoarr as $whoarrsingle) { ?>
      <option value="<?php echo $whoarrsingle; ?>"><?php echo $whoarrsingle; ?></option>
  <?php
    } ?>
</select><?php } else { ?><input type="text" name="who_to" id="who_to"><?php } ?></td> 
    <td valign="top"><textarea id="image-annotate-text" name="notetext" id="notetext" style="width:90%;"></textarea></td>
    <td valign="top"><input type="text" name="mylocation" id="mylocation"></td>
    <td valign="top" align='left'><a href='#' id='addnote'>add note</a></td>
  </tr></table>
  </form>
<div id="whereaboutnotes"><?php if ($notes) {  ?>
  <table><tr>
    <th class="datetime currentlocheader"><?php echo $lang['whereabouts_currentloc_header'];?></th>
    <th class="whoto"></th> 
    <th class="note"></th>
    <th class="mylocation"></th>
    <th class="actions"></th>
  </tr><?php
$i = 0;
$len = count($notes);
foreach ($notes as $item) {
$formattedaddress = str_replace(" ", "+", urlencode($item['mylocation']));

if ($i == 0) {
        // first
        echo "<tr class='currentloc'><td valign='top' align='left'>". date('Y-d-m H:i', $item['date_movement']) . "</td><td valign='top'  align='left'>" . $item['who_to'] . "</td><td valign='top' align='left'>" . $item['note'] . "</td><td valign='top' align='left'>"; 
         ?>
        <?php if ($whereabouts_show_maps) {?><div class="hover_img"><a href="http://maps.google.com/?q=<?php echo $item['mylocation']; ?>" target="_new"><?php echo $item['mylocation']; ?><span><img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $formattedaddress; ?>&markers=color:blue%7C<?php echo $formattedaddress; ?>&zoom=11&size=450x250&key=<?php echo $whereabouts_google_apikey; ?>"/></span></a>
</div><?php } else { echo "<a href='http://maps.google.com/?q=".$item['mylocation']."'>" . $item['mylocation'] . "</a>"; }?></td><td valign='top' align='left'>
<?php echo "<a href='#' class='deletenote' id='" . $item['note_id'] . "'>delete</a></td></tr>";
echo "<tr class='spacerrow'><td></td><td></td><td></td><td></td><td></td></tr>";
    } else {
echo "<tr><td valign='top' align='left'>". date('Y-d-m H:i', $item['date_movement']) . "</td><td valign='top' align='left'>" . $item['who_to'] . "</td><td class='note' valign='top' align='left'>" . $item['note'] . "</td><td valign='top'  align='left'>"; 
        ?>
        <?php if ($whereabouts_show_maps) {?><?php if ($whereabouts_show_maps_all) {?><div class="hover_img"><a href="http://maps.google.com/?q=<?php echo $item['mylocation']; ?>" target="_new"><?php echo $item['mylocation']; ?><span><img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $formattedaddress; ?>&markers=color:blue%7C<?php echo $formattedaddress; ?>&zoom=11&size=450x250&key=<?php echo $whereabouts_google_apikey; ?>"/></span></a>
</div><?php }} else { echo "<a href='http://maps.google.com/?q=".$item['mylocation']."'>" . $item['mylocation'] . "</a>"; } ?></td><td valign='top' align='left'>
<?php echo "<a href='#' class='deletenote' id='" . $item['note_id'] . "'>delete</a></td></tr>";
}
    $i++;

} ?>
</table><?php
} ?></div>
</div><?php
}
?>