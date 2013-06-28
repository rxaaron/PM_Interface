function addnotification(event){
        $('#notification-area').append('<div class="alert alert-' + event.data.type + '"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>' + event.data.title + '</strong> ' + event.data.text + '</div>');
        };

