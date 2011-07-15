function showArtwork(id){
	$('img.artwork').attr('src','imgs/spinner-artwork.gif');
	$.post('rpc/',
		{ method:'fetchArtwork',
		  params:"{\"id\": \"" + id + "\"}"
		},function(data){
			if (typeof(data.link) != undefined){
				$('img.artwork').attr('src',data.link);
				$('a.fancyBox').attr('href',data.link);
				$title = $('#' + id).children('.tdT').html();
				$str = $title.substr(0,29);
				if ($title.substr(29,$title.length) != ""){
					$str += "..."
				}
				$('#artwork-bar').html($str);
			} else {
				$('img.artwork').attr('src','imgs/artwork_default.png');
				$('#artwork-bar').html('');
			}
		},"json");
}
function LoadLibrary(){
$('#artwork-bar').html('');
$('#spinner').show();
	$.post('rpc/',
		{ method: 'FetchLib',
		  params: ''
		},
		function (data){
			table = "<table cellspacing=\"0\" id=\"liblist\"><thead><tr><th>Title</th><th>Author</th><th>Summary</th><th>Pages</th><th>Published</th></tr></thead><tbody>";
			library = data;
			$.each(library,function(id,val){
				table += "<tr class=\"LibRow\" id=\"" + id + "\"><td class=\"tdT\">" + val.Title + "</td><td class=\"tdA\">" + val.author + "</td><td class=\"tdS\">" + val.SmallSummary + "</td><td class=\"tdPa\">" + val.Length + "</td><td class=\"tdPu\">" + val.PublishDate + "</td></tr>";
			});
			table += "</tbody></table>";
			$('#table').html(table);
/*
			$('tr.libRow > td').click(function() {
				showArtwork($(this).parents('tr').attr('id'));
				if ($(this).parents('tr').hasClass('row_selected')){
					$(this).parents('tr').removeClass('row_selected');
				} else {
					$('.row_selected').removeClass('row_selected');
					$(this).parents('tr').addClass('row_selected');
				}
			});
*/
			$('#liblist').dataTable({
				"sScrollY": "100%",
				"bPaginate" : false,
				"bInfo"	: false,
				"bFilter" : false
			});
			jQuery.tableNavigation({
			table_selector: 'table#liblist',
			row_selector: 'table#liblist tbody tr',
			selected_class: 'row_selected',
			activation_selector: 'td',
			bind_key_events_to_links: false,
			focus_links_on_select: true,
			select_event: 'click',
			activate_event: 'dblclick',
			activation_element_activate_event: 'none',
			scroll_overlap: 20,
			cookie_name: 'last_selected_row_index',
			focus_tables: true,
			focused_table_class: 'focused',
			jump_between_tables: true,
			disabled: false,
			on_activate: function(row){
					return true;
					},
			on_select: function(row){
					showArtwork($(row).attr('id'));
					return true;

					}
});
	},"json");

setTimeout("$('#spinner').hide();",2000);
}
$(document).ready(function(){
//$('tr.LibRow > td').live('click',function(){
//	$(this).parents('tr').css('background-color','blue');
//});
$("#actionSearch").click(function(){
	if ($('#table').css('top') == "120px"){
		$('#table').animate({'top':'+=25px'},"slow");
		$('#searchString').focus();
	} else {
		setTimeout(function(){LoadLibrary();},500);
		$('#table').animate({'top':'-=25px'},"slow");
	}
	$('#artwork-bar').html('');
	setTimeout("$('img.artwork').attr('src','imgs/artwork_default.png');",500);
});

$('#searchForm').submit(function(){

$('#spinner').show();
		searchString = $("#searchString").val();
		paramsJ = {'searchQuery': searchString};
		params = $.toJSON(paramsJ);
		$.post('rpc/',
		{ method: 'test',
		  params: params
		},function(data){
			table = "<table cellspacing=\"0\" id=\"liblist\"><thead><tr><th>Title</th><th>Author</th><th>Summary</th><th>Pages</th><th>Published</th></tr></thead><tbody>";
			library = data;
			$.each(library,function(id,val){
				table += "<tr class=\"LibRow\" href=\"book.php?id=" + val.Code + "\" id=\"" + id + "\"><td class=\"tdT\">" + val.Title + "</td><td class=\"tdA\">" + val.author + "</td><td class=\"tdS\">" + val.SmallSummary + "</td><td class=\"tdPa\">" + val.Length + "</td><td class=\"tdPu\">" + val.PublishDate + "</td></tr>";
			});
			table += "</tbody></table>";
			$('#table').html(table);
/*			$('tr.libRow > td').click(function() {
				showArtwork($(this).parents('tr').attr('id'));
				if ($(this).parents('tr').hasClass('row_selected')){
					$(this).parents('tr').removeClass('row_selected');
				} else {
					$('.row_selected').removeClass('row_selected');
					$(this).parents('tr').addClass('row_selected');
				}
			});*/
			$('#liblist').dataTable({
				"sScrollY": "100%",
				"bPaginate" : false,
				"bInfo"	: false,
				"bFilter" : false
			});
			jQuery.tableNavigation({
			table_selector: 'table#liblist',
			row_selector: 'table#liblist tbody tr',
			selected_class: 'row_selected',
			activation_selector: 'td',
			bind_key_events_to_links: false,
			focus_links_on_select: true,
			select_event: 'click',
			activate_event: 'dblclick',
			activation_element_activate_event: 'click',
			scroll_overlap: 20,
			cookie_name: 'last_selected_row_index',
			focus_tables: true,
			focused_table_class: 'focused',
			jump_between_tables: true,
			disabled: false,
			on_activate: function(row){
					id = $(row).attr('id');
					showArtwork(id);
					return true;
					},
			on_select: function(row){
					id = $(row).attr('id');
					showArtwork(id);
					return true;
					}
			});
		},"json");

setTimeout("$('#spinner').hide();",500);
		return false;
});
$('.pop').popupWindow({
	centerBrowser:1,
	width: 400,
	height: 300,
});
$('.pop2').popupWindow({
	centerBrowser:1,
	width: 600,
	height: 400,
});
$('.fancyBox').fancybox({
	'transitionIn': 'elastic',
	'transitionOut': 'elastic'
	});
$('#spinner').hide();
$('.reload').click(function(){
	LoadLibrary();
});
$('#filter').selectbox();
$('#actionInfo').popupWindow({
				centerBrowser:1,
				width: 700,
				height: 748,
				This: '.row_selected',
				Bookpop: true,
	});
$('#leftMenu li a').click(function(){
	var link = $(this).attr('href').replace('#','');
});

$('#leftMenu').menuTree({
animation: true,
handler: 'toggle',
anchor: 'a[class="mI"]',
speed: 'slow',
trace: false
});
});
