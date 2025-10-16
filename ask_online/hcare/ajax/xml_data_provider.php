<?php

    // This is a very simple data provider for the cascading dropdown
    // example. A *real* data provider would most likely connect to
    // a database, use xslt and implement some level of security.

include ("../settings.php");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);

Header("Content-type: text/xml"); 
    // get query string params
	$filter = $_GET['filter'];
	$xml = '';
	$iscountry = 1;
	
    // build xml content for client JavaScript
if(isset($_GET['state']) && $_GET['state']==1){
	$query  = "SELECT * from districts where state_ref = '$filter'";
	$result = mysql_query($query,$dbf->conn);
	while($row = $result -> fetch_assoc())
	{ 
		if ($iscountry == 1)
		{
		$xml = $xml . '<continent name="' . $row['state_ref'] . '">';
		$xml = $xml . '<country id="-1">---select---</country>';
		}
		
		$xml = $xml . '<country id="' . $row['id'] . '">' . $row['district'] . '</country>';
		$iscountry = $iscountry + 1;
	}	
	$xml = $xml . '</continent>';
	
	if ($iscountry == 1)
	{
        $xml = $xml . '<continent name="none">';
        $xml = $xml . '<country id="0">no Districts found</country>';
        $xml = $xml . '</continent>';
	}
	echo( $xml );

}else{
	
	$query  = "SELECT * from states where country_ref = '$filter'";
	$result = mysql_query($query,$dbf->conn);
	while($row = $result -> fetch_assoc())
	{ 
		if ($iscountry == 1)
		{
		$xml = $xml . '<continent name="' . $row['country_ref'] . '">';
		$xml = $xml . '<country id="-1">---select---</country>';
		}
		
		$xml = $xml . '<country id="' . $row['id'] . '">' . $row['state'] . '</country>';
		$iscountry = $iscountry + 1;
	}	
	$xml = $xml . '</continent>';
	
	if ($iscountry == 1)
	{
        $xml = $xml . '<continent name="none">';
        $xml = $xml . '<country id="0">no countries found</country>';
        $xml = $xml . '</continent>';
	}
	echo( $xml );
}
    // send xml to client
	
?>