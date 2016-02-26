function jstree_category_create()
{
    var ref = $('#jstree-category').jstree(true),
        sel = ref.get_selected();

    if (!sel.length) { return false; }
    sel = sel[0];

    sel = ref.create_node(sel);
    if (sel) {
        ref.edit(sel);
    }
}

function jstree_category_rename()
{
    var ref = $('#jstree-category').jstree(true),
        sel = ref.get_selected();

    if (!sel.length) { return false; }
    sel = sel[0];
    if (sel != 1) {ref.edit(sel);}
}

function jstree_category_delete()
{
    var ref = $('#jstree-category').jstree(true),
        sel = ref.get_selected();

    if (!sel.length) { return false; }
    if (sel != 1) {ref.delete_node(sel);}
}

function jstree_ajax(obj, action)
{
    $.post(
        admin_adress + "/post/c/form",
        {
            action: action,
            id: obj.node.id,
            parentId: obj.node.parent,
            title: obj.text
        },
        function(data, status) {
            if (data == 'refresh') {
                $('#jstree-category').jstree(true).refresh();
            }
        }
    );
}

$(function () {

	/**
	 * Sets default category id
	 */
    if (typeof category_id == 'undefined') category_id = 0;

    /**
     * 
     */
    $('input[name="categoryId"]').val(category_id);

    /**
     * Configure jsTree
     */
    $('#jstree-category').jstree({
        "core" : {
            "animation" : 0,
            "check_callback" : true,
            "force_text" : true,
            "themes" : {
                "variant" : "large",
                "icons" : false
            },
            "data" : {
                "url" : admin_adress + "/post/c/ajax/" + category_id + "/category-list.json"
            }
        },
        "plugins" : [ "dnd", "wholerow" ]
    })
    .on('rename_node.jstree', function (e, obj) {
        jstree_ajax(obj, 'edit');
    })
    .on('delete_node.jstree', function (e, obj) {
        jstree_ajax(obj, 'delete');
    })
    .on('loaded.jstree', function() {
    	$('#jstree-category').jstree('open_all');
    })
    .on('select_node.jstree', function() {
        var id = $('#jstree-category').jstree(true).get_selected();
        $('input[name="categoryId"]').val(id);
    });
    $(document).on('dnd_stop.vakata', function (e, obj) {
        parentId = obj.event.target.id.split('_');
        var stub = {
            node : {
                id : obj.data.nodes[0],
                parent : parentId[0]
            },
            text : obj.element.innerText
        }
        jstree_ajax(stub, 'edit');
    });

});