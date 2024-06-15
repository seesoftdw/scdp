<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\Majorhead;
use App\Models\Scheme_master;
use App\Models\Soe_master;
use App\Models\Soe_budget_allocation;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportDepartment;

class DepartmentController extends Controller
{
    public function index()
    {
        $department = Department::orderBy('id', 'DESC')->get();//paginate(10);
        if (count($department) > 0) {
            return view('department.view-department', compact('department'));
        } else {
            return view('department.view-department');
        }
    }

    public function get_department_data(Request $request)
    {
        if($request->sendall)
        {
            $department = Department::all();
        } else {
            $department = Department::where('id' , $request->department_id)->get();
        }
        return response()->json(['department' => $department]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'hod_code' => 'required|unique:departments|min:1|max:3',
            'hod_name' => 'required|unique:departments',
            'department_name' => 'required|unique:departments',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            Department::create($request->all());
            return redirect()->route('department.index')
                ->with('success', 'Department created successfully.');
        }
    }
    
    public function show($id)
    {
        $department = Department::find($id);
        return view('department.show-department')->with('department', $department);
    }

    public function update(Request $request, $id)
    {
        $department = Department::find($id);
        $input = $request->all();
    
        $validate = Validator::make($input, [
            'hod_code' => 'required|unique:departments,hod_code,'.$department->id,'id|min:1|max:3',
            'hod_name' => 'required|unique:departments,hod_name,'.$department->id,'id',
            'department_name' => 'required|unique:departments,department_name,'.$department->id,'id'
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            $res = $department->update($input);
            return redirect('department')->with('update', 'Department updated!');

        }
    }


    public function destroy($id)
    {
        $user = User::where('department_id',$id)->get();
        $delete_user = $user->where("role_id","!=",1);  
        if(count($delete_user) > 0){
            foreach($delete_user as $user){
                $user->delete();
            }
        }        
        
        $soe_budget_allocation = Soe_budget_allocation::where('department_id',$id)->get();
        $soe_master = Soe_master::where('department_id',$id)->get();
        $scheme_master = Scheme_master::where('department_id',$id)->get();
        $majorhead = Majorhead::where('department_id',$id)->get();
        $sector = Sector::where('department_id',$id)->get();

        if(count($soe_budget_allocation) > 0){
            return redirect('department')->with('alert', 'Department is assigned with the soe-budget-allocation, please delete soe-budget-allocation first to delete the department.');
        }elseif(count($soe_master) > 0){
            return redirect('department')->with('alert', 'Department is assigned with the soe, please delete soe first to delete the department.');
        }elseif(count($scheme_master) > 0){
            return redirect('department')->with('alert', ' Department is assigned with the schemes, please delete scheme first to delete the department.');
        }elseif(count($majorhead) > 0){
            return redirect('department')->with('alert', 'Department is assigned with the majorhead, please delete majorhead first to delete the department.');
        }elseif(count($sector) > 0){
            return redirect('department')->with('alert', 'Department is assigned with the sector, please delete sector first to delete the department.');
        }else{
            $department = Department::find($id);
            $department->delete(); 
            return redirect('department')->with('delete', 'Department deleted!');
        }
        
    }
    
    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportDepartment, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Department imported successfully.');
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