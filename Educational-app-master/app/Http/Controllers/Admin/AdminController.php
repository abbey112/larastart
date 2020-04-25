<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Subject;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 
    public function __construct()
    {
        $this->middleware(['auth','role:super_admin|sub_admin']);
    }
    public function index()
    {
        return view('admin.index');
    }

    // STUDNETS
    public function allstudents()
    {
        $students = User::role('students')->paginate();
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newstudents(Request $request)
    {
        $this->validate($request,[
            'full_name'=> "required|min:3",
            'email' => 'required|email|unique:users',
            'password'=>'required|min:5'

        ]);
        // dd($request->all());
        $user = User::create([
            'name'=> $request->full_name,
            'email'=> $request->email,
            'password'=> $request->password,
        ]);
        $user->assignRole($request->role);
        return redirect('admin/students')->with('success',"Student created");

    }


    // SUbjects
    public function subjects()
    {
        $subjects = Subject::paginate();
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function newsubject(Request $request)
    {
        $this->validate([
            'name'=>'required|min:3',
            
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
