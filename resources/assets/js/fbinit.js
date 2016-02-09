/**
 * Created by carlosrenato on 01-31-16.
 */
window.fbAsyncInit = function() {
    FB.init({
        appId      : '353859614689535',
        xfbml      : true,
        version    : 'v2.0',
        cookie     : true,
        status     : true
    });

    // ADD ADDITIONAL FACEBOOK CODE HERE

    //function onLogin(response) {
    //    if (response.status == 'connected') {
    //        FB.api('/me?fields=first_name', function(data) {
    //            var welcomeBlock = document.getElementById('fb-welcome');
    //            welcomeBlock.innerHTML = 'Hello, ' + data.first_name + '!';
    //        });
    //    }
    //}

    FB.getLoginStatus(function(response) {
        // Check login status on load, and if the user is
        // already logged in, go directly to the welcome message.
        if (response.status == 'connected') {
            // init fb access
            $('.img-loading').removeClass('hide');
            $.ajax({
                url: '/data',
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $.each(data.pages.data, function(i, val) {
                        //$('select#select-pages').select2('val', val.id);
                        $('.select-pages').append($('<option/>').html(val.name).val(val.id)).data('pgName', val.name).select2();
                    });
                    $.each(data.groups.data, function(i, val) {
                        //$('select#select-groups').select2('data', {id: val.id, text: val.name});
                        $('.select-groups').append($('<option/>').html(val.name).val(val.id)).data('pgName', val.name).select2();
                    });
                    //
                    $('.img-loading').addClass('hide');
                }
            });
            var uid = response.authResponse.userID;
            var accessToken = response.authResponse.accessToken;
        } else {
            // Otherwise, show Login dialog first.
            FB.login(function(response) {
                //onLogin(response);
            }, {scope: $('#fb_scopes').val() });
        }
    });
    //
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));