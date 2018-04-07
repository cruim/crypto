$(document).on("click", "#save_profile", function(e) {
    e.preventDefault();
    var user_id = $(this).val();

    var email = $(this).parent().parent().parent().children('div.panel-body').children().children().children()
        .children().children().children().children('#user_email').val();

    var telegram_id = $(this).parent().parent().parent().children('div.panel-body').children().children().children()
        .children().children().children().children('#telegram_id').val();

    window.location.replace("/update_user_info/" + user_id + "/" + email + "/" + telegram_id);
});

$(document).on("click", "#back_to_previous", function(e) {
    window.location.replace("/");
});