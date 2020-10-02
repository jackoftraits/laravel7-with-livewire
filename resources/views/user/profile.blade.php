@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Profile Settings') }}</div>
                <div class="card-body">
                    @livewire('user-profile')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
