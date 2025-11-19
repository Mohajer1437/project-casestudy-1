jQuery(function($){
    var frame;

    $('#ib_catalog_select').on('click', function(e){
        e.preventDefault();
        // یکبار فقط مدیافریم را بساز
        if ( frame ) {
            frame.open();
            return;
        }
        frame = wp.media({
            title: 'انتخاب یا آپلود PDF کاتالوگ',
            library: { type: 'application/pdf' },
            button: { text: 'انتخاب' },
            multiple: false
        });

        frame.on('select', function(){
            var attachment = frame.state().get('selection').first().toJSON();
            $('#catalog_media_id').val( attachment.id );
            $('#ib_catalog_preview').html(
                '<p><a href="' + attachment.url + '" target="_blank">' +
                attachment.filename +
                '</a></p>' +
                '<p><button class="button" id="ib_catalog_remove">حذف فایل</button></p>'
            );
        });

        frame.open();
    });

    // دکمه حذف فایل
    $('#ib_catalog_preview').on('click', '#ib_catalog_remove', function(e){
        e.preventDefault();
        $('#catalog_media_id').val('');
        $('#ib_catalog_preview').html('');
    });
});
