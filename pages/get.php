<?php


include_once "../../../include/db.php";
include_once "../../../include/general.php";
$k=getvalescaped("k","");if (($k=="") || (!check_access_key(getvalescaped("ref",""),$k))) {include_once "../../../include/authenticate.php";}

$ref=getval("ref","");
if ($ref==""){die("no");}
$preview_width=getval("pw",0);
$preview_height=getval("ph",0);
$page = getval('page', 1);

// Get notes based on page:
$sql_and = '';

if($page >= 1) {
	$sql_and = ' AND page = ' . $page;
}

$notes=sql_query("select * from whereabouts where ref='$ref'" . $sql_and . " ORDER by date_movement DESC");
sql_query("update resource set whereabouts_count=".count($notes)." where ref=$ref");
// check if display size is different from original preview size, and if so, modify coordinates
?>

  <table><tr>
    <th class="datetime currentlocheader"><?php echo $lang['whereabouts_currentloc_header'];?></th>
    <th class="whoto"></th> 
    <th class="note"></th>
    <th class="mylocation"></th>
    <th class="actions"></th></tr><?php
$i = 0;
$len = count($notes);
foreach ($notes as $item) {
$formattedaddress = str_replace(" ", "+", urlencode($item['mylocation']));
if ($i == 0) {
        // first
        echo "<tr class='currentloc'><td valign='top' align='left'>". date('Y-d-m H:i', $item['date_movement']) . "</td><td valign='top'  align='left'>" . $item['who_to'] . "</td><td valign='top' align='left'>" . $item['note'] . "</td><td valign='top' align='left'>"; 
        ?>
        <?php if ($whereabouts_show_maps) {?><div class="hover_img"><a href="http://maps.google.com/?q=<?php echo $item['mylocation']; ?>" target="_new"><?php echo $item['mylocation']; ?><span><img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $formattedaddress; ?>&markers=color:blue%7C<?php echo $formattedaddress; ?>&zoom=<?php echo $whereabouts_google_static_zoomlevel; ?>&size=450x250&key=<?php echo $whereabouts_google_static_apikey; ?>"/></span></a>
</div><?php } else { echo "<a href='http://maps.google.com/?q=".$item['mylocation']."'>" . $item['mylocation'] . "</a>"; }?></td><td valign='top' align='left'>
<?php echo "<a href='#' class='deletenote' id='" . $item['note_id'] . "'>delete</a></td></tr>";
echo "<tr class='spacerrow'><td></td><td></td><td></td><td></td><td></td></tr>";
    } else {
echo "<tr><td valign='top' align='left'>". date('Y-d-m H:i', $item['date_movement']) . "</td><td valign='top' align='left'>" . $item['who_to'] . "</td><td class='note' valign='top' align='left'>" . $item['note'] . "</td><td valign='top'  align='left'>"; 
        ?>
        <?php if ($whereabouts_show_maps_all) {?><div class="hover_img"><a href="http://maps.google.com/?q=<?php echo $item['mylocation']; ?>" target="_new"><?php echo $item['mylocation']; ?><span><img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $formattedaddress; ?>&markers=color:blue%7C<?php echo $formattedaddress; ?>&zoom=<?php echo $whereabouts_google_static_zoomlevel; ?>&size=450x250&key=<?php echo $whereabouts_google_static_apikey; ?>"/></span></a>
</div><?php } else { echo "<a href='http://maps.google.com/?q=".$item['mylocation']."'>" . $item['mylocation'] . "</a>"; } ?></td><td valign='top' align='left'>
<?php echo "<a href='#' class='deletenote' id='" . $item['note_id'] . "'>delete</a></td></tr>";
}
    $i++;

} ?>
</table>

