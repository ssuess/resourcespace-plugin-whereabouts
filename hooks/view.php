<?php
function HookWhereaboutsViewCustompanels() { 
global $collapsible_sections,$ref,$userref,$whereabouts_rt_exclude,$resource,$whereabouts_show_maps_all,$whereabouts_show_maps,$whereabouts_google_static_apikey,$lang,$whereabouts_google_static_zoomlevel;
	if (in_array($resource['resource_type'],$whereabouts_rt_exclude)){return false;}

	$notes=sql_query("select * from whereabouts where ref='$ref' ORDER by date_movement DESC");
if ($notes) {
?>
<div class="RecordBox">
<div class="RecordPanel">	<div id="Whereabouts">
	<div class="Title"><?php echo $lang['whereabouts']; ?></div>
	<?php if ($notes) {  ?><table class="headertable"><tr>
	<th class="datetime"><?php echo $lang['whereabouts_date_header']; ?></th>
    <th class="whoto"><?php echo $lang['whereabouts_whoto_header']; ?></th> 
    <th class="note"><?php echo $lang['whereabouts_note_header']; ?></th>
    <th class="mylocation"><?php echo $lang['whereabouts_location_header']; ?></th>
    </tr></table><div id="whereaboutnotes">
  <table><tr>
    <th class="datetime currentlocheader"><?php echo $lang['whereabouts_currentloc_header'];?></th>
    <th class="whoto"></th> 
    <th class="note"></th>
    <th class="mylocation"></th>
  </tr><?php
$i = 0;
$len = count($notes);
foreach ($notes as $item) {
$formattedaddress = str_replace(" ", "+", urlencode($item['mylocation']));
if ($i == 0) {
         // first
        echo "<tr class='currentloc'><td valign='top' align='left'>". date('Y-d-m H:i', $item['date_movement']) . "</td><td valign='top'  align='left'>" . $item['who_to'] . "</td><td valign='top' align='left' class='note'>" . $item['note'] . "</td><td valign='top' align='left'>"; 
        ?>
        <?php if ($whereabouts_show_maps) {?><div class="hover_img"><a href="http://maps.google.com/?q=<?php echo $item['mylocation']; ?>"><?php echo $item['mylocation']; ?><span><img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $formattedaddress; ?>&markers=color:blue%7C<?php echo $formattedaddress; ?>&zoom=<?php echo $whereabouts_google_static_zoomlevel; ?>&size=450x250&key=<?php echo $whereabouts_google_static_apikey; ?>"/></span></a>
</div><?php } else { echo "<a href='http://maps.google.com/?q=".$item['mylocation']."'>" . $item['mylocation'] . "</a>"; }?></td></tr><?php
echo "<tr class='spacerrow'><td></td><td></td><td></td><td></td><td></td></tr>";
    } else {
echo "<tr><td valign='top' align='left'>". date('Y-d-m H:i', $item['date_movement']) . "</td><td valign='top' align='left'>" . $item['who_to'] . "</td><td class='note' valign='top' align='left' class='note'>" . $item['note'] . "</td><td valign='top'  align='left'>"; 
        ?>
        <?php if ($whereabouts_show_maps) {?><?php if ($whereabouts_show_maps_all) {?><div class="hover_img"><a href="http://maps.google.com/?q=<?php echo $item['mylocation']; ?>"><?php echo $item['mylocation']; ?><span><img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $formattedaddress; ?>&markers=color:blue%7C<?php echo $formattedaddress; ?>&zoom=<?php echo $whereabouts_google_static_zoomlevel; ?>&size=450x250&key=<?php echo $whereabouts_google_static_apikey; ?>"/></span></a>
</div><?php }} else { echo "<a href='http://maps.google.com/?q=".$item['mylocation']."'>" . $item['mylocation'] . "</a>"; } ?></td></tr><?php
}
    $i++;

} ?>
</table><?php
} ?></div>
</div>
</div>
<div class="PanelShadow"></div>
</div>
<?php
}}

?>
