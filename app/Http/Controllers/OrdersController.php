<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Category;
use App\Customers;
use App\Orders;
use App\Products;
use App\Settings;
use App\LastSync;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class OrdersController extends Controller
{
    /**
     * Show the application to show magento orders graph.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input 		= $request->all();
        $year 		= @$input['year'];
        $status 	= @$input['status'];
        $months     = @$input['months'];
        $amount 	= @$input['amount'];
        if(!empty($year)){
            $year = $year;
        }else{
            $year = date('Y');
        }
        if(!empty($months)){
            $months = $months;
        }else{
            $months = '';
        }
        if(!empty($status)){
            $status = $status;
        }else{
            $status = '';
        }
        if(!empty($amount)){
            $amount = $amount;
            $graphheading = 'Magento Orders Graph Using Quantity';
            $totalorderlabel = 'Total Orders Quantity';
            $completeorderlabel = 'Complete Orders Quantity';
            $processingorderlabel = 'Processing Orders Quantity';
            $canceledorderlabel = 'Canceled Orders Quantity';
        }else{
            $amount = '0';
            $graphheading = 'Magento Orders Graph Using Price';
            $totalorderlabel = 'Total Orders Price';
            $completeorderlabel = 'Complete Orders Price';
            $processingorderlabel = 'Processing Orders Price'; 
            $canceledorderlabel = 'Canceled Orders Price';                    
        }
        if ($status == 'complete') {
    		$totalOrders = '';               // get count of records of orders
	        $allOrders   = '';               // show all records on graph data 
	        $totalProecssingOrders  = '';               // get count of records of orders
	        $allProecssingOrders    = '';               // show all records on graph data
	        $totalCancelOrders  	= '';               // get count of records of orders
	        $allCancelOrders    	= '';               // show all records on graph data
	        $allcompletedOrders   = $this->GetAllCompletedOrders($year,$months,$status,$amount);  // get data for all orders according to years   
	        $allcompletedOrders   = explode('~', $allcompletedOrders);    // explode data of completed count and months data
	        $totalCompletdOrders  = $allcompletedOrders[0];               // get count of records of orders
	        $allCompletdOrders    = $allcompletedOrders[1];               // show all records on graph data
	    }elseif ($status == 'processing') {
	    	$totalOrders = '';               // get count of records of orders
	        $allOrders   = '';               // show all records on graph data 
	        $totalProecssingOrders  = '';               // get count of records of orders
	        $allProecssingOrders    = '';               // show all records on graph data
	        $totalCancelOrders  	= '';               // get count of records of orders
	        $allCancelOrders    	= '';               // show all records on graph data
	        $totalCompletdOrders    = '';               // get count of records of orders
	        $allCompletdOrders      = '';               // show all records on graph data
	        $allprocessingOrders    = $this->GetAllProcessingOrders($year,$months,$status,$amount);  // get data for all orders according to years   
	        $allprocessingOrders    = explode('~', $allprocessingOrders);    // explode data of processing count and months data
	        $totalProecssingOrders  = $allprocessingOrders[0];               // get count of records of orders
	        $allProecssingOrders    = $allprocessingOrders[1];               // show all records on graph data
    	}elseif ($status == 'canceled') {
    		$totalOrders = '';               // get count of records of orders
	        $allOrders   = '';               // show all records on graph data 
	        $totalProecssingOrders  = '';               // get count of records of orders
	        $allProecssingOrders    = '';               // show all records on graph data
	        $totalCancelOrders  	= '';               // get count of records of orders
	        $allCancelOrders    	= '';               // show all records on graph data
	        $totalCompletdOrders    = '';               // get count of records of orders
	        $allCompletdOrders      = '';               // show all records on graph data
	        $allcancelOrders    = $this->GetAllCancelOrders($year,$months,$status,$amount);  // get data for all orders according to years   
	        $allcancelOrders    = explode('~', $allcancelOrders);    // explode data of canceled count and months data
	        $totalCancelOrders  = $allcancelOrders[0];               // get count of records of orders
	        $allCancelOrders    = $allcancelOrders[1];               // show all records on graph data
    	}else{
    		$allorders   = $this->GetAllOrders($year,$months,$status,$amount);  // get data for all orders according to years   
	        $allorders   = explode('~', $allorders);    // explode data of total count and months data
	        $totalOrders = $allorders[0];               // get count of records of orders
	        $allOrders   = $allorders[1];               // show all records on graph data 
	        $allcompletedOrders   = $this->GetAllCompletedOrders($year,$months,$status,$amount);  // get data for all orders according to years   
	        $allcompletedOrders   = explode('~', $allcompletedOrders);    // explode data of completed count and months data
	        $totalCompletdOrders  = $allcompletedOrders[0];               // get count of records of orders
	        $allCompletdOrders    = $allcompletedOrders[1];               // show all records on graph data
	        $allprocessingOrders   = $this->GetAllProcessingOrders($year,$months,$status,$amount);  // get data for all orders according to years   
	        $allprocessingOrders    = explode('~', $allprocessingOrders);    // explode data of processing count and months data
	        $totalProecssingOrders  = $allprocessingOrders[0];               // get count of records of orders
	        $allProecssingOrders    = $allprocessingOrders[1];               // show all records on graph data
	        $allcancelOrders    = $this->GetAllCancelOrders($year,$months,$status,$amount);  // get data for all orders according to years   
	        $allcancelOrders    = explode('~', $allcancelOrders);    // explode data of canceled count and months data
	        $totalCancelOrders  = $allcancelOrders[0];               // get count of records of orders
	        $allCancelOrders    = $allcancelOrders[1];               // show all records on graph data
    	}
    	$setting  = Settings::where(['user_id'=>Auth::user()->id,'setting_for'=>"orders"])->get()->toArray();
    	$settings = array();
	    foreach ($setting as $key => $value) {
	        $set[$value['name']] = $this->metavalue($value['name']);
	        $settings = $set;
	    }
	    $graph =  @$settings['graphType'];
	    if(empty($graph)){
	    	$graph = 'bar';
	    }else{
	    	$graph = $graph;
	    }
	    $totalorderscolor =  @$settings['totalcustomerscolor'];
	    if(empty($totalorderscolor)){
	    	$totalorderscolor = '#FF6384';
	    }else{
	    	$totalorderscolor = '#'.$totalorderscolor;
	    }
	    $completedorderscolor =  @$settings['activecustomerscolor'];
	    if(empty($completedorderscolor)){
	    	$completedorderscolor = '#36A2EB';
	    }else{
	    	$completedorderscolor = '#'.$completedorderscolor;
	    }
	    $processingorderscolor =  @$settings['nonactivecustomerscolor'];
	    if(empty($processingorderscolor)){
	    	$processingorderscolor = '#4BC0C0';
	    }else{
	    	$processingorderscolor = '#'.$processingorderscolor;
	    }
	    $canceledorderscolor =  @$settings['normalcustomerscolor'];
	    if(empty($canceledorderscolor)){
	    	$canceledorderscolor = '#FFCD56';
	    }else{
	    	$canceledorderscolor = '#'.$canceledorderscolor;
	    }


        return view('admin/magento_orders_graph',compact('year','status','months','totalOrders','allOrders','totalCompletdOrders','allCompletdOrders','totalProecssingOrders','allProecssingOrders','totalCancelOrders','allCancelOrders','graph','totalorderscolor','completedorderscolor','processingorderscolor','canceledorderscolor','amount','graphheading','totalorderlabel','completeorderlabel','processingorderlabel','canceledorderlabel'));
    }


    /**
     * Function to get the data according to filters
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllOrders($year,$months,$status,$amount)
    {
        $jan    = $this->ShowdataOnGraph(1,$year,$status,$amount);
        $feb    = $this->ShowdataOnGraph(2,$year,$status,$amount);
        $mar    = $this->ShowdataOnGraph(3,$year,$status,$amount);
        $apr    = $this->ShowdataOnGraph(4,$year,$status,$amount);
        $may    = $this->ShowdataOnGraph(5,$year,$status,$amount);
        $jun    = $this->ShowdataOnGraph(6,$year,$status,$amount);
        $jul    = $this->ShowdataOnGraph(7,$year,$status,$amount);
        $aug    = $this->ShowdataOnGraph(8,$year,$status,$amount);
        $sep    = $this->ShowdataOnGraph(9,$year,$status,$amount);
        $oct    = $this->ShowdataOnGraph(10,$year,$status,$amount);
        $nov    = $this->ShowdataOnGraph(11,$year,$status,$amount);
        $dec    = $this->ShowdataOnGraph(12,$year,$status,$amount);
        if($months == 1){
        	$totalCount = $jan;
        	$records = ''.$jan.',0,0,0,0,0,0,0,0,0,0,0';
        }elseif ($months == 2) {
        	$totalCount = $feb;
        	$records = '0,'.$feb.',0,0,0,0,0,0,0,0,0,0';
        }elseif ($months == 3) {
        	$totalCount = $mar;
        	$records = '0,0,'.$mar.',0,0,0,0,0,0,0,0,0';
        }elseif ($months == 4) {
        	$totalCount = $apr;
        	$records = '0,0,0,'.$apr.',0,0,0,0,0,0,0,0';
        }elseif ($months == 5) {
        	$totalCount = $may;
        	$records = '0,0,0,0,'.$may.',0,0,0,0,0,0,0';
        }elseif ($months == 6) {
        	$totalCount = $jun;
        	$records = '0,0,0,0,0,'.$jun.',0,0,0,0,0,0';
        }elseif ($months == 7) {
        	$totalCount = $jul;
        	$records = '0,0,0,0,0,0,'.$jul.',0,0,0,0,0';
        }elseif ($months == 8) {
        	$totalCount = $aug;
        	$records = '0,0,0,0,0,0,0,'.$aug.',0,0,0,0';
        }elseif ($months == 9) {
        	$totalCount = $sep;
        	$records = '0,0,0,0,0,0,0,0,'.$sep.',0,0,0';
        }elseif ($months == 10) {
        	$totalCount = $oct;
        	$records = '0,0,0,0,0,0,0,0,0,'.$oct.',0,0';
        }elseif ($months == 11) {
        	$totalCount = $nov;
        	$records = '0,0,0,0,0,0,0,0,0,0,'.$nov.',0';
        }elseif ($months == 12) {
        	$totalCount = $dec;
        	$records = '0,0,0,0,0,0,0,0,0,0,0,'.$dec.'';
        }else{
	        $totalCount = $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec;
	        $records = $jan.','.$feb.','.$mar.','.$apr.','.$may.','.$jun.','.$jul.','.$aug.','.$sep.','.$oct.','.$nov.','.$dec;
	    }
        return $totalCount.'~'.$records;
    }



    /**
     * count all data filtered according to months and year
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowdataOnGraph($month,$year,$status,$amount)
    {
        if($amount == '1'){
        	$query = Orders::where(['user_id'=>Auth::user()->id]);
        	if(!empty($status)){
        		$query = $query->where('status', $status);
        	}
        	$query = $query->whereMonth('m_created_at', $month)->whereYear('m_created_at', $year)->get()->count();
            return $query;
        }else{
            $query = Orders::where(['user_id'=>Auth::user()->id]);
            if(!empty($status)){
                $query = $query->where('status', $status);
            }
            $query = $query->select(DB::raw('SUM(grand_total) as total_sales'));
            $query = $query->whereMonth('m_created_at', $month)->whereYear('m_created_at', $year)->first();
            if(!empty($query)){
                  return $query['total_sales'];
               
            }else{
                return '0';
            }
        }
    }

    /**
     * Function to get the data according to filters
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllCompletedOrders($year,$months,$status,$amount)
    {
        $jan    = $this->CompletedOrders(1,$year,$status,$amount);
        $feb    = $this->CompletedOrders(2,$year,$status,$amount);
        $mar    = $this->CompletedOrders(3,$year,$status,$amount);
        $apr    = $this->CompletedOrders(4,$year,$status,$amount);
        $may    = $this->CompletedOrders(5,$year,$status,$amount);
        $jun    = $this->CompletedOrders(6,$year,$status,$amount);
        $jul    = $this->CompletedOrders(7,$year,$status,$amount);
        $aug    = $this->CompletedOrders(8,$year,$status,$amount);
        $sep    = $this->CompletedOrders(9,$year,$status,$amount);
        $oct    = $this->CompletedOrders(10,$year,$status,$amount);
        $nov    = $this->CompletedOrders(11,$year,$status,$amount);
        $dec    = $this->CompletedOrders(12,$year,$status,$amount);
        if($months == 1){
        	$totalCount = $jan;
        	$records = ''.$jan.',0,0,0,0,0,0,0,0,0,0,0';
        }elseif ($months == 2) {
        	$totalCount = $feb;
        	$records = '0,'.$feb.',0,0,0,0,0,0,0,0,0,0';
        }elseif ($months == 3) {
        	$totalCount = $mar;
        	$records = '0,0,'.$mar.',0,0,0,0,0,0,0,0,0';
        }elseif ($months == 4) {
        	$totalCount = $apr;
        	$records = '0,0,0,'.$apr.',0,0,0,0,0,0,0,0';
        }elseif ($months == 5) {
        	$totalCount = $may;
        	$records = '0,0,0,0,'.$may.',0,0,0,0,0,0,0';
        }elseif ($months == 6) {
        	$totalCount = $jun;
        	$records = '0,0,0,0,0,'.$jun.',0,0,0,0,0,0';
        }elseif ($months == 7) {
        	$totalCount = $jul;
        	$records = '0,0,0,0,0,0,'.$jul.',0,0,0,0,0';
        }elseif ($months == 8) {
        	$totalCount = $aug;
        	$records = '0,0,0,0,0,0,0,'.$aug.',0,0,0,0';
        }elseif ($months == 9) {
        	$totalCount = $sep;
        	$records = '0,0,0,0,0,0,0,0,'.$sep.',0,0,0';
        }elseif ($months == 10) {
        	$totalCount = $oct;
        	$records = '0,0,0,0,0,0,0,0,0,'.$oct.',0,0';
        }elseif ($months == 11) {
        	$totalCount = $nov;
        	$records = '0,0,0,0,0,0,0,0,0,0,'.$nov.',0';
        }elseif ($months == 12) {
        	$totalCount = $dec;
        	$records = '0,0,0,0,0,0,0,0,0,0,0,'.$dec.'';
        }else{
	        $totalCount = $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec;
	        $records = $jan.','.$feb.','.$mar.','.$apr.','.$may.','.$jun.','.$jul.','.$aug.','.$sep.','.$oct.','.$nov.','.$dec;
	    }
        return $totalCount.'~'.$records;
    }



    /**
     * count all data filtered according to months and year
     *
     * @return \Illuminate\Http\Response
     */
    public function CompletedOrders($month,$year,$status,$amount)
    {
        if($amount == '1'){
        	$query = Orders::where(['user_id'=>Auth::user()->id]);
        	if(!empty($status)){
        		$query = $query->where('status', $status);
        	}else{
        		$query = $query->where('status', 'complete');
        	}
        	$query = $query->whereMonth('m_created_at', $month)->whereYear('m_created_at', $year)->get()->count();
            return $query;
        }else{
            $query = Orders::where(['user_id'=>Auth::user()->id]);
            if(!empty($status)){
                $query = $query->where('status', $status);
            }else{
                $query = $query->where('status', 'complete');
            }
            $query = $query->select(DB::raw('SUM(grand_total) as total_sales'));
            $query = $query->whereMonth('m_created_at', $month)->whereYear('m_created_at', $year)->first();
            if(!empty($query)){
                  return $query['total_sales'];
               
            }else{
                return '0';
            }
        }
    }


    /**
     * Function to get the data according to filters
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllProcessingOrders($year,$months,$status,$amount)
    {
        $jan    = $this->ProcessingOrders(1,$year,$status,$amount);
        $feb    = $this->ProcessingOrders(2,$year,$status,$amount);
        $mar    = $this->ProcessingOrders(3,$year,$status,$amount);
        $apr    = $this->ProcessingOrders(4,$year,$status,$amount);
        $may    = $this->ProcessingOrders(5,$year,$status,$amount);
        $jun    = $this->ProcessingOrders(6,$year,$status,$amount);
        $jul    = $this->ProcessingOrders(7,$year,$status,$amount);
        $aug    = $this->ProcessingOrders(8,$year,$status,$amount);
        $sep    = $this->ProcessingOrders(9,$year,$status,$amount);
        $oct    = $this->ProcessingOrders(10,$year,$status,$amount);
        $nov    = $this->ProcessingOrders(11,$year,$status,$amount);
        $dec    = $this->ProcessingOrders(12,$year,$status,$amount);
        if($months == 1){
        	$totalCount = $jan;
        	$records = ''.$jan.',0,0,0,0,0,0,0,0,0,0,0';
        }elseif ($months == 2) {
        	$totalCount = $feb;
        	$records = '0,'.$feb.',0,0,0,0,0,0,0,0,0,0';
        }elseif ($months == 3) {
        	$totalCount = $mar;
        	$records = '0,0,'.$mar.',0,0,0,0,0,0,0,0,0';
        }elseif ($months == 4) {
        	$totalCount = $apr;
        	$records = '0,0,0,'.$apr.',0,0,0,0,0,0,0,0';
        }elseif ($months == 5) {
        	$totalCount = $may;
        	$records = '0,0,0,0,'.$may.',0,0,0,0,0,0,0';
        }elseif ($months == 6) {
        	$totalCount = $jun;
        	$records = '0,0,0,0,0,'.$jun.',0,0,0,0,0,0';
        }elseif ($months == 7) {
        	$totalCount = $jul;
        	$records = '0,0,0,0,0,0,'.$jul.',0,0,0,0,0';
        }elseif ($months == 8) {
        	$totalCount = $aug;
        	$records = '0,0,0,0,0,0,0,'.$aug.',0,0,0,0';
        }elseif ($months == 9) {
        	$totalCount = $sep;
        	$records = '0,0,0,0,0,0,0,0,'.$sep.',0,0,0';
        }elseif ($months == 10) {
        	$totalCount = $oct;
        	$records = '0,0,0,0,0,0,0,0,0,'.$oct.',0,0';
        }elseif ($months == 11) {
        	$totalCount = $nov;
        	$records = '0,0,0,0,0,0,0,0,0,0,'.$nov.',0';
        }elseif ($months == 12) {
        	$totalCount = $dec;
        	$records = '0,0,0,0,0,0,0,0,0,0,0,'.$dec.'';
        }else{
	        $totalCount = $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec;
	        $records = $jan.','.$feb.','.$mar.','.$apr.','.$may.','.$jun.','.$jul.','.$aug.','.$sep.','.$oct.','.$nov.','.$dec;
	    }
        return $totalCount.'~'.$records;
    }



    /**
     * count all data filtered according to months and year
     *
     * @return \Illuminate\Http\Response
     */
    public function ProcessingOrders($month,$year,$status,$amount)
    {
        if($amount =='1'){
        	$query = Orders::where(['user_id'=>Auth::user()->id]);
        	if(!empty($status)){
        		$query = $query->where('status', $status);
        	}else{
        		$query = $query->where('status', 'processing');
        	}
        	$query = $query->whereMonth('m_created_at', $month)->whereYear('m_created_at', $year)->get()->count();
            return $query;
        }else{
            $query = Orders::where(['user_id'=>Auth::user()->id]);
            if(!empty($status)){
                $query = $query->where('status', $status);
            }else{
                $query = $query->where('status', 'processing');
            }
            $query = $query->select(DB::raw('SUM(grand_total) as total_sales'));
            $query = $query->whereMonth('m_created_at', $month)->whereYear('m_created_at', $year)->first();
            if(!empty($query)){
                  return $query['total_sales'];
               
            }else{
                return '0';
            }
        }
    }



   	/**
     * Function to get the data according to filters
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllCancelOrders($year,$months,$status,$amount)
    {
        $jan    = $this->CancelOrders(1,$year,$status,$amount);
        $feb    = $this->CancelOrders(2,$year,$status,$amount);
        $mar    = $this->CancelOrders(3,$year,$status,$amount);
        $apr    = $this->CancelOrders(4,$year,$status,$amount);
        $may    = $this->CancelOrders(5,$year,$status,$amount);
        $jun    = $this->CancelOrders(6,$year,$status,$amount);
        $jul    = $this->CancelOrders(7,$year,$status,$amount);
        $aug    = $this->CancelOrders(8,$year,$status,$amount);
        $sep    = $this->CancelOrders(9,$year,$status,$amount);
        $oct    = $this->CancelOrders(10,$year,$status,$amount);
        $nov    = $this->CancelOrders(11,$year,$status,$amount);
        $dec    = $this->CancelOrders(12,$year,$status,$amount);
        if($months == 1){
        	$totalCount = $jan;
        	$records = ''.$jan.',0,0,0,0,0,0,0,0,0,0,0';
        }elseif ($months == 2) {
        	$totalCount = $feb;
        	$records = '0,'.$feb.',0,0,0,0,0,0,0,0,0,0';
        }elseif ($months == 3) {
        	$totalCount = $mar;
        	$records = '0,0,'.$mar.',0,0,0,0,0,0,0,0,0';
        }elseif ($months == 4) {
        	$totalCount = $apr;
        	$records = '0,0,0,'.$apr.',0,0,0,0,0,0,0,0';
        }elseif ($months == 5) {
        	$totalCount = $may;
        	$records = '0,0,0,0,'.$may.',0,0,0,0,0,0,0';
        }elseif ($months == 6) {
        	$totalCount = $jun;
        	$records = '0,0,0,0,0,'.$jun.',0,0,0,0,0,0';
        }elseif ($months == 7) {
        	$totalCount = $jul;
        	$records = '0,0,0,0,0,0,'.$jul.',0,0,0,0,0';
        }elseif ($months == 8) {
        	$totalCount = $aug;
        	$records = '0,0,0,0,0,0,0,'.$aug.',0,0,0,0';
        }elseif ($months == 9) {
        	$totalCount = $sep;
        	$records = '0,0,0,0,0,0,0,0,'.$sep.',0,0,0';
        }elseif ($months == 10) {
        	$totalCount = $oct;
        	$records = '0,0,0,0,0,0,0,0,0,'.$oct.',0,0';
        }elseif ($months == 11) {
        	$totalCount = $nov;
        	$records = '0,0,0,0,0,0,0,0,0,0,'.$nov.',0';
        }elseif ($months == 12) {
        	$totalCount = $dec;
        	$records = '0,0,0,0,0,0,0,0,0,0,0,'.$dec.'';
        }else{
	        $totalCount = $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec;
	        $records = $jan.','.$feb.','.$mar.','.$apr.','.$may.','.$jun.','.$jul.','.$aug.','.$sep.','.$oct.','.$nov.','.$dec;
	    }
        return $totalCount.'~'.$records;
    }



    /**
     * count all data filtered according to months and year
     *
     * @return \Illuminate\Http\Response
     */
    public function CancelOrders($month,$year,$status,$amount)
    {
        if($amount == '1'){
        	$query = Orders::where(['user_id'=>Auth::user()->id]);
        	if(!empty($status)){
        		$query = $query->where('status', $status);
        	}else{
        		$query = $query->where('status', 'canceled');
        	}
        	$query = $query->whereMonth('m_created_at', $month)->whereYear('m_created_at', $year)->get()->count();
            return $query;
        }else{
            $query = Orders::where(['user_id'=>Auth::user()->id]);
            if(!empty($status)){
                $query = $query->where('status', $status);
            }else{
                $query = $query->where('status', 'canceled');
            }
            $query = $query->select(DB::raw('SUM(grand_total) as total_sales'));
            $query = $query->whereMonth('m_created_at', $month)->whereYear('m_created_at', $year)->first();
            if(!empty($query)){
                  return $query['total_sales'];
               
            }else{
                return '0';
            }
        }
    }


    /**
     * Show the datatables accoding to filters.
     *
     * @return \Illuminate\Http\Response
     */
    public function MagentoOrdersTableAjax(Request $request)
    {
        $input    = $request->all();
        $year     = @$input['year'];
        $status   = @$input['status'];
        $months   = @$input['months'];
        if(!empty($year)){
            $year = $year;
        }else{
            $year = date('Y');
        } 
		$query = Orders::
				 select('customers.firstname','customers.lastname','customers.email','customers.telephone','orders.*')
				 ->where(['orders.user_id'=>Auth::user()->id])->join('customers', 'orders.customer_id', '=', 'customers.id');
        if(!empty($status)){
        	$query = $query->where('orders.status',$status);
        }
        if(!empty($months)){
        	$query = $query->whereMonth('orders.m_created_at', $months);
        }
        $data = $query->whereYear('orders.m_created_at', $year)->get()->toArray();
        if(!empty($data)){
           $array = array();
           foreach ($data as $key => $value) {
                $onclick = "onclick='ViewOrder(".$value['id'].")'";
                $link    = "<a id='modal-217243' href='#modal-container-217243' role='button' class='btn' data-toggle='modal' ".$onclick.">View Order</a>";
                $array[] =  '["'.$value['firstname'].' '.$value['lastname'].'<br>'.$value['email'].'<br>'.$value['telephone'].'","'.$value['tax_amount'].'","'.$value['discount_amount'].'","'.$value['quantity'].'","'.$value['ship_amount'].'","'.$value['sub_total'].'","'.$value['grand_total'].'","'.$value['status'].'","'.$value['m_created_at'].'","'.$link.'"]';
           }
           echo '{"data":[';
           echo implode( ',', $array);
           echo ']}';
        }else{
           echo '{"data":[';
           echo '["No orders found!","","","","","","","","",""]';
           echo ']}';
        }
       
        
    }


    
    /**
     * Show the customers settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderssettings()
    {
    	$setting = Settings::where(['user_id'=>Auth::user()->id,'setting_for'=>'orders'])->get()->toArray();
    	$settings = array();
	    foreach ($setting as $key => $value) {
	        $set[$value['name']] = $this->metavalue($value['name']);
	        $settings = $set;
	    }
    	return view('admin/orders-settings',compact('settings'));
    }


    /**
     * function to get meta data
     *
     * @return \Illuminate\Http\Response
     */
    function metavalue($name)  
    {
        return Settings::where(array('name' =>$name,'user_id'=>Auth::user()->id,'setting_for'=>'orders' ))->pluck('value')->first();
    }


    /**
     * function to update customers settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateorderssettings(Request $request)
    {
    	$input = $request->all();
		Settings::where(['user_id'=>Auth::user()->id,'setting_for'=>"orders"])->delete();
		foreach ($input as $key => $value) {
			if($key != '_token'){
				$data = array(
					'user_id'=>Auth::user()->id,
					'name'=>$key,
					'value'=>$value,
					'setting_for'=>'orders'
					 );
    			Settings::insert($data);
			}    			
		}
		return Redirect::back()->withErrors(['orders setting successfully added']);
    }



    
    /**
     * function to update customers settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function OrderView($id)
    {
        $getorder = Orders::
                    select('customers.firstname','customers.lastname','customers.email','customers.telephone','orders.*')
                    ->where(['orders.id'=>$id])->join('customers', 'orders.customer_id', '=', 'customers.id')->first();
        echo '<div class="p-b-2 clearfix">
                                  <div class="pull-right text-xs-right">
                                    <h5 class="bold m-b-0">
                                      Invoice #'.$getorder['id'].'
                                    </h5>
                                    <p class="m-b-0">
                                      Issued on '.$getorder['m_created_at'].'
                                    </p>
                                    <p class="m-b-0">
                                      Order Status';
                                      if($getorder['status'] == 'canceled'){
                                        echo '<div class="btn btn-danger"><strong>
                                        Canceled!</strong></div>';
                                      }elseif($getorder['status'] == 'complete'){
                                        echo '<div class="btn btn-success"><strong>
                                        Complete!</strong></div>';
                                      }elseif($getorder['status'] == 'processing'){
                                        echo '<div class="btn btn-warning"><strong>
                                        Proessing!</strong></div>';
                                      }else{
                                        echo '<div class="btn btn-info"><strong>
                                        '.$getorder['status'].'!</strong></div>';
                                      }
                         echo    '</p>
                                  </div>
                                 
                                  <div class="overflow-hidden">
                                    <h5 class="bold m-b-0">
                                      User Detail
                                    </h5>
                                    <p class="m-b-0">
                                     '.$getorder['firstname'].' '.$getorder['lastname'].' <br> '.$getorder['email'].' <br> 
                                     '.$getorder['billing_address'].'
                                    </p>
                                    <p class="m-b-0">
                                      '.$getorder['telephone'].'
                                    </p>
                                  </div>
                                </div>

                                <div class="table-responsive p-t-2 p-b-2">
                                  <table class="table table-bordered m-b-0">
                                    <thead>
                                      <tr>
                                        <th>
                                          Quantity
                                        </th>
                                        <th>
                                          Ship Amount
                                        </th>
                                        <th>
                                          Discount Amount
                                        </th>
                                        <th>
                                          Tax
                                        </th>
                                        <th>
                                          Sub Total
                                        </th>
                                        <th>
                                          Grand Total
                                        </th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                         '.$getorder['quantity'].'
                                        </td>
                                        <td>
                                          '.$getorder['ship_amount'].'
                                        </td>
                                        <td>
                                          '.$getorder['discount_amount'].'
                                        </td>
                                        <td>
                                          '.$getorder['tax_amount'].'
                                        </td>
                                        <td>
                                          '.$getorder['sub_total'].'
                                        </td>
                                        <td>
                                          '.$getorder['grand_total'].'
                                        </td>
                                      </tr>
                                      
                                    </tbody>
                                  </table>
                                </div>
                                <div class="invoice-totals p-t-2 p-b-2">
                                  <div class="invoice-totals-row">
                                    <strong class="invoice-totals-title">
                                      Subtotal
                                    </strong>
                                    <span class="invoice-totals-value">
                                      '.$getorder['sub_total'].'
                                    </span>
                                  </div>
                                 <div class="invoice-totals-row">
                                    <strong class="invoice-totals-title">
                                      Amount Paid
                                    </strong>
                                    <span class="invoice-totals-value">
                                     '.$getorder['grand_total'].'
                                    </span>
                                  </div>
                                 
                                </div>';
    }
    
}
