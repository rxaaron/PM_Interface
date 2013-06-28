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
                <div class="span4">
                    <form autocomplete="off" method="POST" action="">
                        <label>Start Date</label>
                        <div class="input-append date datepicker" data-date-format="mm/dd/yyyy"><input type="text" id="StartDate" autocomplete="off" value="<?php echo date("m/d/Y"); ?>" name="startdate"><span class="add-on"><i class="icon-calendar"></i></span></div>
                        <label>Stop Date</label>
                        <div class="input-append date datepicker" data-date-format="mm/dd/yyyy"><input type="text" id="StopDate" autocomplete="off" name="stopdate"><span class="add-on"><i class="icon-calendar"></i></span></div>
                        <label>Cut Off Time</label>
                        <div class="input-append pad4 bootstrap-timepicker"><input id="CutOff" type="text" autocomplete="off" value="01:00" name="cutoff"><span class="add-on"><i class="icon-time"></i></span></div>
                        <div class="pad4" style="margin-bottom:10px;">
                        <label class="radio inline"><input type="radio" id="cycle" name="cutofftype" value="cycle" checked="checked">Cycle</label><label class="radio inline"><input type="radio" id="daily" name="cutofftype" value="daily">Daily</label><label class="radio inline"><input type="radio" id="abx" name="cutofftype" value="abx">Antibiotic</label>
                        </div>
                        <label>File Name</label>
                        <div class="input-append pad4"><input type="text" id="FileName" placeholder="File Name" autcomplete="off" name="filename"><span class="add-on"><i class="icon-file"></i></span></div>
                        <br>
                        <div class="pad4 btn-group"><button type="submit" class="btn btn-primary wide85" name="action" value="process">Process</button><button type="submit" class="btn btn-success wide85" name="action" value="export">Export</button><button type="submit" class="btn btn-danger wide85" name="action" value="clear" onClick="return confirm('Are you sure you want to clear the Export Table?');">Clear</button></div>
                    </form>
                </div>
                <div class="span6">
                    <div class="tab-content">
                        <div class="tab-pane active" id="export">
                            <div class="row-fluid">
                                <div class="span12" id="exportdata">
                                    <?php echo $_SERVER['REMOTE_ADDR']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="list">
                             <div class="row-fluid">
                                <div class="span12" id="listdata">
                                    
                                </div>
                            </div>                           
                        </div>
                        <div class="tab-pane" id="admintimes">
                            <div class="row-fluid">
                                <div class="span12" id="admindata">
                                    
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
                <div class="span2">
                    <div class="tabbable tabs-right">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#export" data-toggle="tab"><button class="btn">Orders Ready<br>For Export</button></a></li>
                            <li class><a href="#list" data-toggle="tab"><button class="btn">View Listed<br>Orders</button></a></li>
                            <li class><a href="#admintimes" data-toggle="tab"><button class="btn">Administration<br>Times</button></a></li>
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
                        <?php include('scripts/imported_files.php'); ?>
                    </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" id="importfilebtn" onclick="$('#import').modal('hide');$('#progress').modal('show');" value="Import File">
                    </form>
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" id="closeimportbtn">Close</button>
                </div>
            </div>
            <div class="modal hide fade" id="progress" tabindex="-1" role="dialog" aria-labelledby="otherModalLabel" aria-hidden="true">
                <div class="modal-header">
                     <h3 id="otherModalLabel">Please Wait.  File Being Imported</h3>
                </div>
                <div class="modal-body">
                    <div class="progress progress-striped active">
                        <div class="bar" id="fimport" style="width:100%"></div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    &nbsp;
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
            $('.datepicker').datepicker({
                autoclose: true
            });
        $('#closeimportbtn').click({type: 'error', title: 'File Import', text: 'was cancelled'},addnotification);
        $('#CutOff').timepicker({
            minuteStep: 30,
            showMeridian: false
        });
        $(document).ready(function(){
            if (<?php echo $fsz; ?>>0)
               {
                  $('#notification-area').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>File Import</strong> <?php echo $fff; ?></div>');
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