@extends('layouts/adminlayout')
@section('content')
<link rel="stylesheet" href="{{ asset('/resources/assets/frontend/styles/register.css') }}"/>
<style type="text/css">
.configuration-cog.toggle-options {display: none;}
</style>  
    <!-- main area -->
        <div class="main-content">
          <div class="content-view">
            <div class="card">
              <div class="card-header no-bg b-a-0">
                Customers Settings
              </div>
              <div class="card-block">
                 @if($errors->any())
                 <div class="alert alert-success">
                  <strong>{{$errors->first()}}!</strong> 
                </div>
                @endif
                   <form action="{{ url('admin/update-customers-settings') }}" method="post" id="CustomerSettings">
                      {{ csrf_field() }}
                      <fieldset class="form-group">
                        <label for="exampleSelect1">
                         Graph Type
                        </label>
                        <select class="form-control" name="graphType">
                          <option value="">Select Graph Type</option>
                          <option value="bar" <?php echo (@$settings['graphType'] == 'bar')?"selected":"" ?>>Bar</option>
                          <option value="horizontalBar" <?php echo (@$settings['graphType'] == 'horizontalBar')?"selected":"" ?>>Horizontal Bar</option>
                          <option value="line" <?php echo (@$settings['graphType'] == 'line')?"selected":"" ?>>Line</option>
                        </select>
                      </fieldset>
                                    
                      <!-- <fieldset class="form-group">
                        <label for="exampleSelect1">
                        Active Customers
                        </label> -->
                        <!-- <input type="text" class="form-control" value="{{ @$settings['active_customer_limit'] }}" name="active_customer_limit" placeholder="Enter active customers to show on graph"> -->
                        <input type="hidden" class="form-control" value="2" name="active_customer_limit" placeholder="Enter active customers to show on graph">
                      <!-- </fieldset>          -->

                      <fieldset class="form-group">
                        <label for="exampleSelect1">
                        Total Customers Graph Color
                        </label>
                        <input type="text" class="form-control jscolor {valueElement:'totalcustomerscolor', onFineChange:'setColorTotalCustomers(this)'}" placeholder="Pick color for total customers">
                        <input id="totalcustomerscolor" value="{{ @$settings['totalcustomerscolor'] }}" type="hidden" name="totalcustomerscolor">
                      </fieldset>     
    
                      <fieldset class="form-group">
                        <label for="exampleSelect1">
                        Active Customers Graph Color
                        </label>
                        <input type="text" class="form-control jscolor {valueElement:'activecustomerscolor', onFineChange:'setColorActiveCustomers(this)'}" placeholder="Pick color for total customers">
                        <input id="activecustomerscolor" value="{{ @$settings['activecustomerscolor'] }}" type="hidden" name="activecustomerscolor">
                      </fieldset>  
                      

                      <fieldset class="form-group">
                        <label for="exampleSelect1">
                        Non-Active Customers Graph Color
                        </label>
                        <input type="text" class="form-control jscolor {valueElement:'nonactivecustomerscolor', onFineChange:'setColorNonactiveCustomers(this)'}" placeholder="Pick color for total customers">
                        <input id="nonactivecustomerscolor" value="{{ @$settings['nonactivecustomerscolor'] }}" type="hidden" name="nonactivecustomerscolor">
                      </fieldset>  


                      <fieldset class="form-group">
                        <label for="exampleSelect1">
                        Normal Customers Graph Color
                        </label>
                        <input type="text" class="form-control jscolor {valueElement:'normalcustomerscolor', onFineChange:'setColorNormalCustomers(this)'}" placeholder="Pick color for total customers">
                        <input id="normalcustomerscolor" value="{{ @$settings['normalcustomerscolor'] }}" type="hidden" name="normalcustomerscolor">
                      </fieldset>  

                      <button type="submit" class="btn btn-primary">
                        Submit
                      </button>
                    </form>
                  </div>
            </div>
          </div>
         
        </div>
        <!-- /main area -->


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src=""></script>
        <script src="{{ asset('/resources/assets/js/jscolor.js') }}"></script>
        <script type="text/javascript">
        $(document).ready(function() {
          $('#CustomerSettings').bootstrapValidator({
              feedbackIcons: {
                  valid: 'glyphicon glyphicon-ok',
                  invalid: 'glyphicon glyphicon-remove',
                  validating: 'glyphicon glyphicon-refresh'
              },
              fields: {
                  graphType: {
                      validators: {
                          notEmpty: {
                              message: 'The graph type is required and cannot be empty'
                          }
                      }
                  }
              //     active_customer_limit: {
              //     validators: {
              //         notEmpty: {
              //             message: 'The limit is required and cannot be empty'
              //         },
              //         stringLength: {
              //             min: 1,
              //             max: 2,
              //             message: 'The limit length should be between 1 to 2 characters'
              //         },
              //         regexp: {
              //                 regexp: /^[0-9]+$/,
              //                 message: 'The limit can only consist number '
              //             }
              //     }
              // }

              }
          });
      });
      // Function to get color for total customers data showing
      function setColorTotalCustomers(picker) {
        $('#totalcustomerscolor').val(picker.toString());
      }

      // Function to get color for total customers data showing
      function setColorActiveCustomers(picker) {
        $('#activecustomerscolor').val(picker.toString());
      }

      // Function to get color for total customers data showing
      function setColorNonactiveCustomers(picker) {
        $('#nonactivecustomerscolor').val(picker.toString());
      }

      // Function to get color for total customers data showing
      function setColorNormalCustomers(picker) {
        $('#normalcustomerscolor').val(picker.toString());
      }
      </script>
@endsection
