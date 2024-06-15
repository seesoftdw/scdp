<?php

namespace App\Http\Controllers;
use App\Models\Soe_budget_allocation;
use App\Models\Soe_budget_distribution;
use App\Models\Department;
use App\Models\Majorhead;
use App\Models\Scheme_master;
use App\Models\Soe_master;
use App\Models\District_percentage;
use App\Models\District;
use App\Models\User;
use App\Models\Finyear;
use App\Models\Plan;
use App\Models\RevisedOutlayLogs;
use App\Models\Soe_budget_distribution_logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use File;
class Soe_budget_distribution_Controller extends Controller
{
    public $quarters=[1=>[4,5,6],2=>[7,8,9],3=>[10,11,12],4=>[1,2,3]];

    public function currentquarter(){

              foreach ($this->quarters as $key => $quarter) {
                
                if(in_array(date('n'), $quarter)){

                    $currentquarter=$key;
                }
            }
            return $currentquarter;
    }

    public function index(){   


        if(auth()->user()->role_id === 1) {
            $soeBudgetDistribution = Soe_budget_distribution::where("fin_year_id",Session::get('finyear'))->orderBy('id', 'DESC')->get();//paginate(10);
        } else {
            $soeBudgetDistribution = Soe_budget_distribution::where("department_id", auth()->user()->department_id)
            ->orderBy('id', 'DESC')
            ->get();//paginate(10);
        }
        
        if (count($soeBudgetDistribution) > 0) {
            return view('soe-budget-distribution.view-soe-budget-distribution', compact('soeBudgetDistribution'));
        } else {
            return view('soe-budget-distribution.view-soe-budget-distribution');
        }
    }

    public function allList(){
        $departmentlist = Department::all();
        $finyearlist = Finyear::all();
        $districtlist = District::all();
        $planlist = Plan::all();
        $currentquarter=$this->currentquarter();

        return view('soe-budget-distribution.create-soe-budget-distribution')->with('departmentlist',$departmentlist)
                                                                            ->with('finyearlist',$finyearlist)
                                                                            ->with('districtlist',$districtlist)
                                                                            ->with('planlist',$planlist)
                                                                            ->with('currentquarter',$currentquarter);
    }

    public function get_distribution_majorhead_by_department(Request $request){
        $majorheadHtml='';
        $schemeHtml='';
        $soeHtml='';
        if (!$request->department_id) {
            $majorheadHtml .= '<option value="">'."---Select Majorhead---".'</option>';
            $schemeHtml .= '<option value="">'."---Select scheme---".'</option>';
            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';
        }
        else {
            $html = '';
            $majorheadList = Majorhead::where('department_id', $request->department_id)->get();
            $majorheadHtml .= '<option value="">'."---Select Majorhead---".'</option>';
            $schemeHtml .= '<option value="">'."---Select scheme---".'</option>';
            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';
            foreach ($majorheadList as $majorhead) {
                $majorheadHtml .= '<option value="'.$majorhead->id.'">'.$majorhead->complete_head.'</option>';
            }
        }
        return response()->json(['majorheadHtml' => $majorheadHtml, 'schemeHtml' => $schemeHtml, 'soeHtml' => $soeHtml]);
    }

    public function get_distribution_scheme_by_majorhead(Request $request){
        $schemeHtml='';
        $soeHtml='';
        if (!$request->majorhead_id) {
            $schemeHtml .= '<option value="">'."---Select scheme---".'</option>';
            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';
        }
        else {
            $html = '';
            $schemeList = Scheme_master::where('majorhead_id', $request->majorhead_id)->get();
            $schemeHtml .= '<option value="">'."---Select scheme---".'</option>';
            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';
            foreach ($schemeList as $scheme) {
                $schemeHtml .= '<option value="'.$scheme->id.'">'.$scheme->scheme_name.'</option>';
            }
        }
        return response()->json(['schemeHtml' => $schemeHtml,'soeHtml' => $soeHtml]);
    }

    public function get_distribution_soe_by_scheme(Request $request){
        $soeHtml='';
        if (!$request->scheme_id) {
            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';
        }
        else {
            $html = '';


            $soeBudgetDistribution = Soe_budget_distribution::where("scheme_id",$request->scheme_id)->where('majorhead_id', $request->majorhead_id)->where('department_id', $request->department_id)->get();
            $ids=[];
            foreach ($soeBudgetDistribution as  $value) {
               $ids[]=$value->soe_id;
            }
            //dd($ids);
            $soeList = Soe_master::where('scheme_id', $request->scheme_id)->whereNotIn('id', $ids)->get();
            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';
            foreach ($soeList as $soe) {
                $soeHtml .= '<option value="'.$soe->id.'">'.$soe->soe_name.'</option>';
            }
        }
        return response()->json(['soeHtml' => $soeHtml]);
    }

    public function store(Request $request){

        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'department_id' => 'required',
            'majorhead_id' => 'required',
            'scheme_id' => 'required',
            'soe_id' => 'required',
            'fin_year_id' => 'required',
            'type' => 'required',
            
            
        ]);



        $data=array('outlay'=>$request->outlay,'expenditure'=>$request->expenditure,'opercentage'=>$request->opercentage,'unit'=>$request->unit,'unit_measure'=>$request->unit_measure,'achievement'=>$request->achievement,'upercentage'=>$request->upercentage,'ben_total'=>$request->ben_total,'women'=>$request->women,'disable'=>$request->disable,'item_name'=>$request->item_name,'resvised_outlay'=>$request->outlay);
       
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
               
                

                            $schemebudgetdistribution = new Soe_budget_distribution;
                            $schemebudgetdistribution->department_id = $request->department_id;
                            $schemebudgetdistribution->majorhead_id = $request->majorhead_id;
                            $schemebudgetdistribution->scheme_id = $request->scheme_id;
                            $schemebudgetdistribution->soe_id = $request->soe_id;
                            $schemebudgetdistribution->fin_year_id = $request->fin_year_id;
                            $schemebudgetdistribution->plan_id = $request->plan_id;
                          
                           
                            $schemebudgetdistribution->data =json_encode($data);
                           
                            $res = $schemebudgetdistribution->save();

                if($res=="true"){
                    return redirect()->route('soe-budget-distribution.index')
                    ->with('success', 'Soe budget distributed successfully.');
                }
        }
    }

    public function show($id){
        $soebudgetdistribution = Soe_budget_distribution::find($id);

        $firstqutstart = date('Y-04-01 00:00:00');
        $startqutend = date('Y-06-30 23:59:59');
        $secondqutstart = date('Y-07-01 00:00:00');
        $secondqutend = date('Y-09-30 23:59:59');
        $thirdqutstart = date('Y-10-01 00:00:00');
        $thirdqutend = date('Y-12-31 23:59:59');
        $fourthqutstart = date('Y-01-01 00:00:00');
        $fourthqutend = date('Y-03-31 23:59:59');

        $first = RevisedOutlayLogs::where('budget_distribution_id',$id)->wherebetween('created_at', [$firstqutstart, $startqutend])->latest()->get();
        $second = RevisedOutlayLogs::where('budget_distribution_id',$id)->wherebetween('created_at', [$secondqutstart, $secondqutend])->latest()->get();
        $third = RevisedOutlayLogs::where('budget_distribution_id',$id)->wherebetween('created_at', [$thirdqutstart, $thirdqutend])->latest()->get();
        $fourth = RevisedOutlayLogs::where('budget_distribution_id',$id)->wherebetween('created_at', [$fourthqutstart, $fourthqutend])->latest()->get();

        return view('soe-budget-distribution.show-soe-budget-distribution')->with('soebudgetdistribution', $soebudgetdistribution)->with('first', $first)->with('second', $second)->with('third', $third)->with('fourth', $fourth);
    }

    public function get_soe_undistributed_outlay(Request $request)
    {
        if($request->department_id > 0 && $request->majorhead_id > 0 && $request->scheme_id > 0 && $request->soe_id > 0 && $request->fin_year_id > 0) {}
        
        if($request->soe_id > 0 && $request->scheme_id > 0)
        {
            $totaloutlay = Soe_budget_allocation::select('department_id','majorhead_id','scheme_id','soe_id','fin_year_id','outlay','plan_id')
                                                ->where('department_id', $request->department_id)
                                                ->where('majorhead_id', $request->majorhead_id)
                                                ->where('scheme_id', $request->scheme_id)
                                                ->where('soe_id', $request->soe_id)
                                                ->where('fin_year_id', $request->fin_year_id)
                                                ->get();
            $distribute_outlay =[];
            $distributeOutlay = 0;
            if(count($totaloutlay) > 0){
                $soebudgetdistribution = Soe_budget_distribution::where('id' , $request->soe_budget_distribution_id)->first();
                $revised=0;
                if($soebudgetdistribution){
                    $currentquarter=$this->currentquarter();
                    $fieldname='q_'.$currentquarter.'_data';

                    if($soebudgetdistribution->$fieldname !=null){
                        $revised=1;
                        $districtdata=json_decode($soebudgetdistribution->$fieldname);
                        $soebudgetdistribution=(array)end($districtdata);
                    }else{
                        $soebudgetdistribution=(array)json_decode($soebudgetdistribution->data);
                        for ($i=$currentquarter-1; $i >= 1  ; $i--) { 
                            $fieldname='q_'.$i.'_data';

                            if($soebudgetdistribution->$fieldname !=null){
                                $revised=1;
                                $districtdata=json_decode($soebudgetdistribution->$fieldname);
                                $soebudgetdistribution=(array)end($districtdata);
                            }
                        }
                    }
                    if ($revised==0) {
                        $layout=(array)$soebudgetdistribution['outlay'];
                    }else{
                        $layout=(array)$soebudgetdistribution['resvised_outlay'];
                    }
                    foreach ($layout as $key => $value) {
                        $distributeOutlay += $value*100000;
                    }
                }
                $undistributed_outlay = ((int)$totaloutlay[0]['outlay'] -  $distributeOutlay);

                if($undistributed_outlay == $totaloutlay[0]['outlay']) {
                    return response()->json(['undistributed_outlay' => $undistributed_outlay,
                                            'totaloutlay'=> (int)$totaloutlay[0]['outlay'],
                                            'plan_id' =>$totaloutlay[0]['plan_id'],
                                        ]);
                }else{
                    return response()->json(['undistributed_outlay' => $undistributed_outlay,
                                            'totaloutlay'=> (int)$totaloutlay[0]['outlay'],
                                            'distribute_outlay' => $distribute_outlay,
                                            'plan_id' =>$totaloutlay[0]['plan_id']]);
                }
            } else {
                    return response()->json(['undistributed_outlay' => 0.00,
                                            'totaloutlay'=> 0.00]);
            }
        }
    }

    public function get_soe_budget_distribution_data(Request $request){
        $soebudgetdistribution = Soe_budget_distribution::where('id' , $request->soe_budget_distribution_id)->get();
        
        $departmentlist = Department::all();
        $majorheadlist = Majorhead::where('department_id', $soebudgetdistribution[0]['department_id'])->get();
        $schemelist = Scheme_master::where('majorhead_id', $soebudgetdistribution[0]['majorhead_id'])->get();
        $soelist = Soe_master::where('scheme_id',$soebudgetdistribution[0]['scheme_id'])->get();
        $districtlist = District::all();
        $finyearlist = Finyear::all();
        $planlist = Plan::all();
        return response()->json(['soebudgetdistribution' => $soebudgetdistribution,
                                'departmentlist' => $departmentlist,
                                'majorheadlist' => $majorheadlist,
                                'schemelist' => $schemelist,
                                'soelist' => $soelist,
                                'districtlist' => $districtlist,
                                'finyearlist' => $finyearlist,
                                'planlist' => $planlist,
                            ]);
    } 

    public function districtList()
    {
        $currentquarter=$this->currentquarter();
        $id=array_keys($_GET)[0];

        $soebudgetdistribution = Soe_budget_distribution::where('id' , $id)->first();
        $districtlist = District::all();

        $fieldname='q_'.$currentquarter.'_data';

        if($soebudgetdistribution->$fieldname !=null){
            $districtdata=json_decode($soebudgetdistribution->$fieldname);
            $districtdata=end($districtdata);
        }else{
             $districtdata=json_decode($soebudgetdistribution->data);
                for ($i=$currentquarter-1; $i >= 1  ; $i--) { 
                    $fieldname='q_'.$i.'_data';

                        if($soebudgetdistribution->$fieldname !=null){
                            $districtdata=json_decode($soebudgetdistribution->$fieldname);
                            $districtdata=end($districtdata);
                        }
                }
        }
        
       // dd($districtdata);
              $data=[];
            foreach($districtdata as $key=>$value){
                $data[$key]=(array)$value;
            }
       $districtdata=$data;
       $user=User::where('id',auth()->user()->id )->first();

       return view('soe-budget-distribution.edit-soe-budget-distribution')->with('districtlist',$districtlist)->with('districtdata',$districtdata)->with('user',$user)->with('currentquarter',$currentquarter);
    }

     public function revised(){
        $currentquarter=$this->currentquarter();
        $id=array_keys($_GET)[0];

         $soebudgetdistribution = Soe_budget_distribution::where('id' , $id)->first();
  
        $districtlist = District::all();

        $fieldname='q_'.$currentquarter.'_data';

        if($soebudgetdistribution->$fieldname !=null){
            $districtdata=json_decode($soebudgetdistribution->$fieldname);
            $districtdata=end($districtdata);
        }else{
             $districtdata=json_decode($soebudgetdistribution->data);
                for ($i=$currentquarter-1; $i >= 1  ; $i--) { 
                    $fieldname='q_'.$i.'_data';

                        if($soebudgetdistribution->$fieldname !=null){
                            $districtdata=json_decode($soebudgetdistribution->$fieldname);
                            $districtdata=end($districtdata);
                        }
                }
               
        }
        
       // dd($districtdata);

              
              $data=[];
            foreach($districtdata as $key=>$value){
                $data[$key]=(array)$value;

            }
       $districtdata=$data;
       $user=User::where('id',auth()->user()->id )->first();

        return view('soe-budget-distribution.revised-soe-budget-distribution')->with('districtlist',$districtlist)->with('districtdata',$districtdata)->with('user',$user)->with('currentquarter',$currentquarter);
    }
    public function get_districtPercentage(){
        $districtlist =  District::all();
        $districtpercentagelist =  District_percentage::all();

        return response()->json(['districtpercentagelist'=>$districtpercentagelist,
                                'districtlist'=>$districtlist]);
    }

    public function update(Request $request, $id){
       // print_r($request->all()); die(); 
       /* $districtlist =  District::all();
        for ($i=0; $i < count($districtlist) ; $i++) { 
            if($request->has($districtlist[$i]['district_name'])){
                if($request->{$districtlist[$i]['district_name']} > 0){

                    $schemebudgetdistribution['department_id'] = $request->department_id;
                    $schemebudgetdistribution['majorhead_id'] = $request->majorhead_id;
                    $schemebudgetdistribution['scheme_id'] = $request->scheme_id;
                    $schemebudgetdistribution['soe_id'] = $request->soe_id;
                    $schemebudgetdistribution['fin_year_id'] = $request->fin_year_id;
                    $schemebudgetdistribution['district_id'] =$districtlist[$i]['id'];
                    $schemebudgetdistribution['outlay'] =$request->{$districtlist[$i]['district_name']} == 0 ? 0 :
                                                        $request->{$districtlist[$i]['district_name']}*100000;
                    $isExist = Soe_budget_distribution::where("department_id", $request->department_id)
                                    ->where("majorhead_id", $request->majorhead_id)
                                    ->where("scheme_id", $request->scheme_id)
                                    ->where("soe_id", $request->soe_id)
                                    ->where("fin_year_id", $request->fin_year_id)
                                    ->where("district_id", $districtlist[$i]['id'])
                                    ->get();

                    $soebudgetdist = Soe_budget_distribution::find($isExist[0]['id']);
                    $res = $soebudgetdist->update($schemebudgetdistribution);
                }
            }
        }*/
       
     $currentquarter=$this->currentquarter();
      
        $data=array(array('outlay'=>$request->outlay,'resvised_outlay'=>$request->resvised_outlay,'expenditure'=>$request->expenditure,'opercentage'=>$request->opercentage,'unit'=>$request->unit,'unit_measure'=>$request->unit_measure,'achievement'=>$request->achievement,'upercentage'=>$request->upercentage,'ben_total'=>$request->ben_total,'women'=>$request->women,'disable'=>$request->disable,'item_name'=>$request->item_name,'udate_date'=>date('Y-m-d')));
                //dd($beneficiaries_disable);
                   
                
                   $soebudgetdist = Soe_budget_distribution::find($id);
                   $fieldname='q_'.$currentquarter.'_data';
                   if($soebudgetdist->$fieldname!=null){

                         $olddata=$soebudgetdist->$fieldname;
                         $olddata=json_decode($olddata);
                         $schemebudgetdistribution[$fieldname] = json_encode(array_merge($olddata,$data));
                   }else{

                    $schemebudgetdistribution[$fieldname] =$data;
                   }
 
                 $res = $soebudgetdist->update($schemebudgetdistribution);

        if($res=="true"){
            if($request->setval == 'set_resvised_outlay')
            {
                $loginsert = new RevisedOutlayLogs;
                $loginsert->comments = $request->comments;
                $revisedoutlay = json_encode($request->resvised_outlay);
                $loginsert->revised_outlay_values = $revisedoutlay;
                $loginsert->budget_distribution_id = $id;
                $loginsert->created_by = auth()->user()->id;
                if($request->file) {
                    $fileName = time().'.'.$request->file->extension();  
                    $request->file->move(public_path('notification_docs'), $fileName);
                    $loginsert->notification_doc = $fileName;
                }
                $loginsert->save();
            }

            if($request->logval == 'entereditlog')
            {
                $logset = new Soe_budget_distribution_logs;
                $logset->department_id = $request->department_id;
                $logset->majorhead_id = $request->majorhead_id;
                $logset->scheme_id = $request->scheme_id;
                $logset->soe_id = $request->soe_id;
                $logset->fin_year_id = $request->fin_year_id;
                $logset->plan_id = $request->plan_id;
                $logset->data = json_encode($data);
                $logset->user_id = auth()->user()->id;
                $logset->seo_id = $id;
                $logset->save();
            }

            return redirect()->route('soe-budget-distribution.index')
            ->with('success', 'Soe budget distribution updated successfully.');
        }
    }

    public function destroy($id){
        $soebudgetdistribution = Soe_budget_distribution::find($id);
        $soebudgetdistribution->delete();
        return redirect('soe-budget-distribution')->with('delete', 'Soe-budget distribution deleted!');
    }

    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                $excelArray = Excel::toArray([],$request->file);   
                $newArray = array_values($excelArray[0]);
                $record = 0;
                for ($i=1; $i < count($newArray); $i++) { 
                    if(!($newArray[$i][0] == null && $newArray[$i][1] == null && $newArray[$i][2] == null &&$newArray[$i][3] == null && 
                        $newArray[$i][4] == null && $newArray[$i][5] == null && $newArray[$i][6] == null && $newArray[$i][7] == null)){
                        $validate = Validator::make($newArray[$i], [
                            '0' => 'required',
                            '1' => 'required',
                            '2' => 'required',
                            '3' => 'required',
                            '4' => 'required',
                            '5' => 'required',
                            '6' => 'required',
                            '7' => 'required',
                        ]);
                        if(!$validate->fails()){
                            $sector_id =  Sector::where('sector_name',$newArray[$i][0])->first();
                            $subsector_id =  Subsector::where('subsectors_name',$newArray[$i][1])->first();
                            $department_id =  Department::where('department_name',$newArray[$i][2])->first();
                            $fin_year_id =  Finyear::where('finyear',$newArray[$i][3])->first();
                            $scheme_id =  Scheme_master::where('scheme_name',$newArray[$i][4])->first();
                            $soe_id =  Soe_master::where('soe_name',$newArray[$i][5])->first();
                            $district_id =  District::where('district_name',$newArray[$i][6])->first();
                            if( !($sector_id == null && $subsector_id == null && $department_id == null && $fin_year_id == null && $scheme_id == null && $soe_id == null && $district_id == null) ){
                                $record++;
                                $arrayVariable = array(
                                    'sector_id' => $sector_id->id,
                                    'subsector_id' => $subsector_id->id,
                                    'department_id' => $department_id->id,
                                    'fin_year_id' => $fin_year_id->id,
                                    'scheme_id' => $scheme_id->id,
                                    'soe_id' => $soe_id->id,    
                                    'district_id' => $district_id->id,
                                    'outlay' => $newArray[$i][7]
                                );
                                Soe_budget_distribution::create($arrayVariable);
                            }
                        }
                    }
                }
                if($record > 0){
                    return redirect()->route('soe-budget-distribution.index')
                    ->with('success',$record .' Soe budget distribution impoerted successfully.');
                }else{
                    return redirect()->route('soe-budget-distribution.index')
                ->with('error',$record .'Soe budget distribution impoerted');
                }
            }
            else{
                return back()->with('error', 'The excel file must be a file of type:xlsx');
            }            
        }
    }
    public function soe_financial_budget_distribution($id){
            dd($id);

    }

    public function get_log_of_revised_outlay($id){
        $log = RevisedOutlayLogs::where('id', $id)->first();

        $decodelog = json_decode($log->revised_outlay_values);
        $name = User::where('id',$log->created_by)->first();
        if(!empty($name->name))
        {
            $username = $name->name;
        }
        $date = date('d-m-Y', strtotime($log->created_at));
        
        $setdate = date('Y-m-d', strtotime($log->created_at));
        $firstqutstart = date('Y-m-d', strtotime(date('Y-04-01')));
        $startqutend = date('Y-m-d', strtotime(date('Y-06-30')));
        $secondqutstart = date('Y-m-d', strtotime(date('Y-07-01')));
        $secondqutend = date('Y-m-d', strtotime(date('Y-09-30')));
        $thirdqutstart = date('Y-m-d', strtotime(date('Y-10-01')));
        $thirdqutend = date('Y-m-d', strtotime(date('Y-12-31')));
        $fourthqutstart = date('Y-m-d', strtotime(date('Y-01-01')));
        $fourthqutend = date('Y-m-d', strtotime(date('Y-03-31')));

        if (($setdate >= $firstqutstart) && ($setdate <= $startqutend)){
            $heading = "Quarter 1 (April to June)";
        } elseif (($setdate >= $secondqutstart) && ($setdate <= $secondqutend)){
            $heading = "Quarter 2 (July to September)";
        } elseif (($setdate >= $thirdqutstart) && ($setdate <= $thirdqutend)){
            $heading = "Quarter 3 (October to December)";
        } elseif (($setdate >= $fourthqutstart) && ($setdate <= $fourthqutend)){
            $heading = "Quarter 4 (January to March)";
        } else {
            $heading = "Quarter";
        }
        // print_r($decodelog); 
        $table = "<span>Name = ".$username."</span><br><span> Date = ".$date."</span><br><span> Quarter = ".$heading."</span><table class='table table-bordered'><tr><th>District Name</th><th>Outlay</th></tr>";
        foreach ($decodelog as $key => $value) {
            $district = District::where('id', $key)->first();
            $table .= "<tr><td>".$district->district_name."</td><td>".$value."</td></tr>";
        }
        $table .= "</table>";

        echo $table;
    }

    public function editlogs($id){

        $log = Soe_budget_distribution_logs::where('seo_id', $id)->latest()->paginate(10);

        return view('soe-budget-distribution.edit-logs-soe-budget-distribution')->with('log',$log);

    }

    public function showeditlogs($id){
        $log = Soe_budget_distribution_logs::where('id', $id)->first();

        $district = District::all();
        $date = date('d-m-Y', strtotime($log->created_at));

        return view('soe-budget-distribution.view-logs-of-soe-budget-distribution')->with('district',$district)->with('log',$log)->with('user', $log->user()->first()->name)->with('date',$date);

        // print_r($decodelog); 
        // $table = "<table class='table table-bordered'>
        //             <thead>
        //                 <tr style='text-align: center;'>
        //                     <th>District</th>
        //                     <th colspan='4'>Financial</th>
        //                     <th colspan='5'>Physical Achievement</th>
        //                     <th colspan='3'>Beneficiaries</th>
                            
        //                 </tr>
        //                 <tr>
        //                     <th></th>
        //                     <th>Outlay</th>
        //                     <th>Revised Outlay</th>
        //                     <th>Expenditure</th>
        //                     <th>Percentage (%)</th>
        //                     <th>Item Name</th>
        //                     <th>Unit Of Measure</th>
        //                     <th>Unit</th>
        //                     <th>Achievement</th>
        //                     <th>Percentage (%)</th>
        //                     <th>Total</th>
        //                     <th>Women (Out of Total )</th>
        //                     <th>Disable (Out of total)</th>
        //                 </tr>
        //             </thead>
        //             <tbody>";

        //     $data=[];
        //     foreach($decodelog as $key=>$value){
        //         $data[$key]=(array)$value;
        //     }
        //     // $districtdata=$data;

        //     $outlay=0;
        //     $expenditure=0;
        //     $opercentage=0;
        //     $unit=0;
           
        //     $achievement=0;
        //     $upercentage=0;
        //     $ben_total=0;
        //     $women=0;
        //     $disable=0;
        //     $resvised_outlay=0;

        //     foreach ($district as $key => $value) {
        //         $i = $value->id;
        //         // if(sizeof($districtdata['outlay'])==$i){
        //         //     continue;
        //         // }
        //         $outlay=$outlay+$data['outlay'][$i];
        //         $resvised_outlay=$resvised_outlay+$data['resvised_outlay'][$i];
        //         $expenditure=$expenditure+$data['expenditure'][$i];
        //         $opercentage=$opercentage+$data['opercentage'][$i];
        //         $unit=$unit+$data['unit'][$i];
        //         $achievement=$achievement+$data['achievement'][$i];
        //         $upercentage=$upercentage+$data['upercentage'][$i];
        //         $ben_total=$ben_total+$data['ben_total'][$i];
        //         $women=$women+$data['women'][$i];
        //         $disable=$disable+$data['disable'][$i];


        //         $table .= "<tr>
        //                     <td>".$value->district_name."</td>
        //                     <td>".$data['outlay'][$i]."</td>
        //                     <td>".$data['resvised_outlay'][$i]."</td>
        //                     <td>".$data['expenditure'][$i]."</td>
        //                     <td>".$data['opercentage'][$i]."</td>
        //                     <td>".$data['item_name'][$i]."</td>
        //                     <td>".$data['unit_measure'][$i]."</td>
        //                     <td>".$data['unit'][$i]."</td>
        //                     <td>".$data['achievement'][$i]."</td>
        //                     <td>".$data['upercentage'][$i]."</td>
        //                     <td>".$data['ben_total'][$i]."</td>
        //                     <td>".$data['women'][$i]."</td>
        //                     <td>".$data['disable'][$i]."</td>
        //                 </tr>";
        //     }

        //     $table .= "<tr>
        //                 <th>Total</th>
        //                 <th>".$outlay."</th>
        //                 <th>".$resvised_outlay."</th>
        //                 <th>".$expenditure."</th>
        //                 <th>";
        //     $count1 = $expenditure / $resvised_outlay;
        //     $count2 = $count1 * 100;
        //     $table .= number_format($count2, 2)."</th>
        //                 <th></th> 
        //                 <th></th>
        //                 <th>".$unit."</th>
        //                 <th>".$achievement."</th>
        //                 <th>";
        //     if($achievement != 0)
        //     {
        //         $count3 = $achievement / $unit;
        //         $count4 = $count3 * 100;
        //     } else {
        //         $count4 = 0;
        //     }
        //     $table .= number_format($count4, 2)."</th>
        //                 <th>".$ben_total."</th>
        //                 <th>".$women."</th>
        //                 <th>".$disable."</th>
        //                 </tr></tbody></table>";

        //     // echo $table;
        //     $date = date('d-m-Y', strtotime($log->created_at));
        //     return response()->json(['table' => $table, 'date' => $date, 'user' => $log->user()->first()->name]);

    }
}
