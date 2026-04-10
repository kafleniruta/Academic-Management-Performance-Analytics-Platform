<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class TeacherController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $teachers = Teacher::all();
        return view ('ADMIN.teachers.viewteachers')->with('Teachers',$teachers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
        public function edit(string $id): View
        {
            $teacher = Teacher::find($id);
            return view('ADMIN.teachers.editTeachers', compact('teacher'));
        }
            
    public function update(Request $request, string $id): RedirectResponse
    {
        $teacher = Teacher::find($id);
        $input = $request->all();
        $teacher->update($input);
        return redirect('admin/Teachers')->with('flash_message', 'Teacher Updated!');  
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
