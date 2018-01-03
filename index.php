<?php 
    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">    
    <title>Scan Pajak</title>            
    <!--if lt IE 9script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="js/datatable/datatables.min.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>    
      <div class="container-fluid">              
        <div class="row">
            <div class="col-md-12">
                <h3 style="text-align: center;">DATA SCAN</h3>
            </div>
            <br><br>
            <div class="col-md-12">
                <div class="input-group" style="width: 70%;"><span class="input-group-addon">SCAN QR CODE</span>
                    <input type="text" placeholder="..." class="form-control" id="scanurl">
                </div>                                                                           
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <form id="form-format1" method="post" target="_blank" class="pull-right" action="createspreadsheet1.php">
                            <input type="hidden" name="data1" id="data1" value=""/>                                                                
                            <button class="btn btn-primary" id="btn-format1">Export Table</button>
                        </form>
                    </div>                    
                </div>                                 
            </div>
            <div class="col-md-12">
                <div class="table-responsive">                    
                    <table id="datatable" class="table table-bordered dataTable">
                        <thead>
                            <tr>                                
                                <th>NO</th>
                                <th>NPWP</th>
                                <th>PENJUAL</th>
                                <th>ALAMAT PENJUAL</th>
                                <th>FAKTUR</th>
                                <th>TANGGAL FAKTUR</th>
                                <th>JUMLAH DPP</th>
                                <th>JUMLAH PPN</th>                                
                                <th>STATUS</th>       
                                <th>#</th>       
                            </tr>
                        </thead>
                        <tbody class="no-border-y">

                        </tbody>
                    </table>
                </div>                                                                          
            </div>
        </div>
    </div>      
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/datatable/datatables.min.js"></script>
    <script src="js/uiblock/jquery.blockUI.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){                    
            //initialize the javascript            
            $('#scanurl').focus();
             var dataTable = $('#datatable').dataTable( {
                "dom": 'T<"clear">lfrtip',                               
                "bSort" : false,
                "paging": false
            });           
            
            //custom style for datatable
            $('.dataTable_wrapper .clear').after('<div class="row"><div class="col-sm-6 style-length"></div><div class="col-sm-6 style-filter"></div></div>');                        
            $('.dataTable_length').appendTo($('#datatable_wrapper .style-length'));                 
            $('.dataTable_filter').appendTo($('#datatable_wrapper .style-filter'));                         
            $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
            $('.dataTables_length select').addClass('form-control');  
            $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
            $('.dataTables_length select').addClass('form-control');
            var ARRAYDATATABLE = new Array();
            
            $('#scanurl').keyup(function(e){
                var path = $(this).val();                
                if(e.keyCode == 13){
                    $.blockUI();
                    var ajax = $.ajax({
                        method: "POST",
                        url: "ajaxscanqrcode.php",
                        data: { path: path }
                    });
                    ajax.done(function(msg){   
                        if(msg == 'false'){
                            alert('Faktur Pajak tidak ditemukan di server Pajak Online');
                        }
                        else{
                            var data = $.parseJSON(msg);
                            ARRAYDATATABLE.push(data);                                                
                            updateDatatable();                            
                        }
                        $.unblockUI();
                        $('#scanurl').val('');
                        $('#scanurl').focus();    
                        
                    });

                    ajax.fail(function( jqXHR, textStatus ) {                                    
                        alert("Error code " + jqXHR.status + " : " + jqXHR.responseText);   
                        $.unblockUI();
                        $('#scanurl').val('');
                        $('#scanurl').focus();
                    });   
                }
            });
            
            $('#datatable').delegate('.btn-delete', 'click', function(e){
                $('#loading-image').show();
                var row = $(this).attr('data-row');
                ARRAYDATATABLE.splice(row, 1);
                updateDatatable();
                $('#loading-image').hide();
                $('#scanurl').val('');
                $('#scanurl').focus();
            });
            function updateDatatable(){
                var table = $('#datatable').DataTable();
                table.clear();
                                
                for(i = 0; i < ARRAYDATATABLE.length; i++){                                           
                    var link = '<button class="btn btn-danger btn-delete" data-row="' + i + '">DEL</button>';
                    table.row.add([(i + 1), ARRAYDATATABLE[i]['npwpPenjual'], ARRAYDATATABLE[i]['namaPenjual'], ARRAYDATATABLE[i]['alamatPenjual'],
                            ARRAYDATATABLE[i]['kdJenisTransaksi'] + ARRAYDATATABLE[i]['fgPengganti'] + ARRAYDATATABLE[i]['nomorFaktur'], ARRAYDATATABLE[i]['tanggalFaktur'], ARRAYDATATABLE[i]['jumlahDpp'], ARRAYDATATABLE[i]['jumlahPpn'], ARRAYDATATABLE[i]['statusApproval'], link]);                    
                }
                table.draw();    
            }
            
            $('#btn-format1').click(function(e){
                e.preventDefault();
                $('#data1').val(JSON.stringify(ARRAYDATATABLE));                                
                $('#form-format1').submit();
            });                        
      });
    </script>
  </body>
</html>