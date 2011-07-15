<?
/**
 * OpenLibrary class
 * 
 * Base class for database operations
 * @author Stijn Van Campenhout <stijn.vancampenhout@gmail.com>
 */
 
/**
 * OpenLibrary Class
 *
 * Base class for database operations
 * @author Stijn Van Campenhout <stijn.vancampenhout@gmail.com>
 * @package OpenLibrary
 * @subpackage core
 * @version 1.0
 */
Class OpenLibrary {
	public $db_host = "localhost";
	public $db_user = "bib";
	public $db_pass = "bib";
	public $db_db = "bib";
	public $db;
	protected $statusFile = "/var/www/Bibliotheek/status.json";
	
	protected function db_connect(){
		if ($this->db = mysql_connect($this->db_host,$this->db_user,$this->db_pass)) {
			if (mysql_select_db($this->db_db,$this->db)){
				return true;
			} else {
				throw new Exception('Internal Error: Unable to connect to database!');
				}
		} else {
			throw new Exception('Internal Error: Unable to connect to Mysql Server!');
		}
		
	}
	protected function db_close() {
		mysql_close($this->db);
	}
	public function updateStatus($program,$status){

		file_put_contents($this->statusFile,json_encode($status),FILE_APPEND);
	}
	public function getAuthorId($author = false){
		if ($author == false){
			$author == 'null';
		}
		$this->db_connect();
		$result = mysql_query("SELECT * FROM `authors` WHERE `author` = '".$author."'");
		if (mysql_num_rows($result) == "0"){
			if(!mysql_query("INSERT INTO `authors` (`author`) VALUES ('".$author."')")){
				throw new Exception('Internal Error: Unable to add author "'.$author.'" to database!');
			} else { return mysql_insert_id();}
		} else {
			$return = mysql_fetch_assoc($result);
			$this->db_close();
			return $return['id'];
		}
	}
	public function getEditorId($editor = false){
		if ($editor == false){
			$editor == 'null';
		}
		$this->db_connect();
		$result = mysql_query("SELECT * FROM `editors` WHERE `editor` = '".$editor."'");
		if (mysql_error()){
			throw new Exception(mysql_error());
		}
		if (mysql_num_rows($result) == "0"){
			if(!mysql_query("INSERT INTO `editors` (`editor`) VALUES ('".$editor."')")){
				throw new Exception('Internal Error: Unable to add editor "'.$editor.'" to database!');
			} else { return mysql_insert_id();}
		} else {
			$return = mysql_fetch_assoc($result);
			$this->db_close();
			return $return['id'];
		}
	}
	public function getLanguageId($language = false){
		if($language == false){
			$language == 'null';
		}
		$this->db_connect();
		$result = mysql_query("SELECT * FROM `languages` WHERE `language` = '".$language."'");
		if (mysql_num_rows($result) == "0"){
			if(!mysql_query("INSERT INTO `languages` (`language`) VALUES ('".$language."')")){
				throw new Exception('Internal Error: Unable to add language "'.$language.'" to database!');
			} else { return mysql_insert_id();}
		} else {
			$return = mysql_fetch_assoc($result);
			$this->db_close();
			return $return['id'];
		}
	}
	public function getStudioId($studio = false){
		if ($studio == false){
			$studio == 'null';
		}
		$this->db_connect();
		$result = mysql_query("SELECT * FROM `studios` WHERE `studio` = '".$studio."'");
		if (mysql_num_rows($result) == "0"){
			if(!mysql_query("INSERT INTO `studios` (`studio`) VALUES ('".$studio."')")){
				throw new Exception('Internal Error: Unable to add studio "'.$studio.'" to database!');
			} else { return mysql_insert_id();}
		} else {
			$return = mysql_fetch_assoc($result);
			$this->db_close();
			return $return['id'];
		}
	}
	public function getProductGroupId($productGroup = false){
		if ($productGroup == false){
			$productGroup == 'null';
		}
		$this->db_connect();
		$result = mysql_query("SELECT * FROM `productGroups` WHERE `productGroup` = '".$productGroup."'");
		if (mysql_num_rows($result) == "0"){
			if(!mysql_query("INSERT INTO `productGroups` (`productGroup`) VALUES ('".$productGroup."')")){
				throw new Exception('Internal Error: Unable to add productGroup "'.$productGroup.'" to database!');
			} else { return mysql_insert_id();}
		} else {
			$return = mysql_fetch_assoc($result);
			$this->db_close();
			return $return['id'];
		}
	}
	public function getLocationId($location = false){
		if ($location == false){
			$location == 'null';
		}
		$result = mysql_query("SELECT * FROM `locations` WHERE `location` = '".$location."'");
		if (mysql_error()){
			throw new Exception(mysql_error());
		}
		if (mysql_num_rows($result) == "0"){
			if(!mysql_query("INSERT INTO `locations` (`location`) VALUES ('".$location."')")){
				throw new Exception('Internal Error: Unable to add location "'.$location.'" to database!');
			} else { return mysql_insert_id();}
		} else {
			$return = mysql_fetch_assoc($result);
			$this->db_close();
			return $return['id'];
		}
	}
	public function notInDb($DatabaseId){
		$this->db_connect();
		$result = mysql_query("SELECT `DatabaseId` FROM `books` WHERE `DatabaseId` = '$DatabaseId'");
		if (mysql_num_rows($result) == "0"){
			return true;
		} else {
			return false;
		}
	}
	public function getBook($DatabaseId){
		$this->db_connect();
		$book = array();
		$q  = "SELECT *";
		$q .= " FROM `books`";
		$q .= ",`authors`,`languages`,`locations`,`studios`,`productGroups`,`editors`";
		$q .= " WHERE `books`.`DatabaseId` = '".$DatabaseId."' AND";
		$q .= " `books`.`Author` = `authors`.`id`";
		$q .= " AND `books`.`Languages` = `languages`.`id` ";
		$q .= "AND `books`.`Location`  = `locations`.`id` ";
		$q .= "AND `books`.`Studio` = `studios`.`id` ";
		$q .= "AND `books`.`ProductGroup` = `productGroups`.`id`";
		$q .= " AND `books`.`Editor` = `editors`.`id`";
		$q .= " ORDER BY `books`.`Title` ASC";
		$q .= " LIMIT 1";
		$result = mysql_query($q,$this->db);
		if (mysql_error()){
			throw new Exception('Internal Error: Unable to fetch Book.'.mysql_error());
		}
		$row = mysql_fetch_assoc($result);
		$book[$row['DatabaseId']] = $row;
			foreach($book[$row['DatabaseId']] as $set => $val){
				$book[$row['DatabaseId']][$set] = html_entity_decode($val);
			}
		return $book;
	}
	public function ListLibrary(){
		$this->db_connect();
		$books = array();
		$q  = "SELECT *";
		$q .= " FROM `books`";
		$q .= ",`authors`,`languages`,`locations`,`studios`,`productGroups`,`editors`";
		$q .= " WHERE `books`.`Author` = `authors`.`id`";
		$q .= " AND `books`.`Languages` = `languages`.`id` ";
		$q .= "AND `books`.`Location`  = `locations`.`id` ";
		$q .= "AND `books`.`Studio` = `studios`.`id` ";
		$q .= "AND `books`.`ProductGroup` = `productGroups`.`id`";
		$q .= " AND `books`.`Editor` = `editors`.`id`";
		$q .= " ORDER BY `books`.`Title` ASC";
		//$q .= " LIMIT 10";
		$result = mysql_query($q,$this->db);
		if (mysql_error()){
			throw new Exception('Internal Error: Unable to fetch Book list.'.mysql_error());
		}
		while ($row = mysql_fetch_assoc($result)){
			$row['SmallSummary'] = substr($row['Summary'],'0','20')."...";
			$books[$row['DatabaseId']] = $row;
		}
		return $books;
	}
	public function getArtwork($DatabaseId){
		$this->db_connect();
		$q = "SELECT `Code` FROM `books` WHERE `DatabaseId` = '$DatabaseId'";
		$result = mysql_query($q,$this->db);
		if (mysql_error()){
			throw new Exception('Internal Error: Unable to fetch Artwork link');
		}
		if (mysql_num_rows($result) == 0){
			throw new Exception('Unknown book '.$DatabaseId);
		} else {
		$result = mysql_fetch_assoc($result);
		}
		$artwork = "art/".$result['Code'].".jpg";
		return array(
			"link" => $artwork
			);
	}
	public function createSmartList($name,$data) {
	$this->db_connect();
		$sQ = "SELECT * FROM `smartlists` WHERE `name` = '" . $name . "';";
		if (mysql_num_rows(mysql_query($q,$this->db)) > 0){
			throw new Exception('error: smartlist with name '.$name.' already exists.choose a different name.');
		} else {
			$q = "INSERT INTO `smartlists` ('name','data') VALUES('".$name."','".json_encode($data)."');";
			if(mysql_query($q,$this->db)) {
				$listid = mysql_insert_id($this->db);
				$this->db_close();
				return $listid;
			} else {
				throw new Exception('Interal Error: Unable to add smartlist! '.mysql_error());
			}
		}
	}
	public function Search($searchString){
		$this->db_connect();
		if (empty($searchString)){
			//just list the whole library
			return $this->ListLibrary();
		}
		$searchString = $this->getMysqlSearchTerm($searchString);
		$books = array();
		$q  = "SELECT *";
		$q .= " FROM `books`";
		$q .= ",`authors`,`languages`,`locations`,`studios`,`productGroups`,`editors`";
		$q .= "WHERE MATCH(`books`.`Title`,`books`.`Summary`) AGAINST('".$searchString."') AND";
		$q .= " `books`.`Author` = `authors`.`id`";
		$q .= " AND `books`.`Languages` = `languages`.`id` ";
		$q .= "AND `books`.`Location`  = `locations`.`id` ";
		$q .= "AND `books`.`Studio` = `studios`.`id` ";
		$q .= "AND `books`.`ProductGroup` = `productGroups`.`id`";
		$q .= " AND `books`.`Editor` = `editors`.`id`";
		$q .= " ORDER BY `books`.`Title` ASC";
		$result = mysql_query($q,$this->db);
		if (mysql_error()){
			throw new Exception('Internal Error: Unable to fetch Book list.'.mysql_error());
		}
		while ($row = mysql_fetch_assoc($result)){
			$row['SmallSummary'] = substr($row['Summary'],'0','20')."...";
			$books[$row['DatabaseId']] = $row;
		}
		return $books;
	}
	public function getMySQLSearchTerm($zoekterm){
		// Stripslashes, indien nodig
		$zoekterm = (get_magic_quotes_gpc == 0 ? stripslashes($zoekterm) : $zoekterm);
		// Vervang de spaties tussen " en " door een |
		if (preg_match_all('/"(.*?)"/', $zoekterm, $matches, PREG_SET_ORDER)) {
			foreach($matches as $match) {
				$zoekterm = str_replace($match[0], str_replace(' ', '|', $match[0]), $zoekterm);
			}
		}
		// Vervang de spaties tussen ( en } door een ~
		if (preg_match_all('/((.*?))/', $zoekterm, $matches, PREG_SET_ORDER)) {
			foreach($matches as $match) {
				$zoekterm = str_replace($match[0], str_replace(' ', '~', $match[0]), $zoekterm);
			}
		}
	
		// Stop de zoektermen in een array
		$zoektermTemp = preg_split("/[s,]+/", $zoekterm);
	
		// Doorloop de zoektermen, op zoek naar dubbele keywords achter elkaar
		$aantalAND = 0;
		$aantalOR = 0;
		$zoekterm = array();
		$i = 0;
		while(list($key, $val) = each($zoektermTemp)){
			if (strtoupper($val) == "AND" OR strtoupper($val) == "OR"){
				// Als de term hiervoor ook al een operator is, deze verwijderen
				if ($key != 0){
					if (!(	strtoupper($zoektermTemp[$key-1]) == "AND" OR strtoupper($zoektermTemp[$key-1]) == "OR")){
						$zoekterm[$i] = strtoupper($val);
						$i++;
						// Tel aantal AND en OR's die overblijven
						if (strtoupper($val) == "AND"){
							$aantalAND++;
						}else{
							$aantalOR++;
						}
					}
				}
	
			}else{
				// Als de vorige term geen operator was, moet er nu een AND tussen
				if ($i > 0){
					if ($zoekterm[$i-1] != "AND" AND $zoekterm[$i-1] != "OR"){
						$zoekterm[$i] = "AND";
						$i++;
					}
				}
				// Zoekterm toevoegen
				$zoekterm[$i] = $val;
				$i++;
			}
	
		}
		// Doorloop de zoektermen, op zoek naar een AND
		while(list($key, $val) = each($zoekterm)){
			if (strtoupper($val) == "AND"){
				// De term voor en na deze term zijn verplicht
				if ($key != 0){
					// Voorkom een dubbel plusje
					if (substr($zoekterm[$key-1], 0, 1) != "+"){
						$zoekterm[$key-1] = "+" . $zoekterm[$key-1];
					}
				}
				if ($key != count($zoekterm) - 1){
					$zoekterm[$key+1] = "+" . $zoekterm[$key+1];
				}
	
			}
		}
		// Als er AND én OR in de zoektermen voorkomt, moeten er ronde haken om het AND-deel
		if ($aantalAND > 0 && $aantalOR > 0){
			reset($zoekterm);
			while(list($key, $val) = each($zoekterm)){
				// Openingshaak: (
				if ($key != count($zoekterm) - 1){
					if ($zoekterm[$key+1] == "AND"){
						$zoekterm[$key] = "(" . $zoekterm[$key];
					}
				}
				// Sluithaak: )
				if ($key != 0){
					if ($zoekterm[$key-1] == "AND"){
						$zoekterm[$key] = $zoekterm[$key] . ")";
					}
				}
			}
		}
		// Haal de | en ~ weer weg
		$zoekterm = str_replace("|", " ", $zoekterm);
		$zoekterm = str_replace("~", " ", $zoekterm);
		// Haal handmatig de AND en OR weg
		$zoekterm = str_replace("AND", "", $zoekterm);
		$zoekterm = str_replace("OR", "", $zoekterm);
		// Plak de zoekterm weer aan elkaar
		$zoekterm = implode(" ", $zoekterm);
		return $zoekterm;
	}
}
 

?>
