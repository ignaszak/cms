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

function jstree_ajax(data, action)
{
    $.post(
        admin_adress + "/post/c/form",
        {
            action: action,
            id: data.node.id,
            parentId: data.node.parent,
            title: data.text
        },
        function(data, status) {}
    );
}

$(function () {
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
                "url" : admin_adress + "/post/c/ajax/category-list.json"
            }
        },
        "plugins" : [ "dnd", "state", "wholerow" ]
    })
    .on('rename_node.jstree', function (e, data) {
        jstree_ajax(data, 'edit');
    })
    .on('delete_node.jstree', function (e, data) {
        jstree_ajax(data, 'delete');
    });
    $(document).on('dnd_stop.vakata', function (e, data) {
        parentId = data.event.target.id.split('_');
        var stub = {
            node : {
                id : data.data.nodes[0],
                parent : parentId[0]
            },
            text : data.element.innerText
        }
        jstree_ajax(stub, 'edit');
    });
});