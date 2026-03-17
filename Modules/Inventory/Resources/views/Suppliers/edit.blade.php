@extends('setting::layouts.master')

@section('title', 'Edit Supplier')

@section('content')
<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="fw-bold">Edit Supplier</h1>
                <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </section>

    <!-- Form -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('suppliers_update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="row g-3">

                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control"
                                       value="{{ $supplier->name }}" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                       class="form-control"
                                       value="{{ $supplier->email }}">
                            </div>

                            <!-- Contact -->
                            <div class="col-md-6">
                                <label class="form-label">Contact</label>
                                <input type="text" name="contact"
                                       class="form-control"
                                       value="{{ $supplier->contact }}">
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" name="address"
                                       class="form-control"
                                       value="{{ $supplier->address }}">
                            </div>

                            <!-- PAN -->
                            <div class="col-md-6">
                                <label class="form-label">PAN</label>
                                <input type="text" name="pan"
                                       class="form-control"
                                       value="{{ $supplier->PAN }}">
                            </div>

                          <!-- Status -->
<div class="col-md-3">
    <div class="form-group">
        <label>Status <span class="text-danger">*</span></label>
        <select name="status" class="form-control" required>
            <option value="1" {{ $supplier->status == 1 ? 'selected' : '' }}>
                Active
            </option>
            <option value="0" {{ $supplier->status == 0 ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>
</div>

<!-- Branch -->
<div class="col-md-3">
    <div class="form-group">
        <label>Branch <span class="text-danger">*</span></label>
        <select name="branch_id" class="form-control" required>
            <option value="">Select Branch</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}"
                    {{ $supplier->branch_id == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="discription"
                                          class="form-control"
                                          rows="3">{{ $supplier->discription }}</textarea>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Update
                            </button>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </section>

</div>
@endsection