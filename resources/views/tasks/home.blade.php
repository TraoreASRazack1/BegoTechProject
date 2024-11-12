<!-- resources/views/tasks/home.blade.php -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@extends('layouts.app')

@section('content')

<div class="container">
<div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Tableau de tâches') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Liste des tâches</h3>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Date d'échéance</th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>E-mail</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td>{{ $task->due_date }}</td>
                                    <td>{{ $task->priority }}</td>
                                    <td>{{ $task->status }}</td>
                                    <td>{{ $task->assigned_email }}</td>
                                    <td>
                                    <div class="mb-2">
                                        <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="btn btn-primary mr-2">Éditer</a>
                                        <a href="{{ route('tasks.mail', ['id' => $task->id]) }}" class="btn btn-secondary mr-2">Envoyer un mail</a>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Aucune tâche trouvée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('tasks.create') }}" class="btn btn-success mr-2">Créer une tâche</a>
                        <button onclick="refreshPage()" class="btn btn-primary">Actualiser</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <h2 class="mb-0">Filtrer les Tâches</h2>
<div class="filter-form border p-3">
    <form action="{{ route('tasks.filter') }}" method="GET">
        <div class="form-group mt-3">
            <label for="status">Statut:</label>
            <select name="status" id="status" class="form-control">
                <option value="">Tous</option>
                <option value="A Faire">A Faire</option>
                <option value="En Cours">En Cours</option>
                <option value="Terminée">Terminée</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="priority">Priorité:</label>
            <select name="priority" id="priority" class="form-control">
                <option value="">Tous</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Filtrer</button>
    </form>
</div>
 <!-- Exemple de bouton pour attribuer le rôle 
 <button onclick="RoleUser('{{ auth()->user()->id }}', 'admin')">Attribuer le rôle Admin</button>-->


</div>
<script>
        function refreshPage() {
            location.reload(); // Cette fonction recharge la page
        }
        $(document).ready(function() {
         $('#assignRoleBtn').on('click', function() {
             var userId = $(this).data('user-id');
             var roleName = $(this).data('role-name');

             // Requête Ajax pour attribuer le rôle
             $.get('/assign-role/' + userId + '/' + roleName, function(data) {
                 alert(data.message); // Affiche le message de la réponse
             });
         });
     });
      function RoleUser(var userid, var rolename) {
             var userId = userid;
             var roleName = rolename;

             // Requête Ajax pour attribuer le rôle
             $.get('/assign-role/' + userId + '/' + roleName, function(data) {
                 alert(data.message); // Affiche le message de la réponse
             });
         };
</script>
@endsection
