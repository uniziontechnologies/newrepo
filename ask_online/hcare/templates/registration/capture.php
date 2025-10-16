<!doctype html>

<html lang="en">
<head>
	    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $lang_title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../dist/css/font-awesome.min.css">
  
    <link rel="stylesheet" href="../../dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
   
    <link rel="stylesheet" href="../../dist/css/skins/skin-blue.min.css">
	<style type="text/css">
		body { font-family: Helvetica, sans-serif; }
		h2, h3 { margin-top:0; }
		form { margin-top: 15px; }
		form > input { margin-right: 15px; }
		#results { float:right; margin:20px; padding:20px; border:1px solid; background:#ccc; }
	</style>
</head>
<body>
	<div id="results">Your captured image will appear here...</div>
	
	<h3>Capture Image</h3>
	
	<div id="my_camera"></div>
	
	<!-- First, include the Webcam.js JavaScript Library -->
	<script type="text/javascript" src="../../dist/js/webcam.js"></script>
	
	<!-- Configure a few settings and attach camera -->
	<script language="JavaScript">
		Webcam.set({
			width: 320,
			height: 240,
			image_format: 'jpeg',
			jpeg_quality: 90
		});
		Webcam.attach( '#my_camera' );
	</script>
	<?php
	
	$opno=$this->popArr['opno'];
	$id=$this->popArr['id'];	
	$module_name=$this->popArr['module_name'];
	?>
	<!-- A button for taking snaps -->
	<form>
		<input type=button value="Take Snapshot" onClick="take_snapshot()" class="btn btn-success">
		<input type=button value="Skip & Continue" onClick="skipCapturing()" class="btn btn-danger">
	</form>
	<form name="saveImage" action="../../lib/controllers/centralController.php?module=Registration&sub_module=save_image" method="post">
	<!-- Code to handle taking the snapshot and displaying it locally -->
	<script language="JavaScript">
		// preload shutter audio clip
		var shutter = new Audio();
		shutter.autoplay = false;
		shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';
		
		function take_snapshot() {
			// play sound effect
			shutter.play();
			var imgOrURL;
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
			
			  document.saveImage.imageData.value=data_uri;
				// display results in page
				document.getElementById('results').innerHTML = 
					'<h3>Your Snap</h3>' + 
					'<img id="embedImage" src="'+data_uri+'"/ height="180px" width="180px">' +
					'</br><a href="#" onclick="document.saveImage.submit()" class="btn btn-info">Save Photo</a>';
					//$('#embedImage').click()					
			} );
		}

        function skipCapturing(){

                       document.saveImage.action="../../lib/controllers/centralController.php?module=Registration&sub_module=<?php echo $module_name;?>";			
			document.saveImage.submit();
			return true;
        }		
		
	</script>
	
	
	
	<input type="hidden" name="imageData" id="imageData" value="">
	<input type="hidden" name="opno" value="<?php echo $opno;?>">
	<input type="hidden" name="id" value="<?php echo $id;?>">
	<input type="hidden" name="module_name" value="<?php echo $module_name;?>">
	</form>
	
</body>
</html>
