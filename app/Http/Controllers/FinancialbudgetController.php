<?php
namespace App\Http\Controllers;
use App\Models\Financialbudget;
use App\Models\Department;
use App\Models\Majorhead;
use App\Models\Scheme_master;
use App\Models\Soe_master;
use App\Models\District_percentage;
use App\Models\District;
use App\Models\Finyear;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class FinancialbudgetController extends Controller
{
    public function index(){   


        if(auth()->user()->role_id === 1) {
            $soeBudgetDistribution = Soe_budget_distribution::orderBy('id', 'DESC')->paginate(10);
        } else {
            $soeBudgetDistribution = Soe_budget_distribution::where("department_id", auth()->user()->department_id)
            ->orderBy('id', 'DESC')
            ->paginate(10);
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

       //  dd($planlist);
        return view('financial-budget.create-financial-budget')->with('departmentlist',$departmentlist)
                                                                            ->with('finyearlist',$finyearlist)
                                                                            ->with('districtlist',$districtlist)
                                                                            ->with('planlist',$planlist);
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
            $soeList = Soe_master::where('scheme_id', $request->scheme_id)->get();
            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';
            foreach ($soeList as $soe) {
                $soeHtml .= '<option value="'.$soe->id.'">'.$soe->soe_name.'</option>';
            }
        }
        return response()->json(['soeHtml' => $soeHtml]);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(), [
            'department_id' => 'required',
            'majorhead_id' => 'required',
            'scheme_id' => 'required',
            'soe_id' => 'required',
            'fin_year_id' => 'required',
            'type' => 'required'
            
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
                $districtlist =  District::all();
                for ($i=0; $i < count($districtlist) ; $i++) { 
                    if($request->has($districtlist[$i]['district_name'])){
                        if($request->{$districtlist[$i]['district_name']} > 0){
                                $schemebudgetdistribution = new Soe_budget_distribution;
                            $schemebudgetdistribution->department_id = $request->department_id;
                            $schemebudgetdistribution->majorhead_id = $request->majorhead_id;
                            $schemebudgetdistribution->scheme_id = $request->scheme_id;
                            $schemebudgetdistribution->soe_id = $request->soe_id;
                            $schemebudgetdistribution->fin_year_id = $request->fin_year_id;
                            $schemebudgetdistribution->plan_id = $request->plan_id;
                            $schemebudgetdistribution->district_id =$districtlist[$i]['id'];
                            $schemebudgetdistribution->outlay =$request->{$districtlist[$i]['district_name']} == 0 ? 0 :
                                                                $request->{$districtlist[$i]['district_name']}*100000;
                    
                            $res = $schemebudgetdistribution->save();
                        }
                    }
                }
                if($res=="true"){
                    return redirect()->route('soe-budget-distribution.index')
                    ->with('success', 'Soe budget distributed successfully.');
                }
        }
    }

    public function show($id){
        $soebudgetdistribution = Soe_budget_distribution::find($id);
        return view('soe-budget-distribution.show-soe-budget-distribution')->with('soebudgetdistribution', $soebudgetdistribution);
    }

    public function get_soe_undistributed_outlay(Request $request){
        if($request->department_id > 0 && $request->majorhead_id > 0 && $request->scheme_id > 0 && $request->soe_id > 0 && $request->fin_year_id > 0){}
        if($request->soe_id > 0 && $request->scheme_id > 0){
            $totaloutlay = Soe_budget_allocation::select('department_id','majorhead_id','scheme_id','soe_id','fin_year_id','outlay','plan_id')
                                                ->where('department_id', $request->department_id)
                                                ->where('majorhead_id', $request->majorhead_id)
                                                ->where('scheme_id', $request->scheme_id)
                                                ->where('soe_id', $request->soe_id)
                                                ->where('fin_year_id', $request->fin_year_id)
                                                ->get();
            $distribute_outlay = Soe_budget_distribution::select('department_id','majorhead_id','scheme_id','soe_id','fin_year_id','district_id','outlay')
                                                ->where('department_id', $request->department_id)
                                                ->where('majorhead_id', $request->majorhead_id)
                                                ->where('scheme_id', $request->scheme_id)
                                                ->where('soe_id', $request->soe_id)
                                                ->where('fin_year_id', $request->fin_year_id)
                                                ->get();
            $distributeOutlay = 0;
            if(count($totaloutlay) > 0){
                if (count($distribute_outlay) > 0) {
                    for ($i=0; $i <= $distribute_outlay->keys()->last() ; $i++) {
                        $distributeOutlay += $distribute_outlay[$i]['outlay'];
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

            }
            else{
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

    public function districtList(){
        $districtlist = District::all();

        return view('soe-budget-distribution.edit-soe-budget-distribution')->with('districtlist',$districtlist);
    }

    public function get_districtPercentage(){
        $districtlist =  District::all();
        $districtpercentagelist =  District_percentage::all();

        return response()->json(['districtpercentagelist'=>$districtpercentagelist,
                                'districtlist'=>$districtlist]);
    }

    public function update(Request $request, $id){
        $districtlist =  District::all();
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
        }
        if($res=="true"){
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
}
