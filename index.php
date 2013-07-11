<?php 

    include('scripts/init.php');
    include('scripts/file_import.php');
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/datepicker.css" rel="stylesheet">
        <link href="css/timepicker.css" rel="stylesheet">
        <title>PacMed Interface</title>

    </head>
    <body>
        <div class="container-fluid">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><i class="icon-list"></i></a>
                        <a class="brand" href="#">PacMed Interface</a>
                        <div class="nav-collapse collapse">
                            <ul class="nav">
                                <li class><a href="#import" data-toggle="modal"><i class="icon-folder-open"></i> Import Files</a></li>
                                <li class="active"><a href="#create" data-toggle="pill"><i class="icon-upload"></i> Create Batch</a></li>
                                <li class="divider-vertical"></li>
                                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-book"></i> Reports<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li class><a href="#manifests" data-toggle="pill"><i class="icon-list-alt"></i><i class="divider-vertical"></i>Manifests</a></li>
                                        <li class><a href="#usage" data-toggle="pill"><i class="icon-align-left"></i><i class="divider-vertical"></i>PacMed Usage</a></li>
                                    </ul>
                                </li>
                                <li class="divider-vertical"></li>
                                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i> Administration<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li class><a href="#options" data-toggle="pill"><i class="icon-wrench"></i><i class="divider-vertical"></i>Options</a></li>
                                        <li class><a href="#settings" data-toggle="pill"><i class="icon-warning-sign"></i><i class="divider-vertical"></i>Advanced Settings</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
            <div class="tab-pane active" id="create">
            <div class="row-fluid">
                <div class="span3">
                    <form autocomplete="off" method="POST" action="">
                        <label>Start Date</label>
                        <div class="input-append date datepicker" data-date-format="mm/dd/yyyy"><input type="text" id="StartDate" autocomplete="off" value="<?php echo date("m/d/Y"); ?>" name="startdate"><span class="add-on"><i class="icon-calendar"></i></span></div>
                        <label>Stop Date</label>
                        <div class="input-append date datepicker" data-date-format="mm/dd/yyyy"><input type="text" id="StopDate" autocomplete="off" name="stopdate"><span class="add-on"><i class="icon-calendar"></i></span></div>
                        <label>Cut Off Time</label>
                        <div class="input-append pad4 bootstrap-timepicker"><input id="CutOff" type="text" autocomplete="off" value="01:00" name="cutoff"><span class="add-on"><i class="icon-time"></i></span></div>
                        <div class="pad4">
                        <label class="radio inline"><input type="radio" id="cycle" name="cutofftype" value="cycle" checked="checked"><a href="#" id="cyclepop" data-toggle="popover" data-title="Cycle Fill" data-content="This is used for cycle fill.  The packages go from 1 AM on the start date up to 1 AM on the stop date." data-trigger="hover" data-delay="500">Cycle</a></label><label class="radio inline"><input type="radio" id="daily" name="cutofftype" value="daily"><a href="#" id="dailypop" data-toggle="popover" data-title="Daily Batches" data-content="This is used for daily batches.  The packages start at the cutoff time of the start date, then go all the way through to the end of the stop date." data-trigger="hover" data-delay="500">Daily</a></label><label class="radio inline"><input type="radio" id="abx" name="cutofftype" value="abx"><a href="#" id="abxpop" data-toggle="popover" data-title="Antibiotics (and others)" data-content="This is used for batches that are written for a certain number of doses, usually antibiotics.  Packages start at cutoff time on the start date (usually 6 pm closing time) and go through to the cutoff time on the stop date." data-trigger="hover" data-delay="500">Antibiotic</a></label>
                        </div>
                        <div class="pad4" style="margin-bottom:10px;">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#admintimes">Remove Administration Times</button>
                        </div>
                        <label>File Name</label>
                        <div class="input-append pad4"><input type="text" id="FileName" placeholder="File Name" autcomplete="off" name="filename"><span class="add-on"><i class="icon-file"></i></span></div>
                        <br>
                        <div class="pad4 btn-group"><button type="button" class="btn btn-primary wide85" name="action" value="process" onClick="processrx();" >Process</button><button type="button" class="btn btn-success wide85" name="action" value="export" onClick="exportrx();" >Export</button><button type="button" class="btn btn-danger wide85" name="action" value="clear" onClick="clearrx();">Clear</button></div>
                    </form>
                    <div id="processprogress" style="display:none;">
                        <div class="progress progress-striped active">
                            <div class="bar" id="processbar" style="width: 100%;">Processing...</div>
                        </div>
                    </div>
                </div>
                <div class="span8">
                    <div class="tab-content">
                        <div class="tab-pane active" id="export">
                            <div class="row-fluid">
                                <div class="span12" id="exportdata">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="list">
                             <div class="row-fluid">
                                <div class="span12" id="listdata">
                                    <div id="listprogress">
                                        <div class="progress progress-striped active">
                                            <div class="bar" id="listbar" style="width: 100%;">Building List</div>
                                        </div>
                                    </div>
                                    <div id="listdata2" class="listdiv">
                                        
                                    </div>
                                </div>
                            </div>                           
                        </div>
                        <div class="tab-pane" id="startstop">
                            <div class="row-fluid">
                                <div class="span12" id="ssdata">
                                    
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="span1">
                    <div class="tabbable tabs-right">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#export" data-toggle="tab"><button class="btn">Orders Ready<br>For Export</button></a></li>
                            <li class><a href="#list" data-toggle="tab"><button class="btn">View Listed<br>Orders</button></a></li>
                            <li class><a href="#startstop" data-toggle="tab"><button class="btn">Start / Stop<br>Dates</button></a></li>
                        </ul>
                    </div>

                </div>
            </div>
            </div>
            <div class="modal hide fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 id="myModalLabel">Import Files</h3>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="file" id="file2import" name="file2import" style="display:none;">
                        <div class="input-append">
                            <input id="fakefilefield" name="fakefilefield" class="input-xlarge" autocomplete="off" placeholder="File Name" type="text"><span class="add-on"><i class="icon-search" id="browsefile" onclick="$('input[id=file2import]').click();"></i></span>
                        </div>
                        <div class="progress progress-striped active">
                            <div class="bar" id="imprtbar" style="width: 0%;"></div>
                        </div>
                        <?php include('scripts/imported_files.php'); ?>
                    </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" id="importfilebtn" value="Import File">
                    </form>
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" id="closeimportbtn">Close</button>
                </div>
            </div>
            <div class="modal hide fade" id="admintimes" tabindex="-1" role="dialog" aria-labelledby="timesmodallabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h3 id="timesmodallabel">Remove Admin Times</h3>
                </div>
                <div class="modal-body">
                    <div id="admintable">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" id="closeimportbtn">Close</button>
                </div>
            </div>
            <div class="modal hide fade" id="drugadmin" tabindex="-1" role="dialog" aria-labelledby="drugsmodallabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h3 id="drugsmodallabel">Change Drug Status</h3>
                </div>
                <div class="modal-body">
                    <div id="drugoptions">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" id="closeimportbtn">Close</button>
                </div>
            </div> 
            <div class="tab-pane" id="manifests">
                    
            </div> 
            <div class="tab-pane" id="usage">
                    
            </div>
            <div class="tab-pane" id="options">
                    
            </div>
            <div class="tab-pane" id="settings">
                    
            </div>
            </div>
        <div class="notification-area" id="notification-area">

        </div>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="js/custom.js"></script>
        <script src="js/bootstrap-timepicker.js"></script>
        <script>
            $('#cyclepop').popover();
            $('#dailypop').popover();
            $('#abxpop').popover();
            $('.datepicker').datepicker({
                autoclose: true
            });
        $('#closeimportbtn').click({type: 'error', title: 'File Import', text: 'was cancelled', id: 'cncl'},addnotification);
        $('#importfilebtn').click(function(){
            $('#imprtbar').width('100%');
            $('#imprtbar').text("Importing File...");
        });
        
        $('#CutOff').timepicker({
            minuteStep: 30,
            showMeridian: false
        });
        $(document).ready(function(){
            refreshlist();
            var wheight = $(window).height();
            var newheight = wheight - 200;
            $('.listdiv').height(newheight);
            if (<?php echo $fsz; ?>>0)
               {
                  $('#notification-area').append('<div id="success" class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>File Import</strong> <?php echo $fff; ?></div>');
                  $('#success').alert();
                  setTimeout(function(){$('#success').fadeOut(500,function(){$('#success').alert('close')})},5000);
               }
           });
        $('input[id=file2import]').change(function(){
               $('#fakefilefield').val($(this).val()); 
        });
        $('input:radio[name="cutofftype"]').change(function(){
            var val = $('input:radio[name="cutofftype"]:checked').val();
            if (val === 'cycle'){
                $('#CutOff').val('01:00');
            }else if (val === 'daily'){
                $('#CutOff').val('18:00');
            }else if (val === 'abx'){
                $('#CutOff').val('18:00');
            }else{
             //wtf?  How did that happen?   
            }
        });
         </script>
    </body>
</html>