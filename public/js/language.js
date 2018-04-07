$(document).ready(function() {
    $('.selectpicker1').on('change', function() {
        var language = $('.selectpicker1').val();
        addRecord(language);
    })
});

$(function(){
    $('.selectpicker1').selectpicker();
});

function addRecord(language) {
    var request =
    {
        'language': language
    };
    $.ajax({
        url: '/change_app_language',
        type: "GET",
        dataType: "json",
        data: {
            request: request

        },
        success: function (response) {
            console.log(response);
            location.reload();

        },
        error: function (jqXHR, textStatus, errorThrown) {
            document.location.replace("/setlocale/" + language);
        }
    });
}