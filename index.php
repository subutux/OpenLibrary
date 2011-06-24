<?
/**
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
<title>OpenLibrary</title>
<style>

</style>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.popup.js" type="text/javascript"></script>
<script src="js/jquery.json.min.js" type="text/javascript"></script>
<script src="js/jquery.table_navigation.js" type="text/javascript"></script>
<script src="js/jquery.menuTree.js" type="text/javascript"></script>
<script src="js/dropdown/jquery.selectbox.js" type="text/javascript"></script>
<script type='text/javascript' src='menu.js'></script>
<link rel="stylesheet" href="menu.css" type="text/css" media="screen" />
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<script src="js/DataTables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="js/DataTables/media/css/demo_table.css" REL="stylesheet" TYPE="text/css">
<link href="js/dropdown/selectbox.css" REL="stylesheet" TYPE="text/css">
	<script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="js/main.pack.js" type="text/javascript"></script>
</head>
<body onload="LoadLibrary();">
<div id="searchBar">
<form  id="searchForm" action="test">
<span style="display:inline-block;color: grey;font-family:'arial';font-size:12px;">Search in 
<select name="filter" id="filter">
<option val="t-s">Title, Summary:</option>
<option val="a">Author</option>
</select>
 </span><input type="search" results="10" name="searchstring" id="searchString" />
<input type="submit" class="SSubmit" value="search"/>
</form>
</div>
<div id="topBar">
<span class="barButton" id="actionNewList">&nbsp;</span>
<span class="barButton" id="actionNewAutoList">&nbsp;</span>
<span class="barButton" id="actionDeleteList">&nbsp;</span>
<span class="separator">&nbsp;</span>
<span class="barButton" id="actionSearch">&nbsp;</span>
<span class="barButton" id="actionAdd">&nbsp;</span>
<span class="separator">&nbsp;</span>
<span class="barButton" id="actionEdit">&nbsp;</span>
<span class="barButton" id="actionLoan">&nbsp;</span>
<span class="barButton" id="actionInfo">&nbsp;</span>
</div>
<div id="leftPanel">
<div id="Dirs">
<div id="leftMenu">
<ul>
<li><a href="#lib" class="mI"><span class="icon-lib">&nbsp;</span>Library</a>
	<ul>
		<li><span class="icon-lib">&nbsp;</span><a href="#watch">Watchlist</a></li>
		<li><span class="icon-lib">&nbsp;</span><a href="#wish">Wishlist</a></li>
		<li><span class="icon-lib">&nbsp;</span><a href="#out">outlend</a></li>
	</ul>
</li>
</ul>
</div>
</div>
<div id="artwork">
<div id="artwork-bar">
</div>
<div class="artwork-wrap">
<a href="#" class="fancyBox">
<img class="artwork" src="imgs/spinner-artwork.gif"/>
</a>
</div>
</div>
</div>
<div id="table"></div>
<div id="menu">
<ul id="nav">
    <li><a class="topMenu" href="#">File</a>
    	<ul>
    		<li><a href="#" class="reload"> Reload</a></li>
    		<li><a href="#"> Exit</a></li>
    	</ul>
    </li>
    <li><a class="topMenu" href="#">Edit</a>
                  <ul>
                    <li><a href="#"> Add...</a></li>
                    <li><a href="#"> Edit...</a></li>
                    <li><a href="#"> Delete...</a></li>
                    <li><a href="#"> Import</a>
                        <ul>
                    		<li><a href="#"> From CSV...</a></li>
                    		<li><a href="import-BookHunter.php" class="pop2"> From Book Hunter...</a></li>
              			</ul>
                    </li>
                    <li><a href="#">Export</a>
                        <ul>
                    		<li><a href="#"> To CSV...</a></li>
                    		<li><a href="#"> To Book Hunter...</a></li>
              			</ul>
                    </li>
              </ul>
    </li>
    <li><a class="topMenu" href="#">Help </a>
      <ul>
            <li><a href="about.html" class="pop"> About...</a></li>
            <li style="color: grey"> version 1.0</li>
      </ul>
    </li>
</ul>
</div>
<div id="spinner">
&nbsp;
</div>
