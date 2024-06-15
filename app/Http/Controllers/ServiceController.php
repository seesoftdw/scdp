<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportService;

class ServiceController extends Controller
{
    public function index()
    {
        $service = Service::orderBy('id', 'DESC')->get();//paginate(10);
        if(count($service) > 0){
            return view('service.view-service', compact('service'));
        }else{
            return view('service.view-service');
        }        
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'service_name' => 'required|unique:services',
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }else{
            Service::create($request->all());
            return redirect()->route('service.index')->with('success', 'Service created successfully.');
        }
    }

    public function show($id)
    {
        $service = Service::find($id);
        return view('service.show-service')->with('service', $service);
    }

    public function edit($id)
    {
        $service = Service::find($id);
        return view('service.edit-service')->with('service', $service);
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        $input = $request->all();

        $validate = Validator::make($input, [
            'service_name' => 'required|unique:services,service_name,'.$service->id,'id'
        ]);
        
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }else{
            $res = $service->update($input);
            return redirect('service')->with('update', 'Service updated.');
        }
    }
    public function destroy($id)
    {

        $sector = Sector::where('service_id',$id)->get();

        if(count($sector) > 0){
            return redirect('service')->with('alert', 'Service is exist with the sector, please delete sector first to delete the service.');
        }else{
            $service = Service::find($id);
            $service->delete();
            return redirect('service')->with('delete', 'Service Deleted.');
        }
    }

    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportService, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Services imported successfully.');
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
