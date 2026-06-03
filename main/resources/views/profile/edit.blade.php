@extends('layout')
@section('titre', 'Mon profil')
@section('contenu')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4 mb-4">
                @include('profile.partials.update-profile-information-form')
            </div>
            <div class="card p-4 mb-4">
                @include('profile.partials.update-password-form')
            </div>
            <div class="card p-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

@endsection
