@extends('layout.base')

@section('main')

@include('User.shared.campos', ['readonlyData' => true])

@endsection