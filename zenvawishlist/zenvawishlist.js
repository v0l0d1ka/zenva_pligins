jQuery(document).ready(function($) {
    $('#zvawp_add_wishlist').click(function(e) {
        $.post(document.location.protocol+'//'+document.location.host+'/wp-admin/admin-ajax.php', MyAjax, function(response) {
            $('#zvawp_add_wishlist_div').html('You want this');
        })
    });
});