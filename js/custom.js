function addnotification(event){
        $('#notification-area').append('<div id="' + event.data.id + '" class="alert alert-' + event.data.type + '"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>' + event.data.title + '</strong> ' + event.data.text + '</div>');
        $('#' + event.data.id).alert();
        setTimeout(function(){$('#' + event.data.id).fadeOut(500,function(){$('#' + event.data.id).alert('close')})},5000);
        };