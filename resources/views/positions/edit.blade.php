@extends('layouts.admin_layout')

@section('content')

    <h1>Edit Position</h1>
    <form method="POST" action="{{route('position.update', ['position'=>$position->id])}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('positions.partisals._form')
        <div>
            <input  class="btn btn-primary btn-block" type="submit" value="Update">
        </div>
    </form>
@endsection
