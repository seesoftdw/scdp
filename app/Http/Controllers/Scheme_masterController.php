<?php

namespace App\Http\Controllers;

use App\Models\Scheme_master;
use App\Models\Department;
use App\Models\Majorhead;
use App\Models\Soe_master;
use App\Models\Soe_budget_allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportSchemeMaster;
use Auth;
class Scheme_masterController extends Controller
{
    public function index()
    {
        if(auth()->user()->role_id === 1) {
            $schememaster= Scheme_master::orderBy('id', 'DESC')->get();//paginate(10);
        } else {
            $schememaster=  Scheme_master::where("department_id", auth()->user()->department_id)
            ->orderBy('id', 'DESC')
            ->get();//paginate(10);
        }

        if (count($schememaster) > 0) {
            return view('scheme-master.view-scheme-master', compact('schememaster'));
        } else {
            return view('scheme-master.view-scheme-master');
        }
    }

    public function departmentList()
    {
        $departmentList = Department::all();
        return response()->json(['departmentList' => $departmentList]);
    }

    public function get_scheme_majorhead(Request $request)
    {
        $majorheadHTML='';
        if (!$request->department_id) {
            $majorheadHTML .= '<option value="">'."---Select Majorhead---".'</option>';
        }
        else {
            $html = '';
            $majorheadlist = Majorhead::where('department_id', $request->department_id)->get();
            $majorheadHTML .= '<option value="">'."---Select Majorhead---".'</option>';
            foreach ($majorheadlist as $majorhead) {
                $majorheadHTML .= '<option value="'.$majorhead->id.'">'.$majorhead->complete_head.'</option>';
            }
        }
        return response()->json(['majorheadHTML' => $majorheadHTML]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'department_id' => 'required',
            'majorhead_id' => 'required',
            'scheme_name' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            $isExist = Scheme_master::where("department_id", $request->department_id)
            ->where("majorhead_id", $request->majorhead_id)
            ->where("scheme_name", $request->scheme_name)
            ->exists();
            if(!$isExist) {
                Scheme_master::create($request->all());
                return redirect()->route('scheme-master.index')
                    ->with('success', 'Scheme Name & Major Head created successfully.');
            }else{
                return redirect()->route('scheme-master.index')
                ->with('error', 'Scheme Name & Major Head already exist.');
            }
        }
    }

    public function show($id)
    {
        $schememaster = Scheme_master::find($id);
        return view('scheme-master.show-scheme-master')->with('schememaster', $schememaster);
    }

    public function get_schememaster_data(Request $request)
    {
        $schememasterdata = Scheme_master::where('id' , $request->scheme_id)->get();
        $departmentlist = Department::all();
        $majorheadlist = Majorhead::where('department_id', $schememasterdata[0]['department_id'])->get();
        return response()->json(['schememasterdata' => $schememasterdata,
                                'departmentlist' => $departmentlist, 
                                'majorheadlist' => $majorheadlist, 
                                ]);
    }

    public function update(Request $request, $id)
    {
        $schemenamemajorhead = Scheme_master::find($id);
        $input = $request->all();

        $validate = Validator::make($request->all(), [
            'department_id' => 'required',
            'majorhead_id' => 'required',
            'scheme_name' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            $isExist = Scheme_master::where("department_id", $request->department_id)
            ->where("majorhead_id", $request->majorhead_id)
            ->where("scheme_name", $request->scheme_name)
            ->where("id",'!=', $id)
            ->exists();
            if(!$isExist) {
                $res = $schemenamemajorhead->update($input);
                return redirect('scheme-master')->with('update', 'Scheme master Updated!'); 
            }else{
                return redirect()->route('scheme-master.index')
                ->with('error', 'Scheme master already exist.');
            }
        }
    }

    public function destroy($id)
    {
        $soe_budget_allocation = Soe_budget_allocation::where('scheme_id',$id)->get();
        $soe_master = Soe_master::where('scheme_id',$id)->get();

        if(count($soe_budget_allocation) > 0){
            return redirect('scheme-master')->with('alert', 'Scheme is assigned with the soe-budget-allocation, please delete soe-budget-allocation first to delete the scheme.');
        }elseif(count($soe_master) > 0){
            return redirect('scheme-master')->with('alert', 'Scheme is assigned with the soe, please delete soe first to delete the scheme.');
        }else{
            $schemenamemajorhead = Scheme_master::find($id);
            $schemenamemajorhead->delete();
            return redirect('scheme-master')->with('delete', 'Scheme Name & Major Head Deleted!');
        }
    }

    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportSchemeMaster, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Majorhead imported successfully.');
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
