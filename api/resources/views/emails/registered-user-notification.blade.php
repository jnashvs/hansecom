@extends('emails.layouts.main')
@section('content')
    <p>Dear {{ $user->name }},</p>
    <p>Your account has been created successfully! Welcome to our platform.</p>
@endsection
