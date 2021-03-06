<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Organization;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use\Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(!is_null($data['organization'])){ 
                            $var3= User::create([
                               'name' => $data['name'],
                               'email' => $data['email'],
                            'password' => Hash::make($data['password']),
                              'role'=>'owner',
                              
                               ]);
                $var1=Organization::create([
                         'owner_id'=>$var3['id'],
                           'org_name'=> $data['organization'],
                          'owner_name' =>$data['name'],       
                  ]);
                  $org_num= DB::table('organizations')->where('org_name',$data['organization'])->where('owner_id',$var3['id'])->first()->org_num;
                  DB::table('users')->where('email',$data['email']) ->update([ 'org_id' => $org_num]);
                   return $var3;
        }
                     $var2= User::create([
                         'name' => $data['name'],
                         'email' => $data['email'],
                         'password' => Hash::make($data['password']),
                       
                        ]);
                    
                    return $var2;
    }
}
