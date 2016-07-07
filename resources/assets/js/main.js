/**
 * Created by carlosrenato on 02-01-16.
 */
$(function() {

    /**
     * Script to always send csrf-token from laravel to ajax requests
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('select.select2').select2();

    $('select[name=post1_page_id]').on('change', function() {
        if (!$(this).parents('.hide').length) {
            $('#post1_page_name').val($(this).find("option:selected").text());
            //console.log('page 1 = ' + $(this).find("option:selected").text());
        }
    });

    $('select[name=post2_page_id]').on('change', function() {
        if (!$(this).parents('.hide').length) {
            $('#post2_page_name').val($(this).find("option:selected").text());
            //console.log('page 2 = ' + $(this).find("option:selected").text());
        }
    });
    /**
     * Post to Mass groups/pages after comparison
     */
    $('#blastMassChkbox').on('change', function(e) {
        if (this.checked) {
            $('.massCheckbox').prop('disabled', false);
            $('.below-container .col-md-6 .panel').removeClass('panel-default').addClass('panel-info');
            $('.below-container .col-md-6 .panel-body').removeClass('disabled-on');
            //$('#blastDate').prop('disabled', false);
            //$('#blastTime').prop('disabled', false);
            $('#blastDateTime').prop('disabled', false);
        } else {
            $('.massCheckbox').prop('disabled', true);
            $('.below-container .col-md-6 .panel').removeClass('panel-info').addClass('panel-default');
            $('.below-container .col-md-6 .panel-body').addClass('disabled-on');
            //$('.massCheckbox').prop('checked', false);
            //$('#blastDate').prop('disabled', true);
            //$('#blastTime').prop('disabled', true);
            $('#blastDateTime').prop('disabled', true);
        }
    });

    $("#blastDateTimePlugin").DateTimePicker({
        defaultDate: new Date(),
        //maxDate: new Date(2016, 7 - 1, 8),
        titleContentDateTime: 'Set blasting out datetime',
        dateTimeFormat: "MM-dd-yyyy hh:mm AA",
        buttonsToDisplay: ["HeaderCloseButton", "SetButton"], //, "ClearButton"
    });
    $("#blastDateTime").on('change', function(e){
        console.log($(this).val());
    });

    $('#createContestSubmitBtn').on('click', function(e) {
        var needvalidation = false;
        $('.cd-form .post-textarea').each(function(i, el){
             if (el.value == '') {
                 needvalidation = true;
                 $(el).css({'border-color': '#F00'});
                 // alertify.notify( message, 'error', [wait, callback]);
                 alertify.notify($(el).data('control') + " can't be blank!", 'error', [2000, function(){}]);
             } else {
                 $(el).css({'border-color': '#CCC'});
             }
        });
        $('.cd-form .select-groups:not(:disabled), .cd-form .select-pages:not(:disabled)').each(function(i, el){
             if (el.value == '') {
                 needvalidation = true;
                 $(el).css({'border-color': '#F00'});
                 alertify.notify("Please select an item on " + $(el).data('control'), 'error', [2000, function(){}]);
             } else {
                 $(el).css({'border-color': '#CCC'});
             }
        });
        if (needvalidation) {
            e.preventDefault();
        }
    });


    //$('#blastDate, #blastTime').on('change', function(){
    //    var blastDate = $('#blastDate').val();
    //    var blastTime = $('#blastTime').val();
    //    var datetimeValue = (blastDate != '' && blastTime != '')
    //                        ? blastDate + ' ' + blastTime + ':00'
    //                        : null;
    //    $('#blastTimeInput').val(datetimeValue);
    //});

    var pagesNamesSelected = [], groupsNamesSelected = [];
    $('body').on('change', '.massCheckbox', function(e) {
        var len = $('body .massCheckbox:checked').length;
        if (this.checked) {
            if ($(this).hasClass('massPagesCheckbox')) {
                pagesNamesSelected.push($(this).data('name'));
            } else if ($(this).hasClass('massGroupsCheckbox')) {
                groupsNamesSelected.push($(this).data('name'));
            }
        }
        else {
            var ind;
            if ($(this).hasClass('massPagesCheckbox')) {
                ind = pagesNamesSelected.indexOf($(this).data('name'));
                pagesNamesSelected.splice(ind, 1);
            } else if ($(this).hasClass('massGroupsCheckbox')) {
                ind = groupsNamesSelected.indexOf($(this).data('name'));
                groupsNamesSelected.splice(ind, 1);
            }
        }

        $('#pagesNamesSelected').val(pagesNamesSelected);
        $('#groupsNamesSelected').val(groupsNamesSelected);

        $('.below-container .panel .groups .alert-warning p').html(groupsNamesSelected.join(',  '));
        $('.below-container .panel .pages .alert-warning p').html(pagesNamesSelected.join(',  '));

        if (len >= 25) {
            if (this.checked) {
                this.checked = false;
            }
            alert('You are able to add up to 25 groups to post the winner ad');
            //e.preventDefault();
        }
    });

    /**
     * Dynamic radio control selection
     */
    $('[name=typeToPost]').on('change', function(e) {
        var selected = this.value;
        if (selected == '0') {
            $('#post1-container .pages-list-container').removeClass('hide').find('.select-pages').attr('disabled', false);
            $('#post1-container .pages-list-container').find('input.page_sort').attr('disabled', false);
            //
            $('#post1-container .groups-list-container').addClass('hide').find('.select-groups').attr('disabled', true);
            $('#post1-container .groups-list-container').find('input.group_sort').attr('disabled', true);
            //
            $('#post2-container .pages-list-container').addClass('hide').find('.select-pages').attr('disabled', true);
            $('#post2-container .pages-list-container').find('input.page_sort').attr('disabled', true);
            //
            $('#post2-container .groups-list-container').removeClass('hide').find('.select-groups').attr('disabled', false);
            $('#post2-container .groups-list-container').find('input.group_sort').attr('disabled', false);
        }
        /**
         * If 2 pages selected
         */
        else if (selected == '1') {
            $('.groups-list-container').addClass('hide').find('.select-groups').attr('disabled', true);
            $('.groups-list-container').find('input.group_sort').attr('disabled', true);
            //
            $('.pages-list-container').removeClass('hide').find('.select-pages').attr('disabled', false);
            $('.pages-list-container').find('input.page_sort').attr('disabled', false);
        }
        /**
         * If 2 groups selected
         */
        else if (selected == '2') {
            $('.pages-list-container').addClass('hide').find('.select-pages').attr('disabled', true);
            $('.pages-list-container').find('input.page_sort').attr('disabled', true);
            //
            $('.groups-list-container').removeClass('hide').find('.select-groups').attr('disabled', false);
            $('.groups-list-container').find('input.group_sort').attr('disabled', false);
        } else {
            console.log('error, no checkbox selected');
        }
    });

    /**
     * Graph
     */
    if ($('#comparison-chart-container').length) {
        var chart;
        var id = $('#comparison_id').val();
        $('.img-loading').removeClass('hide');
        $.ajax({
            url: '/comparison/stats/' + id,
            method: 'post',
            data: {},
            dataType: 'json',
            success: function(data) {
                $('#comparison-chart-container').highcharts({
                    chart: {
                        type: 'column',
                    },
                    title: {
                        text: 'Contest between posts'
                    },
                    xAxis: {
                        categories: ['Likes', 'Shared', 'Comments'],
                    },
                    yAxis: {

                    },
                    credits: {
                        enabled: false
                    },
                    series: [
                        {
                            name: data.post1.name,
                            data: data.post1.data,
                            color: '#a1ffa1'
                        },
                        {
                            name: data.post2.name,
                            data: data.post2.data,
                            color: '#ffa1a1'
                        }]
                });
                $('.img-loading').addClass('hide');
            }
        });

    }



});