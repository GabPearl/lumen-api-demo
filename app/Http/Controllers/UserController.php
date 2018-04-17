<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\User;
use App\Http\Controllers\Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
         ];

        $customMessages = [
             'required' => 'Please fill attribute :attribute'
        ];
        $this->validate($request, $rules, $customMessages);


        try {
            $hasher = app()->make('hash');
            $email = $request->input('email');
            $password = $hasher->make($request->input('password'));

            $save = User::create([
                'email'=> $email,
                'password'=> $password,
                'api_token'=> ''
            ]);
            $res['status'] = true;
            $res['message'] = 'Registration success!';
            return response($res, 200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $res['status'] = false;
            $res['message'] = $ex->getMessage();
            return response($res, 500);
        }
    }

    public function get_user()
    {
        $user = User::all();
        if ($user) {
              $res['status'] = true;
              $res['message'] = $user;

              return response($res);
        }else{
          $res['status'] = false;
          $res['message'] = 'Cannot find user!';

          return response($res);
        }
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $rules = [
          'email' => 'required',
          'password' => 'required'
          ];

            $customMessages = [
               'required' => ':attribute tidak boleh kosong'
          ];
            $this->validate($request, $rules, $customMessages);
             $email    = $request->input('email');
            try {
                $login = User::where('email', $email)->first();
                if ($login) {
                    if ($login->count() > 0) {
                        if (Hash::check($request->input('password'), $login->password)) {
                            try {
                                $api_token = sha1($login->id_user.time());

                                  $create_token = User::where('id', $login->id_user)->update(['api_token' => $api_token]);
                                  $res['status'] = true;
                                  $res['message'] = 'Success login';
                                  $res['data'] =  $login;
                                  $res['api_token'] =  $api_token;

                                  return response($res, 200);


                            } catch (\Illuminate\Database\QueryException $ex) {
                                $res['status'] = false;
                                $res['message'] = $ex->getMessage();
                                return response($res, 500);
                            }
                        } else {
                            $res['success'] = false;
                            $res['message'] = 'Username / email / password not found';
                            return response($res, 401);
                        }
                    } else {
                        $res['success'] = false;
                        $res['message'] = 'Username / email / password  not found';
                        return response($res, 401);
                    }
                } else {
                    $res['success'] = false;
                    $res['message'] = 'Username / email / password not found';
                    return response($res, 401);
                }
            } catch (\Illuminate\Database\QueryException $ex) {
                $res['success'] = false;
                $res['message'] = $ex->getMessage();
                return response($res, 500);
            }
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function me()
    // {
    //    return \RS::send($this->guard()->user());
    // }

    public function me()
    {
        $user = User::all();
        if ($user) {
              $res['status'] = true;
              $res['message'] = $user;

              return response($res);
        }else{
          $res['status'] = false;
          $res['message'] = 'Cannot find user!';

          return response($res);
        }
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $this->guard()->logout();
            return \RS::send(trans('messages.logout_success'));
        } catch (\Exception $e) {
            return \RS::send($e->getMessage() . '. Line: ' . $e->getLine(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = $this->guard()->refresh();
        return \RS::send(compact('token'));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    private function guard()
    {
        return Auth::guard();
    }




}
