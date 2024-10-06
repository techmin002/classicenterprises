@extends('setting::layouts.master')

@section('title', 'Edit Services')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Service</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Service</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="product-form" action="{{ route('services.update',$service->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Title</label>
                                                <input type="text" name="title" class="form-control"
                                                    placeholder="Enter Title "value="{{ $service->title }}" required>
                                                @error('title')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="icon">icon </label>

                                                <input type="file" id="file-ip-1" accept="image/*"
                                                    class="form-control-file border" value="{{ old('icon') }}"
                                                    onchange="showPreview2(event);" name="icon">
                                                @error('icon')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <img src="" id="file-ip-2-preview" width="200px">
                                                </div>
                                                <div class="preview mt-2">
                                                    <img src="{{ asset('upload/images/services/'.$service->icon) }}" width="200px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shortDescription">Short Description</label>
                                                <textarea type="text" name="shortDescription" class="summernote" placeholder="Enter Short Description" required>{{ $service->shortDescription }}</textarea>
                                                @error('shortDescription')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea type="text" name="description" class="summernote" placeholder="Enter Short description">{{ $service->description  }}</textarea>
                                                @error('description')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image">Image </label>

                                                <input type="file" id="file-ip-1" accept="image/*"
                                                    class="form-control-file border" value="{{ old('image') }}"
                                                    onchange="showPreview1(event);" name="image">
                                                @error('image')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <img src="" id="file-ip-1-preview" width="200px">
                                                </div>
                                                <div class="preview mt-2">
                                                    <img src="{{ asset('upload/images/services/'.$service->image) }}" width="200px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Bootstrap Switch -->
                                            <div class="card card-secondary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Publish</h3>
                                                </div>
                                                <div class="card-body">
                                                    @if($service->status == 'on')
                                                    <input type="checkbox" name="status" checked data-bootstrap-switch
                                                        data-off-color="danger" data-on-color="success" >
                                                @else
                                                    <input type="checkbox" name="status" data-bootstrap-switch
                                                    data-off-color="danger" data-on-color="success">
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('script')

    <!-- image preview -->
    <script type="text/javascript">
        function showPreview1(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }
    </script>
    <script type="text/javascript">
        function showPreview2(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-2-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }
    </script>
    <script>
        $('textarea.summernote').summernote({
            // placeholder: 'Enter Description',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']],
                ['view', ['fullscreen', 'codeview']],
                ['help', ['help']]
            ],
        });
    </script>
    <script>
        $('.extra-fields-customer').click(function() {
            $('.customer_records').clone().appendTo('.customer_records_dynamic');
            $('.customer_records_dynamic .customer_records').addClass('single remove');
            $('.single .extra-fields-customer').remove();
            $('.single').append(
                '<a href="#" class="remove-field btn-remove-customer badge badge-danger">Remove Product</a>');
            $('.customer_records_dynamic > .single').attr("class", "remove");

            $('.customer_records_dynamic input').each(function() {
                var count = 0;
                var fieldname = $(this).attr("name");
                $(this).attr('name', fieldname + count);
                count++;
            });

        });

        $(document).on('click', '.remove-field', function(e) {
            $(this).parent('.remove').remove();
            e.preventDefault();
        });
    </script>
   
@endsection
