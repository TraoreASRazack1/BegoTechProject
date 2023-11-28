<!-- create.blade.php -->

@extends('layouts.app')

@section('content')
  <div class="container">
    <create-task></create-task>
  </div>
@endsection

@push('scripts')
  <script src="{{ mix('js/create-task.js') }}"></script>
@endpush
