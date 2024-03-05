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
                                        <a href="{{ route('admin.pages.index') }}"
                                           class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST"
                                              action="{{ route('admin.page.store') }}">
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
                                                    <label for="menu">Menu</label>
                                                    <select id="menu" name="menu" class="form-control">
                                                        <option value="">Select Menu</option>
                                                        @foreach($menus as $menu)
                                                            <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                                                            @foreach($menu->children as $child)
                                                                <option
                                                                    value="{{ $child->id }}">{{ $menu->title.' - '.$child->title }}</option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                    @error('menu')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb20">
                                                    <label for="active_banner">Active Banner</label>
                                                    <select id="active_banner" name="active_banner" class="form-control">
                                                        <option {{ old('active_banner')==1 ? 'selected' : '' }} value="1">Active</option>
                                                        <option {{ old('active_banner')==0 ? 'selected' : '' }} value="0">Inactive</option>
                                                    </select>
                                                    @error('active_banner')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb20">
                                                    <label for="title" class="mb20 text-left d-block">Banner</label>
                                                    <input id="banner" type="file" name="banner"
                                                           class="form-control">
                                                    @error('banner')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3 mt-3">
                                                    <label for="banner_description"ِ>Banner Description</label>
                                                    <textarea class="form-control" id="banner_description" name="banner_description">{{ old('banner_description') }}</textarea>
                                                    @error('banner_description')
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
        CKEDITOR.replace( 'banner_description' ,{
            language: 'en',
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush

