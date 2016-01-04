String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

$(function () {

	$('button#page, button#post').click(function () {
		load_elements(this);
	});
	
	$('input[name="search"]').bind('input', function () {
		load_elements(this);
	}).change();

});

function load_elements(obj) {
	var alias = $(obj).attr('id');
	var data = null;
	var page = 1;

	$.post(
		admin_adress + '/menu/ajax/' + alias + '/' + page +"/load.json",
		{search: $(obj).val()},
		function( data ) {

		dataObject = data;
		var element = $('ul#' + alias);
		element.html('');

		var count = data.length;
		for (var i = 0; i < count; ++ i) {

			data[i].number = i;

			element.append(
				'<li><a href="javascript:void(0)" id="' + i + '">' +
				get_category(data[i].category) + data[i].title + 
				'</a></li>'
			);
		}

		$('ul#' + alias + ' a').click(function() {
			$('.add-elemnt-buttons ul a').removeClass('active');
			$(this).addClass('active');
			id = $(this).attr('id');
			$('input[name="dataAlias"]').val(alias);
			$('input[name="dataNumber"]').val(id);
			add_element(data[id]);
		});
	});
}

function add_element(data) {
	$('div.add-elemnt-buttons button#add').click(function(){
		var alias = $('input[name="dataAlias"]').val();
		var number = $('input[name="dataNumber"]').val();
		if (alias == data.route && data.number == number) {
			
			var title = $('input[name="' + alias + 'Title"]').val();
			
			if (title == '') {
				alert('Please insert item title.');
			} else {
				$('input[name="' + alias + 'Title"]').val('');
				$('div#menu').append(
					'<input type="hidden" name="menuElement[]" value="' + title + '|' + data.link + '">' +
					'<a href="javascript:void(0);" class="list-group-item">' +
					'<h4 class="list-group-item-heading">' + title + '</h4>' +
					'<p class="list-group-item-text">' +
					'<b>' + alias.capitalize() + ':</b> ' +
					get_category(data.category) + data.title +
					'</p></a>'
				);
			}
		}
	});
}

function get_category(cat) {
	return (cat !== undefined ?
		'<span><i class="fa fa-folder-o"></i> ' +
		cat + ' <i class="fa fa-angle-double-right"></i></span> ' : "");
}