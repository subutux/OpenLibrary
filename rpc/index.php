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
$method = $_POST['method'];
require '../bib.class.php';
$OL = new OpenLibrary();
switch ($method){
	case 'FetchLib':
		try{
		$lib = $OL->ListLibrary();
		echo json_encode($lib);
		} catch (Exception $e){
				echo $e->getMessage();
		}
		break;
	case 'fetchArtwork':
		$params = json_decode($_POST['params'],true);
		try {
		$art = $OL->getArtwork($params['id']);
		echo json_encode($art);
		} catch (Exception $e){
			echo $e->getMessage();
		}
		break;
	case 'FetchBook':
		$params = json_decode($_POST['params'],true);
		try {
		$book = $OL->getBook($params['databaseId']);
		echo json_encode($book);
		} catch (Exception $e){
			echo $e->getMessage();
		}
		break;
	case 'test':
		$params = json_decode($_POST['params'],true);
		try {
		$Q = $OL->search($params['searchQuery']);
		echo json_encode($Q);
		} catch (Exception $e){
			echo $e->getMessage();
		}
		break;
	default:
		echo "Unknown method.";
		break;
}
?>
