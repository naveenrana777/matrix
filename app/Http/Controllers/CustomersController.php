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

class CustomersController extends Controller
{
    /**
     * Show the application to show magento customer graph.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input 		= $request->all();
        $year 		= @$input['year'];
        $status 	= @$input['status'];
        $months 	= @$input['months'];
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
        $setting  = Settings::where(['user_id'=>Auth::user()->id,'setting_for'=>'customers'])->get()->toArray();
    	$settings = array();
	    foreach ($setting as $key => $value) {
	        $set[$value['name']] = $this->metavalue($value['name']);
	        $settings = $set;
	    }
	    $graphType =  @$settings['graphType'];
	    $active_customer_limit =  @$settings['active_customer_limit'];
	    if(empty($graphType)){
	    	$graphType = 'line';
	    }else{
	    	$graphType = $graphType;
	    }
	    if(empty($active_customer_limit)){
	    	$active_customer_limit = '2';
	    }else{
	    	$active_customer_limit = $active_customer_limit;
	    }
	    $totalcustomerscolor =  @$settings['totalcustomerscolor'];
	    if(empty($totalcustomerscolor)){
	    	$totalcustomerscolor = '#FF6384';
	    }else{
	    	$totalcustomerscolor = '#'.$totalcustomerscolor;
	    }
	    $activecustomerscolor =  @$settings['activecustomerscolor'];
	    if(empty($activecustomerscolor)){
	    	$activecustomerscolor = '#36A2EB';
	    }else{
	    	$activecustomerscolor = '#'.$activecustomerscolor;
	    }
	    $nonactivecustomerscolor =  @$settings['nonactivecustomerscolor'];
	    if(empty($nonactivecustomerscolor)){
	    	$nonactivecustomerscolor = '#4BC0C0';
	    }else{
	    	$nonactivecustomerscolor = '#'.$nonactivecustomerscolor;
	    }
	    $normalcustomerscolor =  @$settings['normalcustomerscolor'];
	    if(empty($normalcustomerscolor)){
	    	$normalcustomerscolor = '#FFCD56';
	    }else{
	    	$normalcustomerscolor = '#'.$normalcustomerscolor;
	    }
	    
    	if($status == '0'){
        	$totalCount     	 = '';       // get count of records of customers
        	$allrecords     	 = '';       // show all records on graph data 
        	$totalnonactivecount = '';       // get count of records of non active customers
	        $allNonActive        = '';       // show all records on graph data  of non active users
	        $totalnormalcount    = '';       // get count of records of normal customers
	        $allNormal           = '';       // show all records on graph data  of normal users
	        $allActiveUser 		 = $this->GetAllActiveCustomers($year,$active_customer_limit,$months);  //get all active users 
	        $allActiveUser  	 = explode('~', $allActiveUser);   // explode data of total count and months data
	        $activecount    	 = $allActiveUser[0];              // get count of records of active customers
	        $allActiveUser  	 = $allActiveUser[1];              // show all records on graph data of active users 
        }elseif ($status == '1') {
        	$totalCount     	 = '';       // get count of records of customers
        	$allrecords     	 = '';       // show all records on graph data 
        	$totalnonactivecount = '';       // get count of records of non active customers
	        $allNonActive        = '';       // show all records on graph data  of non active users
	        $totalnormalcount    = '';       // get count of records of normal customers
	        $allNormal           = '';       // show all records on graph data  of normal users
	        $activecount    	 = '';              // get count of records of active customers
	        $allActiveUser  	 = '';              // show all records on graph data of active users
	        $allNonActive 		 = $this->GetAllNonActiveCustomers($year,$months); //get all non active users 
	        $allNonActive        = explode('~', $allNonActive);    // explode data of total count and months data
	        $totalnonactivecount = $allNonActive[0];       // get count of records of non active customers
	        $allNonActive        = $allNonActive[1];       // show all records on graph data  of non active users
        }elseif ($status == '2') {
        	$totalCount     	 = '';       // get count of records of customers
        	$allrecords     	 = '';       // show all records on graph data 
        	$totalnonactivecount = '';       // get count of records of non active customers
	        $allNonActive        = '';       // show all records on graph data  of non active users
	        $activecount    	 = '';              // get count of records of active customers
	        $allActiveUser  	 = '';              // show all records on graph data of active users
	        $allNormal    		 = $this->GetAllNormalCustomers($year,$months); //get all normal users 
	        $allNormal           = explode('~', $allNormal);    // explode data of total count and months data
	        $totalnormalcount    = $allNormal[0];       // get count of records of normal customers
	        $allNormal           = $allNormal[1];       // show all records on graph data  of normal users
        }elseif ($status == '3') {
        	$totalCount     	 = '';       // get count of records of customers
        	$allrecords     	 = '';       // show all records on graph data 
        	$totalnonactivecount = '';       // get count of records of non active customers
	        $allNonActive        = '';       // show all records on graph data  of non active users
	        $activecount    	 = '';              // get count of records of active customers
	        $allActiveUser  	 = '';              // show all records on graph data of active users
	        $totalnormalcount    = '';       // get count of records of normal customers
	        $allNormal           = '';       // show all records on graph data  of normal users
	        $allcustomers 		 = $this->GetAllCustomers($year,$months);  // get data for all customers according to years   
	        $allcustomers   	 = explode('~', $allcustomers);    // explode data of total count and months data
	        $totalCount     	 = $allcustomers[0];               // get count of records of customers
	        $allrecords     	 = $allcustomers[1];               // show all records on graph data 
        }else{
        	$allcustomers 		 = $this->GetAllCustomers($year,$months);  // get data for all customers according to years   
	        $allcustomers   	 = explode('~', $allcustomers);    // explode data of total count and months data
	        $totalCount     	 = $allcustomers[0];               // get count of records of customers
	        $allrecords     	 = $allcustomers[1];               // show all records on graph data 
	        $allActiveUser 		 = $this->GetAllActiveCustomers($year,$active_customer_limit,$months);  //get all active users 
	        $allActiveUser  	 = explode('~', $allActiveUser);   // explode data of total count and months data
	        $activecount    	 = $allActiveUser[0];              // get count of records of active customers
	        $allActiveUser  	 = $allActiveUser[1];              // show all records on graph data of active users 
        	$allNonActive 		 = $this->GetAllNonActiveCustomers($year,$months); //get all non active users 
	        $allNonActive        = explode('~', $allNonActive);    // explode data of total count and months data
	        $totalnonactivecount = $allNonActive[0];       // get count of records of non active customers
	        $allNonActive        = $allNonActive[1];       // show all records on graph data  of non active users
	        $allNormal    		 = $this->GetAllNormalCustomers($year,$months); //get all normal users 
	        $allNormal           = explode('~', $allNormal);    // explode data of total count and months data
	        $totalnormalcount    = $allNormal[0];       // get count of records of normal customers
	        $allNormal           = $allNormal[1];       // show all records on graph data  of normal users
        }
        return view('admin/magento_users_graph',compact('allrecords','totalCount','year','status','months','allActiveUser','activecount','allNonActive','totalnonactivecount','allNormal','totalnormalcount','settings','graphType','totalcustomerscolor','activecustomerscolor','nonactivecustomerscolor','normalcustomerscolor','active_customer_limit'));
    }



    /**
     * Function to get the data according to filters
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllCustomers($year,$months)
    {
        $jan    = $this->ShowdataOnGraph(1,$year);
        $feb    = $this->ShowdataOnGraph(2,$year);
        $mar    = $this->ShowdataOnGraph(3,$year);
        $apr    = $this->ShowdataOnGraph(4,$year);
        $may    = $this->ShowdataOnGraph(5,$year);
        $jun    = $this->ShowdataOnGraph(6,$year);
        $jul    = $this->ShowdataOnGraph(7,$year);
        $aug    = $this->ShowdataOnGraph(8,$year);
        $sep    = $this->ShowdataOnGraph(9,$year);
        $oct    = $this->ShowdataOnGraph(10,$year);
        $nov    = $this->ShowdataOnGraph(11,$year);
        $dec    = $this->ShowdataOnGraph(12,$year);
        if($months == 1){
        	$totalCount = $jan;
        	$records = ''.$jan.',,,,,,,,,,,';
        }elseif ($months == 2) {
        	$totalCount = $feb;
        	$records = ','.$feb.',,,,,,,,,,';
        }elseif ($months == 3) {
        	$totalCount = $mar;
        	$records = ',,'.$mar.',,,,,,,,,';
        }elseif ($months == 4) {
        	$totalCount = $apr;
        	$records = ',,,'.$apr.',,,,,,,,';
        }elseif ($months == 5) {
        	$totalCount = $may;
        	$records = ',,,,'.$may.',,,,,,,';
        }elseif ($months == 6) {
        	$totalCount = $jun;
        	$records = ',,,,,'.$jun.',,,,,,';
        }elseif ($months == 7) {
        	$totalCount = $jul;
        	$records = ',,,,,,'.$jul.',,,,,';
        }elseif ($months == 8) {
        	$totalCount = $aug;
        	$records = ',,,,,,,'.$aug.',,,,,';
        }elseif ($months == 9) {
        	$totalCount = $sep;
        	$records = ',,,,,,,,'.$sep.',,,,';
        }elseif ($months == 10) {
        	$totalCount = $oct;
        	$records = ',,,,,,,,,'.$oct.',,,';
        }elseif ($months == 11) {
        	$totalCount = $nov;
        	$records = ',,,,,,,,,,'.$nov.',,';
        }elseif ($months == 12) {
        	$totalCount = $dec;
        	$records = ',,,,,,,,,,,'.$dec.',';
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
    public function ShowdataOnGraph($month,$year)
    {
    	return Customers::
                whereMonth('m_created_at', $month)
                ->where(['user_id'=>Auth::user()->id])
                ->whereYear('m_created_at', $year)
                ->get()->count();
    }


    /**
     * Show the application to get count of data according to year.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllActiveCustomers($year,$active_customer_limit,$months)
    {
        $jan    = $this->CountActiveCustomerts(1,$year,$active_customer_limit);
        $feb    = $this->CountActiveCustomerts(2,$year,$active_customer_limit);
        $mar    = $this->CountActiveCustomerts(3,$year,$active_customer_limit);
        $apr    = $this->CountActiveCustomerts(4,$year,$active_customer_limit);
        $may    = $this->CountActiveCustomerts(5,$year,$active_customer_limit);
        $jun    = $this->CountActiveCustomerts(6,$year,$active_customer_limit);
        $jul    = $this->CountActiveCustomerts(7,$year,$active_customer_limit);
        $aug    = $this->CountActiveCustomerts(8,$year,$active_customer_limit);
        $sep    = $this->CountActiveCustomerts(9,$year,$active_customer_limit);
        $oct    = $this->CountActiveCustomerts(10,$year,$active_customer_limit);
        $nov    = $this->CountActiveCustomerts(11,$year,$active_customer_limit);
        $dec    = $this->CountActiveCustomerts(12,$year,$active_customer_limit);
        if($months == 1){
        	$totalCount = $jan;
        	$records = ''.$jan.',,,,,,,,,,,';
        }elseif ($months == 2) {
        	$totalCount = $feb;
        	$records = ','.$feb.',,,,,,,,,,';
        }elseif ($months == 3) {
        	$totalCount = $mar;
        	$records = ',,'.$mar.',,,,,,,,,';
        }elseif ($months == 4) {
        	$totalCount = $apr;
        	$records = ',,,'.$apr.',,,,,,,,';
        }elseif ($months == 5) {
        	$totalCount = $may;
        	$records = ',,,,'.$may.',,,,,,,';
        }elseif ($months == 6) {
        	$totalCount = $jun;
        	$records = ',,,,,'.$jun.',,,,,,';
        }elseif ($months == 7) {
        	$totalCount = $jul;
        	$records = ',,,,,,'.$jul.',,,,,';
        }elseif ($months == 8) {
        	$totalCount = $aug;
        	$records = ',,,,,,,'.$aug.',,,,,';
        }elseif ($months == 9) {
        	$totalCount = $sep;
        	$records = ',,,,,,,,'.$sep.',,,,';
        }elseif ($months == 10) {
        	$totalCount = $oct;
        	$records = ',,,,,,,,,'.$oct.',,,';
        }elseif ($months == 11) {
        	$totalCount = $nov;
        	$records = ',,,,,,,,,,'.$nov.',,';
        }elseif ($months == 12) {
        	$totalCount = $dec;
        	$records = ',,,,,,,,,,,'.$dec.',';
        }else{
	        $totalCount = $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec;
	        $records = $jan.','.$feb.','.$mar.','.$apr.','.$may.','.$jun.','.$jul.','.$aug.','.$sep.','.$oct.','.$nov.','.$dec;
	    }
        return $totalCount.'~'.$records;
    }


    /**
     * count all active customers data
     *
     * @return \Illuminate\Http\Response
     */
    public function CountActiveCustomerts($month,$year,$active_customer_limit)
    {
    	return Customers::
    	select(DB::raw('COUNT(*) as activeusers'))
	    ->whereIn('id', DB::table('orders')->pluck('customer_id'))
	    ->having('activeusers', '>=' , $active_customer_limit)
	    ->where(['user_id'=>Auth::user()->id])
	    ->whereMonth('m_created_at', $month)
        ->whereYear('m_created_at', $year)
	    ->get()->count();
    }



    /**
     * count all non active customers data
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllNonActiveCustomers($year,$months)
    {
        $jan    = $this->CountNonActiveCustomerts(1,$year);
        $feb    = $this->CountNonActiveCustomerts(2,$year);
        $mar    = $this->CountNonActiveCustomerts(3,$year);
        $apr    = $this->CountNonActiveCustomerts(4,$year);
        $may    = $this->CountNonActiveCustomerts(5,$year);
        $jun    = $this->CountNonActiveCustomerts(6,$year);
        $jul    = $this->CountNonActiveCustomerts(7,$year);
        $aug    = $this->CountNonActiveCustomerts(8,$year);
        $sep    = $this->CountNonActiveCustomerts(9,$year);
        $oct    = $this->CountNonActiveCustomerts(10,$year);
        $nov    = $this->CountNonActiveCustomerts(11,$year);
        $dec    = $this->CountNonActiveCustomerts(12,$year);
        if($months == 1){
        	$totalCount = $jan;
        	$records = ''.$jan.',,,,,,,,,,,';
        }elseif ($months == 2) {
        	$totalCount = $feb;
        	$records = ','.$feb.',,,,,,,,,,';
        }elseif ($months == 3) {
        	$totalCount = $mar;
        	$records = ',,'.$mar.',,,,,,,,,';
        }elseif ($months == 4) {
        	$totalCount = $apr;
        	$records = ',,,'.$apr.',,,,,,,,';
        }elseif ($months == 5) {
        	$totalCount = $may;
        	$records = ',,,,'.$may.',,,,,,,';
        }elseif ($months == 6) {
        	$totalCount = $jun;
        	$records = ',,,,,'.$jun.',,,,,,';
        }elseif ($months == 7) {
        	$totalCount = $jul;
        	$records = ',,,,,,'.$jul.',,,,,';
        }elseif ($months == 8) {
        	$totalCount = $aug;
        	$records = ',,,,,,,'.$aug.',,,,,';
        }elseif ($months == 9) {
        	$totalCount = $sep;
        	$records = ',,,,,,,,'.$sep.',,,,';
        }elseif ($months == 10) {
        	$totalCount = $oct;
        	$records = ',,,,,,,,,'.$oct.',,,';
        }elseif ($months == 11) {
        	$totalCount = $nov;
        	$records = ',,,,,,,,,,'.$nov.',,';
        }elseif ($months == 12) {
        	$totalCount = $dec;
        	$records = ',,,,,,,,,,,'.$dec.',';
        }else{
	        $totalCount = $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec;
	        $records = $jan.','.$feb.','.$mar.','.$apr.','.$may.','.$jun.','.$jul.','.$aug.','.$sep.','.$oct.','.$nov.','.$dec;
	    }
        return $totalCount.'~'.$records;        
    }

    

    /**
     * count all non active customers data
     *
     * @return \Illuminate\Http\Response
     */
    public function CountNonActiveCustomerts($month,$year)
    {
	  	return Customers::
	  	whereNotIn('id', DB::table('orders')->pluck('customer_id'))
	  	->where(['user_id'=>Auth::user()->id])
	    ->whereMonth('m_created_at', $month)
        ->whereYear('m_created_at', $year)
	    ->get()->count();
    }


    
     /**
     * count all normal customers data
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllNormalCustomers($year,$months)
    {
        $jan    = $this->CountNormalCustomerts(1,$year);
        $feb    = $this->CountNormalCustomerts(2,$year);
        $mar    = $this->CountNormalCustomerts(3,$year);
        $apr    = $this->CountNormalCustomerts(4,$year);
        $may    = $this->CountNormalCustomerts(5,$year);
        $jun    = $this->CountNormalCustomerts(6,$year);
        $jul    = $this->CountNormalCustomerts(7,$year);
        $aug    = $this->CountNormalCustomerts(8,$year);
        $sep    = $this->CountNormalCustomerts(9,$year);
        $oct    = $this->CountNormalCustomerts(10,$year);
        $nov    = $this->CountNormalCustomerts(11,$year);
        $dec    = $this->CountNormalCustomerts(12,$year);
        if($months == 1){
        	$totalCount = $jan;
        	$records = ''.$jan.',,,,,,,,,,,';
        }elseif ($months == 2) {
        	$totalCount = $feb;
        	$records = ','.$feb.',,,,,,,,,,';
        }elseif ($months == 3) {
        	$totalCount = $mar;
        	$records = ',,'.$mar.',,,,,,,,,';
        }elseif ($months == 4) {
        	$totalCount = $apr;
        	$records = ',,,'.$apr.',,,,,,,,';
        }elseif ($months == 5) {
        	$totalCount = $may;
        	$records = ',,,,'.$may.',,,,,,,';
        }elseif ($months == 6) {
        	$totalCount = $jun;
        	$records = ',,,,,'.$jun.',,,,,,';
        }elseif ($months == 7) {
        	$totalCount = $jul;
        	$records = ',,,,,,'.$jul.',,,,,';
        }elseif ($months == 8) {
        	$totalCount = $aug;
        	$records = ',,,,,,,'.$aug.',,,,,';
        }elseif ($months == 9) {
        	$totalCount = $sep;
        	$records = ',,,,,,,,'.$sep.',,,,';
        }elseif ($months == 10) {
        	$totalCount = $oct;
        	$records = ',,,,,,,,,'.$oct.',,,';
        }elseif ($months == 11) {
        	$totalCount = $nov;
        	$records = ',,,,,,,,,,'.$nov.',,';
        }elseif ($months == 12) {
        	$totalCount = $dec;
        	$records = ',,,,,,,,,,,'.$dec.',';
        }else{
	        $totalCount = $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec;
	        $records = $jan.','.$feb.','.$mar.','.$apr.','.$may.','.$jun.','.$jul.','.$aug.','.$sep.','.$oct.','.$nov.','.$dec;
	    }
        return $totalCount.'~'.$records;       
    }



    /**
     * count all normal customers data
     *
     * @return \Illuminate\Http\Response
     */
    public function CountNormalCustomerts($month,$year)
    {
	  	return Customers::
    	select(DB::raw('COUNT(*) as activeusers'))
	    ->whereIn('id', DB::table('orders')->pluck('customer_id'))
	    //->groupBy('customer_id')
	    ->having('activeusers', '>=' , 1)
	    ->where(['user_id'=>Auth::user()->id])
	    ->whereMonth('m_created_at', $month)
        ->whereYear('m_created_at', $year)
	    ->get()->count();
    }


    /**
     * Show the datatables accoding to filters.
     *
     * @return \Illuminate\Http\Response
     */
    public function MagentoCustomersTableAjax(Request $request)
    {
        $input    = $request->all();
        $year     = @$input['year'];
        $status   = @$input['status'];
        $limit    = @$input['active_customer_limit'];
        $months   = @$input['months'];
        if(!empty($year)){
            $year = $year;
        }else{
            $year = date('Y');
        }  
        if($status == '0'){
        	$ids   = $this->GetAllStatusIds('0',$year,$limit);
        	if($ids != '0'){
        		if(!empty($months)){
	        		$data  = Customers::
	                where(['user_id'=>Auth::user()->id])
	                ->whereIn('id', $ids)                
	                ->whereYear('m_created_at', $year)
	                ->whereMonth('m_created_at', $months)
	                ->get()->toArray();
	            }else{
	            	$data  = Customers::
	                where(['user_id'=>Auth::user()->id])
	                ->whereIn('id', $ids)                
	                ->whereYear('m_created_at', $year)
	                ->get()->toArray();
	            }
            }
    	}elseif ($status == '1') {
    		$ids  = $this->GetAllStatusIds('1',$year,'');
    		if($ids != '0'){
    			if(!empty($months)){
        		$data = Customers::
                where(['user_id'=>Auth::user()->id])
                ->whereIn('id', $ids)                
                ->whereYear('m_created_at', $year)
                ->whereMonth('m_created_at', $months)
                ->get()->toArray();
            	}else{
            		$data = Customers::
	                where(['user_id'=>Auth::user()->id])
	                ->whereIn('id', $ids)                
	                ->whereYear('m_created_at', $year)
	                ->get()->toArray();
            	}
            }
    	}elseif ($status == '2') {
    		$ids  = $this->GetAllStatusIds('2',$year,'');
    		if($ids != '0'){
    			if(!empty($months)){
	        		$data = Customers::
	                where(['user_id'=>Auth::user()->id])
	                ->whereIn('id', $ids)                
	                ->whereYear('m_created_at', $year)
	                ->whereMonth('m_created_at', $months)
	                ->get()->toArray();
	            }else{
	            	$data = Customers::
	                where(['user_id'=>Auth::user()->id])
	                ->whereIn('id', $ids)                
	                ->whereYear('m_created_at', $year)
	                ->get()->toArray();
	            }
            }
    	}elseif ($status == '3') {
    		$ids  = $this->GetAllStatusIds('3',$year,'');
    		if($ids != '0'){
    			if(!empty($months)){
    				$data = Customers::
	                where(['user_id'=>Auth::user()->id])
	                ->whereIn('id', $ids)                
	                ->whereYear('m_created_at', $year)
	                ->whereMonth('m_created_at', $months)
	                ->get()->toArray();
    			}else{
	        		$data = Customers::
	                where(['user_id'=>Auth::user()->id])
	                ->whereIn('id', $ids)                
	                ->whereYear('m_created_at', $year)
	                ->get()->toArray();
            	}
            }
    	}else{
    		$data = Customers::
                where(['user_id'=>Auth::user()->id])
                ->whereYear('m_created_at', $year)
                ->get()->toArray();
    	}
              
        
        
        if(!empty($data)){
           $array = array();
           foreach ($data as $key => $value) {
                $array[] =  '["'.$value['firstname'].' '.$value['lastname'].'","'.$value['email'].'","'.$value['addresses'].'","'.$value['city'].'","'.$value['country'].'","'.$value['postcode'].'","'.$value['region'].'","'.$value['telephone'].'","'.$value['m_created_at'].'"]';
           }
           echo '{"data":[';
           echo implode( ',', $array);
           echo ']}';
        }else{
           echo '{"data":[';
           echo '["No customers found!","","","","","","","",""]';
           echo ']}';
        }
       
        
    }


    
    /**
     * count all normal customers data
     *
     * @return \Illuminate\Http\Response
     */
    public function GetAllStatusIds($status,$year,$active_customer_limit)
    {
    	if($status == '0'){
		  	$data =  Customers::
	    	select('customer_id',DB::raw('COUNT(*) as activeusers'))
		    ->whereIn('id', DB::table('orders')->pluck('customer_id'))
		    ->having('activeusers', '>=' , $active_customer_limit)
		    ->where(['user_id'=>Auth::user()->id])
	        ->whereYear('m_created_at', $year)
		    ->get()->toArray();
		    if(!empty($data)){
		    	$ids = array(); 
		    	foreach ($data as $key => $value) {
		    		$ids[] = $value['customer_id'];
		    	}
		    	return $ids;
		    }else{
		    	return '0';
		    }
		}elseif ($status == '1') {
			$data =  Customers::
			select('customer_id')
		  	->whereNotIn('id', DB::table('orders')->pluck('customer_id'))
		  	->where(['user_id'=>Auth::user()->id])
	        ->whereYear('m_created_at', $year)
		    ->get()->toArray();
		    if(!empty($data)){
		    	$ids = array(); 
		    	foreach ($data as $key => $value) {
		    		$ids[] = $value['customer_id'];
		    	}
		    	return $ids;
		    }else{
		    	return '0';
		    }
		}elseif ($status == '2') {
			$data =  Customers::
	    	select('customer_id')
	    	->whereIn('id', DB::table('orders')->pluck('customer_id'))
	    	->where(['user_id'=>Auth::user()->id])
	        ->whereYear('m_created_at', $year)
		    ->get()->toArray();
		    if(!empty($data)){
		    	$ids = array(); 
		    	foreach ($data as $key => $value) {
		    		$ids[] = $value['customer_id'];
		    	}
		    	return $ids;
		    }else{
		    	return '0';
		    }
		}
		elseif ($status == '3') {
			$data =  Customers::
				select('id')
                ->where(['user_id'=>Auth::user()->id])
                ->whereYear('m_created_at', $year)
                ->get()->toArray();
		    if(!empty($data)){
		    	$ids = array(); 
		    	foreach ($data as $key => $value) {
		    		$ids[] = $value['id'];
		    	}
		    	return $ids;
		    }else{
		    	return '0';
		    }
		}
    }



    
    /**
     * Show the customers settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function customerssettings()
    {
    	$setting = Settings::where(['user_id'=>Auth::user()->id,'setting_for'=>'customers'])->get()->toArray();
    	$settings = array();
	    foreach ($setting as $key => $value) {
	        $set[$value['name']] = $this->metavalue($value['name']);
	        $settings = $set;
	    }
    	return view('admin/customer-settings',compact('settings'));
    }


    /**
     * function to get meta data
     *
     * @return \Illuminate\Http\Response
     */
    function metavalue($name)
    {
        return Settings::where(array('name' =>$name,'user_id'=>Auth::user()->id,'setting_for'=>'customers' ))->pluck('value')->first();
    }


    /**
     * function to update customers settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatecustomerssettings(Request $request)
    {
    	$input = $request->all();
		Settings::where(['user_id'=>Auth::user()->id,'setting_for'=>"customers"])->delete();
		foreach ($input as $key => $value) {
			if($key != '_token'){
				$data = array(
					'user_id'=>Auth::user()->id,
					'name'=>$key,
					'value'=>$value,
                    'setting_for'=>'customers'
					 );
    			Settings::insert($data);
			}    			
		}
		return Redirect::back()->withErrors(['customers setting successfully added']);
    }
    
}
