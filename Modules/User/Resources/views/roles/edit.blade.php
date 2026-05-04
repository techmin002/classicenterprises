@extends('setting::layouts.master')

@section('title', 'Edit Role')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('style')
    <style>
        .custom-control-label {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Role <i class="bi bi-check"></i>
                                </button>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Role Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" required
                                            value="{{ $role->name }}">
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <label for="permissions">
                                            Permissions <span class="text-danger">*</span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="select-all">
                                            <label class="custom-control-label" for="select-all">Give All
                                                Permissions</label>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <!-- User Management Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    User Mangement
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_user_management" name="permissions[]"
                                                                    value="access_user_management"
                                                                    {{ $role->hasPermissionTo('access_user_management') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_user_management">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_own_profile" name="permissions[]"
                                                                    value="edit_own_profile"
                                                                    {{ $role->hasPermissionTo('edit_own_profile') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_own_profile">Own Profile</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Settings -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Settings
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_settings" name="permissions[]"
                                                                    value="access_settings"
                                                                    {{ $role->hasPermissionTo('access_settings') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_settings">Access</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sliders Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Sliders
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_sliders" name="permissions[]"
                                                                    value="access_sliders"
                                                                    {{ $role->hasPermissionTo('access_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_sliders">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_sliders" name="permissions[]"
                                                                    value="show_sliders"
                                                                    {{ $role->hasPermissionTo('show_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_sliders">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_sliders" name="permissions[]"
                                                                    value="create_sliders"
                                                                    {{ $role->hasPermissionTo('create_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_sliders">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_sliders" name="permissions[]"
                                                                    value="edit_sliders"
                                                                    {{ $role->hasPermissionTo('edit_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_sliders">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_sliders" name="permissions[]"
                                                                    value="delete_sliders"
                                                                    {{ $role->hasPermissionTo('delete_sliders') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_sliders">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Blogs Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Blogs
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_blogs" name="permissions[]"
                                                                    value="access_blogs"
                                                                    {{ $role->hasPermissionTo('access_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_blogs">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_blogs" name="permissions[]"
                                                                    value="show_blogs"
                                                                    {{ $role->hasPermissionTo('show_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_blogs">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_blogs" name="permissions[]"
                                                                    value="create_blogs"
                                                                    {{ $role->hasPermissionTo('create_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_blogs">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_blogs" name="permissions[]"
                                                                    value="edit_blogs"
                                                                    {{ $role->hasPermissionTo('edit_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_blogs">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_blogs" name="permissions[]"
                                                                    value="delete_blogs"
                                                                    {{ $role->hasPermissionTo('delete_blogs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_blogs">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Advertisements Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Advertisements
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_advertisements" name="permissions[]"
                                                                    value="access_advertisements"
                                                                    {{ $role->hasPermissionTo('access_advertisements') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_advertisements">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_advertisements" name="permissions[]"
                                                                    value="show_advertisements"
                                                                    {{ $role->hasPermissionTo('show_advertisements') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_advertisements">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_advertisements" name="permissions[]"
                                                                    value="create_advertisements"
                                                                    {{ $role->hasPermissionTo('create_advertisements') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_advertisements">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_advertisements" name="permissions[]"
                                                                    value="edit_advertisements"
                                                                    {{ $role->hasPermissionTo('edit_advertisements') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_advertisements">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_advertisements" name="permissions[]"
                                                                    value="delete_advertisements"
                                                                    {{ $role->hasPermissionTo('delete_advertisements') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_advertisements">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Teams Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Teams
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_teams" name="permissions[]"
                                                                    value="access_teams"
                                                                    {{ $role->hasPermissionTo('access_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_teams">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_teams" name="permissions[]"
                                                                    value="show_teams"
                                                                    {{ $role->hasPermissionTo('show_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_teams">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_teams" name="permissions[]"
                                                                    value="create_teams"
                                                                    {{ $role->hasPermissionTo('create_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_teams">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_teams" name="permissions[]"
                                                                    value="edit_teams"
                                                                    {{ $role->hasPermissionTo('edit_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_teams">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_teams" name="permissions[]"
                                                                    value="delete_teams"
                                                                    {{ $role->hasPermissionTo('delete_teams') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_teams">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Faqs Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Faqs
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_faqs" name="permissions[]"
                                                                    value="access_faqs"
                                                                    {{ $role->hasPermissionTo('access_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_faqs">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_faqs" name="permissions[]" value="show_faqs"
                                                                    {{ $role->hasPermissionTo('show_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_faqs">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_faqs" name="permissions[]"
                                                                    value="create_faqs"
                                                                    {{ $role->hasPermissionTo('create_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_faqs">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_faqs" name="permissions[]" value="edit_faqs"
                                                                    {{ $role->hasPermissionTo('edit_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_faqs">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_faqs" name="permissions[]"
                                                                    value="delete_faqs"
                                                                    {{ $role->hasPermissionTo('delete_faqs') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_faqs">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Testimonials Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Testimonials
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_testimonials" name="permissions[]"
                                                                    value="access_testimonials"
                                                                    {{ $role->hasPermissionTo('access_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_testimonials">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_testimonials" name="permissions[]"
                                                                    value="show_testimonials"
                                                                    {{ $role->hasPermissionTo('show_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_testimonials">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_testimonials" name="permissions[]"
                                                                    value="create_testimonials"
                                                                    {{ $role->hasPermissionTo('create_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_testimonials">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_testimonials" name="permissions[]"
                                                                    value="edit_testimonials"
                                                                    {{ $role->hasPermissionTo('edit_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_testimonials">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_testimonials" name="permissions[]"
                                                                    value="delete_testimonials"
                                                                    {{ $role->hasPermissionTo('delete_testimonials') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_testimonials">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Vacancies Permission -->
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Vacancy
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_vacancies" name="permissions[]"
                                                                    value="access_vacancies"
                                                                    {{ $role->hasPermissionTo('access_vacancies') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_vacancies">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_vacancies" name="permissions[]"
                                                                    value="show_vacancies"
                                                                    {{ $role->hasPermissionTo('show_vacancies') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_vacancies">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_vacancies" name="permissions[]"
                                                                    value="create_vacancies"
                                                                    {{ $role->hasPermissionTo('create_vacancies') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_vacancies">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_vacancies" name="permissions[]"
                                                                    value="edit_vacancies"
                                                                    {{ $role->hasPermissionTo('edit_vacancies') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_vacancies">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_vacancies" name="permissions[]"
                                                                    value="delete_vacancies"
                                                                    {{ $role->hasPermissionTo('delete_vacancies') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_vacancies">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Service permissions --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Services
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_services" name="permissions[]"
                                                                    value="access_services"
                                                                    {{ $role->hasPermissionTo('access_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_services">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_services" name="permissions[]"
                                                                    value="show_services"
                                                                    {{ $role->hasPermissionTo('show_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_services">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_services" name="permissions[]"
                                                                    value="create_services"
                                                                    {{ $role->hasPermissionTo('create_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_services">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_services" name="permissions[]"
                                                                    value="edit_services"
                                                                    {{ $role->hasPermissionTo('edit_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_services">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_services" name="permissions[]"
                                                                    value="delete_services"
                                                                    {{ $role->hasPermissionTo('delete_services') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_services">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- service category permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Services Category
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_service_category" name="permissions[]"
                                                                    value="access_service_category"
                                                                    {{ $role->hasPermissionTo('access_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_service_category">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_service_category" name="permissions[]"
                                                                    value="show_service_category"
                                                                    {{ $role->hasPermissionTo('show_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_service_category">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_service_category" name="permissions[]"
                                                                    value="create_service_category"
                                                                    {{ $role->hasPermissionTo('create_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_service_category">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_service_category" name="permissions[]"
                                                                    value="edit_service_category"
                                                                    {{ $role->hasPermissionTo('edit_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_service_category">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_service_category" name="permissions[]"
                                                                    value="delete_service_category"
                                                                    {{ $role->hasPermissionTo('delete_service_category') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_service_category">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Branch permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Branch Category
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_branch" name="permissions[]"
                                                                    value="access_branch"
                                                                    {{ $role->hasPermissionTo('access_branch') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_branch">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_branch" name="permissions[]"
                                                                    value="show_branch"
                                                                    {{ $role->hasPermissionTo('show_branch') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_branch">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_branch" name="permissions[]"
                                                                    value="create_branch"
                                                                    {{ $role->hasPermissionTo('create_branch') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_branch">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_branch" name="permissions[]"
                                                                    value="edit_branch"
                                                                    {{ $role->hasPermissionTo('edit_branch') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_branch">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_branch" name="permissions[]"
                                                                    value="delete_branch"
                                                                    {{ $role->hasPermissionTo('delete_branch') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_branch">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Expense permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Expense
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_expense" name="permissions[]"
                                                                    value="access_expense"
                                                                    {{ $role->hasPermissionTo('access_expense') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_expense">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_expense" name="permissions[]"
                                                                    value="show_expense"
                                                                    {{ $role->hasPermissionTo('show_expense') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_expense">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_expense" name="permissions[]"
                                                                    value="create_expense"
                                                                    {{ $role->hasPermissionTo('create_expense') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_expense">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_expense" name="permissions[]"
                                                                    value="edit_expense"
                                                                    {{ $role->hasPermissionTo('edit_expense') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_expense">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_expense" name="permissions[]"
                                                                    value="delete_expense"
                                                                    {{ $role->hasPermissionTo('delete_expense') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_expense">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Petty Cash permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Petty Cash
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_pettycash" name="permissions[]"
                                                                    value="access_pettycash"
                                                                    {{ $role->hasPermissionTo('access_pettycash') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_pettycash">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_pettycash" name="permissions[]"
                                                                    value="show_pettycash"
                                                                    {{ $role->hasPermissionTo('show_pettycash') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_pettycash">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_pettycash" name="permissions[]"
                                                                    value="create_pettycash"
                                                                    {{ $role->hasPermissionTo('create_pettycash') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_pettycash">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_pettycash" name="permissions[]"
                                                                    value="edit_pettycash"
                                                                    {{ $role->hasPermissionTo('edit_pettycash') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_pettycash">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_pettycash" name="permissions[]"
                                                                    value="delete_pettycash"
                                                                    {{ $role->hasPermissionTo('delete_pettycash') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_pettycash">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Vehicle MGNT permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Vehicle MGNT
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_vehicle" name="permissions[]"
                                                                    value="access_vehicle"
                                                                    {{ $role->hasPermissionTo('access_vehicle') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_vehicle">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_vehicle" name="permissions[]"
                                                                    value="show_vehicle"
                                                                    {{ $role->hasPermissionTo('show_vehicle') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_vehicle">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_vehicle" name="permissions[]"
                                                                    value="create_vehicle"
                                                                    {{ $role->hasPermissionTo('create_vehicle') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_vehicle">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_vehicle" name="permissions[]"
                                                                    value="edit_vehicle"
                                                                    {{ $role->hasPermissionTo('edit_vehicle') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_vehicle">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_vehicle" name="permissions[]"
                                                                    value="delete_vehicle"
                                                                    {{ $role->hasPermissionTo('delete_vehicle') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_vehicle">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Finance permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Finance
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_finance" name="permissions[]"
                                                                    value="access_finance"
                                                                    {{ $role->hasPermissionTo('access_finance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_finance">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_finance" name="permissions[]"
                                                                    value="show_finance"
                                                                    {{ $role->hasPermissionTo('show_finance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_finance">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_finance" name="permissions[]"
                                                                    value="create_finance"
                                                                    {{ $role->hasPermissionTo('create_finance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_finance">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_finance" name="permissions[]"
                                                                    value="edit_finance"
                                                                    {{ $role->hasPermissionTo('edit_finance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_finance">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_finance" name="permissions[]"
                                                                    value="delete_finance"
                                                                    {{ $role->hasPermissionTo('delete_finance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_finance">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Ticket permission --}}
                                        {{-- <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Tickets
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_ticket" name="permissions[]"
                                                                    value="access_ticket"
                                                                    {{ $role->hasPermissionTo('access_ticket') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_ticket">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_ticket" name="permissions[]"
                                                                    value="show_ticket"
                                                                    {{ $role->hasPermissionTo('show_ticket') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_ticket">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_ticket" name="permissions[]"
                                                                    value="create_ticket"
                                                                    {{ $role->hasPermissionTo('create_ticket') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_ticket">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_ticket" name="permissions[]"
                                                                    value="edit_ticket"
                                                                    {{ $role->hasPermissionTo('edit_ticket') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_ticket">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_ticket" name="permissions[]"
                                                                    value="delete_ticket"
                                                                    {{ $role->hasPermissionTo('delete_ticket') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_ticket">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        {{-- Product permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Products
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_product" name="permissions[]"
                                                                    value="access_product"
                                                                    {{ $role->hasPermissionTo('access_product') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_product">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_product" name="permissions[]"
                                                                    value="show_product"
                                                                    {{ $role->hasPermissionTo('show_product') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_product">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_product" name="permissions[]"
                                                                    value="create_product"
                                                                    {{ $role->hasPermissionTo('create_product') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_product">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_product" name="permissions[]"
                                                                    value="edit_product"
                                                                    {{ $role->hasPermissionTo('edit_product') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_product">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_product" name="permissions[]"
                                                                    value="delete_product"
                                                                    {{ $role->hasPermissionTo('delete_product') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_product">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Inventory permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Inventory
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_inventory" name="permissions[]"
                                                                    value="access_inventory"
                                                                    {{ $role->hasPermissionTo('access_inventory') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_inventory">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_inventory" name="permissions[]"
                                                                    value="show_inventory"
                                                                    {{ $role->hasPermissionTo('show_inventory') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_inventory">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_inventory" name="permissions[]"
                                                                    value="create_inventory"
                                                                    {{ $role->hasPermissionTo('create_inventory') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_inventory">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_inventory" name="permissions[]"
                                                                    value="edit_inventory"
                                                                    {{ $role->hasPermissionTo('edit_inventory') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_inventory">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_inventory" name="permissions[]"
                                                                    value="delete_inventory"
                                                                    {{ $role->hasPermissionTo('delete_inventory') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_inventory">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- ==================== LEADS ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Leads</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_leads" name="permissions[]" value="access_leads" {{ $role->hasPermissionTo('access_leads') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_leads">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_leads" name="permissions[]" value="create_leads" {{ $role->hasPermissionTo('create_leads') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_leads">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_leads" name="permissions[]" value="show_leads" {{ $role->hasPermissionTo('show_leads') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_leads">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_leads" name="permissions[]" value="edit_leads" {{ $role->hasPermissionTo('edit_leads') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_leads">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_leads" name="permissions[]" value="delete_leads" {{ $role->hasPermissionTo('delete_leads') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_leads">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== INSTALLMENTS ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Installments</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_installments" name="permissions[]" value="access_installments" {{ $role->hasPermissionTo('access_installments') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_installments">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_installments" name="permissions[]" value="create_installments" {{ $role->hasPermissionTo('create_installments') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_installments">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_installments" name="permissions[]" value="show_installments" {{ $role->hasPermissionTo('show_installments') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_installments">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_installments" name="permissions[]" value="edit_installments" {{ $role->hasPermissionTo('edit_installments') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_installments">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_installments" name="permissions[]" value="delete_installments" {{ $role->hasPermissionTo('delete_installments') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_installments">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== TICKETS ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Tickets</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_tickets" name="permissions[]" value="access_tickets" {{ $role->hasPermissionTo('access_tickets') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_tickets">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_tickets" name="permissions[]" value="create_tickets" {{ $role->hasPermissionTo('create_tickets') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_tickets">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_tickets" name="permissions[]" value="show_tickets" {{ $role->hasPermissionTo('show_tickets') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_tickets">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_tickets" name="permissions[]" value="edit_tickets" {{ $role->hasPermissionTo('edit_tickets') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_tickets">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_tickets" name="permissions[]" value="delete_tickets" {{ $role->hasPermissionTo('delete_tickets') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_tickets">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== SALES CATEGORY ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Sales Category</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_salescategory" name="permissions[]" value="access_salescategory" {{ $role->hasPermissionTo('access_salescategory') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_salescategory">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_salescategory" name="permissions[]" value="create_salescategory" {{ $role->hasPermissionTo('create_salescategory') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_salescategory">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_salescategory" name="permissions[]" value="show_salescategory" {{ $role->hasPermissionTo('show_salescategory') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_salescategory">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_salescategory" name="permissions[]" value="edit_salescategory" {{ $role->hasPermissionTo('edit_salescategory') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_salescategory">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_salescategory" name="permissions[]" value="delete_salescategory" {{ $role->hasPermissionTo('delete_salescategory') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_salescategory">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== CUSTOMERS ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Customers</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_customers" name="permissions[]" value="access_customers" {{ $role->hasPermissionTo('access_customers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_customers">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_customers" name="permissions[]" value="create_customers" {{ $role->hasPermissionTo('create_customers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_customers">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_customers" name="permissions[]" value="show_customers" {{ $role->hasPermissionTo('show_customers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_customers">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_customers" name="permissions[]" value="edit_customers" {{ $role->hasPermissionTo('edit_customers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_customers">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_customers" name="permissions[]" value="delete_customers" {{ $role->hasPermissionTo('delete_customers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_customers">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== ALL SALES ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">All Sales</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_allsales" name="permissions[]" value="access_allsales" {{ $role->hasPermissionTo('access_allsales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_allsales">Access</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== SALES ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Sales</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_sales" name="permissions[]" value="access_sales" {{ $role->hasPermissionTo('access_sales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_sales">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_sales" name="permissions[]" value="create_sales" {{ $role->hasPermissionTo('create_sales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_sales">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_sales" name="permissions[]" value="show_sales" {{ $role->hasPermissionTo('show_sales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_sales">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_sales" name="permissions[]" value="edit_sales" {{ $role->hasPermissionTo('edit_sales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_sales">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_sales" name="permissions[]" value="delete_sales" {{ $role->hasPermissionTo('delete_sales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_sales">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== PRE SALES ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Pre Sales</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_presales" name="permissions[]" value="access_presales" {{ $role->hasPermissionTo('access_presales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_presales">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_presales" name="permissions[]" value="create_presales" {{ $role->hasPermissionTo('create_presales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_presales">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_presales" name="permissions[]" value="show_presales" {{ $role->hasPermissionTo('show_presales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_presales">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_presales" name="permissions[]" value="edit_presales" {{ $role->hasPermissionTo('edit_presales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_presales">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_presales" name="permissions[]" value="delete_presales" {{ $role->hasPermissionTo('delete_presales') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_presales">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== SALES RETURN ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Sales Return</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_salesreturn" name="permissions[]" value="access_salesreturn" {{ $role->hasPermissionTo('access_salesreturn') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_salesreturn">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_salesreturn" name="permissions[]" value="create_salesreturn" {{ $role->hasPermissionTo('create_salesreturn') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_salesreturn">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_salesreturn" name="permissions[]" value="show_salesreturn" {{ $role->hasPermissionTo('show_salesreturn') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_salesreturn">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_salesreturn" name="permissions[]" value="edit_salesreturn" {{ $role->hasPermissionTo('edit_salesreturn') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_salesreturn">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_salesreturn" name="permissions[]" value="delete_salesreturn" {{ $role->hasPermissionTo('delete_salesreturn') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_salesreturn">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== INVENTORY (IME) ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Inventory (IME)</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_ime" name="permissions[]" value="access_ime" {{ $role->hasPermissionTo('access_ime') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_ime">Access</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== SUPPLIERS ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Suppliers</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_suppliers" name="permissions[]" value="access_suppliers" {{ $role->hasPermissionTo('access_suppliers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_suppliers">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_suppliers" name="permissions[]" value="create_suppliers" {{ $role->hasPermissionTo('create_suppliers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_suppliers">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_suppliers" name="permissions[]" value="show_suppliers" {{ $role->hasPermissionTo('show_suppliers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_suppliers">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_suppliers" name="permissions[]" value="edit_suppliers" {{ $role->hasPermissionTo('edit_suppliers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_suppliers">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_suppliers" name="permissions[]" value="delete_suppliers" {{ $role->hasPermissionTo('delete_suppliers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_suppliers">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== PURCHASES ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Purchases</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_purchases" name="permissions[]" value="access_purchases" {{ $role->hasPermissionTo('access_purchases') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_purchases">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_purchases" name="permissions[]" value="create_purchases" {{ $role->hasPermissionTo('create_purchases') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_purchases">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_purchases" name="permissions[]" value="show_purchases" {{ $role->hasPermissionTo('show_purchases') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_purchases">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_purchases" name="permissions[]" value="edit_purchases" {{ $role->hasPermissionTo('edit_purchases') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_purchases">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_purchases" name="permissions[]" value="delete_purchases" {{ $role->hasPermissionTo('delete_purchases') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_purchases">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== PURCHASE RETURN ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Purchase Return</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_purchasereturn" name="permissions[]" value="access_purchasereturn" {{ $role->hasPermissionTo('access_purchasereturn') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_purchasereturn">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_purchasereturn" name="permissions[]" value="create_purchasereturn" {{ $role->hasPermissionTo('create_purchasereturn') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_purchasereturn">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_purchasereturn" name="permissions[]" value="show_purchasereturn" {{ $role->hasPermissionTo('show_purchasereturn') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_purchasereturn">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_purchasereturn" name="permissions[]" value="edit_purchasereturn" {{ $role->hasPermissionTo('edit_purchasereturn') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_purchasereturn">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_purchasereturn" name="permissions[]" value="delete_purchasereturn" {{ $role->hasPermissionTo('delete_purchasereturn') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_purchasereturn">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== TECHNICIANS ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Technicians</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_technicians" name="permissions[]" value="access_technicians" {{ $role->hasPermissionTo('access_technicians') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_technicians">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_technicians" name="permissions[]" value="create_technicians" {{ $role->hasPermissionTo('create_technicians') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_technicians">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_technicians" name="permissions[]" value="show_technicians" {{ $role->hasPermissionTo('show_technicians') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_technicians">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_technicians" name="permissions[]" value="edit_technicians" {{ $role->hasPermissionTo('edit_technicians') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_technicians">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_technicians" name="permissions[]" value="delete_technicians" {{ $role->hasPermissionTo('delete_technicians') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_technicians">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== STOCK TRANSFERS ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Stock Transfers</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_stocktransfers" name="permissions[]" value="access_stocktransfers" {{ $role->hasPermissionTo('access_stocktransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_stocktransfers">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_stocktransfers" name="permissions[]" value="create_stocktransfers" {{ $role->hasPermissionTo('create_stocktransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_stocktransfers">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_stocktransfers" name="permissions[]" value="show_stocktransfers" {{ $role->hasPermissionTo('show_stocktransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_stocktransfers">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_stocktransfers" name="permissions[]" value="edit_stocktransfers" {{ $role->hasPermissionTo('edit_stocktransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_stocktransfers">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_stocktransfers" name="permissions[]" value="delete_stocktransfers" {{ $role->hasPermissionTo('delete_stocktransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_stocktransfers">Delete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== REQUEST TRANSFERS ==================== --}}
<div class="col-lg-4 col-md-6 mb-3">
    <div class="card h-100 border-0 shadow">
        <div class="card-header">Request Transfers</div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="access_requestransfers" name="permissions[]" value="access_requestransfers" {{ $role->hasPermissionTo('access_requestransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="access_requestransfers">Access</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="create_requestransfers" name="permissions[]" value="create_requestransfers" {{ $role->hasPermissionTo('create_requestransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="create_requestransfers">Create</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="show_requestransfers" name="permissions[]" value="show_requestransfers" {{ $role->hasPermissionTo('show_requestransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="show_requestransfers">View</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="edit_requestransfers" name="permissions[]" value="edit_requestransfers" {{ $role->hasPermissionTo('edit_requestransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="edit_requestransfers">Edit</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="delete_requestransfers" name="permissions[]" value="delete_requestransfers" {{ $role->hasPermissionTo('delete_requestransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="delete_requestransfers">Delete</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="status_requestransfers" name="permissions[]" value="status_requestransfers" {{ $role->hasPermissionTo('status_requestransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status_requestransfers">Status</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="accept_requestransfers" name="permissions[]" value="accept_requestransfers" {{ $role->hasPermissionTo('accept_requestransfers') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="accept_requestransfers">Accept</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                                        {{-- Gallery permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Gallery
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_gallery" name="permissions[]"
                                                                    value="access_gallery"
                                                                    {{ $role->hasPermissionTo('access_gallery') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_gallery">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_gallery" name="permissions[]"
                                                                    value="show_gallery"
                                                                    {{ $role->hasPermissionTo('show_gallery') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_gallery">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_gallery" name="permissions[]"
                                                                    value="create_gallery"
                                                                    {{ $role->hasPermissionTo('create_gallery') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_gallery">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_gallery" name="permissions[]"
                                                                    value="edit_gallery"
                                                                    {{ $role->hasPermissionTo('edit_gallery') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_gallery">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_gallery" name="permissions[]"
                                                                    value="delete_gallery"
                                                                    {{ $role->hasPermissionTo('delete_gallery') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_gallery">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Leave permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Leave
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_leave" name="permissions[]"
                                                                    value="access_leave"
                                                                    {{ $role->hasPermissionTo('access_leave') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_leave">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_leave" name="permissions[]"
                                                                    value="show_leave"
                                                                    {{ $role->hasPermissionTo('show_leave') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_leave">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_leave" name="permissions[]"
                                                                    value="create_leave"
                                                                    {{ $role->hasPermissionTo('create_leave') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_leave">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_leave" name="permissions[]"
                                                                    value="edit_leave"
                                                                    {{ $role->hasPermissionTo('edit_leave') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_leave">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_leave" name="permissions[]"
                                                                    value="delete_leave"
                                                                    {{ $role->hasPermissionTo('delete_leave') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_leave">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Inquiries permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Inquiries
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_inquiries" name="permissions[]"
                                                                    value="access_inquiries"
                                                                    {{ $role->hasPermissionTo('access_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_inquiries">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_inquiries" name="permissions[]"
                                                                    value="show_inquiries"
                                                                    {{ $role->hasPermissionTo('show_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_inquiries">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_inquiries" name="permissions[]"
                                                                    value="create_inquiries"
                                                                    {{ $role->hasPermissionTo('create_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_inquiries">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_inquiries" name="permissions[]"
                                                                    value="edit_inquiries"
                                                                    {{ $role->hasPermissionTo('edit_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_inquiries">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_inquiries" name="permissions[]"
                                                                    value="delete_inquiries"
                                                                    {{ $role->hasPermissionTo('delete_inquiries') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_inquiries">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Payroll permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Payroll
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_payroll" name="permissions[]"
                                                                    value="access_payroll"
                                                                    {{ $role->hasPermissionTo('access_payroll') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_payroll">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_payroll" name="permissions[]"
                                                                    value="show_payroll"
                                                                    {{ $role->hasPermissionTo('show_payroll') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_payroll">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_payroll" name="permissions[]"
                                                                    value="create_payroll"
                                                                    {{ $role->hasPermissionTo('create_payroll') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_payroll">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_payroll" name="permissions[]"
                                                                    value="edit_payroll"
                                                                    {{ $role->hasPermissionTo('edit_payroll') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_payroll">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_payroll" name="permissions[]"
                                                                    value="delete_payroll"
                                                                    {{ $role->hasPermissionTo('delete_payroll') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_payroll">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Attendance permission --}}
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <div class="card h-100 border-0 shadow">
                                                <div class="card-header">
                                                    Attendance
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="access_attendance" name="permissions[]"
                                                                    value="access_attendance"
                                                                    {{ $role->hasPermissionTo('access_attendance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="access_attendance">Access</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="show_attendance" name="permissions[]"
                                                                    value="show_attendance"
                                                                    {{ $role->hasPermissionTo('show_attendance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="show_attendance">View</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="create_attendance" name="permissions[]"
                                                                    value="create_attendance"
                                                                    {{ $role->hasPermissionTo('create_attendance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="create_attendance">Create</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="edit_attendance" name="permissions[]"
                                                                    value="edit_attendance"
                                                                    {{ $role->hasPermissionTo('edit_attendance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="edit_attendance">Edit</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="delete_attendance" name="permissions[]"
                                                                    value="delete_attendance"
                                                                    {{ $role->hasPermissionTo('delete_attendance') ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="delete_attendance">Delete</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#select-all').click(function() {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function() {
                    this.checked = checked;
                });
            })
        });
    </script>
@endsection
