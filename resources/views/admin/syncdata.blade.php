@extends('layouts/adminlayout')
@section('content')
  <!-- main area -->
        <div class="main-content">
          <div class="content-view">         
            <h6>Hi, {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h6>
            <ul class="list-group m-b-1">
              <li class="list-group-item notification-bar-success">
                <div class="syncdata">
                <div href="#" class="notification-bar-icon">
                  <form method="post" action="<?php echo url('api/matrix/syncdata') ?>">
                   <button type="button" class="btn btn-success" id="submit">Sync Data</button>
                 </form>
                </div>
                <div class="notification-bar-details">
                  <a href="#" class="notification-bar-title">
                    Click to sync data
                  </a>

                  <span class="text-muted">
                    @if($timeago)
                      last sync: {{ $timeago }}
                    @endif
                  </span>
                </div>
              </div>
              <div class="loadermsg" style="display: none">
                <div class="alert alert-info infomsg">
                  <strong>{{ Auth::user()->firstname }},</strong> please wait for sometime this will take time for data synchronization.
                </div>

                <div class="alert alert-danger somerror">
                  <strong>{{ Auth::user()->firstname }},</strong> some error occure,please try after sometime.
                </div>

                <p class="productslabel">importing products data 
                  <img class="productsloader" src="{{ asset('/resources/uploads/loader.gif') }}" alt="logo" style="width: 40px;display: none;"/>
                  <i class="totalproducts" style="color: #5cb85c;display: none">total products import <b class="numproducts"></b></i>
                  <i class="fa fa-check productsdone" aria-hidden="true" style="color: #5cb85c;font-size: 20px;display: none"></i>
                </p>
                <p class="orderslabel">importing orders data 
                  <img class="ordersloader" src="{{ asset('/resources/uploads/loader.gif') }}" alt="logo" style="width: 40px;display: none;"/>
                  <i class="totalorders" style="color: #5cb85c;display: none">total orders import <b class="numorders"></b></i>
                  <i class="fa fa-check ordersdone" aria-hidden="true" style="color: #5cb85c;font-size: 20px;display: none"></i>
                </p>
                <p class="customerslabel">importing customers data 
                  <img class="customersloader" src="{{ asset('/resources/uploads/loader.gif') }}" alt="logo" style="width: 40px;display: none;"/>
                  <i class="totalcustomers" style="color: #5cb85c;display: none">total customers import <b class="numcustomers"></b></i>
                  <i class="fa fa-check customersdone" aria-hidden="true" style="color: #5cb85c;font-size: 20px;display: none"></i>
                </p>
                <p class="categorylabel">importing category data 
                  <img class="categoryloader" src="{{ asset('/resources/uploads/loader.gif') }}" alt="logo" style="width: 40px;display: none;"/>
                  <i class="totalcategory" style="color: #5cb85c;display: none">total category import <b class="numcategory"></b></i>
                  <i class="fa fa-check categorydone" aria-hidden="true" style="color: #5cb85c;font-size: 20px;display: none"></i>
                </p>
              
                 <div class="alert alert-success successmsg" style="display: none">
                  <strong>{{ Auth::user()->firstname }},</strong> Thanks for data synchronization.
                </div>
              </div>

              </li>
            </ul>
            <div id="respone"></div>
          </div>
          <!-- bottom footer -->
          
          <!-- /bottom footer -->
        </div>
        <!-- /main area -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">
          $('#submit').click(function() {
            $('.syncdata').css('display','none');
            $('.loadermsg').css('display','block');
            $.ajax({
                url: '<?php echo url('api/matrix/syncdata') ?>',
                type: 'get',
                data: {
                    token: '<?php echo Auth::user()->user_token ?>',
                    user_id: '<?php echo Auth::user()->id ?>',
                    website: '<?php echo Auth::user()->website ?>',
                    url: '<?php echo url('api/matrix/syncdata')?>'
                },
                success: function(firstresponse) {
                  if(firstresponse)
                  {
                    if(firstresponse == "error"){
                      $('.infomsg').css('display','none');
                      $(".somerror").css('display','inline-block');
                      setInterval(function(){ 
                        location.reload(); 
                      }, 5000);
                      exit();
                    }
                      $('.productsloader').css('display','inline-block');
                      $('.productslabel').css('color','#0275d8');
                      $.ajax({
                        url: '<?php echo url('api/matrix/StoreProductsData') ?>',
                        type: 'get',
                        data: {
                            user_id: '<?php echo Auth::user()->id ?>',
                            allurl: firstresponse
                        },
                        success: function(productresponse) {
                          $('.productsloader').css('display','none');
                          $('.productsdone').css('display','inline-block');
                          if(productresponse)
                          {
                              $('.ordersloader').css('display','inline-block');
                              $('.totalproducts').css('display','inline-block');
                              $('.numproducts').html(productresponse);
                              $('.orderslabel').css('color','#0275d8');
                              $.ajax({
                                url: '<?php echo url('api/matrix/StoreOrdersData') ?>',
                                type: 'get',
                                data: {
                                    user_id: '<?php echo Auth::user()->id ?>',
                                    ordersurl: firstresponse
                                },
                                success: function(ordersresponse) {
                                  $('.ordersloader').css('display','none');
                                  $('.ordersdone').css('display','inline-block');
                                  if(ordersresponse)
                                  {
                                    $('.customersloader').css('display','inline-block');
                                    $('.totalorders').css('display','inline-block');
                                    $('.numorders').html(ordersresponse);
                                    $('.customerslabel').css('color','#0275d8');
                                    $.ajax({
                                      url: '<?php echo url('api/matrix/StoreCustomersData') ?>',
                                      type: 'get',
                                      data: {
                                          user_id: '<?php echo Auth::user()->id ?>',
                                          customersurl: firstresponse
                                      },
                                      success: function(customersresponse) {
                                        $('.customersloader').css('display','none');
                                        $('.customersdone').css('display','inline-block');
                                        if(customersresponse)
                                        {
                                          $('.categoryloader').css('display','inline-block');
                                          $('.totalcustomers').css('display','inline-block');
                                          $('.numcustomers').html(customersresponse);
                                          $('.categorylabel').css('color','#0275d8');
                                          $.ajax({
                                            url: '<?php echo url('api/matrix/StoreCategoryData') ?>',
                                            type: 'get',
                                            data: {
                                                user_id: '<?php echo Auth::user()->id ?>',
                                                categoryurl: firstresponse
                                            },
                                            success: function(categoryresponse) {
                                              $('.syncdata').css('display','inline-block');
                                              $('.categoryloader').css('display','none');
                                              $('.categorydone').css('display','inline-block');
                                              $('.totalcategory').css('display','inline-block');
                                              $('.infomsg').css('display','none');
                                              $('.successmsg').css('display','inline-block');
                                              $('.numcategory').html(categoryresponse);
                                            }               
                                        });
                                        }
                                      }               
                                  });
                                  }
                                }               
                            });
                          }
                        }               
                    });
                }
                }               
            });
        });
      </script>
@endsection
