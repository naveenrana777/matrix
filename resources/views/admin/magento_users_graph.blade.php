@extends('layouts/adminlayout')
@section('content')
<script src="{{ asset('/resources/assets/js/Chart.bundle.js') }}"></script>
<script src="{{ asset('/resources/assets/js/canvas_graph.js') }}"></script>
<style type="text/css">
canvas {-moz-user-select: none;-webkit-user-select: none;-ms-user-select: none;}
.buttons-html5{height: 50px;width: 100px;border: 1px solid #4c7ff0;padding: 10px;}
#DataTables_Table_0_wrapper {margin-top: 10px !important;}
.selectpicker{float: right;}
</style>
  <!-- main area -->
        <div class="main-content">
          <div class="content-view">    
          <fieldset class="col-md-12"><p style="font-weight:bold;">Filter Customers using Status,Months and Year</p></fieldset>   
            <form action="{{ url('admin/customers') }}" method="post">
            	{{ csrf_field() }}
                <fieldset class="col-md-3">
    	            <select class="form-control" name="year" id="year">
                        <option value="" >Select Year</option
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

                <fieldset class="col-md-3">
                    <select class="form-control" name="status" id="status" onchange="SetData(this)">
                        <option value="" <?php echo ($status == '')?"selected":"" ?>>All</option>
    	            	<option value="0" <?php echo ($status == '0')?"selected":"" ?>>Active Customers</option>
    	            	<option value="1" <?php echo ($status == '1')?"selected":"" ?>>Non-Active Customers</option>
                        <option value="2" <?php echo ($status == '2')?"selected":"" ?>>Normal Customers</option>
    	            	<option value="3" <?php echo ($status == '3')?"selected":"" ?>>Total Customers</option>
    	            </select>
                </fieldset>
                <input type="hidden" name="onchangemonth" id="onchangemonth" value="{{ $status }}">
	            <input type="hidden" name="active_customer_limit" id="active_customer_limit" value="{{ $active_customer_limit }}">

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
                        Name
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Address
                      </th>
                      <th>
                        City
                      </th>
                      <th>
                        Country
                      </th>
                      <th>
                        Postal Code
                      </th>
                      <th>
                        Region
                      </th>
                      <th>
                        Phone
                      </th>
                      <th>
                        User Created On
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

        
        <script>
        var totalactivecolot = '<?php echo $totalcustomerscolor; ?>';
        var activecustomerscolor = '<?php echo $activecustomerscolor; ?>';   
        var nonactivecustomerscolor = '<?php echo $nonactivecustomerscolor; ?>';   
        var normalcustomerscolor = '<?php echo $normalcustomerscolor; ?>';	
        var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var config = {
            type: '<?php echo $graphType; ?>',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: [{
                    label: "Total Customers(<?php echo $totalCount; ?>)",
                    data: [
                        <?php echo $allrecords; ?>
                    ],
                    backgroundColor: totalactivecolot,
                    borderColor: totalactivecolot,
                    fill: false,
                    borderDash: [5, 5],
                    // pointRadius: 15,
                    pointHoverRadius: 10,
                    pointHitRadius: 20,
                }, {
                    label: "Active Customers(<?php echo $activecount; ?>)",
                    data: [
                        <?php echo $allActiveUser; ?>
                    ],
                    backgroundColor:activecustomerscolor,
                    borderColor: activecustomerscolor,
                    fill: false,
                    // borderDash: [5, 5],
                    // pointRadius: [2, 4, 6, 18, 0, 12, 20],
                    pointHoverRadius: 10,
                    pointHitRadius: 20,
                }, {
                    label: "Non-Active Customers(<?php echo $totalnonactivecount; ?>)",
                    data: [
                        <?php echo $allNonActive; ?>
                    ],
                    backgroundColor: nonactivecustomerscolor,
                    borderColor: nonactivecustomerscolor,
                    fill: false,
                    // pointHoverRadius: 30,
                    pointHoverRadius: 10,
                    pointHitRadius: 20,
                }, {
                    label: "Normal Customers(<?php echo $totalnormalcount; ?>)",
                    data: [
                       <?php echo $allNormal; ?>
                    ],
                    // backgroundColor: window.chartColors.yellow,
                    // borderColor: window.chartColors.yellow,
                    backgroundColor: normalcustomerscolor,
                    borderColor: normalcustomerscolor,
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
                    text: 'Magento Customers Graph'
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
		                "url": "<?php echo url('/admin/customerstableajax') ?>",
		                "type": "GET",
						"data": {
		                    'year': $("#year").val(),
		                    'status': $("#onchangemonth").val(),
                            'active_customer_limit':$("#active_customer_limit").val(),
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
                    saveAs(blob, "Customers.png");
                });
        });
    var ctx = $("#canvas").get(0).getContext("2d");
    var mychart = new Chart(ctx).Bar(config);

        </script>
        <!-- end initialize page scripts -->

@endsection
