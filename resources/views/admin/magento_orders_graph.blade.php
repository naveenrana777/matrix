@extends('layouts/adminlayout')
@section('content')
<title>Orders</title>
<script src="{{ asset('/resources/assets/js/Chart.bundle.js') }}"></script>
<script src="{{ asset('/resources/assets/js/canvas_graph.js') }}"></script>
<style type="text/css">
canvas {-moz-user-select: none;-webkit-user-select: none;-ms-user-select: none;}
.buttons-html5{height: 50px;width: 100px;border: 1px solid #4c7ff0;padding: 10px;}
#DataTables_Table_0_wrapper {margin-top: 10px !important;}
.selectpicker{float: right;}
.modal-dialog {max-width: 1000px;}
</style>
  <!-- main area -->
        <div class="main-content">
          <div class="content-view">    
          <fieldset class="col-md-12"><p style="font-weight:bold;">Filter Orders using Status,Months and Year</p></fieldset>   
            <form action="{{ url('admin/orders') }}" method="post">
                {{ csrf_field() }}
                <fieldset class="col-md-2">
                    <select class="form-control" name="year" id="year">
                        <option value="" >Select Year</option>
                      <?php 
                      $current = date('Y');
                        for ($i=2000;$i<=$current;$i++){ 
                            ?><option value="{{ $i }}" <?php echo ($i == $year)?"selected":"" ?>>{{ $i }}</option><?php
                        } 
                      ?>                  
                    </select>
                </fieldset>

                <fieldset class="col-md-2">
                    <select class="form-control" name="months" id="months">
                        <option value="" >Select Month</option>
                        <option value="" >All Month</option>
                      <?php 
                      for ($i=1;$i<=12;$i++){ 
                            ?><option value="{{ $i }}" <?php echo ($i == $months)?"selected":"" ?>>{{ $i }}</option><?php
                        } 
                      ?>                  
                    </select>
                </fieldset>

                <fieldset class="col-md-2">
                    <select class="form-control" name="status" id="status" onchange="SetData(this)">
                        <option value="" <?php echo ($status == '')?"selected":"" ?>>All</option>
                        <option value="complete" <?php echo ($status == 'complete')?"selected":"" ?>>Complete Orders</option>
                        <option value="canceled" <?php echo ($status == 'canceled')?"selected":"" ?>>Canceled Orders</option>
                        <option value="closed" <?php echo ($status == 'closed')?"selected":"" ?>>Closed Orders</option>
                        <option value="pending" <?php echo ($status == 'pending')?"selected":"" ?>>Pending Orders</option>
                        <option value="processing" <?php echo ($status == 'Processing')?"selected":"" ?>>Processing Orders</option>
                        <option value="on hold" <?php echo ($status == 'on hold')?"selected":"" ?>>On Hold Orders</option>
                        <option value="suspected fraud" <?php echo ($status == 'suspected fraud')?"selected":"" ?>>Suspected Fraud</option>
                    </select>
                </fieldset>
                <fieldset class="col-md-2">
                    <select class="form-control" name="amount" id="amount">
                        <option value="0" <?php echo ($amount == '0')?"selected":"" ?>>Total/Price</option>
                        <option value="1" <?php echo ($amount == '1')?"selected":"" ?>>Quantity/Items</option>
                    </select>
                </fieldset>

                <input type="hidden" name="onchangemonth" id="onchangemonth" value="{{ $status }}">
                
                 <fieldset class="col-md-2">
                   <input type="submit" value="Filter" class="btn btn-primary">
                </fieldset>
                <fieldset class="col-md-2">
                   <button id="save-btn" class="btn btn-primary">Save Chart Image</button>
                </fieldset>
            </form>

            
             <div class="col-sm-12">
                <canvas id="canvas"></canvas>
            </div>

          </div>
          <!-- bottom footer -->
           <div class="card">
              <div class="card-header no-bg b-a-0">
                Magento Customers Table
              </div>
              
              <div class="card-block">
                <div class="table-responsive">
                <table class="table table-bordered datatable table table-striped m-b-0">
                  <thead>
                    <tr>
                      <th>
                        Customer Details
                      </th>
                      <th>
                        Total Tax 
                      </th>
                      <th>
                        Total Discount
                      </th>
                      <th>
                        Quantity
                      </th>
                       <th>
                        Ship Amount 
                      </th>
                      <th>
                        Sub Total
                      </th>
                      <th>
                        Grand Total
                      </th>
                      <th>
                        Order Status
                      </th>
                      <th>
                        Order Date
                      </th>
                      <th>
                        View Order Detail
                      </th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
        </div>
          <!-- /bottom footer -->
        </div>
        <!-- /main area -->

        <div class="row">
        <div class="col-md-12">
             
            <div class="modal fade" id="modal-container-217243" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                             
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                ×
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                               Order Detail
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="card-block orderdata">
                                
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div>
    </div>
        
    

    <script>
        var totalorderscolor     = '<?php echo $totalorderscolor; ?>';
        var completedorderscolor = '<?php echo $completedorderscolor; ?>';   
        var processingorderscolor= '<?php echo $processingorderscolor; ?>';   
        var canceledorderscolor  = '<?php echo $canceledorderscolor; ?>';  
        var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var config = {
            type: '<?php echo $graph; ?>',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: [{
                    label: '<?php echo $totalorderlabel; ?>(<?php echo $totalOrders; ?>)',
                    data: [
                        <?php echo $allOrders; ?>
                    ],
                    backgroundColor: totalorderscolor,
                    borderColor: totalorderscolor,
                    fill: false,
                    borderDash: [5, 5],
                    pointHoverRadius: 10,
                    pointHitRadius: 20,
                }, {
                    label: '<?php echo $completeorderlabel; ?>(<?php echo $totalCompletdOrders; ?>)',
                    data: [
                        <?php echo $allCompletdOrders; ?>
                    ],
                    backgroundColor:completedorderscolor,
                    borderColor: completedorderscolor,
                    fill: false,
                    pointHoverRadius: 10,
                    pointHitRadius: 20,
                }, {
                    label: '<?php echo $processingorderlabel; ?>(<?php echo $totalProecssingOrders; ?>)',
                    data: [
                        <?php echo $allProecssingOrders; ?>
                    ],
                    backgroundColor: processingorderscolor,
                    borderColor: processingorderscolor,
                    fill: false,
                    pointHoverRadius: 10,
                    pointHitRadius: 20,
                }, {
                    label: '<?php echo $canceledorderlabel; ?>(<?php echo $totalCancelOrders; ?>)',
                    data: [
                       <?php echo $allCancelOrders; ?>
                    ],
                    backgroundColor: canceledorderscolor,
                    borderColor: canceledorderscolor,
                    fill: false,
                    pointHoverRadius: 10,
                    pointHitRadius: 20,
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
                hover: {
                    mode: 'index'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Customers <?php echo $year ?>'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                },
                title: {
                    display: true,
                    text: '<?php echo $graphheading; ?>'
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx, config);
        };


    </script>

        <!-- initialize page scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/eligrey/FileSaver.js/master/FileSaver.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/eligrey/canvas-toBlob.js/master/canvas-toBlob.js"></script>
        <script type="text/javascript">
        // Function to set data value of status on changes 
        function SetData(selectObject) { 
            $("#onchangemonth").val(selectObject.value);
        }
        // Function to get data from datatable using ajax request
        $('.datatable').DataTable({
                "ajax":
                    {
                        "url": "<?php echo url('/admin/orderstableajax') ?>",
                        "type": "GET",
                        "data": {
                            'year': $("#year").val(),
                            'status': $("#onchangemonth").val(),
                            'months':$("#months").val()
                        }
                    },
                "destroy" : true,
                   dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
            }).ajax.reload();


        $("#save-btn").click(function() {
                $("#canvas").get(0).toBlob(function(blob) {
                    saveAs(blob, "Orders.png");
                });
        });
        var ctx = $("#canvas").get(0).getContext("2d");
        var mychart = new Chart(ctx).Bar(config);


        // Function To show order details
        function ViewOrder(id)
        {
            $.ajax({
                url: '<?php echo url('/admin/orderview') ?>/'+id,
                type: 'get',
                success: function(result)
                {
                   $(".orderdata").html(result);
                }
            });
        }
        </script>
        <!-- end initialize page scripts -->

@endsection
