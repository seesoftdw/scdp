<?php

namespace App\Http\Controllers;
use App\Models\Majorhead;
use App\Models\Department;
use App\Models\Scheme_master;
use App\Models\Soe_master;
use App\Models\Soe_budget_allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportMajorhead;


class MajorheadController extends Controller
{
    public function index()
    {
        $majorhead = Majorhead::orderBy('id', 'DESC')->get();//paginate(10);
        
        if(count($majorhead) > 0){
            return view('majorhead.view-majorhead', compact('majorhead'));
        }else{
            return view('majorhead.view-majorhead');
        }
    }

    public function get_major_department(){
        $departmentlist = Department::all();
        if(count($departmentlist) > 0){
            return view('majorhead.create-majorhead', compact('departmentlist'));
        }else{
            return view('majorhead.create-majorhead');
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'department_id' => 'required',
            'mjr_head' => 'required|min:4|max:4',
            'sm_head' => 'required|min:2|max:2',
            'min_head' => 'required|min:3|max:3',
            'sub_head' => 'required|min:2|max:2',
            'bdgt_head' => 'required|min:4|max:4',
            'complete_head' => 'required|unique:majorhead',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            $isExist = Majorhead::where("department_id", $request->department_id)
            ->where("mjr_head", $request->mjr_head)
            ->where("sm_head", $request->sm_head)
            ->where("min_head", $request->min_head)
            ->where("sub_head", $request->sub_head)
            ->where("bdgt_head", $request->bdgt_head)
            ->where("complete_head", $request->complete_head)
            ->exists();
            
            if(!$isExist) {
                if(str_starts_with($request->complete_head,2) || str_starts_with($request->complete_head,3)){
                    $request['type'] ="revenue";
                }
                if(str_starts_with($request->complete_head,4) || str_starts_with($request->complete_head,5)){
                    $request['type'] ="capital";
                }
                if(str_starts_with($request->complete_head,6)){
                    $request['type'] ="loan";
                }
                Majorhead::create($request->all());
                return redirect()->route('majorhead.index')
                    ->with('success', 'Major Head created successfully.');
            }else{
                return redirect()->route('majorhead.index')
                ->with('error', 'Major Head already exist.');
            }
        }
    }

    public function show($id)
    {
        $majorhead = Majorhead::find($id);
        return view('majorhead.show-majorhead')->with('majorhead', $majorhead);
    }

    public function get_majorhead_data(Request $request)
    {
        $majorhead = Majorhead::where('id' , $request->majorhead_id)->get();
        $departmentlist = Department::all();
        return response()->json(['majorhead' => $majorhead, 'departmentlist' => $departmentlist]);
    } 

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $majorhead = Majorhead::find($id);
        $input = $request->all();

        $validate = Validator::make($input, [
            'department_id' => 'required',
            'mjr_head' => 'required|min:4|max:4',
            'sm_head' => 'required|min:2|max:2',
            'min_head' => 'required|min:3|max:3',
            'sub_head' => 'required|min:2|max:2',
            'bdgt_head' => 'required|min:4|max:4',
            'complete_head' => 'required|unique:majorhead,complete_head,'.$majorhead->id,'id',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            if(str_starts_with($input['complete_head'],2) || str_starts_with($input['complete_head'],3)){
                $input['type'] ="revenue";
            }
            if(str_starts_with($input['complete_head'],4) || str_starts_with($input['complete_head'],5)){
                $input['type'] ="capital";
            }
            if(str_starts_with($input['complete_head'],6)){
                $input['type'] ="loan";
            }

            $res = $majorhead->update($input);
            return redirect('majorhead')->with('update', 'Majorhead updated!');
        }
    }

    public function destroy($id)
    {
        $soe_budget_allocation = Soe_budget_allocation::where('majorhead_id',$id)->get();
        $soe_master = Soe_master::where('majorhead_id',$id)->get();
        $scheme_master = Scheme_master::where('majorhead_id',$id)->get();

        if(count($soe_budget_allocation) > 0){
            return redirect('majorhead')->with('alert', 'Majorhead is assigned with the soe-budget-allocation, please delete soe-budget-allocation first to delete the majorhead.');
        }elseif(count($soe_master) > 0){
            return redirect('majorhead')->with('alert', 'Majorhead is assigned with the soe, please delete soe first to delete the majorhead.');
        }elseif(count($scheme_master) > 0){
            return redirect('majorhead')->with('alert', ' Majorhead is assigned with the schemes, please delete scheme first to delete the majorhead.');
        }else{
            $majorhead = Majorhead::find($id);
            $majorhead->delete();
            return redirect('majorhead')->with('delete', 'Majorhead deleted!');
        }
    }

    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportMajorhead, $request->file('file')->store('files'));
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
