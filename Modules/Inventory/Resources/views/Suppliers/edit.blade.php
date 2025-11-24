@extends('setting::layouts.master')

@section('title', 'Edit Supplier')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">{{ ucfirst($supplier->type) }} Suppliers</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Suppliers</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
                            <li class="breadcrumb-item active">Edit Suppliers</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content-header">
            <div class="container-fluid mb-4">
                <form action="{{ route('suppliers_update', $supplier->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="name" required
                                                    value="{{ $supplier->name }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input class="form-control" type="email" name="email"
                                                    value="{{ $supplier->email }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="contact">Contact</label>
                                                <input class="form-control" type="text" name="contact"
                                                    value="{{ $supplier->contact }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input class="form-control" type="text" name="address"
                                                    value="{{ $supplier->address }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="pan">PAN</label>
                                                <input class="form-control" type="text" name="pan"
                                                    value="{{ $supplier->PAN }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="vat">VAT</label>
                                                <input class="form-control" type="text" name="vat"
                                                    value="{{ $supplier->VAT }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="type">Type <span class="text-danger">*</span></label>
                                                <select class="form-control" name="type" required>
                                                    <option value="supplier"
                                                        {{ $supplier->type == 'supplier' ? 'selected' : '' }}>Local
                                                    </option>
                                                    <option value="vendor"
                                                        {{ $supplier->type == 'vendor' ? 'selected' : '' }}>International
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group  ">
                                                <label for="status">Status <span class="text-danger">*</span></label>
                                                <select class="form-control" name="status" required>
                                                    <option value="1" {{ $supplier->status == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0" {{ $supplier->status == 0 ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="branch_id">Branch <span class="text-danger">*</span></label>
                                                <select class="form-control" name="branch_id" required>
                                                    <option value="">Select Branch</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}"
                                                            {{ $supplier->branch_id == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="created_by">Created By <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="created_by" required>
                                                    <option value="">Select User</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $supplier->created_by == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="image">Discription</label>
                                                <input class="form-control" type="text" name="discription"
                                                    value="{{ $supplier->discription }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary">Update <i class="bi bi-check"></i></button>
                                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back <i
                                                    class="bi bi-arrow-left"></i></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        function showPreview1(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }
    </script>
@endsection
