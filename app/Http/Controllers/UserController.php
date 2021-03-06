<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
//use Illuminate\Http\Request;
use Request;

class UserController extends Controller {

    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->middleware('manager');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $users = User::search(Request::all())->paginate(50);
        return view('user.index')->with(compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = new User();
        return view('user.create')->with(compact('user'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\UserRequest $request)
	{
		$request = $request->all();
        $user = new User();
        $user->create($request);
        $login      = Request::get('email');
        $password   = Request::get('password');
        \Mail::send('emails.createuser',compact('login','password'), function($message) use ($login)
        {
            $message->to($login, 'Callcenter №1')->subject('Круглосуточный call-центр №1');
        });

        return redirect('user');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $user = User::findOrFail($id);
		return view('user.show')->with(compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user=User::findOrFail($id);
        return view('user.edit',compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,Requests\UserUpdateRequest $request)
	{
        $request = $request->all();
        $user=User::findOrFail($id);
        $user->update($request);
        return redirect("user/$id");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        //TODO SET NULL OR CHANGE PROJECT AND CLAIM related user

		User::destroy($id);
        return redirect (url('user'));
	}

}
