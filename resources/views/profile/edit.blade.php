@extends('layouts.admin')

@section('title', 'Profile')
@section('page-title', 'Profile')
@section('breadcrumb', 'Profile')

@section('content')

    <div class="row">

        <div class="col-12 col-lg-8">

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Profile Information</h3>
                </div>

                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Update Password</h3>
                </div>

                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Archive Account</h3>
                </div>

                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>

    </div>

@endsection
