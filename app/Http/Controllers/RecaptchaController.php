<?php

namespace App\Http\Controllers;

use Adldap\AdldapInterface;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Auth;

class RecaptchaController extends Controller
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
    }

    /**
     * Displays the all LDAP users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = $this->ldap->search()->users()->find('Ramiro');
        dd($user);
        return view('users.index', compact('users'));
    }
    public function home()
    {
        return view('recaptcha');
    }

    use AuthenticatesUsers;
    public function login(Request $request){

           /*$credentials = $request->validate([
                'samaccountname' => 'required',
                'password' => 'required|min:6',
                'g-recaptcha-response' => 'captcha'
            ]);*/

            $credentials1 = $request->validate([
                'samaccountname' => 'required',
                'password' => 'required|min:6',
            ]);

            if(Auth::attempt($credentials1))
            {
                $user = User::where('username', $request->samaccountname)->first();
                $us = User::find($user->id);
                $us->samaccountname = $request->samaccountname;
                $us->save();
                Auth::attempt($credentials1);
                return redirect()->route('notifi');
            }
            return back()->withErrors(['samaccountname'=>'Credenciales incorrectas, por favor reintente']);
    }
    public function login2($user, $pass){
        $user = chekar('decifrar',$user);
        $pass = chekar('decifrar',$pass);
        if(Auth::attempt(['samaccountname' => $user, 'password' => $pass]))
        {
        return redirect()->route('notifi');
        }
        return back()->withErrors(['samaccountname'=>'Credenciales incorrectas, por favor reintente']);
    }

}
