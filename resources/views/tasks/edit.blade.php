<!-- resources/views/tasks/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Modifier Tache') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="title">{{ __('Titre') }}</label>
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $task->title) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea id="description" class="form-control" name="description">{{ old('description', $task->description) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="due_date">{{ __('Date D\'echeance') }}</label>
                                <input id="due_date" type="date" class="form-control" name="due_date" value="{{ old('due_date', $task->due_date) }}">
                            </div>

                            <div class="form-group">
                                <label for="priority">{{ __('Priorite') }}</label>
                                <input id="priority" type="number" class="form-control" name="priority" value="{{ old('priority', $task->priority) }}">
                            </div>

                            <div class="form-group">
                                <label for="status">{{ __('Statut') }}</label>
                                <input id="status" type="text" class="form-control" name="status" value="{{ old('status', $task->status) }}">
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                            <a href="javascript:history.back()" class="btn btn-secondary btn-block">Retour</a>
                            <button type="submit" class="btn btn-primary">{{ __('Modifier Tache') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
