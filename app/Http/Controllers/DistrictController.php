<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\District_percentage;
use App\Models\Soe_budget_distribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportDistrict;
class DistrictController extends Controller
{
    public function index()
    {
        // $district = District::all();
        $district = District::orderBy('id', 'DESC')->get();//paginate(10);
        if(count($district) > 0){
            return view('district.view-district', compact('district'));
        }else{
            return view('district.view-district');
        }        
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'district_name' => 'required|unique:districts',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }else{
            District::create($request->all());
            return redirect()->route('district.index')->with('success', 'District created successfully.');
        }
    }

    public function show($id)
    {
        $district = District::find($id);
        return view('district.show-district')->with('district', $district);
    }

    public function edit($id)
    {
        $district = District::find($id);
        return view('district.edit-district')->with('district', $district);
    }

    public function update(Request $request, $id)
    {
        $district = District::find($id);
        $input = $request->all();
        $res = $district->update($input);
        return redirect('district')->with('update', 'District updated.');
    }
    public function destroy($id)
    {
        $districtPercentage = District_percentage::where('district_id',$id)->get();
        $soeBudgetDistribution = Soe_budget_distribution::where('district_id',$id)->get();

        if(count($districtPercentage) > 0){
            return redirect('district')->with('alert', 'District percentage is assigned with the district, please delete district percentage first to delete the district.');
        }elseif(count($soeBudgetDistribution) > 0){
            return redirect('district')->with('alert', 'Soe budget distribution is assigned with the district, please delete Soe budget distribution first to delete the district.');
        }else{
            $district = District::find($id);
            $district->delete();
            return redirect('district')->with('delete', 'District Deleted.');
        }
    }
    
    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportDistrict, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'District imported successfully.');
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