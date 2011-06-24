<?
$file = "package.xml";
$xml = simplexml_load_file($file);
$books = $xml->Book;
foreach ($books as $book){
	echo $book->Title."\n";
}
?>
