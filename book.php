<?/**
 * Framework Page
 *
 * Build up the framework & layout and start an initial load of the database.
 *
 * @author Stijn Van Campenhout <stijn.vancampenhout@gmail.com>
 * @version 1.0
 * @package OpenLibrary
 * @subpackage framework
 */
?>
<html>
<head>
<title>OpenLibrary > </title>
<style>
@font-face {
	font-family: JGJ;
	src: url('imgs/JGJUNCIA.TTF');
}
@font-face {
	font-family: BlackC;
	src: url('imgs/BLKCHCRY.TTF');
}

body {
	background: url('imgs/OL_bookshelf.png') no-repeat;
	overflow-y:auto;
	margin: 0px;
	background-attachment:fixed;
}
#artwork {
	position: fixed;
	float: left;
	top: 105px;
	left: 50px;
	height: 300px;
	background-color: black;
	text-align: center;
	border-radius: 4px;
	box-shadow: 1px 1px 20px #666;
	-webkit-box-shadow: 1px 1px 20px #666;
}
#artwork .artwork {
	height: 300px;
	border-radius: 4px;
	-moz-border-radius: 4px;
	position: absolute;
	box-shadow: 0px 3px 8px #333;
	-webkit-box-shadow: 0px 3px 8px #333;
	top: 0px;
}
#artwork .shadow {
	position: absolute;
	top: 0px;
	bottom: 0px;
	width: 20px;
	z-index: 1;
background: -moz-linear-gradient(left, rgba(119,119,119,0.39) 0%, rgba(0,0,0,0) 100%);
background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(119,119,119,0.39)), color-stop(100%,rgba(0,0,0,0)));
background: -webkit-linear-gradient(left, rgba(119,119,119,0.39) 0%,rgba(0,0,0,0) 100%);
background: -o-linear-gradient(left, rgba(119,119,119,0.39) 0%,rgba(0,0,0,0) 100%);
background: -ms-linear-gradient(left, rgba(119,119,119,0.39) 0%,rgba(0,0,0,0) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#63777777', endColorstr='#00000000',GradientType=1 );
background: linear-gradient(left, rgba(119,119,119,0.39) 0%,rgba(0,0,0,0) 100%);
	}
#details {
	position: fixed;
	float: right;
	top: 44px;
	left: 300px;
	min-height: 300px;
	max-height: 400px;
	overflow-y: auto;
	width: 350px;
	border-radius: 0px 0px 4px 4px;
	-moz-border-radius: 0px 0px 4px 4px;
	background: url('imgs/OL_brownpaper.jpg');
	text-align: center;
	box-shadow: 1px 1px 20px rgba(201,124,16,0.6);
	-webkit-box-shadow: 1px 1px 20px rgba(201,124,16,0.7);
	
}
#details-topshadow {
	position: fixed;
	float: right;
	top: 44px;
	left: 300px;
	height: 40px;
	width: 350px;
background-image: -webkit-gradient(
    linear,
    left bottom,
    left top,
    color-stop(0.45, rgba(150,95,0,0.0)),
    color-stop(1, rgb(87,48,0))
);
background-image: -moz-linear-gradient(
    center bottom,
    rgba(150,95,0,0.0) 45%,
    rgb(87,48,0) 100%
);
}
#title {
	font-family: 'BlackC';
	text-shadow: 1px 1px 1px rgba(255,255,255,0.4);
	font-size: 25px;
}
.info {
	font-family: 'arial';
	
	text-align: left;
	margin-left: 10px;
	font-size: 12px;
	margin-right: 10px;
}
.summary {
	text-align: justify !important;	
	margin-bottom: 10px;
}
.star {
	background: url('imgs/OL_nostar_bookshelf.png') no-repeat;
	width: 67px;
	height:170px;
	position: fixed;
	top: 439px;
	float: left;
	display:block;
}
.s1 {

	left: 30px;
}
.s2 {

	left:100px;
}

.s3 {

	left:170px;
}
.s4 {

	left:240px;
}

.s5 {


	left:310px;
}
</style>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.popup.js" type="text/javascript"></script>
<script src="js/jquery.json.min.js" type="text/javascript"></script>
<script src="js/jquery.table_navigation.js" type="text/javascript"></script>
<script src="js/dropdown/jquery.selectbox.js" type="text/javascript"></script>
<script src="js/DataTables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="js/DataTables/media/css/demo_table.css" REL="stylesheet" TYPE="text/css">
<link href="js/dropdown/selectbox.css" REL="stylesheet" TYPE="text/css">
	<script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){
	paramsJ = {'databaseId' : '<?=$_GET['id'];?>' };
	params = $.toJSON(paramsJ);
	$.post('rpc/',
		{ method: 'FetchBook',
		  params: params
		},
		function (data){
			library = data;
			$.each(library,function(id,val){
				$("#title").html(val.Title);
				$("#author").html(val.author);
				$("#editor").html(val.editor);
				$(".summary").html(val.Summary);
				$("#publishDate").html(val.PublishDate);
				$(".artwork").attr('src','art/' + val.Code + '.jpg');
			});
		},"json");

$('.s1').hover(
	function(){
		$('.s1').css('background','url(\'imgs/OL_star_bookshelf.png\')');
	},
	function(){
		$('.s1').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
	});
$('.s2').hover(
	function(){
		$('.s1').css('background','url(\'imgs/OL_star_bookshelf.png\')');
		$('.s2').css('background','url(\'imgs/OL_star_bookshelf.png\')');
	},
	function(){
		$('.s1').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
		$('.s2').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
	});
$('.s3').hover(
	function(){
		$('.s1').css('background','url(\'imgs/OL_star_bookshelf.png\')');
		$('.s2').css('background','url(\'imgs/OL_star_bookshelf.png\')');
		$('.s3').css('background','url(\'imgs/OL_star_bookshelf.png\')');
	},
	function(){
		$('.s1').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
		$('.s2').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
		$('.s3').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
	});
$('.s4').hover(
	function(){
		$('.s1').css('background','url(\'imgs/OL_star_bookshelf.png\')');
		$('.s2').css('background','url(\'imgs/OL_star_bookshelf.png\')');
		$('.s3').css('background','url(\'imgs/OL_star_bookshelf.png\')');
		$('.s4').css('background','url(\'imgs/OL_star_bookshelf.png\')');
	},
	function(){
		$('.s1').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
		$('.s2').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
		$('.s3').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
		$('.s4').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
	});
$('.s5').hover(
	function(){
		$('.s1').css('background','url(\'imgs/OL_star_bookshelf.png\')');
		$('.s2').css('background','url(\'imgs/OL_star_bookshelf.png\')');
		$('.s3').css('background','url(\'imgs/OL_star_bookshelf.png\')');
		$('.s4').css('background','url(\'imgs/OL_star_bookshelf.png\')');
		$('.s5').css('background','url(\'imgs/OL_star_bookshelf.png\')');
	},
	function(){
		$('.s1').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
		$('.s2').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
		$('.s3').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
		$('.s4').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
		$('.s5').css('background','url(\'imgs/OL_nostar_bookshelf.png\')');
	});
});
</script>
</head>
<body>

<a class="star s1">&nbsp;</a>
<a class="star s2">&nbsp;</a>
<a class="star s3">&nbsp;</a>
<a class="star s4">&nbsp;</a>
<a class="star s5">&nbsp;</a>
<div id="artwork">
	&nbsp;
	<img class="artwork" src="" />
	<div class="shadow">&nbsp;</div>
</div>
<div id="details">
<h1 id="title"></h1>

<div style="margin-top: -20px;text-align: center !important;font-family:arial;font-size: 12px;text-shadow: 1px 1px 1px rgba(255,255,255,0.4);">
By: <span id="author"></span>
</div>
<p class="info">
Editor: <span id="editor"></span></br>
Puplish date: <span id="publishDate"></span>
</p>
<p class="info">Summary:</p>
<p class="info summary">
</p>
</div>
<div id="details-topshadow"></div>
</body>
</html>
