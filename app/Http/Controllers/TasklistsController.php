<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Tasklist;

use App\User;

class TasklistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {

            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasklists' => $tasklists,
            ];
            $data += $this->counts($user);
            return view('tasklists.index', $data);
        }else {
            return view('welcome');
        }
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
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        
        $user = \Auth::user();
    $user->id;
        
        $tasklist = new Tasklist;
        $tasklist->status = $request->status;
        $tasklist->content = $request->content;
        $tasklist->user_id = $user->id;
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
         $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        $tasklist = Tasklist::find($id);
        $tasklist->status = $request->status;
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