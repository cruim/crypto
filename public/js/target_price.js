$(document).ready(function(){
    $(document).on('change','.main td [type=checkbox]',function (e)
    {
        e.preventDefault();
        var element = $(this);
        updateData(element);
    })

    $(document).on("click", "#modal-btn-si", function(e) {
        e.preventDefault();
        var element = $(this);
        deleteRecord(element);
    });

    $(document).on("click", ".upd", function(e) {
        e.preventDefault();
        var element = $(this);
        updateCurrentPrice(element);
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
        if(record_name == 'Bitcoin' && cross_currency == 'btc')
        {
            return;
        }
        window.location.replace("/add_target_price_record/" + record_name + "/" + cross_currency);

    });

    $(document).on('change','.main td input',function (e)
    {
        e.preventDefault();
        var element = $(this);
        updateTargetPrice(element);
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
        url: '/update_target_active',
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

function updateTargetPrice(element)
{
    var request =
    {
        'record_id':$(element).parent().parent().parent().data('active'),
        'value':$(element).val(),
        'column':$(element).attr('id')
    };

    $.ajax({
        url: '/update_target_price',
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

function updateCurrentPrice(element)
{
    var request =
    {
        'record_id':$(element).parent().parent().data('active')
    }

    $.ajax({
        url: '/update_current_price',
        type: "GET",
        dataType: "json",
        data:{
            request: request,
        },
        success: function (response) {
            $(element).parent().parent().find('.current_price').children().find('.currency-amount').val(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
        }
    });
}
function deleteRecord(element)
{
    window.location.replace("/delete_target_price_record/" + record_id);
}

function addRecord(record_name)
{

    window.location.replace("/add_target_price_record/" + record_name);
}


