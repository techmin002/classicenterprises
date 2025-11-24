@extends('setting::layouts.master')

@section('title', 'Edit EMI Plan')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('emi.system.index') }}">EMI Plans</a></li>
        <li class="breadcrumb-item active">Edit EMI Plan</li>
    </ol>
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit EMI Plan</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('emi.system.update', $emiPlan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Plan Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $emiPlan->title }}" required>
                        </div>

                        <div class="form-group">
                            <label for="duration">Duration (Months)</label>
                            <input type="number" name="duration" class="form-control" value="{{ $emiPlan->duration }}" required min="1">
                        </div>

                        <div class="form-group">
                            <label for="interest_rate">Interest Rate (%)</label>
                            <input type="number" step="0.01" name="interest_rate" class="form-control" value="{{ $emiPlan->interest_rate }}" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ $emiPlan->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $emiPlan->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $emiPlan->description }}</textarea>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('emi.system.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Update EMI Plan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
