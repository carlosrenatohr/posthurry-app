/**
 * Created by carlosrenato on 01-31-16.
 */

$('.img-loading').removeClass('hide');
$.ajax({
    url: '/data',
    method: 'post',
    dataType: 'json',
    success: function(data) {
        $.each(data.pages.data, function(i, val) {
            //$('.select-pages').append($('<option/>').html(val.name).val(val.id)).data('pgName', val.name).select2();
            $('.select-pages').append($('<option/>').html(val.name).val(val.id)).data('pgName', val.name);
            // groups to blast in mass
            var form = $('<div class="cd-form"/>');
            $('<input/>', {type: 'checkbox', value: val.id, id: val.id, 'data-name': val.name, class: 'massCheckbox massPagesCheckbox', name: 'massPosts[pages][]'})
                .appendTo(form);
            $('<label/>').html(val.name).attr('for', val.id).appendTo(form);
            form.appendTo('.below-container .pages');
        });
        $.each(data.groups.data, function(i, val) {
            //$('.select-groups').append($('<option/>').html(val.name).val(val.id)).data('pgName', val.name).select2();
            var isPublic = (val.privacy != 'OPEN');
            $('.select-groups').append($('<option/>').html(val.label).val(val.id).data('pgName', val.name)); //.prop('disabled', isPublic)
            // groups to blast in mass
            var form = $('<div class="cd-form"/>');
            $('<input/>', {type: 'checkbox', value: val.id, id: val.id, 'data-name': val.name, class: 'massCheckbox massGroupsCheckbox', name: 'massPosts[groups][]'})
                .appendTo(form);
            $('<label/>').html(val.label).attr('for', val.id).appendTo(form);
            form.appendTo('.below-container .groups');
        });
        //
        $('.below-container .col-md-6 .panel-body').addClass('disabled-on');
        $('.massCheckbox').prop('disabled', true);
        //
        $('.img-loading').addClass('hide');
    },
    error: function(xhr, text, errorThrown) {
        console.log(xhr, text, errorThrown);
    }
});