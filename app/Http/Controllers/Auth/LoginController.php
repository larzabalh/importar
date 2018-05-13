<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Events\Dispatcher;


use Illuminate\Contracts\Auth\UserProvider;

use Socialize;

use App\Models\Person;

class LoginController extends Controller
{
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware( 'guest', ['only' => 'showLoginForm']  );
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(  )
    {
        //dd($args);
        return view('auth.login');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'loginUser';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function fieldPassword()
    {
        return 'password';
    }

    protected function validateLogin(Request $request){
        $this->validate($request, [
            $this->username() => 'required|string',
            $this->fieldPassword() => 'required|string|min:6',
        ]);
    }

  /**
   * Get the needed authorization credentials from the request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
    public function credentials($request){
      //dd($request->only($this->username(), 'claveUser' ));
      return $request->only( $this->username(), $this->fieldPassword());
    }



    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
      //these equals
        $this->validateLogin($request);
        //** If you use another field for password not like 'password',
        //** these lines can help you to fix this and laravel Auth works fine
        $credentials = [
          $this->username() => $request[$this->username()],
          'password' => $request[$this->fieldPassword()],
        ];

      //these equals
       if ($this->hasTooManyLoginAttempts($request)) {
          $this->fireLockoutEvent($request);
          return $this->sendLockoutResponse($request);
       }

       //Change the way to find the user and Log in.
       if(Auth::attempt($credentials))
       {

          return $this->sendLoginResponse($request);
       }

       //these equals
       $this->incrementLoginAttempts($request);
       return $this->sendFailedLoginResponse($request);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //dd(count($user->userMasterPersons()->get()));
        if(count($user->userMasterPersons()->get())>0){
          $request->session()->put('master_person_id',
            $user->userMasterPersons()->first()->id);

          $request->session()->put('current_person_id',
            $user->userMasterPersons()->first()->id);

          $request->session()->put('current_person',
            Person::find(session('current_person_id'))->field_name1
          );
        }
    }



    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('login')->with('logout', 'Session Closed');
        //return redirect()->action( 'HomeController@index', 'Session Closed' );
    }



    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialize::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialize::driver('google')->user();

        // $user->token;
    }

}
