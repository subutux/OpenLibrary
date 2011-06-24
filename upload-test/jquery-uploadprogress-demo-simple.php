<?
/*
demo page and servlet for jquery.uploadprogress
requires PHP 5.2.x
with uploadprogress module installed:
http://pecl.php.net/package/uploadprogress
*/

extract($_REQUEST);

// servlet that handles uploadprogress requests:
if ($upload_id) {
	$data = uploadprogress_get_info($upload_id);
	if (!$data)
		$data['error'] = 'upload id not found';
	else {		
		$avg_kb = $data['speed_average'] / 1024;
		if ($avg_kb<100)
			$avg_kb = round($avg_kb,1);
		else if ($avg_kb<10)
			$avg_kb = round($avg_kb,2);
		else $avg_kb = round($avg_kb);
		
		// two custom server calculations added to return data object:
		$data['kb_average'] = $avg_kb;
		$data['kb_uploaded'] = round($data['bytes_uploaded'] /1024);
	}
	
	echo json_encode($data);
	exit;
}


// display on completion of upload:
if ($UPLOAD_IDENTIFIER) {
	echo "<pre>";
	print_r($_FILES);
	unlink($_FILES['file1']['tmp_name']);
	unlink($_FILES['file2']['tmp_name']);
	unlink($_FILES['file3']['tmp_name']);
	echo "</pre>";
	exit;
}

// uncomment the following block for pre-request upload ID generation:
/*
$upload_id = genUploadKey();

function genUploadKey ($length = 11) 
{ 
    $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
    for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))]; 
    return $key; 
}
*/

// Default Upload Form:
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PHP + jQuery AJAX File Upload Progress Demo</title>
<style type="text/css">

form {
	border:1px outset #330099;
	padding:10px;
	background-color:#FFF8F2;
	width:400px;
}

form fieldset {
	border:1px inset #309;
}

#upload-message {
	background-color:#FFFFEE;
	border:1px dashed #CC3300;
	font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;
	font-size:14px;
	width:400px;
	padding:10px;
	margin:10px 0px;
}

.upload-progress {
	width:500px;
	height:40px;
}
.upload-progress div.holdmeter {
	background: #ffffff url("gradient-bg.png") repeat-x top;
	-o-background-size: 100% 100%;
	-moz-background-size: 100% 100%;
	-webkit-background-size: 100% 100%;
	background-size: 100% 100%;
	/* Recent browsers */
	background: -moz-linear-gradient(
		top,
		#999999,
		#ffffff
	);
	background: -webkit-gradient(
		linear,
		left top, left bottom,
		from(#999999),
		to(#ffffff)
	);
        height: 10px;
        border-radius: 5px;
        font-size:1px; /* IE display hack */
	width: 100%;
	border: 1px solid grey;

}
.upload-progress div.holdmeter div.meter {
	width:0px;
	height:10px;
	border-radius: 5px;
	font-size:1px; /* IE display hack */
	background: #3399cc url("gradient-bg.png") repeat-x top;
	-o-background-size: 100% 100%;
	-moz-background-size: 100% 100%;
	-webkit-background-size: 100% 100%;
	background-size: 100% 100%;
	/* Recent browsers */
	background: -moz-linear-gradient(
		top,
		#aaeeff,
		#3399cc
	);
	background: -webkit-gradient(
		linear,
		left top, left bottom,
		from(#aaeeff),
		to(#3399cc)
	);	



}

.upload-progress div.readout {
	padding:5px 0px 0px 12px;
	font-family:"Courier New", Courier, monospace;
	font-size:10px;
	line-height:10px;
}

.upload-progress div.readout span {
	font-weight:bold;
}
</style>
</head>

<body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript" src="jquery.uploadprogress.0.3.js"></script>
<script type="text/javascript">
jQuery(function () {
	// apply uploadProgress plugin to form element
	// with debug mode and array of data fields to publish to readout:
	jQuery('#upload_form').uploadProgress({ 
						progressURL:'jquery-uploadprogress-demo-simple.php',
						displayFields : ['kb_uploaded','kb_average','est_sec'],
						start: function() { 
							jQuery('#upload-message').html('Uploading files now - please wait.'); 
							jQuery('input[type=submit]',this).val('Uploading... PLEASE WAIT');
						},
						success: function() { 
							jQuery('input[type=submit]',this).val('Upload File(s)');
							jQuery(this).get(0).reset();
							jQuery('#upload-message').html('Upload received!<br/>Form cleared for more uploads.'); 
						}
					});
});
</script>
<h1>jQuery uploadprogress - simple demo</h1>
<form id="upload_form" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Select files to upload:</legend>
<? 
// in case above upload_id generation block is uncommented, 
// insert the required uploadprogress UPLOAD_IDENTIFIER tag now:
if ($upload_id) { ?>
<input name="UPLOAD_IDENTIFIER" type="hidden" value="<?=$upload_id?>" />
<? } ?>
<input type="file" id="file1" name="file1" /><br />
<input type="file" id="file2" name="file2" /><br />
<input type="file" id="file3" name="file3" /><br />
<input type="submit" name="submit" value="Upload File(s)" id="submit" />
</fieldset>
</form>
<? if ($upload_id) { ?>
<h2>Server created upload_id: <?=$upload_id?></h2>
<? } ?>
<div id="upload-message">Start your upload above.</div>
<div class="upload-progress">
	<div class="readout">
		<span class="kb_uploaded">0</span> kb uploaded - <span class="kb_average">0</span> kb/sec <br/><span class="est_sec">0</span> seconds remain
	</div>
	<div class="holdmeter">
	<div class="meter"></div>
	</div>
</div>
</body>
</html>
