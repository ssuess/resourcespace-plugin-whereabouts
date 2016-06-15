<?php

include_once "../../../include/db.php";
include_once "../../../include/general.php";
include_once "../../../include/authenticate.php";
include_once "../../../include/resource_functions.php";


$ref=getvalescaped("ref","");
if ($ref==""){die("no");}

$whoto=getvalescaped('who_to','');
$mylocation=getvalescaped('mylocation','');
$datemovement=getvalescaped('date_movement','');
$text=getvalescaped('notetext','');
$text=str_replace("<br />\n"," ",$text);// remove the breaks added by get.php
$page = getvalescaped('page', 1);
$id=getvalescaped('id','');


$oldtext=sql_value("select note value from whereabouts where ref='$ref' and note_id='$id'","");
if ($oldtext!=""){
	remove_keyword_mappings($ref,i18n_get_indexable($oldtext),-1,false,false,"whereabouts_ref",$id);
}

sql_query("delete from whereabouts where ref='$ref' and note_id='$id'");


if (substr($text,0,strlen($username))!=$username){$text=$username.": ".$text;}


sql_query("insert into whereabouts (ref,who_to,mylocation,date_movement,note,user,page) values ('$ref','$whoto','$mylocation','$datemovement','$text','$userref',$page) ");

$annotateid = sql_insert_id();
echo $annotateid;

$notes=sql_query("select * from whereabouts where ref='$ref'");
sql_query("update resource set whereabouts_count=".count($notes)." where ref=$ref");

#Add annotation to keywords
$keywordtext = substr(strstr($text,": "),2); # don't add the username to the keywords
debug("adding whereabouts to resource keywords. Keywords: " . $keywordtext);

add_keyword_mappings($ref,i18n_get_indexable($keywordtext),-1,false,false,"whereabouts_ref",$annotateid);
add_keyword_mappings($ref,i18n_get_indexable($whoto),-1,false,false,"whereabouts_ref",$annotateid);
add_keyword_mappings($ref,i18n_get_indexable($mylocation),-1,false,false,"whereabouts_ref",$annotateid);


#add_keyword_mappings($ref,$text,-1);
