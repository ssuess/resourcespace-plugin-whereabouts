<?php


include_once "../../../include/db.php";
include_once "../../../include/general.php";
include_once "../../../include/authenticate.php";
include_once "../../../include/resource_functions.php";

$ref=getvalescaped("ref","");
if ($ref==""){die("no");}
$id=getvalescaped('noteid','');

$oldtext=sql_value("select note value from whereabouts where ref='$ref' and note_id='$id'","");
if ($oldtext!=""){

	remove_keyword_mappings($ref,i18n_get_indexable($oldtext),-1,false,false,"whereabouts_ref",$id);
	debug("Annotation: deleting keyword: " . i18n_get_indexable($oldtext). " from resource id: " . $ref);
}

$notes=sql_query("delete from whereabouts where ref='$ref' and note_id='$id'");
$notes=sql_query("select * from whereabouts where ref='$ref'");
sql_query("update resource set whereabouts_count=".count($notes)." where ref=$ref");

