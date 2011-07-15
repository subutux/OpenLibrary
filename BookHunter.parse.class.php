<?
/**
 * OpenLibrary BookHunter Importer
 * 
 * This file contains the class needed for importing a BookHunter Database
 * @author Stijn Van Campenhout <stijn.vancampenhout@gmail.com>
 */
 
/**
 * OpenLibrary BookHunter Importer
 *
 * Import BookHunter database
 * @author Stijn Van Campenhout <stijn.vancampenhout@gmail.com>
 * @package OpenLibrary
 * @subpackage plugins-import
 * @version 1.0
 */
 Class BookHunterImport extends OpenLibrary {
 		public $url;
 		
 		public function Import(){
 			if (!is_dir($this->url)){
 				throw new Exception('Cannot find '.$this->url.'! Check if we have read access!');
 			}
 			$xmlFile = $this->url.'/package.xml';
 			$xml = simplexml_load_file($xmlFile);
 			$books = $xml->Book;
 			$this->db_connect();
 			foreach ($books as $book){
 				$title = (string) $book->Title;
 				$this->updateStatus('BookHunter: Import','Importing '.$title);
 				$bookdata = array (
 					"DatabaseId"	=> (string) $book->DatabaseId[0],
 					"DateModified"	=> (string) $book->DateModified[0],
 					"IsInWishlist"	=> (string) $book->IsInWishlist[0],
 					"Title"			=> addslashes((string) $book->Title[0]),
 					"ISBN"			=> (string) $book->ISBN[0],
 					"Length"		=> (string) $book->Length[0],
 					"PublishDate"	=> (string) $book->PublishDate[0],
 					"Status"		=> (string) $book->Status[0],
 					"Code"			=> (string) $book->Code[0],
 					"DateAcquired"	=> (string) $book->DateAcquired[0],
 					"Summary"		=> addslashes((string) $book->Summary[0]),
 					"ASIN"			=> (string) $book->ASIN[0],
 					"EAN"			=> (string) $book->EAN[0],
 					"Price"			=> (string) $book->Price[0],
 					"SalesRank"		=> (string) $book->SalesRank[0],
 					"Location"		=> (string) $this->getLocationId((string) $book->Location[0]),
 					"Author"		=> (string) $this->getAuthorId(addslashes((string) $book->Author)),
 					"Languages"		=> (string) $this->getLanguageId((string) $book->Languages),
 					"Studio"		=> (string) $this->getStudioId((string) $book->Studio),
 					"Editor"		=> (string) $this->getEditorId(addslashes((string) $book->Editor)),
 					"ProductGroup"	=> (string) $this->getProductGroupId(addslashes((string) $book->ProductGroup))
 					);
 				/**
 				 * Building the query
 				 */
 				 $cols = array();
 				 $vals = array();
 				foreach ($bookdata as $col => $val){
 					$cols[] = "`".$col."`";
 					$vals[] = "'".$val."'";
 				}
 				$q = "INSERT INTO `books` (".join($cols,',').") VALUES(".join($vals,",").")";
 				if ($this->notInDb((string) $book->DatabaseId)){
	 				echo "Executing query for: ".$bookdata['Title']."\n";

 					if (!mysql_query($q,$this->db)){
 						throw new Exception('Internal Error: Unable to add book "'.$title.'" to database! '.mysql_error());
 					}
 				}
 			}
			$this->db_close();
		}
/**
		public function convertPhotos(){
			if ($handle = @opendir($this->url)){
				while( false !=== ($file = readdir($handle) ){
					$ff = explode($file,".");
					$ext = end($ff);
 					if (strtoupper($ext) == "JP2"){
 						$outfile = $ff[0] . ".jpg";
 						$this->updateStatus('BookHunter: Import','converting $file to $outfile ');
 						imagejpeg($file,$outfile,"100");
 					}
 				}
 			}
 		}
 			
**/
}					
 ?>
