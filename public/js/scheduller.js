$(document).ready(function(){
    $(document).on('change','.main td [type=checkbox]',function (e)
    {
        e.preventDefault();
        var element = $(this);
        updateData(element);
    })

    $(document).on('change','.main td input',function (e)
    {
        e.preventDefault();
        var element = $(this);
        updateInputScheduller(element);
    })

    $(document).on("click", "#modal-btn-si", function(e) {
        e.preventDefault();
        var element = $(this);
        deleteRecord(element);
        });

    $(document).on("click", "#add_record_btn", function(e) {
        e.preventDefault();
        var element = $(this);
        if(element.val() >= 5)
        {
            $('#myModal').modal("show");
            return;
        }
        var record_name = $('#add_record').val();
        var cross_currency = $('#add_currency').val();
        window.location.replace("/add_record/" + record_name + "/" + cross_currency);
    });
});
var record_id = {};
var record_name = {};
var modalConfirm = function(callback){

    $(".delete").on("click", function(e){
        e.preventDefault();
        var element = $(this);
        record_id = $(element).parent().parent().data('active')
        $("#mi-modal").modal('show');
    });

    $("#modal-btn-si").on("click", function(){
        callback(true);
        $("#mi-modal").modal('hide');
    });

    $("#modal-btn-no").on("click", function(){
        callback(false);
        $("#mi-modal").modal('hide');
    });
};

modalConfirm(function(confirm,element){
    if(confirm){
    }
});

function updateData(element){
    var request =
    {
        'record_id':$(element).parent().parent().parent().parent().data('active')
    };
    $.ajax({
        url: '/update_record_active',
        type: "GET",
        dataType: "json",
        data:{
            request: request
        },
        success: function (response) {
            console.log(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
        }
    });
}

function updateScheduller(element)
{
    var request =
    {
        'record_id':$(element).parent().parent().data('active'),
        'value':$(element).find('#sending_time').val()
    };
    $.ajax({
        url: '/update_record_time',
        type: "GET",
        dataType: "json",
        data:{
            request: request,
        },
        success: function (response) {
            console.log(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
        }
    });
}

function updateInputScheduller(element)
{
    var request =
    {
        'record_id':$(element).parent().parent().parent().data('active'),
        'value':$(element).val()
    };
    $.ajax({
        url: '/update_record_time',
        type: "GET",
        dataType: "json",
        data:{
            request: request,
        },
        success: function (response) {
            console.log(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
        }
    });
}

function deleteRecord(element)
{
    window.location.replace("/delete_record/" + record_id);
}


$('.sending_time').clockpicker({
    donetext: 'click',
    autoclose: true,
    afterDone: function() {
        updateScheduller(snd_time);
    }
});
var snd_time = {};
$('.sending_time').click(function(e){
    e.preventDefault();
    snd_time = $(this).children();
});


