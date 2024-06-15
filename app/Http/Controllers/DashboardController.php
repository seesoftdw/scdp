<?php

namespace App\Http\Controllers;
use Session;
use App\Models\Component;
use App\Models\User;
use App\Models\Finyear;
use App\Models\District;
use App\Models\Service; 
use App\Models\Sector;
use App\Models\Subsector;
use App\Models\Department;
use App\Models\Scheme_master;
use App\Models\Constituency;
use App\Models\Plan;
use App\Models\Soe_master;
use App\Models\Majorhead;
use App\Models\Soe_budget_allocation;
use App\Models\Soe_budget_distribution;
use App\Helper\Tokenable;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){

        if(auth()->user()->role_id === 1) {
            $Department = Department::orderBy('id', 'ASC')->get();
        } else {
            $Department = Department::where("id", auth()->user()->department_id)
            ->orderBy('id', 'ASC')->get();
        }
                
        return view('dashboard')->with('Department',$Department); 

    }
     public function get_chart_data(Request $request){
 
         $scheme_id=$request->scheme_id;
    
         $Soe_budget_distribution=Soe_budget_distribution::where("scheme_id", $scheme_id)->first();
         if($Soe_budget_distribution){
             $data=json_decode($Soe_budget_distribution->data);
            $distt=[];
             foreach((array)$data->outlay as $key=>$value){
                   
                    $distt[$key]=Tokenable::get_distt($key);
             }

             $data->district=$distt;
             echo json_encode(['status'=>1,'data'=>$data]);

         }else{

              echo json_encode(['status'=>0,'data'=>[]]);
         }
         


     }
     public function get_majorheads_data(Request $request){

      
            $schememaster= Majorhead::where('department_id',$request->department_id)->orderBy('id', 'DESC')->get();
            $Soe_budget_distribution= Soe_budget_distribution::where('department_id',$request->department_id)->where("fin_year_id",Session::get('finyear'))->get();

            //print_r($Soe_budget_distribution);

            $district=[];
            $achievement=[];
            $ben_total=[];
            $disable=[];
            $expenditure=[];
            $unit=[];
            $women=[];
             $outlay=[];
            
            
         

            if(sizeof($Soe_budget_distribution)>0){

                $status=1;
            }else{
                $status=0;
            }
            foreach($Soe_budget_distribution as $k=>  $value){
                     $value=json_decode($value->data);
                //print_r($value);
                 foreach((array)$value->outlay as $key=>$val){
                        if($k==0){
                        $achievement[$key]=0;
                        $ben_total[$key]=0;
                        $disable[$key]=0;
                        $expenditure[$key]=0;
                        $unit[$key]=0;
                        $women[$key]=0;
                        $outlay[$key]=0;
                        }
                        
                        $district[$key]=Tokenable::get_distt($key);

                        $achievement[$key]=$achievement[$key]+$value->achievement->$key;
                        $ben_total[$key]=$ben_total[$key]+$value->ben_total->$key;
                        $disable[$key]=$disable[$key]+$value->disable->$key;
                        $expenditure[$key]=$expenditure[$key]+$value->expenditure->$key;
                        $unit[$key]=$unit[$key]+$value->unit->$key;
                        $women[$key]=$women[$key]+$value->women->$key;
                        $outlay[$key]=$outlay[$key]+$value->outlay->$key;

                 }
                 
            }

            $data['district']=$district;
            $data['achievement']=$achievement;
            $data['ben_total']=$ben_total;
            $data['disable']=$disable;
            $data['expenditure']=$expenditure;
            $data['unit']=$unit;
            $data['women']=$women;
            $data['outlay']=$outlay;
            
         //print_r($data);die;
        echo json_encode(['schememaster'=>$schememaster,'data'=>$data,'status'=>$status]);
     }
    public function get_scheme_data(Request $request){

       
    $schememaster= Scheme_master::where('majorhead_id',$request->majorhead_id)->orderBy('id', 'DESC')->get();
       

         $Soe_budget_distribution= Soe_budget_distribution::where('majorhead_id',$request->majorhead_id)->where("fin_year_id",Session::get('finyear'))->get();

            //print_r($Soe_budget_distribution);

            $district=[];
            $achievement=[];
            $ben_total=[];
            $disable=[];
            $expenditure=[];
            $unit=[];
            $women=[];
             $outlay=[];
            
            
         

            if(sizeof($Soe_budget_distribution)>0){

                $status=1;
            }else{
                $status=0;
            }
            foreach($Soe_budget_distribution as $k=>  $value){
                     $value=json_decode($value->data);
                //print_r($value);
                 foreach((array)$value->outlay as $key=>$val){
                        if($k==0){
                        $achievement[$key]=0;
                        $ben_total[$key]=0;
                        $disable[$key]=0;
                        $expenditure[$key]=0;
                        $unit[$key]=0;
                        $women[$key]=0;
                        $outlay[$key]=0;
                        }
                        
                        $district[$key]=Tokenable::get_distt($key);

                        $achievement[$key]=$achievement[$key]+$value->achievement->$key;
                        $ben_total[$key]=$ben_total[$key]+$value->ben_total->$key;
                        $disable[$key]=$disable[$key]+$value->disable->$key;
                        $expenditure[$key]=$expenditure[$key]+$value->expenditure->$key;
                        $unit[$key]=$unit[$key]+$value->unit->$key;
                        $women[$key]=$women[$key]+$value->women->$key;
                        $outlay[$key]=$outlay[$key]+$value->outlay->$key;

                 }
                 
            }

            $data['district']=$district;
            $data['achievement']=$achievement;
            $data['ben_total']=$ben_total;
            $data['disable']=$disable;
            $data['expenditure']=$expenditure;
            $data['unit']=$unit;
            $data['women']=$women;
            $data['outlay']=$outlay;
            
         //print_r($data);die;
        echo json_encode(['schememaster'=>$schememaster,'data'=>$data,'status'=>$status]);

     }
    public function get_data_count(){

         if(auth()->user()->role_id === 1) {
        $users = User::count();
        $components = Component::count();
        $finyears = Finyear::count();
        $districts = District::count();
        $services= Service::count();
        $sectors = Sector::count();
        $subsectors = Subsector::count();
        $departments = Department::count();
        $scheme = Scheme_master::count();
        $consitituency = Constituency::count();
        $majorhead = Majorhead::count();
        $plans = Plan::count();
        $soe = Soe_master::count();

    }else{

        $users = User::count();
        $components = Component::count();
        $finyears = Finyear::count();
        $districts = District::count();
        $services= Service::count();
        $sectors = Sector::count();
        $subsectors = Subsector::count();
        $departments = Department::count();
        $scheme = Scheme_master::where('department_id',auth()->user()->department_id)->count();
        $consitituency = Constituency::count();
        $majorhead = Majorhead::where('department_id',auth()->user()->department_id)->count();
        $plans = Plan::count();
        $soe = Soe_master::where('department_id',auth()->user()->department_id)->count();
    }
        return response()->json(['users' => $users,
                                'components' => $components,
                                'finyears' => $finyears,
                                'districts' => $districts,
                                'services' => $services,
                                'sectors' => $sectors,
                                'subsectors' => $subsectors,
                                'departments' => $departments,
                                'scheme' => $scheme,
                                'consitituency' => $consitituency,
                                'majorhead' => $majorhead,
                                'plans' => $plans ,
                                'soe' => $soe
                                ]);
    
    }

    public function get_user_data_count(Request $request){
        $scheme = Scheme_master::where("department_id",'=',$request->departmentId)->count();
        $soe = Soe_master::where("department_id",'=',$request->departmentId)->count();
        return response()->json(['scheme' => $scheme,'soe' => $soe]);
    }

    public function get_outlay_total(){

        $plan= Plan::all();
        for ($i=0; $i < count($plan); $i++) {

                if(auth()->user()->role_id === 1) {

                    if($plan[$i]->plan_name == "SDB"){
                            $sdbOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
                        }
                        if($plan[$i]->plan_name == "CDB"){
                            $cdbOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
                        }
                        if($plan[$i]->plan_name == "NDB"){
                            $ndbOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
                        }

                 } else {

                    
                        if($plan[$i]->plan_name == "SDB"){
                            $sdbOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
                        }
                        if($plan[$i]->plan_name == "CDB"){
                            $cdbOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
                        }
                        if($plan[$i]->plan_name == "NDB"){
                            $ndbOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
                        }



                
                 }
            
        }

        $totalSdbOutlay= 0;
        for ($i=0; $i < count($sdbOutlay); $i++) { 
            $totalSdbOutlay += $sdbOutlay[$i]->outlay;
        }
        $totalCdbOutlay= 0;
        for ($i=0; $i < count($cdbOutlay); $i++) { 
            $totalCdbOutlay += $cdbOutlay[$i]->outlay;
        }
        $totalNdbOutlay= 0;
        for ($i=0; $i < count($ndbOutlay); $i++) { 
            $totalNdbOutlay += $ndbOutlay[$i]->outlay;
        }

        $totalSdbOutlay = $totalSdbOutlay/10000000;
        $totalCdbOutlay = $totalCdbOutlay/10000000;
        $totalScheduledCastes = $totalSdbOutlay + $totalCdbOutlay;
        // $totalNdbOutlay = $totalNdbOutlay/10000000;
        return response()->json(['sdbOutlay' => $totalSdbOutlay, 
                                'cdbOutlay' => $totalCdbOutlay,
                                'totalScheduledCastes' => $totalScheduledCastes
                            ]);
    }

    public function get_plan_outlay_total(){

        $plan= Plan::all();
        $service= Service::all();
        $sdbEconomicsServiceOutlay= [];
        $sdbSocialServiceOutlay= [];
        $sdbGeneralServiceOutlay = [];
        $cdbEconomicsServiceOutlay = [];
        $cdbSocialServiceOutlay= [];
        $cdbGeneralServiceOutlay= [];
        for ($i=0; $i < count($plan); $i++) {
            $planName[$i] = $plan[$i]->plan_name;
            for ($j=0; $j < count($service); $j++) { 





                 if(auth()->user()->role_id === 1) {

                     if($plan[$i]->plan_name == "SDB" && $service[$j]->service_name == "ECONOMIC SERVICES"){
                     // Get SDB plan with Economics Service Outlay
                    $sdbEconomicsServiceOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
                }

                if($plan[$i]->plan_name == "SDB" && $service[$j]->service_name == "SOCIAL SERVICES"){
                     // Get SDB plan with Social Service Outlay
                    $sdbSocialServiceOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
                }

                if($plan[$i]->plan_name == "SDB" && $service[$j]->service_name == "GENERAL SERVICES"){
                    // Get SDB plan with General Service Outlay
                    $sdbGeneralServiceOutlay=Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
                }

                if($plan[$i]->plan_name == "CDB" && $service[$j]->service_name == "ECONOMIC SERVICES"){
                    // Get CDB plan with Economics Service Outlay
                    $cdbEconomicsServiceOutlay=Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
                }

                if($plan[$i]->plan_name == "CDB" && $service[$j]->service_name == "SOCIAL SERVICES"){
                    // Get CDB plan with Social Service Outlay
                    $cdbSocialServiceOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
                }

                if($plan[$i]->plan_name == "CDB" && $service[$j]->service_name == "GENERAL SERVICES"){
                     // Get CDB plan with General Service Outlay
                    $cdbGeneralServiceOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
                }


                 } else {

                        if($plan[$i]->plan_name == "SDB" && $service[$j]->service_name == "ECONOMIC SERVICES"){
                     // Get SDB plan with Economics Service Outlay
                    $sdbEconomicsServiceOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
                }

                if($plan[$i]->plan_name == "SDB" && $service[$j]->service_name == "SOCIAL SERVICES"){
                     // Get SDB plan with Social Service Outlay
                    $sdbSocialServiceOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
                }

                if($plan[$i]->plan_name == "SDB" && $service[$j]->service_name == "GENERAL SERVICES"){
                    // Get SDB plan with General Service Outlay
                    $sdbGeneralServiceOutlay=Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
                }

                if($plan[$i]->plan_name == "CDB" && $service[$j]->service_name == "ECONOMIC SERVICES"){
                    // Get CDB plan with Economics Service Outlay
                    $cdbEconomicsServiceOutlay=Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
                }

                if($plan[$i]->plan_name == "CDB" && $service[$j]->service_name == "SOCIAL SERVICES"){
                    // Get CDB plan with Social Service Outlay
                    $cdbSocialServiceOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
                }

                if($plan[$i]->plan_name == "CDB" && $service[$j]->service_name == "GENERAL SERVICES"){
                     // Get CDB plan with General Service Outlay
                    $cdbGeneralServiceOutlay= Soe_budget_allocation::where('plan_id', $plan[$i]->id)
                                                ->where('service_id', $service[$j]->id)->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
                }


                
                }
            
               
            }
        }

        // SDB services
        $sdbEconomicsServiceTotal = 0;
        for ($i=0; $i < count($sdbEconomicsServiceOutlay); $i++) { 
            $sdbEconomicsServiceTotal += $sdbEconomicsServiceOutlay[$i]->outlay;
        }

        $sdbSocialServiceTotal = 0;
        for ($i=0; $i < count($sdbSocialServiceOutlay); $i++) { 
            $sdbSocialServiceTotal += $sdbSocialServiceOutlay[$i]->outlay;
        }

        $sdbGeneralServiceTotal = 0;
        for ($i=0; $i < count($sdbGeneralServiceOutlay); $i++) { 
            $sdbGeneralServiceTotal += $sdbGeneralServiceOutlay[$i]->outlay;
        }

        // CDB servcies
        $cdbEconomicsServiceTotal = 0;
        for ($i=0; $i < count($cdbEconomicsServiceOutlay); $i++) { 
            $cdbEconomicsServiceTotal += $cdbEconomicsServiceOutlay[$i]->outlay;
        }

        $cdbSocialServiceTotal = 0;
        for ($i=0; $i < count($cdbSocialServiceOutlay); $i++) { 
            $cdbSocialServiceTotal += $cdbSocialServiceOutlay[$i]->outlay;
        }

        $cdbGeneralServiceTotal = 0;
        for ($i=0; $i < count($cdbGeneralServiceOutlay); $i++) { 
            $cdbGeneralServiceTotal += $cdbGeneralServiceOutlay[$i]->outlay;
        }

        // Economics services
        $sdbEconomicsServiceTotal = $sdbEconomicsServiceTotal/10000000;
        $cdbEconomicsServiceTotal = $cdbEconomicsServiceTotal/10000000;

        // Social services
        $sdbSocialServiceTotal = $sdbSocialServiceTotal/10000000;
        $cdbSocialServiceTotal = $cdbSocialServiceTotal/10000000;

        // General services
        $sdbGeneralServiceTotal = $sdbGeneralServiceTotal/10000000;
        $cdbGeneralServiceTotal = $cdbGeneralServiceTotal/10000000;
        
        // Total services
        $totalEconomicsService = $sdbEconomicsServiceTotal + $cdbEconomicsServiceTotal;
        $totalSocialService = $sdbSocialServiceTotal + $cdbSocialServiceTotal;
        $totalGeneralService = $sdbGeneralServiceTotal + $cdbGeneralServiceTotal;

        return response()->json(['sdbEconomicsTotal' => $sdbEconomicsServiceTotal, 
                                'sdbSocialTotal' => $sdbSocialServiceTotal, 
                                'sdbGeneralTotal' => $sdbGeneralServiceTotal, 
                                'cdbEconomicsTotal' => $cdbEconomicsServiceTotal, 
                                'cdbSocialTotal' => $cdbSocialServiceTotal, 
                                'cdbGeneralTotal' => $cdbGeneralServiceTotal, 
                                'totalEconomicsService' => $totalEconomicsService, 
                                'totalSocialService' => $totalSocialService, 
                                'totalGeneralService' => $totalGeneralService, 
                                ]);
    }

    public function get_district(){
        $districts = District::orderBy('district_name', 'asc')->get();
        return response()->json(['districts' => $districts]);
    }

    public function get_district_budget_distributed(){
        $plan= Plan::all();
        $district = District::all();

        $bilaspurSDBData = $bilaspurCDBData = [];
        $chambaSDBData = $chambaCDBData = [];
        $hamirpurSDBData = $hamirpurCDBData = [];
        $kangaraSDBData = $kangaraCDBData = [];
        $kulluSDBData = $kulluCDBData = [];
        $mandiSDBData = $mandiCDBData = [];
        $shimlaSDBData = $shimlaCDBData = [];
        $sirmaurSDBData = $sirmaurCDBData = [];
        $solanSDBData = $solanCDBData = [];
        $unaSDBData = $unaCDBData = [];

        $bilaspurSDBTotal = $bilaspurCDBTotal = 0;
        $chambaSDBTotal = $chambaCDBTotal = 0;
        $hamirpurSDBTotal = $hamirpurCDBTotal = 0;
        $kangaraSDBTotal = $kangaraCDBTotal = 0;
        $kulluSDBTotal = $kulluCDBTotal = 0;
        $mandiSDBTotal = $mandiCDBTotal = 0;
        $shimlaSDBTotal = $shimlaCDBTotal = 0;
        $sirmaurSDBTotal = $sirmaurCDBTotal = 0;
        $solanSDBTotal = $solanCDBTotal = 0;
        $unaSDBTotal = $unaCDBTotal = 0;

        for ($i=0; $i < count($plan); $i++) {
            $planName[$i] = $plan[$i]->plan_name;
            for ($j=0; $j < count($district); $j++) {
                // get bilaspur SDB data
                if($plan[$i]->plan_name == "SDB" && $district[$j]->district_name == "Bilaspur"){
                    $bilaspurSDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                    ->where('district_id', $district[$j]->id)->get();
                }

                // get bilaspur CDB data
                if($plan[$i]->plan_name == "CDB" && $district[$j]->district_name == "Bilaspur"){
                    $bilaspurCDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }

                // get Chamba SDB data
                if($plan[$i]->plan_name == "SDB" && $district[$j]->district_name == "Chamba"){
                    $chambaSDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();

                }
                // get Chamba CDB data
                if($plan[$i]->plan_name == "CDB" && $district[$j]->district_name == "Chamba"){
                    $chambaCDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }

                // get Hamirpur SDB data
                if($plan[$i]->plan_name == "SDB" && $district[$j]->district_name == "Hamirpur"){
                    $hamirpurSDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }
                // get Hamirpur CDB data
                if($plan[$i]->plan_name == "CDB" && $district[$j]->district_name == "Hamirpur"){
                    $hamirpurCDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }

                // get Kangara SDB data
                if($plan[$i]->plan_name == "SDB" && $district[$j]->district_name == "Kangara"){
                    $kangaraSDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }
                // get Kangara CDB data
                if($plan[$i]->plan_name == "CDB" && $district[$j]->district_name == "Kangara"){
                    $kangaraCDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }

                // get Kullu SDB data
                if($plan[$i]->plan_name == "SDB" && $district[$j]->district_name == "Kullu"){
                    $kulluSDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }
                // get Kullu CDB data
                if($plan[$i]->plan_name == "CDB" && $district[$j]->district_name == "Kullu"){
                    $kulluCDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }

                // get Mandi SDB data
                if($plan[$i]->plan_name == "SDB" && $district[$j]->district_name == "Mandi"){
                    $mandiSDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }
                // get Mandi CDB data
                if($plan[$i]->plan_name == "CDB" && $district[$j]->district_name == "Mandi"){
                    $mandiCDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }

                // get Shimla SDB data
                if($plan[$i]->plan_name == "SDB" && $district[$j]->district_name == "Shimla"){
                    $shimlaSDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }
                // get Shimla CDB data
                if($plan[$i]->plan_name == "CDB" && $district[$j]->district_name == "Shimla"){
                    $shimlaCDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }

                // get Sirmaur SDB data
                if($plan[$i]->plan_name == "SDB" && $district[$j]->district_name == "Sirmaur"){
                    $sirmaurSDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }
                // get Sirmaur CDB data
                if($plan[$i]->plan_name == "CDB" && $district[$j]->district_name == "Sirmaur"){
                    $sirmaurCDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }

                // get Solan SDB data
                if($plan[$i]->plan_name == "SDB" && $district[$j]->district_name == "Solan"){
                    $solanSDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }
                // get Solan CDB data
                if($plan[$i]->plan_name == "CDB" && $district[$j]->district_name == "Solan"){
                    $solanCDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }

                // get Una SDB data
                if($plan[$i]->plan_name == "SDB" && $district[$j]->district_name == "Una"){
                    $unaSDBData= Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }
                // get Una CDB data
                if($plan[$i]->plan_name == "CDB" && $district[$j]->district_name == "Una"){
                    $unaCDBData = Soe_budget_distribution::where('plan_id', $plan[$i]->id)
                                                ->where('district_id', $district[$j]->id)->get();
                }
            }
        }

                // Bilaspur SDB services
                if(count($bilaspurSDBData) > 0){
                    for ($i=0; $i < count($bilaspurSDBData); $i++) { 
                        $bilaspurSDBTotal += $bilaspurSDBData[$i]->outlay;
                    }
                }

                if(count($bilaspurCDBData) > 0){
                    for ($i=0; $i < count($bilaspurCDBData); $i++) { 
                        $bilaspurCDBTotal += $bilaspurCDBData[$i]->outlay;
                    }
                }

                // Chamba SDB services
                if(count($chambaSDBData) > 0){
                    for ($i=0; $i < count($chambaSDBData); $i++) { 
                        $chambaSDBTotal += $chambaSDBData[$i]->outlay;
                    }
                }
                if(count($chambaCDBData) > 0){
                    for ($i=0; $i < count($chambaCDBData); $i++) { 
                        $chambaCDBTotal += $chambaCDBData[$i]->outlay;
                    }
                }

                // Hamirpur SDB services
                if(count($hamirpurSDBData) > 0){
                    for ($i=0; $i < count($hamirpurSDBData); $i++) { 
                        $hamirpurSDBTotal += $hamirpurSDBData[$i]->outlay;
                    }
                }
                if(count($hamirpurCDBData) > 0){
                    for ($i=0; $i < count($hamirpurCDBData); $i++) { 
                        $hamirpurCDBTotal += $hamirpurCDBData[$i]->outlay;
                    }
                }

                // Kangara SDB services
                if(count($kangaraSDBData) > 0){
                    for ($i=0; $i < count($kangaraSDBData); $i++) { 
                        $kangaraSDBTotal += $kangaraSDBData[$i]->outlay;
                    }
                }
                if(count($kangaraCDBData) > 0){
                    for ($i=0; $i < count($kangaraCDBData); $i++) { 
                        $kangaraCDBTotal += $kangaraCDBData[$i]->outlay;
                    }
                }

                // Kullu SDB services
                if(count($kulluSDBData) > 0){
                    for ($i=0; $i < count($kulluSDBData); $i++) { 
                        $kulluSDBTotal += $kulluSDBData[$i]->outlay;
                    }
                }
                if(count($kulluCDBData) > 0){
                    for ($i=0; $i < count($kulluCDBData); $i++) { 
                        $kulluCDBTotal += $kulluCDBData[$i]->outlay;
                    }
                }

                // Mandi SDB services
                if(count($mandiSDBData) > 0){
                    for ($i=0; $i < count($mandiSDBData); $i++) { 
                        $mandiSDBTotal += $mandiSDBData[$i]->outlay;
                    }
                }
                if(count($mandiCDBData) > 0){
                    for ($i=0; $i < count($mandiCDBData); $i++) { 
                        $mandiCDBTotal += $mandiCDBData[$i]->outlay;
                    }
                }

                // Shimla SDB services
                if(count($shimlaSDBData) > 0){
                    for ($i=0; $i < count($shimlaSDBData); $i++) { 
                        $shimlaSDBTotal += $shimlaSDBData[$i]->outlay;
                    }
                }
                if(count($shimlaCDBData) > 0){
                    for ($i=0; $i < count($shimlaCDBData); $i++) { 
                        $shimlaCDBTotal += $shimlaCDBData[$i]->outlay;
                    }
                }

                // Sirmaur SDB services
                if(count($sirmaurSDBData) > 0){
                    for ($i=0; $i < count($sirmaurSDBData); $i++) { 
                        $sirmaurSDBTotal += $sirmaurSDBData[$i]->outlay;
                    }
                }
                if(count($sirmaurCDBData) > 0){
                    for ($i=0; $i < count($sirmaurCDBData); $i++) { 
                        $sirmaurCDBTotal += $sirmaurCDBData[$i]->outlay;
                    }
                }

                // Solan SDB services
                if(count($solanSDBData) > 0){
                    for ($i=0; $i < count($solanSDBData); $i++) { 
                        $solanSDBTotal += $solanSDBData[$i]->outlay;
                    }
                }
                if(count($solanCDBData) > 0){
                    for ($i=0; $i < count($solanCDBData); $i++) { 
                        $solanCDBTotal += $solanCDBData[$i]->outlay;
                    }
                }

                // Una SDB services
                if(count($unaSDBData) > 0){
                    for ($i=0; $i < count($unaSDBData); $i++) { 
                        $unaSDBTotal += $unaSDBData[$i]->outlay;
                    }
                }
                if(count($unaCDBData) > 0){
                    for ($i=0; $i < count($unaCDBData); $i++) { 
                        $unaCDBTotal += $unaCDBData[$i]->outlay;
                    }
                }

        $bilaspurTotal = $bilaspurSDBTotal + $bilaspurCDBTotal;
        $chambaTotal = $chambaSDBTotal + $chambaCDBTotal;
        $hamirpurTotal = $hamirpurSDBTotal + $hamirpurCDBTotal;
        $kangaraTotal = $kangaraSDBTotal + $kangaraCDBTotal;
        $kulluTotal = $kulluSDBTotal + $kulluCDBTotal;
        $mandiTotal = $mandiSDBTotal + $mandiCDBTotal;
        $shimlaTotal = $shimlaSDBTotal + $shimlaCDBTotal;
        $sirmaurTotal = $sirmaurSDBTotal + $sirmaurCDBTotal;
        $solanTotal = $solanSDBTotal + $solanCDBTotal;
        $unaTotal = $unaSDBTotal + $unaCDBTotal;
        
        return response()->json(['bilaspurSDBTotal' => $bilaspurSDBTotal/100000,
                                'bilaspurCDBTotal' => $bilaspurCDBTotal/100000,
                                'bilaspurTotal' => $bilaspurTotal/100000,
                                'chambaSDBTotal' => $chambaSDBTotal/100000,
                                'chambaCDBTotal' => $chambaCDBTotal/100000,
                                'chambaTotal' => $chambaTotal/100000,
                                'hamirpurSDBTotal' => $hamirpurSDBTotal/100000,
                                'hamirpurCDBTotal' => $hamirpurCDBTotal/100000,
                                'hamirpurTotal' => $hamirpurTotal/100000,
                                'kangaraSDBTotal' => $kangaraSDBTotal/100000,
                                'kangaraCDBTotal' => $kangaraCDBTotal/100000,
                                'kangaraTotal' => $kangaraTotal/100000,
                                'kulluSDBTotal' => $kulluSDBTotal/100000,
                                'kulluCDBTotal' => $kulluCDBTotal/100000,
                                'kulluTotal' => $kulluTotal/100000,
                                'mandiSDBTotal' => $mandiSDBTotal/100000,
                                'mandiCDBTotal' => $mandiCDBTotal/100000,
                                'mandiTotal' => $mandiTotal/100000,
                                'shimlaSDBTotal' => $shimlaSDBTotal/100000,
                                'shimlaCDBTotal' => $shimlaCDBTotal/100000,
                                'shimlaTotal' => $shimlaTotal/100000,
                                'sirmaurSDBTotal' => $sirmaurSDBTotal/100000,
                                'sirmaurCDBTotal' => $sirmaurCDBTotal/100000,
                                'sirmaurTotal' => $sirmaurTotal/100000,
                                'solanSDBTotal' => $solanSDBTotal/100000,
                                'solanCDBTotal' => $solanCDBTotal/100000,
                                'solanTotal' => $solanTotal/100000,
                                'unaSDBTotal' => $unaSDBTotal/100000,
                                'unaCDBTotal' => $unaCDBTotal/100000,
                                'unaTotal' => $unaTotal/100000
                            ]);
    }

    public function get_outlays(){

        if(auth()->user()->role_id === 1) {

             $outlays= Soe_budget_allocation::where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
         } else {
             $outlays= Soe_budget_allocation::where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
       
        }
       
        return response()->json(['outlays' => $outlays]);
    }

    public function get_earmarked_outlays(){

         if(auth()->user()->role_id === 1) {
          $earmarked = Soe_budget_allocation::where("earmarked",'=',"Yes")->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
        $nonEarmarked= Soe_budget_allocation::where("earmarked",'=',"No")->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->get();
        } else {
          $earmarked = Soe_budget_allocation::where("earmarked",'=',"Yes")->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
        $nonEarmarked= Soe_budget_allocation::where("earmarked",'=',"No")->where("soe_budget_allocation.fin_year_id",Session::get('finyear'))->where('department_id',auth()->user()->department_id)->get();
        }


        

        $earmarkedTotal = $earmarkedHodTotal = $earmarkedDistrictTotal = 0;
        for ($i=0; $i < count($earmarked); $i++) { 
            $earmarkedTotal += $earmarked[$i]->outlay/100000;
            $earmarkedHodTotal += $earmarked[$i]->hod_outlay/100000;
            $earmarkedDistrictTotal += $earmarked[$i]->district_outlay/100000;
        }

        $nonEarmarkedTotal = $nonEarmarkedHodTotal = $nonEarmarkedDistrictTotal = 0;

        for ($i=0; $i < count($nonEarmarked); $i++) {
            $nonEarmarkedTotal += $nonEarmarked[$i]->outlay/100000;
            $nonEarmarkedHodTotal += $nonEarmarked[$i]->hod_outlay/100000;
            $nonEarmarkedDistrictTotal += $nonEarmarked[$i]->district_outlay/100000;
        }

        return response()->json(['earmarkedTotal' => $earmarkedTotal,
                                'earmarkedHodTotal' => $earmarkedHodTotal,
                                'earmarkedDistrictTotal' => $earmarkedDistrictTotal,
                                'nonEarmarkedTotal' => $nonEarmarkedTotal,
                                'nonEarmarkedHodTotal' => $nonEarmarkedHodTotal,
                                'nonEarmarkedDistrictTotal' => $nonEarmarkedDistrictTotal
                                ]);
    }
}
