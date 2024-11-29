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
                                        <a href="{{ route('admin.menus.index') }}"
                                           class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST"
                                              action="{{ route('admin.menu.store') }}">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="title">Title</label>
                                                    <input id="title"  name="title" class="form-control"
                                                           value="{{ old('title') }}">
                                                    @error('title')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="parent">Parent</label>
                                                    <select id="parent"  name="parent" class="form-control">
                                                        <option value="0" >Without Parent</option>
                                                        @foreach($parent_menus as $menu)
                                                        <option value="{{ $menu->id }}" >{{ $menu->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('parent')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>

                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="priority">priority</label>
                                                    <input id="priority" type="number"  name="priority" class="form-control"
                                                           value="{{ old('priority') }}">
                                                    @error('priority')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <input {{ old('show_on_header')==1 ? 'checked' : '' }} id="show_on_header" type="checkbox"  name="show_on_header" value="{{ $menu->show_on_header }}">
                                                    @error('show_on_header')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                    <label for="show_on_header">Show On Header</label>
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <input {{ old('show_on_footer')==1 ? 'checked' : '' }} id="show_on_footer" type="checkbox"  name="show_on_footer" value="{{ $menu->show_on_footer }}">
                                                    @error('show_on_footer')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                    <label for="show_on_footer">Show On Footer</label>
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

@endpush
@push('script')

@endpush

