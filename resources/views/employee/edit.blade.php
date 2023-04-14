@extends('layouts.admin_layout')
@section('content')
    <h1>Edit employee</h1>
    <form method="POST" action="{{route('employee.update', ['employee'=>$employee->id])}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('employee.partisals._form')
        <div>
            <input  class="btn btn-primary btn-block" type="submit" value="Update">
        </div>
    </form>
@endsection
