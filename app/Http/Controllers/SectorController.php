<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Sector;
use App\Models\Subsector;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportSector;

class SectorController extends Controller
{
    public function index()
    {
        $sector = Sector::orderBy('id', 'DESC')->get();//paginate(10);
        if (count($sector) > 0) {
            return view('sector.view-sector', compact('sector'));
        } else {
            return view('sector.view-sector');
        }
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'service_id' => 'required',
            'department_id' => 'required',
            'sector_name' => 'required|min:5|unique:sectors',
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            Sector::create($request->all());
            return redirect()->route('sector.index')
                ->with('success', 'Sector created successfully.');
        }
    }

    public function get_service_list()
    {
        $serviceList = Service::all();
        return response()->json(['$serviceList' => $serviceList]);
    }

    public function get_sector_data(Request $request)
    {
        $serviceList = Service::all();
        $departmentList = Department::all();
        $sectorData = Sector::where('id' , $request->sector_id)->get();
        return response()->json(['$serviceList' => $serviceList,
                                'sectorData' => $sectorData,
                                'departmentList' => $departmentList
                                ]);
    }
    public function get_scheme_master_data(Request $request)
    {
        $departmentList = Department::all();
        $schemenamemajorhead = Scheme_master::where('id' , $request->schemename_majorhead_id)->get();
        return response()->json(['schemenamemajorhead' => $schemenamemajorhead,
                                'departmentList' => $departmentList, 
                                ]);
    }

    public function show($id)
    {
        $sector = Sector::find($id);
        return view('sector.show-sector')->with('sector', $sector);
    }

    public function update(Request $request, $id)
    {
        $sector = Sector::find($id);
        $input = $request->all();

        $validate = Validator::make($request->all(), [
            'service_id' => 'required',
            'department_id' => 'required',
            'sector_name' => 'required|unique:sectors,sector_name,'.$sector->id,'id'
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        } else {
            $isExist = Sector::where("service_id", $request->service_id)
            ->where("department_id", $request->department_id)
            ->where("sector_name", $request->sector_name)
            ->where("id",'!=', $id)
            ->exists();
            if(!$isExist) {
                $res = $sector->update($input);
                return redirect('sector')->with('update', 'Sector updated!'); 
            }else{
                return redirect()->route('sector')
                ->with('error', 'Sector already exist.');
            }
        }

    }
    
    public function destroy($id)
    {
        $subSector = Subsector::where('sector_id',$id)->get();

        if(count($subSector) > 0){
            return redirect('sector')->with('alert', 'Sector is exist in sub-sector, please delete sub-sector first to delete the sector.');
        }else{
            $sector = Sector::find($id);
            $sector->delete();
            return redirect('sector')->with('delete', 'Sector deleted!');
        }
    }

    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportSector, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Sector imported successfully.');
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