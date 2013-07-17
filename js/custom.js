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
        url: "scripts/fill_export.php",
        dataType: "html"
    }).done(function(html){
        $('#processprogress').hide();
        $('#exportdata').html(html);
    });
};

function processrx(){
    var CutType = $('input:radio[name="cutofftype"]:checked').val();
    var strtDate = $('#StartDate').val();
    var stopDate = $('#StopDate').val();
    var CutOff = $('#CutOff').val();
    if(strtDate!==""&&stopDate!==""&&CutOff!==""){
        $('#processprogress').show();
        var proc = $.ajax({
            type: "POST",
            url: "scripts/processrx.php",
            dataType: "html",
            data: { start: strtDate, stop: stopDate, cutoff: CutOff, cuttype: CutType }
        });
    }else{
        alert('Please verify that Start Date, Stop Date, and CutOff Time all have valid entries.');
    };        
    proc.done(function(html){
        if($('#rmvadmin').is(":checked")){
            rmvAdminWindow();
        }
        if(html==='1'){
            rxhoa();
        }
        refreshexport();
    });
    
    proc.fail(function(){
       alert('FAIL'); 
    });
};

function exportrx(){
    
};

function clearrx(){
    var go = confirm('Are you sure you want to clear the Export List?');
    if(go===true){
       $('#processprogress').show();
       $.ajax({
           url: "scripts/clear_export.php",
           dataType: "html"
       }).done(function(){
           refreshexport();
       });
    }
};

function removeexport(rxnumber,admintime,patient,drug){
    var go = confirm("Are you sure you want to remove " + patient + "'s " + drug + " @ " + admintime + "?");
    if(go===true){
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "scripts/delete_export.php",
            data: { rxnumber: rxnumber, admintime: admintime }
        }) .done(function(){
            $('#processprogress').show();
            refreshexport();
        });
    };
};

function rxhoa(){
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "scripts/rx_hoa.php"
    }).done(function(html){
        $('#hoarxtable').html(html);
        inputHelpers();
        if($('#admintimes').data('modal').isShown===false){
            $('#hoamodal').modal('show');   
        }else{
            alert('shown');
            $('#admintimes').on('hidden',function(){
                $('#hoamodal').modal('show');
                $('#admintimes').off('hidden');
            });
        }
        
    });
};

function newRow(table){
    var rowhtml = '<tr><td><div class="input-append date datepicker" data-date-format="mm/dd/yyyy"><input class="input-small" type="text" id="admindate" autocomplete="off" name="admindate[]"><span class="add-on"><i class="icon-calendar"></i></span></div></td><td><div class="input-append pad4"><input id="admintime" class="input-small tmask" type="text" autocomplete="off" name="admintime[]"><span class="add-on"><i class="icon-time"></i></span></div></td><td><div class="input-append pad4"><input type="text" class="input-small" name="quantity[]"><span class="add-on"><strong>#</strong></span></div></td><td><div class="pad4"><button class="btn btn-primary btn-mini" type="button" onClick="newRow(\'' + table + '\');"><i class="icon-plus"></i></button></div></td></tr>';
    $('#' + table).append(rowhtml);
    inputHelpers();
};

function saveRx(patID,drugCode,doctor,RxNumber,Instructions,RPh){
    var datastring = $('#f'+RxNumber).serialize();
    $.ajax({
        type: "POST",
        url: "scripts/insert_RX_HOA.php",
        dataType: "html",
        data: { datastring: datastring, patientid: patID, drugcode: drugCode, doctor: doctor, rxnumber: RxNumber, rph: RPh, instructions: Instructions }
    }).done(function(html){
        $('#div'+RxNumber).remove();
        if(html==='0'){
            $('#hoamodal').modal('hide');
        }
        refreshexport();
    });
};

function inputHelpers(){
        $('.datepicker').datepicker({
                autoclose: true
        });
        $('.tpick').timepicker({
            minuteStep: 30,
            showMeridian: false
        });
        
        $('.tmask').mask("19:59");
};

function rmvAdminWindow(){
    $.ajax({
        type: "POST",
        url: "scripts/list_admin_times.php",
        dataType: "html"
    }).done(function(html){
        $('#admintable').html(html);
        $('#admintimes').modal('show');   
    });
};

function rmvtime(time,tracker){
    $.ajax({
        type: "POST",
        url: "scripts/rmv_admin_times.php",
        dataType: "html",
        data: { time: time, tracker: tracker }
    }).done(function(){
        $('#'+time).remove();
        refreshexport();
    });
};