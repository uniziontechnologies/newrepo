<?php
session_start();
set_time_limit(0);
ini_set("memory_limit","-1");
ini_set('display_errors', '1');

$no_of_uploaders = 1;
$uploader_type = "image";
$max_file_size = 10;
$success="";



$id = $_GET['id'];
$upload_base = 'E:\wamp\www\photouploader';

/*$atype = $_GET['atype'];
$ftype = $_GET['ftype'];
$sess_id = $_GET['sess_id'];
$serv = $_GET['serv'];

if ($serv == "amdt")
{
	$sdir = "file";
}
else
{
	$sdir = "file_dev";
}
*/
$dbname = "visamedicals";
$link = mysql_connect("localhost","root","") or die("Couldn't make connection.");
$db = mysql_select_db($dbname, $link) or die("Couldn't select database");



$valid_uploader_types = array("image","document","video","file");

if($uploader_type == "" || !in_array($uploader_type,$valid_uploader_types)){
	echo "Invalid Uploader Type.";
	exit;
}
if($max_file_size == ""){
	$max_file_size = 10;
}


if($no_of_uploaders == ""){
	$no_of_uploaders = 1;
}

if($uploader_type == "image"){
	$allowed_files = array("image/jpeg", "image/gif", "image/png");
}

if($uploader_type == "document"){
	$allowed_files = array("text/html", "application/rtf", "text/plain", "application/pdf", "application/msword", "application/excel", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
}

if($uploader_type == "video"){
	$allowed_files = array("video/3gpp", "video/x-msvideo", "video/quicktime", "video/mpeg", "video/mp4", "video/x-ms-wmv", "video/asf", "video/x-ms-asf", "video/mpeg4");
}

if($uploader_type == "file"){
	$allowed_files = array("image/jpeg", "image/gif", "image/png", "text/html", "application/rtf", "text/plain", "application/pdf", "application/msword", "application/excel", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
}

if(isset($_POST['start_upload'])){
	
	$fName=$_POST['multiFiles'];
	$args=$_POST['args'];
	$id="1";
	
if($_POST['start_upload']){

		$file_name = basename($_FILES[$fName]['name']); 
		$file_type = $_FILES[$fName]['type'];
		$file_size = $_FILES[$fName]['size'];
		$file_temp = $_FILES[$fName]['tmp_name'];
		
		/*$imageblob = addslashes(file_get_contents($file_temp)); 
		$sql = "UPDATE registration SET photo = '{$imageblob}' WHERE id=$id";		
		$result = mysql_query($sql);
		if($result){
		echo "Photo uploaded successfully.";
		}else{
		echo "No User found for uploading photo. Please create a user.";
		}	*/	


	for($i=1; $i<=$no_of_uploaders; $i++){
		$file_name = basename($_FILES[$fName]['name']); 
		$file_type = $_FILES[$fName]['type'];
		$file_size = $_FILES[$fName]['size'];
		$file_temp = $_FILES[$fName]['tmp_name'];
				
		if($file_name != ""){
			if(!in_array($file_type,$allowed_files)){
				$validation .= "Invalid file type for $file_name<br>";
			}
			
			if($file_size > $max_file_size * 1024 * 1024){
				$validation .= "Invalid file size for $file_name<br>";
			}
					
			
							
			$fname = "photo.jpg";			
			$fpath = $upload_base;
			
			if(file_exists($fpath."/".$id))	
			{
				if(file_exists($fpath."/".$id."/".$fname))	
				{
						@unlink($fpath."/".$id."/".$fname);	
						@unlink($fpath."/".$id."/".$fname);	
					
				}
					
			}
			else
			{
				mkdir($fpath."/".$id,0777); 
			}
			
						
				if(move_uploaded_file($file_temp, $fpath."/".$id."/".$fname)){
					$success = $file_name."<!--seperator-->";						
				}
			
			
		}
	} 
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Multiple File Uploader</title>
<style type="text/css">
*{
	margin: 0px;
	padding: 0px;
}
body{
	font-family: Arial, Helvetica, sans-serif;
}
#multiFiles{
	margin-bottom:2px;
}
#uploader{
	float: left;
	width: 450px;
}
#uploader_fields{
	float: left;
	width: 450px;
	margin-bottom:20px;
	margin-right:10px;
	display:inline;
}
#uploader_failure{
	font-size: 13px;
	font-weight: bold;
	color: #F00;
	float: right;
	width:450px;
	text-align:left;
	margin-bottom: 10px;
}
#uploader_success{
	font-size: 13px;
	font-weight: bold;
	color: #060;
	float: right;
	width:450px;
	text-align:left;
	margin-bottom: 10px;
}
.button {
	display: inline-block;
	outline: none;
	cursor: pointer;
	text-align: center;
	text-decoration: none;
	-webkit-border-radius: .8em;
	-moz-border-radius: .8em;
	border-radius: .8em;
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	-moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	box-shadow: 0 1px 2px rgba(0,0,0,.2);
	font-family: Century Gothic, Helvetica, sans-serif;
	font-size: 14px;
	line-height: 100%;
	font-weight: bold;
	margin-bottom: 5px;
	padding-top: 0.3em;
	padding-right: 1em;
	padding-bottom: 0.33em;
	padding-left: 1em;
}
.button:hover{
	text-decoration: none;
}
.bluebutton{
	color: #fef4e9;
	border: 1px solid #25366A;
	background-image: url(../../img/button.jpg);
	background-repeat: repeat-x;
}
.bluebutton:hover{
	background-image: url(../../img/button_over.jpg);
	background-repeat: repeat-x;	
	border: 1px solid #C7DCF0;
	color: #25366A;
}
</style>
</head>
<body>
<div id="uploader">
<form method="post" action="" enctype="multipart/form-data" name="resp">

<?php
if($success != ""){
	$success = substr($success,0,-16);
	echo "<div id='uploader_success'>$success was uploaded successfully.</div>";
}

?>

<div id="uploader_fields">
<?php

	echo "<input type=file name='multiFiles".$_GET['arg']."' id='multiFiles".$_GET['arg']."' accept='image/gif,image/jpeg,image/png'><br />\n";
	echo "<input type=hidden name='multiFiles' id='multiFiles' value='multiFiles".$_GET['arg']."'>";  	
?>
</div>
<br style="clear:both" />
<input type="submit" name="start_upload" value="Start Upload" class="button bluebutton" onclick="parent.getValue(this.form.rspuid.value,<?php echo $_GET['arg']; ?>);"/> <input type="reset" name="reset" value="Clear" class="button bluebutton" id="reset"/>
</form>

</div>

</body>
</html>