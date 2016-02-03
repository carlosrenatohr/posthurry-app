/**
 * Created by carlosrenato on 02-01-16.
 */
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('select.select2').select2();

    $('[name=typeToPost]').on('change', function(e) {
        var selected = this.value;
        if (selected == '0') {
            $('#post1-container .pages-list-container').removeClass('hide').children('.select-pages').attr('disabled', false);
            $('#post1-container .groups-list-container').addClass('hide').children('.select-groups').attr('disabled', true);
            $('#post2-container .pages-list-container').addClass('hide').children('.select-pages').attr('disabled', true);
            $('#post2-container .groups-list-container').removeClass('hide').children('.select-groups').attr('disabled', false);
        }
        /**
         * If 2 pages selected
         */
        else if (selected == '1') {
            $('.groups-list-container').addClass('hide').children('.select-groups').attr('disabled', true);
            $('.pages-list-container').removeClass('hide').children('.select-pages').attr('disabled', false);
        }
        /**
         * If 2 groups selected
         */
        else if (selected == '2') {
            $('.pages-list-container').addClass('hide').children('.select-pages').attr('disabled', true);
            $('.groups-list-container').removeClass('hide').children('.select-groups').attr('disabled', false);
        } else {

        }


    });

});