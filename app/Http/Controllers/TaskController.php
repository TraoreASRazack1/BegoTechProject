<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Notifications\TaskAssigned;
use App\Mail\ContactMail;

class TaskController extends Controller
{
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
    session()->flash('successMessage', 'Tâche créée avec succès!');
    if ($request->input('assigned_email') === 'other') {
        // Si l'option "Saisir manuellement" est sélectionnée, utilisez la saisie manuelle
        $task->assigned_email = $request->input('assigned_email_manual');
        $task->save();
        $user = User::where('email', $task->assigned_email)->first();
        if ($user) {
        $user->notify(new TaskAssigned($task));
        
        }
        
    }
    else
    {
        $task->assigned_email = $request->input('assigned_email');
        $task->save();
        $user = User::where('email', $task->assigned_email)->first();
        if ($user) {
            $user->notify(new TaskAssigned($task));
        }
    }
    
    return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour avec succès!');
}


    public function edit(Request $request,$id )
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }
    public function mail(Request $request,$id )
    {
        $task = Task::findOrFail($id);
           
    $details = [
        'title' => $task->title,
        'body' => $task->description,
        'date'=> $task->due_date
    ];
   
    \Mail::to($task->assigned_email)->send(new \App\Mail\ContactMail($details));
   
    dd("Email is Sent.");
        return view('tasks.mail', compact('task'));
    }
    public function show($id)
    {
        return redirect()->route('tasks.edit', $id);
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
    public function filter(Request $request)
    {
        $status = $request->input('status');
        $priority = $request->input('priority');

        // Construis la requête en fonction des filtres choisis
        $query = Task::query();

        if ($status && $priority) {
            $query->where('status', $status)->where('priority', $priority);
        } elseif ($status) {
            $query->where('status', $status);
        } elseif ($priority) {
            $query->where('priority', $priority);
        }

        // Exécute la requête et renvoie les résultats
        $tasks = $query->get();

        return view('tasks.home', compact('tasks'));
    }
}
