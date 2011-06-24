<?
if (isset($_GET['upload_id'])){
	$data = uploadprogress_get_info($_GET['upload_id']);
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

$upload_id = genUploadKey();

function genUploadKey ($length = 11) 
{ 
    $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
    for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))]; 
    return $key; 
}

?>
<html>
<head>
<title>OpenLibrary > Import > Book Hunter</title>
<style>
body {
	font-family: 'arial';
}
#canvas {
	position: fixed;
	float: left;
	top: 0px;
	left:0px;
	width: 600px;
	height:400px;
	border: 1px solid black;
	text-align: center;

	background: url('imgs/OL_header600.png') no-repeat;
}
a.button {
margin-left: 208px;
}
a.button span {
width: 150px;
}
h1 {
	font-family: 'arial';
	font-size: 25px;
	font-weight: bolder;
	color: black;
	heigth: 100px;
	width: 600px;
	margin-bottom: 20px;
	text-shadow: 1px 1px 1px rgba(255,255,255,0.4);
}
.sidenote {
	display: block;
	font-family: 'arial';
	font-size: 12px;
	color: grey;
}
#formUpload {
margin-top: 40px;
}
.upload-progress {
	position: fixed;
	float:left;
	bottom: 50px;
	left: 50px;
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
background: rgb(226,188,131);
background: -moz-linear-gradient(top, rgba(226,188,131,1) 0%, rgba(137,73,0,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(226,188,131,1)), color-stop(100%,rgba(137,73,0,1)));
background: -webkit-linear-gradient(top, rgba(226,188,131,1) 0%,rgba(137,73,0,1) 100%);
background: -o-linear-gradient(top, rgba(226,188,131,1) 0%,rgba(137,73,0,1) 100%);
background: -ms-linear-gradient(top, rgba(226,188,131,1) 0%,rgba(137,73,0,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2bc83', endColorstr='#894900',GradientType=0 );
background: linear-gradient(top, rgba(226,188,131,1) 0%,rgba(137,73,0,1) 100%);	



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
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.json.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.uploadprogress.0.3.js"></script>
<script type="text/javascript">
jQuery(function () {
	
/*	jQuery('.upload-progress').hide(); */
	// apply uploadProgress plugin to form element
	// with debug mode and array of data fields to publish to readout:
	jQuery('#upload_form').uploadProgress({ 
						progressURL:'import-BookHunter.php',
						displayFields : ['kb_uploaded','kb_average','est_sec'],
						start: function() {
							jQuery('.upload-progress').fadeIn();
							jQuery('#upload-message').html('Uploading files now - please wait.'); 
							jQuery('input[type=submit]',this).val('Uploading... PLEASE WAIT');
						},
						success: function() { 
							jQuery('input[type=submit]',this).val('Upload File(s)');
							jQuery(this).get(0).reset();
							jQuery('#upload-message').html('Upload received!<br/>Form cleared for more uploads.');
							jQuery('.meter').css('width','100%');
						/*	jQuery('.upload-progress').fadeOut(); */
						}
					});
});
flipflop = true;
function flipFlopProgress(){
$('.meter').css('width','40px');
 if (parseInt($('.meter').css('margin-left')) < '92'){
 		$margin = $('.meter').css('margin-left');
 		$margin = parseInt($('.meter').css('margin-left')) + 2 + "%"
 		 $('.meter').css('margin-left',$margin);
 		 setTimeout("flipFlopProgress();",1000);
 
return true
}
</script>
</head>
<body>
<div id="canvas">
<?
if (!isset($_GET['step'])){
?>
<h1>Import bookhunter database</h1>
<p style="margin-bottom: 40px;text-shadow: 1px 1px 1px rgba(255,255,255,0.4);"> Please choose the method for importing:</p>

<a class="button" href="import-BookHunter.php?step=2&method=add"><span>Add to database</span></a></br></br>
<div class="sidenote">Add the imported books into the database. If the book exists in the database,
do nothing.
</div></br>
<a class="button" href="import-BookHunter.php?step=2&method=addreplace"><span>Add & replace to database</span></a></br></br>
<div class="sidenote">Add the imported books into the database. If the book exists in the database,
replace the data with the new imported data.
</div></br>
<a class="button" href="import-BookHunter.php?step=2&method=replace"><span>Clean import</span></a></br></br>
<div class="sidenote">
Remove all existing data and import.
</div></br>
<?
} else if ($_GET['step'] == "2"){
?>
<h1>Import bookhunter database</h1>
<p style="margin-bottom: 40px;text-shadow: 1px 1px 1px rgba(255,255,255,0.4);"> Upload your exported bookhunter file:</p>
<div class="sidenote">
Before you can import any data, you'll need to export your books in Book Hunter to the native .bookhunter file.
</div>
<div class="sidenote">
Compress this file into a zip by command-click on the .bookhunter file and choose "compress".
</div>
<div class="sidenote">
Upload the file by clicking below on the upload button.
</div>
<div id="formUpload">
<form id="upload_form" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
<?if ($upload_id) { ?>
<input name="UPLOAD_IDENTIFIER" type="hidden" value="<?=$upload_id?>" />
<? } ?>
<input type="file" id="file" name="file" />
<input type="submit" name="submit" value="Upload" id="submit" />
</form>
</div>
<div id="upload-message">Start your upload above.</div>
<div class="upload-progress">
	<div class="holdmeter">
	<div class="meter"></div>
	<div class="readout">
		<span class="kb_uploaded">0</span> kb uploaded - <span class="kb_average">0</span> kb/sec <span class="est_sec">0</span> seconds remain
	</div>
	</div>
</div>
</div>
<?
}
?>
</div>
</body>
</html>
