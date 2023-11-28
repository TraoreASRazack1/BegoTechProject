<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**public function index()
    {
        return view('tasks/home');
    }*/
    public function index()
{
    $tasks = auth()->user()->tasks()->get();
    return view('tasks.home', compact('tasks'));
}


    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'due_date' => 'nullable|date',
        'priority' => 'nullable|integer',
        'status' => 'nullable',
    ]);

    $task = new Task($request->all());
    auth()->user()->tasks()->save($task);
    

    return response()->json($task, 201);
}


    public function edit(Request $request, $id)
    {
        $task = Task::findOrFail($request);
        return redirect()->route('tasks.edit', ['task' => $request]);
    }
    public function show($id)
{
    
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|integer',
            'status' => 'nullable',
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour avec succès!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès!');
    }
}
