<?php

namespace App\Http\Controllers;
use App\Models\Soe_budget_allocation;
use App\Models\Department;
use App\Models\Majorhead;
use App\Models\Scheme_master;
use App\Models\Soe_master;
use App\Models\Finyear;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Sector;
use App\Models\Subsector; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportSoeBudgetAllocation;
use App\Imports\BulkImportNewBudget;
use Session;
use auth;


class Soe_budget_allocation_Controller extends Controller
{
    public function index()
    {
        $soeBudgetallocation = Soe_budget_allocation::where("fin_year_id",Session::get('finyear'))->orderBy('id', 'DESC')->get();//paginate(10);
        
        if (count($soeBudgetallocation) > 0) {
            return view('soe-budget-allocation.view-soe-budget-allocation', compact('soeBudgetallocation'));
        } else {
            return view('soe-budget-allocation.view-soe-budget-allocation');
        }
    }

    public function allList()
    {
        $departmentlist = Department::all();
        $finyearlist = Finyear::all();
        $planlist = Plan::all();
        $servicelist = Service::all();
        return view('soe-budget-allocation.create-soe-budget-allocation')->with('departmentlist', $departmentlist)
                                                                        ->with('finyearlist', $finyearlist)
                                                                        ->with('planlist', $planlist)
                                                                        ->with('servicelist', $servicelist);
    }

    public function get_allocation_majorhead_by_department(Request $request)
    {
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

    public function get_allocation_scheme_by_majorhead(Request $request)
    {
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

    public function get_allocation_soe_by_scheme(Request $request)
    {
        $soeHtml='';
        if (!$request->scheme_id) {
            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';
        }
        else {
            $html = '';
            $soeList = Soe_master::where('scheme_id', $request->scheme_id)->get();
            $soeHtml .= '<option value="">'."---Select Soe---".'</option>';
            foreach ($soeList as $soe) {
                $soe_id = Soe_budget_allocation::where('soe_id',$soe->id)->first();
                if(empty($soe_id))
                {
                    $soeHtml .= '<option value="'.$soe->id.'">'.$soe->soe_name.'</option>';
                }
            }
        }
        return response()->json(['soeHtml' => $soeHtml]);
    }

    public function get_allocation_sector_by_service(Request $request)
    {
        $sectorhtml='';
        $subsectorhtml='';

        if (!$request->service_id) {

            $sectorhtml .= '<option value="">'."--- Select Sector ---".'</option>';
            $subsectorhtml .= '<option value="">'."---Select sub-sector---".'</option>';

        } elseif (!$request->department_id) {

            $sectorhtml .= '<option value="">'."--- Select Sector ---".'</option>';
            $subsectorhtml .= '<option value="">'."---Select sub-sector---".'</option>';

        } else {

            $html = '';
            $sectorlist = Sector::where('service_id', $request->service_id)->where('department_id', $request->department_id)->get();
            $sectorhtml .= '<option value="">'."--- Select Sector ---".'</option>';
            $subsectorhtml .= '<option value="">'."---Select sub-sector---".'</option>';

            foreach ($sectorlist as $sector) {
                $sectorhtml .= '<option value="'.$sector->id.'">'.$sector->sector_name.'</option>';
            }

        }

        return response()->json(['sectorhtml' => $sectorhtml, 'subsectorhtml' => $subsectorhtml]);
    }

    public function get_allocation_subsector_by_sector(Request $request)
    {
        $subsectorhtml='';
        if (!$request->sector_id) {
            $subsectorhtml .= '<option value="">'."---Select sub-sector---".'</option>';
        }
        else {
            $html = '';
            $subsectorlist = Subsector::where('sector_id', $request->sector_id)->get();
            $subsectorhtml .= '<option value="">'."---Select sub-sector---".'</option>';
            foreach ($subsectorlist as $subsector) {
                $subsectorhtml .= '<option value="'.$subsector->id.'">'.$subsector->subsectors_name.'</option>';
            }
        }
        return response()->json(['subsectorhtml' => $subsectorhtml]);
    }

    public function store(Request $request)
    {
        $input=$request->all();
        $input['hod_outlay'] = $request->hod_outlay * 100000;
        $input['district_outlay'] = $request->district_outlay * 100000;
        $input['outlay'] = $request->outlay * 100000;
        $validate = Validator::make($input, [
            'department_id' => 'required',
            'majorhead_id' => 'required',
            'scheme_id' => 'required',
            'soe_id' => 'required',
            'fin_year_id' => 'required',
            'outlay' => 'required',
            'earmarked' => 'required',
            'plan_id' => 'required',
            'service_id' => 'required',
            'sector_id' => 'required',
            'subsector_id' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            $isExist = Soe_budget_allocation::where("department_id", $input['department_id'])
            ->where("majorhead_id", $input['majorhead_id'])
            ->where("scheme_id",$input['scheme_id'])
            ->where("soe_id", $input['soe_id'])
            ->where("fin_year_id", $input['fin_year_id'])
            ->where("outlay", $input['outlay'])
            ->where("earmarked", $input['earmarked'])
            ->where("plan_id", $input['plan_id'])
            ->where("service_id", $input['service_id'])
            ->where("sector_id", $input['sector_id'])
            ->where("subsector_id", $input['subsector_id'])
            ->exists();

            if(!$isExist) {
                Soe_budget_allocation::create($input);
                return redirect()->route('soe-budget-allocation.index')
                    ->with('success', 'Soe budget allocated successfully.');
            }else{
                return redirect()->route('soe-budget-allocation.index')
                ->with('error', 'Soe budget already allocated exists.');
            }

            
        }
    }

    public function show($id)
    {
        $soebudgetallocation = Soe_budget_allocation::find($id);
        return view('soe-budget-allocation.show-soe-budget-allocation')->with('soebudgetallocation', $soebudgetallocation);
    }

    public function get_soe_budget_allocation_data(Request $request)
    {
        $soebudgetallocation = Soe_budget_allocation::where('id' , $request->soe_budget_allocation_id)->get();
        $departmentlist = Department::all();
        $majorheadlist = Majorhead::where('department_id', $soebudgetallocation[0]['department_id'])->get();
        $schemelist = Scheme_master::where('majorhead_id', $soebudgetallocation[0]['majorhead_id'])->get();
        $soelist = Soe_master::where('scheme_id', $soebudgetallocation[0]['scheme_id'])->get();
        $finyearlist = Finyear::all();
        $planlist = Plan::all();
        $servicelist = Service::all();
        $sectorlist = Sector::where('service_id', $soebudgetallocation[0]['service_id'])->get();
        $subsectorlist = Subsector::where('sector_id', $soebudgetallocation[0]['sector_id'])->get();

        return response()->json(['soebudgetallocation' => $soebudgetallocation, 
                                'departmentlist' => $departmentlist,
                                'majorheadlist' => $majorheadlist,
                                'schemelist' => $schemelist,
                                'soelist' => $soelist,
                                'finyearlist' => $finyearlist,
                                'planlist' => $planlist,
                                'servicelist' => $servicelist,
                                'sectorlist' => $sectorlist,
                                'subsectorlist' => $subsectorlist]);
    }    

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $soebudgetallocation = Soe_budget_allocation::find($id);
        $input = $request->all();
        $input['hod_outlay'] = $request->hod_outlay * 100000;
        $input['district_outlay'] = $request->district_outlay * 100000;
        $input['outlay'] = $request->outlay * 100000;

        $validate = Validator::make($input, [
            'department_id' => 'required',
            'majorhead_id' => 'required',
            'scheme_id' => 'required',
            'soe_id' => 'required',
            'fin_year_id' => 'required',
            'outlay' => 'required',
            'earmarked' => 'required',
            'plan_id' => 'required',
            'service_id' => 'required',
            'sector_id' => 'required',
            'subsector_id' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            $isExist = Soe_budget_allocation::where("department_id", $input['department_id'])
            ->where("majorhead_id", $input['majorhead_id'])
            ->where("scheme_id",$input['scheme_id'])
            ->where("soe_id", $input['soe_id'])
            ->where("fin_year_id", $input['fin_year_id'])
            ->where("outlay", $input['outlay'])
            ->where("earmarked", $input['earmarked'])
            ->where("plan_id", $input['plan_id'])
            ->where("service_id", $input['service_id'])
            ->where("sector_id", $input['sector_id'])
            ->where("subsector_id", $input['subsector_id'])
            ->where("id",'!=', $id)
            ->exists();
            
            if(!$isExist) {;
                $res = $soebudgetallocation->update($input);
                return redirect('soe-budget-allocation')->with('update', 'Soe budget updated!');
            }else{
                return redirect()->route('soe-budget-allocation.index')
                ->with('error', 'Soe budget already allocated exists.');
            }
        }
    }


    public function destroy($id)
    {
        $soeBudgetallocation = Soe_budget_allocation::find($id);
        $soeBudgetallocation->delete();
        return redirect('soe-budget-allocation')->with('delete', 'Soe-budget deleted!');
    }

    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportSoeBudgetAllocation, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Soe budget allocation imported successfully.');
                } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                    $failures = $e->failures();
                    return redirect()->back()->with('import_errors', $failures);
                }
            }
            else{
                return back()->with('error', 'The excel file must be a file of type:xlsx');
            }            
        }
    }

    public function bulk_import_show()
    {
        return view('soe-budget-allocation.bulk-import');
    }

    public function bulkimport(Request $request)
    {
        // print_r("sfsd"); die;
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new BulkImportNewBudget, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Soe budget allocation imported successfully.');
                } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                    $failures = $e->failures();
                    return redirect()->back()->with('import_errors', $failures);
                }
            }
            else{
                return back()->with('error', 'The excel file must be a file of type xlsx or xls');
            }            
        }
    }
    
}
