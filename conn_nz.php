<?php
$conn = odbc_connect("DSN_ODBC","user","pass");

function getQuery($sql){
	global $conn;
	return odbc_exec($conn,$sql);	
}

function getDistinct($field,$type="",$val=""){
	$temp_arr = array();
	if($type==""){
		$d = getQuery("SELECT distinct $field from nm_table where  $field is not null order by 1 limit 4;");
	}else{
		$d = getQuery("SELECT distinct $field from nm_table where $type='$val' and $field is not null order by 1 limit 4;");
	}
	while($r = odbc_fetch_array($d)){
		$temp_arr[] = $r[strtoupper($field)];
	}
	return $temp_arr;
}
?>
