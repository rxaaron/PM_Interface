function addnotification(event){
        $('#notification-area').append('<div id="' + event.data.id + '" class="alert alert-' + event.data.type + '"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>' + event.data.title + '</strong> ' + event.data.text + '</div>');
        $('#' + event.data.id).alert();
        setTimeout(function(){$('#' + event.data.id).fadeOut(500,function(){$('#' + event.data.id).alert('close');});},5000);
};
function checkchange(cid,cval){
    var checkstatus = $('#' + cid).prop("checked");
    var checkid = cid;
    var checkvalue = cval;
    var checkjax = $.ajax({
        type: "POST",
        url: "scripts/change_pack.php",
        dataType: "html",
        data: { status: checkstatus, rxid: checkid }
    });
            
    checkjax.done(function(){
        $('#notification-area').append('<div id="chg" class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Rx Status</strong> ' + checkvalue + ' was marked as Pack=' + checkstatus + '</div>');
        $('#chg').alert();
        setTimeout(function(){$('#chg').fadeOut(500,function(){$('#chg').alert('close');});},2000);
});
    checkjax.fail(function(){
        alert('I cannot explain what happened or why it happened.');
    });
};
function changeall(pname,status){
    var changejax = $.ajax({
        type:"POST",
        url:"scripts/pt_pack_change.php",
        dataType:"html",
        data: { pname: pname, status: status }
    });
    changejax.done(function(){
        refreshlist();
    });
    changejax.fail(function(){
        
    });
};

function refreshlist(){
           $.ajax({
              url: "scripts/fill_listed_orders.php",
              dataType: "html"
           }).done(function(html){
             $('#listdata2').html(html);
           }); 
};