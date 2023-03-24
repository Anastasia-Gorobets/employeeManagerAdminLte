@extends('layouts.admin_layout')

@section('content')

<h1>Create position</h1>

<form method="POST" action="{{route('position.store')}}" enctype="multipart/form-data">
    @csrf
    @include('positions.partisals._form')
    <div>
        <input  class="btn btn-primary btn-block" type="submit" value="Create">
    </div>
</form>
@endsection
