<?php

namespace App\Http\Controllers;
use App\Models\Subsector;
use App\Models\Sector;
use App\Models\Service;
use App\Models\Soe_budget_allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportSubsector;

class SubSectorController extends Controller
{
    public function index()
    {
        $subsector = Subsector::orderBy('id', 'DESC')->get();//paginate(10);
        
        if(count($subsector) > 0){
            return view('sub-sector.view-sub-sector', compact('subsector'));
        }else{
            return view('sub-sector.view-sub-sector');
        }
    }

    public function create()
    {
        
    }
    public function sectorList()
    {
        $sectorlist = Sector::all();
        if(count($sectorlist) > 0){
            return view('sub-sector.create-sub-sector', compact('sectorlist'));
        }else{
            return view('sub-sector.create-sub-sector');
        }
    }

    public function get_subsector_data(Request $request)
    {
        $subSectorData = Subsector::where('id' , $request->subsector_id)->get();
        $serviceList = Service::all();
        $sectorList = Sector::where('service_id', $subSectorData[0]['service_id'])->get();
        return response()->json(['serviceList' => $serviceList,
                                'sectorList' => $sectorList,
                                'subSectorData' => $subSectorData
                                ]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
			'service_id' => 'required',
            // 'department_id' => 'required',
            'sector_id' => 'required',
			'subsectors_name' => 'required|min:5|unique:subsectors',
		], [
            'service_id.required' => 'Service field is required.',
            'sector_id.required' => 'Sector name field is required.',
            'subsectors_name.required' => 'Sub-sector name field is required.',
            'subsectors_name.min' => 'Sub-sector name must be at least :min characters.',
            'subsectors_name.unique' => 'Sub-sector name has already been taken.',
        ]);
			if($validate->fails()){
				return back()->withErrors($validate->errors())->withInput();
			}else{
				Subsector::create($request->all());
				return redirect()->route('sub-sector.index')
					->with('success','Subsector created successfully.');
			}
    }

    public function get_sector(Request $request)
    {
        $sectorhtml='';
        if (!$request->service_id) {
            $sectorhtml .= '<option value="">'."--- Select Sector ---".'</option>';
        }
        else {
            $html = '';
            $sectorlist = Sector::where('service_id', $request->service_id)->get();
            $sectorhtml .= '<option value="">'."--- Select Sector ---".'</option>';
            foreach ($sectorlist as $sector) {
                $sectorhtml .= '<option value="'.$sector->id.'">'.$sector->sector_name.'</option>';
            }
        }
        return response()->json(['sectorhtml' => $sectorhtml]);
    }

    public function show($id)
    {
        $subsector = Subsector::find($id);
        return view('sub-sector.show-sub-sector')->with('subsector', $subsector);
    }

    public function update(Request $request, $id)
    {
        $subsector = Subsector::find($id);
        $input = $request->all();

        $validate = Validator::make($request->all(), [
            'service_id' => 'required',
            'department_id' => 'required',
            'sector_id' => 'required',
			'subsectors_name' => 'required|min:5|unique:subsectors,subsectors_name,'.$subsector->id,'id',
        ]);
        
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }else{
                $res = $subsector->update($input);
                return redirect('sub-sector')->with('update', 'Subsector Updated!');  
            }
        }

    public function destroy($id)
    {
        $soe_budget_allocation = Soe_budget_allocation::where('subsector_id',$id)->get();

        if(count($soe_budget_allocation) > 0){
            return redirect('sub-sector')->with('alert', 'Sub-sector is assigned with the soe-budget-allocation, please delete soe-budget-allocation first to delete the sub-sector.');
        }else{
            $subsector = Subsector::find($id);
            $subsector->delete();
            return redirect('sub-sector')->with('delete', 'Subsector Deleted!'); 
        }
    }

    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportSubsector, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Sub-Sector imported successfully.');
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