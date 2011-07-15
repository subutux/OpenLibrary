<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>jQuery Dynamic Form Demo</title>
		<style type="text/css">

		</style>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-dynamic-form/lib/jquery/jquery-ui-1.8.2.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery-dynamic-form/jquery-dynamic-form.js"></script>
		<script type="text/javascript" src="js/jquery.selectboxes.js"></script>
		<script type="text/javascript" src="js/jquery.serializeObject.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
				//Activate the main dynamic form
				var mainDynamicForm = $("#filter").dynamicForm("#plus", "#minus", {
					createColor:"green"
				});
			$('.cols').live('change',function(){
				var normalOpts = {
					"eq"   : "is equal to",
					"neq"  : "is not equal to",
					"like" : "contains"
					};
				var ratingOpts = {
					"0" : ".....",
					"1" : "*....",
					"2" : "**...",
					"3" : "***..",
					"4" : "****.",
					"5" : "*****"
					};
				var statusOpts = {
					"0" : "unread",
					"1" : "read",
					"2" : "stopped"
					};
				var boolOpts = {
					"0" : "is",
					"1" : "is not"
					};
				var ratingOpts = {
					">" : "Greater then",
					">=" : "Greater then or equal to",
					"<" : "Smaller then",
					"<=" : "Smaller then or equal to",
					"=" : "is equal to",
					"!=" : "is not equal to",
					};
				var methodId = $(this).next().attr('id');
				var currentId = $(this).attr('id');
				var selectedVal = $('#' + currentId + " option:selected").val();
				var options;
				switch(selectedVal){
					case 'author' : options = normalOpts;break;
					case 'title' : options = normalOpts;break;
					case 'summary' : options = normalOpts;break;
					case 'rating' : options = ratingOpts;break;
					case 'status' : options = statusOpts;break;
					case 'outlend' : options = boolOpts;break;
				}
				$('#' + methodId).removeOption(/./);
				$('#' + methodId).addOption(options,false);
			});
		/*	$('#smart').submit(function(){
				$('#json').text(JSON.stringify($('#smart')));
				return false;
			});
		*/
			});
		</script>
	</head>
	<body>
		</pre>
		<form method="post" action="smart.php" value="Post" id="smart">
			<fieldset>
				<legend>Smart List</legend>
				<p><label for="firstname">List name : </label><input id="name" type="text" name="name" size="40"></p>
				<p><label for="operator"> Operator: </label><select id="operator" name="operator" size="1">
				  <option value="AND">And</option>
				  <option value="OR">Or</option>
				</select></p>
				<fieldset id="filter">	
				<legend>Rule</legend>
				<select class="cols" id="col" name="col" size="1">
				  <option value="author">author</option>
				  <option value="title">Title</option>
				  <option value="summary">Summary</option>
				  <option value="rating">Rating</option>
				  <option value="status">Status</option>
				  <option value="outlend">Outlend</option>
				</select>
				<select class="methods" id="method" name="method" size="1">
				  <option value="eq">is equal to</option>
				  <option value="noteq">is not equal to</option>
				  <option value="like">contains</option>
				</select>
				<input class="values" type="text" id="value" name="value" />
				</fieldset>
				<p><span><a id="minus" href="">[-]</a> <a id="plus" href="">[+]</a></span></p>
			</fieldset>
			<input type="submit" />
		</form>
		<pre id="json"></pre>
	</body>
</html>
