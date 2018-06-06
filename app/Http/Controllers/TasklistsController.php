<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tasklist;

class TasklistsController extends Controller
{
    public function index()
    {
        $tasklists = Tasklist::all();

        return view('tasklists.index', [
            'tasklists' => $tasklists,
        ]);
    }
    
    public function show($id)
    {
        $tasklist = Tasklist::find($id);

        return view('tasklists.show', [
            'tasklist' => $tasklist,
        ]);
    }
    
    public function create()
    {
        $tasklist = new Tasklist;

        return view('tasklists.create', [
            'tasklist' => $tasklist,
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);
        
        $tasklist = new Tasklist;
        $tasklist->content = $request->content;
        $tasklist->save();

        return redirect('/');
    }
    
     public function edit($id)
    {
        $tasklist = Tasklist::find($id);

        return view('tasklists.edit', [
            'tasklist' => $tasklist,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $tasklist = Tasklist::find($id);
        $tasklist->content = $request->content;
        $tasklist->save();

        return redirect('/');
    }
    
    public function destroy($id)
    {
        $tasklist = Tasklist::find($id);
        $tasklist->delete();

        return redirect('/');
    }
}