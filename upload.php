<?
if (isset($_GET['progress'])){
        $id = $_POST['id'];
        $progress = uploadprogress_get_info($id);
	if ($progress == null){
		$progress = array();
		$progress['upload'] =  "done";
	} else  $progress['upload'] = "active";
        echo json_encode($progress);
} else if (!isset($_FILES['file']) || !isset($_GET['progress'])){
	$id = uniqid("");
?>
<html>
<head>
<title>Upload</title>
<style>
</style>
<script src="js/jquery.js" type="text/javascript"></script>
<script>
var uploadi = 0;
function fetch_upload_info(id){
	$.post("upload.php?progress=true", { id: id },
		function(data) {
			html = "";
			console.log(data);
			if (data.upload == "active"){
				$.each(data,function(i,value){
					html += "<b>" + i + "</b>: " + value + "</br>";

				});
				$("#uploadInfo").html(html);
			} else {
				console.log('im here!');
				//tmp_file = $("#uploadFrame").content().find("#tmp_file").html();
				alert('Done');
				//html = "Upload completed. Temp file = " + tmp_file;
				document.getElementById('uploadInfo').html('');
				//$("#uploadInfo").html('Upload completed. Temp file = ' + tmp_file);
				clearInterval(uploadi);		

			}
		},"json");
}
$(document).ready(function() {
	$('#upload').submit(function(){
		uploadi = setInterval(function(){fetch_upload_info($("#uploadId").val())}, 500);
		return true;
	});
});
</script>
</head>
<body>
<pre>
<?
//print_r(get_loaded_extensions());
//$templateini = ini_get("uploadprogress.file.filename_template");
//echo "tmp: " . $templateini;
?>
</pre>
<form id="upload" action="uploadAction.php" target="uploadFrame" method="post" enctype="multipart/form-data">
<input id="uploadId" type="hidden" name="UPLOAD_IDENTIFIER" value="<?echo $id;?>" />
<input type="file" name="file" />
<input id="uploadS" type="submit" value="Upload"/>
</form>
<div id="uploadInfo"></div>
<div id="tempfile"></div>
</body>
<iframe name="uploadFrame" id="uploadFrame" style="display: none;"></iframe>
</html>

<?
}
?>

