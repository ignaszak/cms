$(document).ready(function() {
    $('#summernote').summernote({
    	fontsize : 15,
        height : 300,
        focus : true,
        fontNames : [
            'Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 'Courier New',
            'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Sacramento'
        ],
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview']],
            ['help', ['help']]
        ],
        placeholder : 'write here...'
    });
});