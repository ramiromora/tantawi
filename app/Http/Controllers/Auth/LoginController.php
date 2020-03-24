<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Adldap\AdldapInterface;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;


use Adldap\Laravel\Facades\Adldap;


class LoginController extends Controller
{
    /**
     * @var Adldap
     */
    protected $ldap;

    /**
     * Constructor.
     *
     * @param AdldapInterface $adldap
     */
    public function __construct(AdldapInterface $ldap)
    {
        $this->ldap = $ldap;
        $this->middleware('guest')->except('logout');
    }
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function index()
    {
        $user = $this->ldap->search()->users()->find('Ramiro');
        
        return view('users.index', compact('users'));
    }
    
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    public function login(Request $request){
        $use = $this->ldap->search()->users()->find($request->username);
        if(is_null($use)){
            //dd($use);
        }
        $credentials1 = $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ]);
        if(Auth::attempt($credentials1))
        {
            if(!is_null(\Auth::user()->deleted_at)){
                
                $this->guard()->logout();
                $request->session()->invalidate();
                return $this->loggedOut($request) ?: redirect('/');
            }
            return redirect('home');
        }
        return back()->withInput(['username'])->withErrors(['username'=>'Credenciales incorrectas, por favor reintente']);
    }
    
    public function logout(Request $request)
    {        
        //$user = User::find(Aut):
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }

    public function salir()
    { 
        
        Auth::logout();
        return redirect('/login');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    use AuthenticatesUsers;
}
