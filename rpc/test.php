<?
/**
 * RPC server
 *
 * Handles RPC requests from Javascript in json
 * @author Stijn Van Campenhout <stijn.vancampenhout@gmail.com>
 * @version 1.0
 * @package OpenLibrary
 * @subpackage framework
 */
/**if (!isset($_POST['method']) || !isset($_POST['params'])){
	echo "<h1>Request Error</h1>";
	echo "<h2>Requested parameters are not used</h2>";
	exit(1);
}*/
$method = $_GET['method'];
require '../bib.class.php';
$OL = new OpenLibrary();
switch ($method){
	case 'FetchLib':
		try{
		$lib = $OL->ListLibrary();
		echo "<pre>";
		print_r($lib);
		echo "</pre>";
		} catch (Exception $e){
				echo $e->getMessage();
		}
		break;
	default:
		echo "Unknown method.";
		break;
}
?>
