<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Notifications\TaskAssigned;
use App\Mail\ContactMail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class TaskController extends Controller
{
    public function __construct()
    {
        // Appeler la fonction pour attribuer le rôle admin lors de la création du contrôleur
        $this->assignRoleToAdmin();
    }
    public function index()
{
    $tasks = auth()->user()->tasks()->get();

    return view('tasks.home', compact('tasks'));
}

public function assignRoleToAdmin()
    {
        $user = auth()->user();

        // Vérifier si l'utilisateur existe et n'a pas encore le rôle 'admin'
        if ($user && !$user->hasRole('admin')) {
            // Récupérer le rôle 'admin'
            $adminRole = Role::findByName('admin');

            // Vérifier si le rôle existe
            if ($adminRole) {
                // Assigner le rôle à l'utilisateur
                $user->assignRole($adminRole);
            }
        }
    }
    
public function assignRoleToUser($userId, $roleName)
{
    // Récupérer l'utilisateur
    $user = User::find($userId);

    // Vérifier si l'utilisateur existe
    if (!$user) {
        return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
    }

    // Récupérer le rôle
    $role = Role::findByName($roleName);

    // Vérifier si le rôle existe
    if (!$role) {
        return response()->json(['message' => 'Rôle non trouvé.'], 404);
    }

    // Assigner le rôle à l'utilisateur
    $user->assignRole($role);

    return response()->json(['message' => 'Rôle attribué avec succès.']);
}

    public function create()
    {
        $user= auth()->user();
        if ($user->hasRole('admin')) {
            // L'utilisateur a le rôle d'administrateur
            return view('tasks.create');
        }
        else 
        {
            //dd($user->getRoleNames());
            return abort(404);
        }
        
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


    public function mail(Request $request,$id)
    {
        $task = Task::findOrFail($id);
           
    $details = [
        'title' => $task->title,
        'body' => $task->description,
        'date'=> $task->due_date
    ];
   
    \Mail::to($task->assigned_email)->send(new \App\Mail\ContactMail($details));
   
    //dd("Email is Sent.");
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
