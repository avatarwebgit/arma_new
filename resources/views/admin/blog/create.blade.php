@extends('admin.layouts.main')

@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div id="settings-profile"
                             aria-labelledby="settings-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <a href="{{ route('admin.blog.index') }}"
                                           class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST"
                                              action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="title">Title</label>
                                                    <input id="title" name="title" class="form-control"
                                                           value="{{ old('title') }}">
                                                    @error('title')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="category_id">Category</label>
                                                    <select id="category_id" name="category_id" class="form-control">
                                                        <option value="">Select Category</option>
                                                        @foreach($CategoryBlog as $category)
                                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb20">
                                                    <label for="send_news">Send For Users</label>
                                                    <select id="send_news" name="send_news" class="form-control">
                                                        <option {{ old('send_news')==1 ? 'selected' : '' }} value="1">Enable</option>
                                                        <option {{ old('send_news')==0 ? 'selected' : '' }} value="0">Disable</option>
                                                    </select>
                                                    @error('send_news')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb20">
                                                    <label for="image" class="mb20 text-left d-block">Image</label>
                                                    <input id="image" type="file" name="image"
                                                           class="form-control">
                                                    @error('image')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3 mt-3">
                                                    <label for="short_description"ِ>Short Description</label>
                                                    <textarea class="form-control" id="short_description" name="short_description">{{ old('short_description') }}</textarea>
                                                    @error('short_description')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="description"ِ>Description</label>
                                                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                                    @error('description')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-primary btn-block btn-sm">
                                                        Create
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        #cke_description .cke_contents{
            height: 700px !important;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset('admin/fullCKEditor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'description' ,{
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace( 'show_description' ,{
            language: 'en',
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush

