<?php

namespace App\Http\Controllers;
use App\Models\District_percentage;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DistrictPercentageController extends Controller
{
    public function index()
    {
        $districtPercentage = District_percentage::orderBy('id', 'DESC')->get();//paginate(10);
        $district = District_percentage::pluck('percentage')->toArray();
        $district_percentage = array_sum($district);
        if(count($districtPercentage) > 0){
            return view('district-percentage.view-percentage', compact('districtPercentage', 'district_percentage'));
        }else{
            return view('district-percentage.view-percentage');
        }
    }

    public function districtList()
    {
        $districtList = District::all();
        if(count($districtList) > 0){
            return view('district-percentage.create-percentage', compact('districtList'));
        }else{
            return view('district-percentage.create-percentage');
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
			'district_id' => 'required|unique:district_percentage',
			'percentage' => 'required',
		]);
			if($validate->fails()){
				return back()->withErrors($validate->errors())->withInput();
			}else{
                $district = District_percentage::pluck('percentage')->toArray();
                array_push($district, $request->percentage);
                if(array_sum($district) <= 100)
                {
    				District_percentage::create($request->all());
    				return redirect()->route('district-percentage.index')
					   ->with('success','District percentage added successfully.');
                } else {
                    return back()->with('error','District percentage total is more than 100%.');
                }
            }
    }

    public function show($id)
    {
        $districtPercentage = District_percentage::find($id);
        return view('district-percentage.show-percentage')->with('districtPercentage', $districtPercentage);
    }

    public function edit($id)
    {
        $districtPercentage = District_percentage::find($id);
        $districtList = District::all();
        return view('district-percentage.edit-percentage')->with('districtPercentage', $districtPercentage)->with('districtList', $districtList);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'district_id' => 'required|unique:district_percentage,id,' . $id,
            'percentage' => 'required',
        ]);

        if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
        }else{
            $districtPercentage = District_percentage::find($id);
            $input = $request->all();

            $district = District_percentage::where('id', '!=', $id)->pluck('percentage')->toArray();
            array_push($district, $request->percentage);

            if(array_sum($district) <= 100)
            {
                $res = $districtPercentage->update($input);
                return redirect('district-percentage')->with('update', 'District Percentage Updated!'); 
            } else {
                return back()->with('error','District percentage total is more than 100%.');
            }
        }
    }

    public function destroy($id)
    {
        $districtPercentage = District_percentage::find($id);
        $districtPercentage->delete();
        return redirect('district-percentage')->with('delete', 'District Percentage Deleted!'); 
    }
}