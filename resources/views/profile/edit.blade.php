@extends('layouts.admin')

@section('title', 'Profil')
@section('page-title', 'Profil')
@section('breadcrumb', 'Profil')

@section('content')

    <div class="row">

        <div class="col-12 col-lg-8">

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Informasi Profil</h3>
                </div>

                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Perbarui Kata Sandi</h3>
                </div>

                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>


        </div>

    </div>

@endsection
