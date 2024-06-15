<?php

namespace App\Http\Controllers;
use App\Models\Component;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportComponent;

class ComponentController extends Controller
{
    public function index()
    {
        // $component = Component::all();
        $component = Component::orderBy('id', 'DESC')->paginate(10);
        if(count($component) > 0){
            return view('component.view-component', compact('component'));
        }else{
            return view('component.view-component');
        }
    }

    public function store(Request $request)
    {
		$validate = Validator::make($request->all(), [
			'component_name' => 'required|min:5|unique:components',
		]);
			if($validate->fails()){
				return back()->withErrors($validate->errors())->withInput();
			}else{
				Component::create($request->all());
				return redirect()->route('component.index')
					->with('success','Component created successfully.');
			}
    }

    public function show($id)
    {
        $component = Component::find($id);
        return view('component.show-component')->with('component', $component);
    }

    public function edit($id)
    {
        $component = Component::find($id);
        return view('component.edit-component')->with('component', $component);
    }

    public function update(Request $request, $id)
    {
        $component = Component::find($id);
        $input = $request->all();
        $res = $component->update($input);
        return redirect('component')->with('update', 'Component Updated!');  
    }
    
    public function destroy($id)
    {
        $component = Component::find($id);
        $component->delete();
        return redirect('component')->with('delete', 'Component Deleted!'); 
    }

    public function import(Request $request){
        if(!$request->file('file')) {
            return back()->with('error', 'Please select excel first!');
        }
        else{
            if($request->file->extension() == 'xlsx' || $request->file->extension() == 'xls'){
                try {
                    $res = Excel::import(new ImportComponent, $request->file('file')->store('files'));
                    return redirect()->back()->with('success', 'Component imported successfully.');
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