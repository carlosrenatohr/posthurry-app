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
                        text: 'Comparison between posts'
                    },
                    xAxis: {
                        categories: ['Likes', 'Shared', 'Comments']
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