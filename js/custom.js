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
    $('#listprogress').show();
    var changejax = $.ajax({
        type:"POST",
        url:"scripts/pt_pack_change.php",
        dataType:"html",
        data: { pname: pname, status: status }
    });
    changejax.done(function(){
        refreshlist();
        $('#notification-area').append('<div id="chg" class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Patient Status</strong> ' + pname + ' was marked as Pack=' + status + '</div>');
        $('#chg').alert();
        setTimeout(function(){$('#chg').fadeOut(500,function(){$('#chg').alert('close');});},3000);
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
        $('#listprogress').hide();
    }); 
};

function drugadmin(drugid){
    $.ajax({
        type: "POST",
        url: "scripts/dnp_verify.php",
        dataType: "html",
        data: { drugid: drugid }
    }).done(function(html){
        $('#drugoptions').html(html);
    });
};

function markdrug(drugid,drugname){
    var drugjax = $.ajax({
        type: "POST",
        url: "scripts/dnp_commit.php",
        dataType: "html",
        data: { drugid: drugid }
    })
    drugjax.done(function(){
        $('#listprogress').show();
        dohoawork();
        $('#notification-area').append('<div id="chgd" class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Drug Status</strong> ' + drugname + ' was marked as Never Pack</div>');
        $('#chgd').alert();
        setTimeout(function(){$('#chgd').fadeOut(500,function(){$('#chgd').alert('close');});},3000);        
    })
};

function dohoawork(){
    $.ajax({
        url: "scripts/rx_hoa_work.php",
        dataType: "html"
    }).done(function(){
       refreshlist(); 
    });
};

function refreshexport(){
    $.ajax({
        
    }).done(function(){
        $('#processprogress').hide();
    });
};

function processrx(){
    var proc = $('#processprogress').show();
    var strtDate = $('#StartDate').val();
    var stopDate = $('#StopDate').val();
    var CutOff = $('#CutOff').val();
    $.ajax({
        type: "POST",
        url: "scripts/processrx.php",
        dataType: "html",
        data: { start: strtDate, stop: stopDate, cutoff: CutOff }
    });
            
    proc.done(function(html){
        //refreshexport();
        alert('well f');
        $('#exportdata').html(html);
    });
    
    proc.fail(function(){
       alert('FAIL'); 
    });
};

function exportrx(){
    
};

function clearrx(){
    var go = confirm('you cleared me!');
    if(go===true){
        
    }
};

//var val = $('input:radio[name="cutofftype"]:checked').val();
//$('#fakefilefield').val($(this).val());