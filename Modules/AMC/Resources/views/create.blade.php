@extends('setting::layouts.master')

@section('title', 'Create AMC')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Create AMC</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Create AMC</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('amc.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">AMC Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label>Year </label>
                                    <input type="text" name="year" class="form-control" placeholder="Enter Year"
                                        >
                                </div>
                                <div class="col-md-3">
                                    <label>Month <span class="text-danger">*</span></label>
                                    <select name="month" class="form-control" required>
                                        <option value="">Select Month</option>
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}">{{ $m }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="price" class="form-control"
                                        placeholder="Enter Price" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Enter Description (optional)"></textarea>
                                </div>
                                <div class="mt-3 col-md-12">
                                    <label class="form-label12">Publish</label>
                                    <br>
                                    <input type="checkbox" name="status" checked data-bootstrap-switch
                                        data-off-color="danger" data-on-color="success">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accessories Section -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title">Accessories</h3>
                        </div>
                        <div class="card-body">
                            <div id="accessoryContainer"></div>
                            <button type="button" id="addAccessory" class="badge badge-primary mt-3">Add Accessory</button>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save AMC</button>
                        <a href="{{ route('amc.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- Accessories JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            let accessoryIndex = 0;

            $('#addAccessory').on('click', function() {
                accessoryIndex++;
                const row = `
                <div class="row align-items-center accessory-row mb-3" id="accessory-${accessoryIndex}">
                    <div class="col-md-6">
                        <select class="form-control accessory-select" name="accessories_id[]"
                            id="accessory-select-${accessoryIndex}">
                            <option value="">Select Accessory</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="accessories_qty[]" value="1" class="form-control"
                            placeholder="Quantity">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="badge badge-danger removeAccessory">X</button>
                    </div>
                </div>`;
                $('#accessoryContainer').append(row);
                initializeSelect(`#accessory-select-${accessoryIndex}`);
            });

            function initializeSelect(selector) {
                $(selector).select2({
                    theme: 'bootstrap4',
                    placeholder: 'Search Accessory',
                    ajax: {
                        url: '/accessories',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.name
                                }))
                            };
                        }
                    }
                });
            }

            $(document).on('click', '.removeAccessory', function() {
                $(this).closest('.accessory-row').remove();
            });
        });
    </script>
@endsection
