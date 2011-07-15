<pre>
<?
/*
{"filter":{
	"filter":{
		"operator":"AND",
		 "0":{
		 	"col":"status",
		 	"method":"0",
		 	"value":"2"},
		 "1":{
		 	"col":"status",
		 	"method":"0",
		 	"value":"0"},
		 "2":{
		 	"col":"rating",
		 	"method":"gt",
		 	"value":"2"}
		 }
	}
}
*/
echo json_encode($_POST,true);
$filters = $_POST['filter']['filter'];
$methods = array(
	'gt'	=> '>',
	'st'	=> '<',
	'gteq'	=> '>=',
	'steq'	=> '<=',
	'neq'	=> '!=',
	'eq'	=> '=',
	'0'		=> '=',
	'1'		=> '!=',
);
		$q  = "SELECT *";
		$q .= " FROM `books`";
		$q .= ",`authors`,`languages`,`locations`,`studios`,`productGroups`,`editors`";
		$q .= " WHERE `books`.`Author` = `authors`.`id`";
		$q .= " AND `books`.`Languages` = `languages`.`id` ";
		$q .= "AND `books`.`Location`  = `locations`.`id` ";
		$q .= "AND `books`.`Studio` = `studios`.`id` ";
		$q .= "AND `books`.`ProductGroup` = `productGroups`.`id`";
		$q .= " AND `books`.`Editor` = `editors`.`id` ";
foreach ($filters as $filter) {
	print_r($filter);
	if (is_array($filter)){
		$q .= "AND `books`.`".$filter['col']."` ".$methods[$filter['method']]." '".$filter['value']."' ";
	}
}

		$q .= " ORDER BY `books`.`Title` ASC";
echo "\n".$q;
?>
</pre>
