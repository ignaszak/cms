function isUrl(s) {
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return regexp.test(s);
}

$(function () {

	$('button#page, button#post').click(function () {
		load_elements(this);
	});
	
	$('input[name="search"]').bind('input', function () {
		load_elements(this);
	}).change();

	$('#jstree-category').on('click.jstree', function (e, data) {
		var catId = $('input[name="categoryId"]').val();
		$('input[name="dataAlias"]').val('category');
		$('input[name="dataNumber"]').val(catId);
		$.post(
			admin_adress + '/menu/ajax/category/' + catId + '/load.json',
			function( data ) {
				data[0].number = catId;
				$('div.add-elemnt-buttons button#add').click(function(){
					data[0].id = '';
					add_element(data[0]);
				});
			}
		);
	});
	
	$('button.add-link').click(function () {
		var data = {
			title : $('input[name="linkTitle"]').val(),
			link : $('input[name="linkAdress"]').val(),
			alias : 'link',
			number : 1,
		}
		$('input[name="dataAlias"]').val(data.alias);
		$('input[name="dataNumber"]').val(1);
		if (data.title == '' || !isUrl(data.link)) {
			alert('Invalid title or/and link');
		} else {
			data.id = ''
			add_element(data);
		}
		order();
	});
	
	if (edit_adress != '') {
		$.post(
			edit_adress,
			function( data ) {
				for (i = 0; i < data.length; ++i) {
					element_schema(data[i]);
				}
				
			}
		);
	}

});

function load_elements(obj) {
	var alias = $(obj).attr('id');
	var data = null;
	var page = 1;

	$.post(
		admin_adress + '/menu/ajax/' + alias + '/' + page + '/load.json',
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

				$('div.add-elemnt-buttons button#add').click(function(){
					data[id].id = '';
					add_element(data[id]);
				});
			});
		}
	);
}

function add_element(data) {
	
		var alias = $('input[name="dataAlias"]').val();
		var number = $('input[name="dataNumber"]').val();

		if (alias == data.alias && data.number == number) {
			
			var title = $('input[name="' + alias + 'Title"]').val();
			
			if (title == '') {
				alert('Please insert item title.');
			} else {
				data.itemTitle = title;
				data.sequence = $('div#menu a').length + 1;
				element_schema(data);
			}
		}
	
}

function element_schema_title(obj) {
	if (obj.value == '') {
		$(obj).val('Item title');
		alert('Please insert item title.');
	}
}

function element_schema_delete(obj){
	var parentObj = $(obj).parent();
	var objId = parentObj.find('input[name="menuId[]"]').val();
	parentObj.remove();
	$('div#menu').append(
		'<input type="hidden" name="menuRemove[]" value="' + objId + '">'
	);
}

function element_schema(data) {
	$('input[name="' + data.alias + 'Title"]').val('');
	$('input[name="' + data.alias + 'Adress"]').val('');
	$('div#menu').append(
		'<a href="javascript:void(0);" class="list-group-item">' +
		'<span id="icon">' + get_icon(data.alias) + '</span>' +
		'<button onclick="javascript:move_up(this);" type="button" class="btn btn-default btn-xs up"><i class="fa fa-arrow-up"></i></button>' +
		'<button onclick="javascript:move_down(this);" type="button" class="btn btn-default btn-xs down"><i class="fa fa-arrow-down"></i></button>' +
		(data.id != '' ? '<input type="hidden" name="menuId[]" value="' + data.id + '">' : '') +
		'<input type="hidden" name="menuAdress[]" value="' + data.link + '">' +
		'<input type="hidden" name="menuSequence[]" value="' + data.sequence + '">' +
		'<button type="button" class="btn btn-default btn-xs" onclick="element_schema_delete(this)"><i class="fa fa-times"></i></button>' +
		'<input type="text" class="edit-item" onchange="element_schema_title(this)" name="menuTitle[]" value="' + data.itemTitle + '">' +
		'<p class="list-group-item-text">' +
		get_category(data.category) + (data.alias == 'link' ? data.link : data.title) +
		'</p></a>'
	);
}

function move_up(obj) {
	var thisParent = $(obj).parent();
	var prevParent = thisParent.prev();
	var thisInputId = thisParent.find('input[name="menuSequence[]"]');
	var prevInputId = prevParent.find('input[name="menuSequence[]"]');
	var thisId = thisInputId.val();
	var prevId = prevInputId.val();
	thisInputId.val(prevId);
	prevInputId.val(thisId);
	thisParent.insertBefore(prevParent);
}

function move_down(obj) {
	var thisParent = $(obj).parent();
	var nextParent = thisParent.next();
	var thisInputId = thisParent.find('input[name="menuSequence[]"]');
	var nextInputId = nextParent.find('input[name="menuSequence[]"]');
	var thisId = thisInputId.val();
	var nextId = nextInputId.val();
	thisInputId.val(nextId);
	nextInputId.val(thisId);
	thisParent.insertAfter(nextParent);
}

function get_icon(alias) {
	if (alias == 'page') {
		return  '<i class="fa fa fa-book"></i>';
	} else if (alias == 'category') {
		return  '<i class="fa fa-folder-o"></i>';
	} else if (alias == 'post') {
		return  '<i class="fa fa-thumb-tack"></i>';
	} else if (alias == 'link') {
		return  '<i class="fa fa-link"></i>';
	}
}

function get_category(cat) {
	return (cat !== undefined ?
		'<span><i class="fa fa-folder-o"></i> ' +
		cat + ' <i class="fa fa-angle-double-right"></i></span> ' : "");
}