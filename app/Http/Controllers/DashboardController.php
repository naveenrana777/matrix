<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Category;
use App\Customers;
use App\Orders;
use App\Products;
use App\LastSync;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class DashboardController extends Controller
{

    /**
     * Show the application to sync magento data.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $last_sync = LastSync::where(['user_id'=>Auth::user()->id])->get()->last();
        $timeago = '';
        if(!empty($last_sync)){
            $curenttime=$last_sync->created_at;
            $timeago =  $this->time_elapsed_string($curenttime);
        }    
        return view('admin/syncdata',compact('timeago'));
    }



    /**
     * Show the application to convert date into fb time standard.
     *
     * @return \Illuminate\Http\Response
     */
    public function time_elapsed_string($datetime, $full = false) 
    {
        date_default_timezone_set('Asia/Kolkata');
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }


    /**
     * Show the application to show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $last_sync = LastSync::where(['user_id'=>Auth::user()->id])->get()->last();
        $timeago = '';
        if(!empty($last_sync)){
            $curenttime=$last_sync->created_at;
            $timeago =  $this->time_elapsed_string($curenttime);
        }   
        $categoryCount  = Category::get()->count();
        $customersCount = Customers::get()->count();
        $ordersCount    = Orders::get()->count();
        $productsCount  = Products::get()->count();
        return view('admin/dashboard',compact('categoryCount','customersCount','ordersCount','productsCount','timeago'));
    }


    /**
     * Show the application to show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function editprofile()
    {
    	$user = User::where(['id'=>Auth::user()->id])->first();
        return view('admin/profile',compact('user'));
    }
    

    /**
     * Show the application to show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateprofile(Request $request)
    {
       $input = $request->all();
       $data =  array(
	            'firstname' 	=> $input['firstname'],
	            'lastname'  	=> $input['lastname'],
	            'email'     	=> $input['email'],
	            'address'   	=> $input['address'],
	            'phone' 		=> $input['phone'],
	            'membership' 	=> $input['membership']
	        );
       User::where(['id'=>Auth::user()->id])->update($data);
       return Redirect::back()->withErrors(['User updated successfully!']);
    }



    /**
     * Show the application to show magento customer graph.
     *
     * @return \Illuminate\Http\Response
     */
    public function MagentoCustomersGraph(Request $request)
    {
        $input = $request->all();
        $year 	= @$input['year'];
        if(!empty($year))
        {
            $year = $year;
        }else{
            $year = date('Y');
        }
    	$jan 	= $this->ShowdataOnGraph(1,$year,'customers');
    	$feb 	= $this->ShowdataOnGraph(2,$year,'customers');
    	$mar 	= $this->ShowdataOnGraph(3,$year,'customers');
    	$apr 	= $this->ShowdataOnGraph(4,$year,'customers');
    	$may 	= $this->ShowdataOnGraph(5,$year,'customers');
    	$jun 	= $this->ShowdataOnGraph(6,$year,'customers');
    	$jul 	= $this->ShowdataOnGraph(7,$year,'customers');
    	$aug 	= $this->ShowdataOnGraph(8,$year,'customers');
    	$sep 	= $this->ShowdataOnGraph(9,$year,'customers');
    	$oct 	= $this->ShowdataOnGraph(10,$year,'customers');
    	$nov 	= $this->ShowdataOnGraph(11,$year,'customers');
    	$dec 	= $this->ShowdataOnGraph(12,$year,'customers');
    	$allrecords 	= $jan.','.$feb.','.$mar.','.$apr.','.$may.','.$jun.','.$jul.','.$aug.','.$sep.','.$oct.','.$nov.','.$dec;
        $totalCount     = $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec;
    	//echo $allActiveUser 	= Orders::get()->count();
        //die;
    	$totalNonActive = Customers::get()->count();
    	$totalRegular 	= Customers::get()->count();
        return view('admin/magento_users_graph',compact('allrecords','totalCount','year'));
    }

    
    /**
     * Show the application to get count of data according to month and year.
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowdataOnGraph($month,$year,$table)
    {
    	if($table == 'customers')
    	{
    		return Customers::
                whereMonth('m_created_at', $month)
                ->whereYear('m_created_at', $year)
                ->get()->count();
    	}
    	
    }



    public function MagentoCustomersTableAjax(Request $request)
    {
        $input   = $request->all();
        $year    = @$input['year'];
        $month   = @$input['month'];
        if(!empty($year))
        {
            $year = $year;
            $data = Customers::
                where(['user_id'=>Auth::user()->id])
                ->whereYear('m_created_at', $year)
                ->get()->toArray();
        }else{
            $year = date('Y');
            $data = Customers::
                where(['user_id'=>Auth::user()->id])
                ->whereYear('m_created_at', $year)
                ->get()->toArray();
        }
        if(!empty($month))
        {
            $month = $month;
            $data = Customers::
                where(['user_id'=>Auth::user()->id])
                ->whereYear('m_created_at', $year)
                ->whereMonth('m_created_at', $month)
                ->get()->toArray();
        }

        if(!empty($data))
        {
           $array = array();
           foreach ($data as $key => $value) 
           {
                $array[] =  '["'.$value['firstname'].' '.$value['lastname'].'","'.$value['email'].'","'.$value['addresses'].'","'.$value['telephone'].'","'.$value['m_created_at'].'","'.$value['created_at'].'"]';
           }
           echo '{"data":[';
           echo implode( ',', $array);
           echo ']}';
        }
        else
        {
           echo '{"data":[';
           echo '["No customers found!","","","","",""]';
           echo ']}';
        }
       
        
    }
}
