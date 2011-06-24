<?
require 'bib.class.php';
require 'BookHunter.parse.class.php';
$bh = new BookHunterImport();
$bh->url = "Bibliotheek.bhpack";
$bh->import();
?>
