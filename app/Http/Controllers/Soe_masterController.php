<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Majorhead;
use App\Models\Scheme_master;
use App\Models\Soe_master;
use App\Models\Soe_budget_allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportSoeMaster;

class Soe_masterController extends Controller
{
    public function index()
    {
        if(auth()->user()->role_id === 1) {
            $soe = Soe_master::orderBy('id', 'DESC')->get();//paginate(10);
        } else {
            $soe=  Soe_master::where("department_id", auth()->user()->department_id)
            ->orderBy('id', 'DESC')
            ->get();//paginate(10);
        }
        
        if (count($soe) > 0) {
            return view('soe-master.view-soe-master', compact('soe'));
        } else {
            return view('soe-master.view-soe-master');
        }
    }

    public function soe_department_list()
    {
        $departmentList = Department::all();
        return response()->json(['departmentList' => $departmentList]);
    }

    public function get_soe_majorhead_by_department(Request $request)
    {
        $majorheadHtml='';
        $schemeHtml='';
        if (!$request->department_id) {
            $majorheadHtml .= '<option value="">'."---Select Majorhead---".'</option>';
            $schemeHtml .= '<option value="">'."---Select scheme---".'</option>';
        }
        else {
            $html = '';
            $majorheadList = Majorhead::where('department_id', $request->department_id)->get();
            $majorheadHtml .= '<option value="">'."---Select Majorhead---".'</option>';
            $schemeHtml .= '<option value="">'."---Select scheme---".'</option>';
            foreach ($majorheadList as $majorhead) {
                $majorheadHtml .= '<option value="'.$majorhead->id.'">'.$majorhead->complete_head.'</option>';
            }
        }
        return response()->json(['majorheadHtml' => $majorheadHtml, 'schemeHtml' => $schemeHtml]);
    }

    public function get_soe_scheme_by_majorhead(Request $request)
    {
        $schemeHtml='';
        if (!$request->majorhead_id) {
            $schemeHtml .= '<option value="">'."---Select scheme---".'</option>';
        }
        else {
            $html = '';
            $schemeList = Scheme_master::where('majorhead_id', $request->majorhead_id)->get();
            $schemeHtml .= '<option value="">'."---Select scheme---".'</option>';
            foreach ($schemeList as $scheme) {
                $schemeHtml .= '<option value="'.$scheme->id.'">'.$scheme->scheme_name.'</option>';
            }
        }
        return response()->json(['schemeHtml' => $schemeHtml]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'department_id' => 'required',
            'majorhead_id' => 'required',
            'scheme_id' => 'required',
            'soe_name' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            $isExist = Soe_master::where("department_id", $request->department_id)
            ->where("majorhead_id", $request->majorhead_id)
            ->where("scheme_id", $request->scheme_id)
            ->where("soe_name", $request->soe_name)
            ->exists();
            if(!$isExist) {
                Soe_master::create($request->all());
                return redirect()->route('soe-master.index')
                ->with('success', 'SOE_master created successfully.');
            }else{
                return redirect()->route('soe-master.index')
                ->with('error', 'SOE_master already exists.');
            }
        }
    }

    public function show($id)
    {
        $soe = Soe_master::find($id);
        return view('soe-master.show-soe-master')->with('soe', $soe);
    }

    public function get_soe_master_data(Request $request)
    {
        $soe = Soe_master::where('id' , $request->soe_id)->get();
        $departmentList = Department::all();
        $majorheadList = Majorhead::where('department_id',$soe[0]['department_id'])->get();
        $schemeMasterList = Scheme_master::where('majorhead_id',$soe[0]['majorhead_id'])->get();
        
        return response()->json([ 'departmentList' => $departmentList, 
                                'majorheadList' => $majorheadList, 
                                'schemeMasterList' => $schemeMasterList, 
                                'soe' => $soe
                                ]);
    }

    public function update(Request $request, $id)
    {
        $soe = Soe_master::find($id);
        $input = $request->all();

        $validate = Validator::make($request->all(), [
            'department_id' => 'required',
            'majorhead_id' => 'required',
            'scheme_id' => 'required',
            'soe_name' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            $isExist = Soe_master::where("department_id", $request->department_id)
            ->where("majorhead_id", $request->majorhead_id)
            ->where("scheme_id", $request->scheme_id)
            ->where("soe_name", $request->soe_name)
            ->where("id",'!=', $id)
            ->exists();
            if(!$isExist) {
                $res = $soe->update($input);
                return redirect('soe-master')->with('update', 'SOE_master updated!'); 
            }else{
                return redirect()->route('soe-master.index')
                ->with('error', 'Soe master already exist.');
            }
        }
    }


    public function destroy($id)
    {
        $soe_budget_allocation = Soe_budget_allocation::where('soe_id',$id)->get();

        if(count($soe_budget_allocation) > 0){
            return redirect('soe-master')->with('alert', 'Soe is assigned with the soe-budget-allocation, please delete soe-budget-allocation first to delete the soe.');
        }else{
            $soe = Soe_master::find($id);
            $soe->delete();
            return redirect('soe-master')->with('delete', 'SOE_master deleted!');
        }

    }
    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportSoeMaster, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Soe imported successfully.');
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
}