<?php
session_start();

include "conn_nz.php";

$type = isset($_POST['type'])?$_POST['type']:"";
$val = isset($_POST['val'])?$_POST['val']:"";

$_SESSION[$type] = $val;

$filter = "";
$empty = 0;
foreach($_SESSION as $key=>$val){
	if(is_array($val)){
		if($key!='' && sizeof($val)>0 && $val!='')
			$filter .= "and $key in ('".implode("','",$val)."') ";
	}else{
		if($key!='' && sizeof($val)>0 && $val!='')
			$filter .= "and $key='$val' ";
	}
	
}
$data = array(); 
if($filter == ""){
	$data['query']  = "-";
	$data['jml']  = "0";
}else{
	$data['query'] = "SELECT count(*)jml FROM nm_table WHERE 1=1 $filter;";
	$cnt = getQuery($data['query']);
	$data['jml'] =  odbc_result($cnt,'jml');
}
$data['filter'] = $_SESSION;
echo json_encode($data);
?>