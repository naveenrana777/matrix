<?php

namespace App\Http\Controllers;
use Request;
use Auth;
use App\User;
use App\Products;
use App\Orders;
use App\Customers;
use App\LastSync;
use App\Category;
class ApiController extends Controller
{
 
    /**
    * Function to sync data.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
      $data    = Request::all();
      $user_id = $data['user_id'];
      LastSync::insert(['user_id'=>$user_id]);
      $ch      = curl_init();
      curl_setopt($ch, CURLOPT_URL,"".$data['website']."restapi/apidata/getFullApiData");
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,"url=".$data['url']."&token=".$data['token']."");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $server_output  = curl_exec($ch);
      $response       = json_decode($server_output);
      if(@$response->response == "success"){
        $data = $response->data;
        echo $Products_Api   =  base64_decode($data->Products_Api).'~';
        echo $Sales_Api      =  base64_decode($data->Sales_Api).'~';
        echo $Customers_Api  =  base64_decode($data->Customers_Api).'~';
        echo $Categories_Api =  base64_decode($data->Categories_Api);
        
      }else
      {
        echo 'error';
      }
      curl_close ($ch);
    }



    /**
    * Function to store products data.
    *
    * @return \Illuminate\Http\Response
    */
    public function StoreProductsData(Request $request)
    {
      $data    		= Request::all();
      $user_id 		= $data['user_id'];
      $apiUrl  		= $data['allurl']; 
      $apiUrl  		= explode('~', $apiUrl);
      $ProductsApi 	= $apiUrl[0];
      // $result 		= file_get_contents($ProductsApi);
      $url  		= $ProductsApi;
	  $curl 		= curl_init();
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	  $auth = curl_exec($curl);
      $data   		= json_decode($auth, true);
      if(!empty($data['products']))
      {
	      foreach ($data['products'] as $key => $value) 
	      {
	          $check_exists = Products::where(['product_id'=>$value['id'],'user_id'=>$user_id])->count();        
	          if($check_exists>0)
	          { 
	            $arraydata = array(
	              'user_id'                 =>  $user_id,
	              'product_id'              =>  $value['id'],
	              'name'                    =>  $value['name'],
	              'sku'                     =>  $value['sku'],
	              'price'                   =>  $value['price'],
	              'special_price'           =>  $value['special_price'],
	              'status'                  =>  $value['status'],
	              'product_type'            =>  $value['type_id'],
	              'm_created_at'            =>  $value['created_at'],
	              'm_updated_at'            =>  $value['updated_at'],
	              'short_description'       =>  $value['short_description'],
	              'long_description'        =>  $value['description'],
	              'image'                   =>  $value['image'],
	              'product_url'             =>  $value['url'],
	              );
	             Products::where(['product_id'=>$value['id'],'user_id'=>$user_id])->update($arraydata);
	          }else
	          {
	          	$arraydata = array(
	              'user_id'                 =>  $user_id,
	              'product_id'              =>  $value['id'],
	              'name'                    =>  $value['name'],
	              'sku'                     =>  $value['sku'],
	              'price'                   =>  $value['price'],
	              'special_price'           =>  $value['special_price'],
	              'status'                  =>  $value['status'],
	              'product_type'            =>  $value['type_id'],
	              'm_created_at'            =>  $value['created_at'],
	              'm_updated_at'            =>  $value['updated_at'],
	              'short_description'       =>  $value['short_description'],
	              'long_description'        =>  $value['description'],
	              'image'                   =>  $value['image'],
	              'product_url'             =>  $value['url'],
	              );
	              Products::insert($arraydata);
	          }
	      }
	  }
	  if(!empty($data['products']))
      {
      	 print_r($data['total_count']);
      }else{
      	echo '0';
      }
    }


    /**
    * Function to store orders data.
    *
    * @return \Illuminate\Http\Response
    */
    public function StoreOrdersData(Request $request)
    {
      $data    		= Request::all();
      $user_id 		= $data['user_id'];
      $apiUrl  		= $data['ordersurl']; 
      $apiUrl  		= explode('~', $apiUrl);
      $OrdersApi 	= $apiUrl[1];
      //$result 		= file_get_contents($OrdersApi);
      $url  		= $OrdersApi;
	  $curl 		= curl_init();
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	  $auth = curl_exec($curl);
      $data   		= json_decode($auth, true);
      if(!empty($data['orders']))
      {
	      foreach ($data['orders'] as $key => $value) 
	      {
	          $check_exists = Orders::where(['order_id'=>$value['order_id'],'user_id'=>$user_id])->count();        
	          if($check_exists>0)
	          { 
	          	// $billing_address 	=  $value['billing_address']['company'].' '.$value['billing_address']['city'].' '.$value['billing_address']['postcode'].' '.$value['billing_address']['country_id'];
	          	// $shipping_address 	=  $value['shipping_address']['company'].' '.$value['shipping_address']['city'].' '.$value['shipping_address']['postcode'].' '.$value['shipping_address']['country_id'];
	          	$billing_address 	= '';
	          	$shipping_address 	= '';	          	
	            $arraydata = array(
	              'user_id'                 =>  $user_id,
	              'product_id'              =>  $value['product_id'],
	              'order_id'                =>  $value['order_id'],
	              'customer_id'             =>  $value['customer_id'],
	              'billing_address'         =>  $billing_address,
	              'shipping_address'        =>  $shipping_address,
	              'quantity'           		=>  $value['total_qty_ordered'],
	              'ship_amount'             =>  $value['shipping_amount'],
	              'ship_discount_method'    =>  $value['shipping_description'],
	              'ship_discount_amount'    =>  $value['shipping_discount_amount'],
	              'tax_amount'              =>  $value['tax_amount'],
	              'discount_amount'         =>  $value['discount_amount'],
	              'status'            		=>  $value['status'],
	              'sub_total'            	=>  $value['subtotal'],
	              'grand_total'            	=>  $value['grand_total'],
	              'currency_code'           =>  $value['currency_code'],
	              'payment_type'            =>  $value['payment_method'],
	              'm_created_at'            =>  $value['created_at'],
	              'm_updated_at'            =>  $value['updated_at']
	              );
	             Orders::where(['order_id'=>$value['order_id'],'user_id'=>$user_id])->update($arraydata);
	          }else
	          {
	          	// $billing_address 	=  $value['billing_address']['company'].' '.$value['billing_address']['city'].' '.$value['billing_address']['postcode'].' '.$value['billing_address']['country_id'];
	          	// $shipping_address 	=  $value['shipping_address']['company'].' '.$value['shipping_address']['city'].' '.$value['shipping_address']['postcode'].' '.$value['shipping_address']['country_id'];
	          	$billing_address 	= '';
	          	$shipping_address 	= '';	
	            $arraydata = array(
	              'user_id'                 =>  $user_id,
	              'product_id'              =>  $value['product_id'],
	              'order_id'                =>  $value['order_id'],
	              'customer_id'             =>  $value['customer_id'],
	              'billing_address'         =>  $billing_address,
	              'shipping_address'        =>  $shipping_address,
	              'quantity'           		=>  $value['total_qty_ordered'],
	              'ship_amount'             =>  $value['shipping_amount'],
	              'ship_discount_method'    =>  $value['shipping_description'],
	              'ship_discount_amount'    =>  $value['shipping_discount_amount'],
	              'tax_amount'              =>  $value['tax_amount'],
	              'discount_amount'         =>  $value['discount_amount'],
	              'status'            		=>  $value['status'],
	              'sub_total'            	=>  $value['subtotal'],
	              'grand_total'            	=>  $value['grand_total'],
	              'currency_code'           =>  $value['currency_code'],
	              'payment_type'            =>  $value['payment_method'],
	              'm_created_at'            =>  $value['created_at'],
	              'm_updated_at'            =>  $value['updated_at']
	              );
	              Orders::insert($arraydata);
	          }
	      }
	  }
      if(!empty($data['orders']))
      {
      	 print_r($data['total_count']);
      }else{
      	echo '0';
      }
    }


    
    /**
    * Function to store customers data.
    *
    * @return \Illuminate\Http\Response
    */
    public function StoreCustomersData(Request $request)
    {
      $data    			= Request::all();
      $user_id 			= $data['user_id'];
      $apiUrl  			= $data['customersurl']; 
      $apiUrl  			= explode('~', $apiUrl);
      $CustomersurlApi 	= $apiUrl[2];
      //$result 			= file_get_contents($CustomersurlApi);
      $url  		= $CustomersurlApi;
	  $curl 		= curl_init();
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	  $auth = curl_exec($curl);
      $data   			= json_decode($auth, true);
      if(!empty($data['customers']))
      {
	      foreach ($data['customers'] as $key => $value) 
	      {
	          $check_exists = Customers::where(['customer_id'=>$value['customer_id'],'user_id'=>$user_id])->count();        
	          if($check_exists>0)
	          { 
	            $arraydata = array(
	              'user_id'                 =>  $user_id,
	              'customer_id'             =>  $value['customer_id'],
	              'email'                   =>  $value['email'],
	              'firstname'               =>  $value['firstname'],
	              'lastname'                =>  $value['lastname'],
	              'addresses'           	=>  $value['addresses']['street'],
	              'city'           	        =>  $value['addresses']['city'],
	              'postcode'           	    =>  $value['addresses']['postcode'],
	              'country'           	    =>  $value['addresses']['country'],
	              'region'           	    =>  $value['addresses']['region'],
	              'telephone'               =>  $value['addresses']['telephone'],
	              'm_created_at'            =>  $value['created_at'],
	              'm_updated_at'            =>  $value['updated_at']
	              );
	             Customers::where(['customer_id'=>$value['customer_id'],'user_id'=>$user_id])->update($arraydata);
	          }else
	          {
	          	$arraydata = array(
	              'user_id'                 =>  $user_id,
	              'customer_id'             =>  $value['customer_id'],
	              'email'                   =>  $value['email'],
	              'firstname'               =>  $value['firstname'],
	              'lastname'                =>  $value['lastname'],
	              'addresses'           	=>  $value['addresses']['street'],
	              'city'           	        =>  $value['addresses']['city'],
	              'postcode'           	    =>  $value['addresses']['postcode'],
	              'country'           	    =>  $value['addresses']['country'],
	              'region'           	    =>  $value['addresses']['region'],
	              'telephone'               =>  $value['addresses']['telephone'],
	              'm_created_at'            =>  $value['created_at'],
	              'm_updated_at'            =>  $value['updated_at']
	              );
	              Customers::insert($arraydata);
	          }
	      }
  	  }
      if(!empty($data['customers']))
      {
      	 print_r($data['total_count']);
      }else{
      	echo '0';
      }
    }


    /**
    * Function to store category data.
    *
    * @return \Illuminate\Http\Response
    */
    public function StoreCategoryData(Request $request)
    {
      $data    			= Request::all();
      $user_id 			= $data['user_id'];
      $apiUrl  			= $data['categoryurl']; 
      $apiUrl  			= explode('~', $apiUrl);
      $CategoryurlApi 	= $apiUrl[3];
      //$result 			= file_get_contents($CategoryurlApi);
      $url  		= $CategoryurlApi;
	  $curl 		= curl_init();
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	  $auth = curl_exec($curl);
      $data   			= json_decode($auth, true);
      if(!empty($data['categories']))
      {
	      foreach ($data['categories'] as $key => $value) 
	      {
	          $check_exists = Category::where(['category_id'=>$value['id'],'user_id'=>$user_id])->count();        
	          if($check_exists>0)
	          { 
	          	$status =  $value['is_active'];
	          	if($status == true){
	          		$status = 1;
	          	}else{
	          		$status = 0;
	          	}
	          	$arraydata = array(
	              'user_id'                 =>  $user_id,
	              'category_id'             =>  $value['id'],
	              'name'                    =>  $value['name'],
	              'status'               	=>  $status
	              );
	             Category::where(['category_id'=>$value['id'],'user_id'=>$user_id])->update($arraydata);
	          }else
	          {
	          	$status =  $value['is_active'];
	          	if($status == true){
	          		$status = 1;
	          	}else{
	          		$status = 0;
	          	}
	          	$arraydata = array(
	              'user_id'                 =>  $user_id,
	              'category_id'             =>  $value['id'],
	              'name'                    =>  $value['name'],
	              'status'               	=>  $status
	              );
	              Category::insert($arraydata);
	          }
	      }
	  }
      if(!empty($data['categories']))
      {
      	 print_r($data['total_count']);
      }else{
      	echo '0';
      }
    }






  }
