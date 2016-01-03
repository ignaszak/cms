String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

function load_element(alias)
{
	var data = null;
	var page = 1;
	$.post(admin_adress + '/menu/ajax/' + alias + '/' + page +"/load.json", function( data ) {

		dataObject = data;
		var element = $('div#' + alias);
		element.html('');
		
		

		var count = data.length;
		for (var i = 0; i < count; ++ i) {
			
			data[i].number = i;

			var categoryString = (data[i].category !== undefined ?
					'&nbsp;&nbsp;<i class="fa fa-folder-o"></i> ' + data[i].category : "");

			element.append(
				'<a href="javascript:void(0)"' +
				'id="' + i + '" class="list-group-item">' +
				'<h4 class="list-group-item-heading">' + data[i].title + '</h4>' +
				'<p class="list-group-item-text">' +
				'<i class="fa fa-calendar"></i> ' + data[i].date +
				'&nbsp;&nbsp;<i class="fa fa-user"></i> ' + data[i].author +
				categoryString +
				'<br>' + data[i].text +
				'</p></a>'
			);
		}

		$('div.choose-element a').click(function(){
			id = $(this).attr('id');
			$('input[name="dataAlias"]').val(alias);
			$('input[name="dataNumber"]').val(id);
			add_element(data[id]);
		});
	});
}

function add_element(data)
{
	$('div.add-elemnt-buttons button#add').click(function(){
		var alias = $('input[name="dataAlias"]').val();
		var number = $('input[name="dataNumber"]').val();
		if (alias == data.route && data.number == number) {
			
			var title = $('input[name="' + alias + 'Title"]').val();
			
			if (title == '') {
				alert('Please insert item title.');
			} else {
				$('div#menu').append(
					'<a href="javascript:void(0);" class="list-group-item">' +
					'<h4 class="list-group-item-heading">' + title + '</h4>' +
					'<p class="list-group-item-text">' +
					'<b>' + alias.capitalize() + ':</b> ' + data.title +
					'<br>Adress: ' + data.link +
					'</p></a>'
				);
			}
		}
	});
}