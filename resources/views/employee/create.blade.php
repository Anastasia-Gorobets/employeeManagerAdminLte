@extends('layouts.admin_layout')

@section('content')

<h1>Create employee</h1>

<form method="POST" action="{{route('employee.store')}}" enctype="multipart/form-data">
    @csrf
    @include('employee.partisals._form')
    <div>
        <input  class="btn btn-primary btn-block" type="submit" value="Create">
    </div>
</form>

@endsection
