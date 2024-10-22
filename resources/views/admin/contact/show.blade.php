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
                                        <a href="{{ route('admin.contact.index') }}"
                                           class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                    </div>


                                    <div class="settings-profile">


                                            <div class="row mt-4">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="url">url</label>
                                                    <input value="{{$contact->url}}" readonly id="url"  class="form-control"
                                                          >

                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="url">options</label>
                                                    <input value="{{$contact->option_value}}" readonly id="option "  class="form-control"
                                                    >

                                                </div>
                                                <div class="col-12 col-md-12 mb-3">
                                                    <label for="description">description</label>
{{--                                                    <input readonly id="url"  class="form-control"--}}
{{--                                                          >--}}

                                                    <textarea class="form-control" readonly  cols="30" rows="10">{{$contact->description}}
                                                    </textarea>

                                                </div>


                                            </div>

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
        .small-image {
            width: 100px;
            height: auto;
            margin: 10px auto;
        }
        #cke_description .cke_contents{
            height: 700px !important;
        }
    </style>
@endpush
@section('script')
    <script>

        CKEDITOR.replace( 'description' ,{
            language: 'en',
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

    </script>
    <script>
        CKEDITOR.replace( 'banner_description' ,{
            language: 'en',
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection

