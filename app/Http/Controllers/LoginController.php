<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Finyear;
class LoginController extends Controller
{
    public function show()
    {

        $fyear=Finyear::get();
        return view('auth.login')->with('fyear',$fyear);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        //dd($credentials);
        if(!Auth::validate($credentials)):
            return redirect()->to('/')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);
        // To Do : in future
        // get the user id from $user
        // write query to get $user role and respnsibility
        // retvied result store in variable $rolesAndResponsibilities = ['1','2','3'];

        // $rolesAndResponsibilities = ['1','2','3'];
        // $user->roles = $rolesAndResponsibilities;
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')
                        ->user()
                        ->generateAndSaveApiAuthToken();

        Session::put('finyear', $request->finyear);
        return $this->authenticated($request, $user);
        }
    }

    public function chage_fin_year(Request $request)
    {
            Session::put('finyear', $request->fin_year);
    }

    protected function authenticated(Request $request, $user) 
    {
        return redirect('/dashboard');
    }
}