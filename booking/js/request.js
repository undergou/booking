$(document).ready(function(){
$('#button-request').click(function(e){
    var necessary = $('.necessary');
    var empty = [];
    for(var i=0;i<necessary.length;i++){
        if(!necessary[i].value){
            empty.push(1);
        }
    }
    if(!empty.length){
            $('#result').html('');
            e.preventDefault();
            var form = document.querySelector('#formx');
            var dataS = $('#formx').serialize();
            // var dataPost = JSON.stringify(dataS);
            $.ajax({
                url: '/project3-1/booking/php/formdata.php',
                type: 'POST',
                // contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                data: dataS,
                success: function(response){
                    // var arr = JSON.parse(response);
                    // $('#result').html('<div id="'+response.id+'" class="alert '+response.classStyle+'">'+response.message+'</div>');
                    $(function() {
                        var dialog = document.createElement('div');
                        dialog.setAttribute('id', 'dialog');
                        dialog.setAttribute('title', 'Booking result:');
                        dialog.innerHTML = response.message;
                        $('#result').append(dialog);
                        $("#dialog").dialog();
                    });
                    if($('#dialog')){
                        form.reset();
                    }
                }
            });
    } else{
        $('#result').html('');
        e.preventDefault();
        $(function() {
            var dialog = document.createElement('div');
            dialog.setAttribute('id', 'dialog');
            dialog.setAttribute('title', 'Booking result:');
            dialog.innerHTML = 'There are empty fields that are necessary to fill';
            $('#result').append(dialog);
            $("#dialog").dialog();
        });
        // $('#result').append('<div class="alert alert-danger">There are empty fields that are necessary to fill</div>');
    }
});
});