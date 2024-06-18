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
                                    <div class="settings-profile">
                                        <form method="POST"
                                              action="{{ route('admin.markets.settings.update') }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="change_time">Change Market Table At(Time)</label>
                                                    <input id="change_time" type="time" name="change_time"
                                                           class="form-control"
                                                           value="{{ $change_time }}">
                                                    @error('change_time')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="bid_deposit_text_area">Bid Deposit</label>
                                                    <textarea id="bid_deposit_text_area" name="bid_deposit_text_area"
                                                              class="form-control text_area">{{ $bid_deposit_text_area }}</textarea>
                                                    @error('bid_deposit_text_area')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    Bid Instructions
                                                    <hr>
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="bid_use">What Do You Want To Use For Bid Instructions
                                                        ?</label>
                                                    <select id="bid_use" name="bid_use" class="form-control">
                                                        <option {{ $bid_use=='Link' ? 'selected' : '' }} value="Link">
                                                            Link
                                                        </option>
                                                        <option {{ $bid_use=='File' ? 'selected' : '' }} value="File">
                                                            File
                                                        </option>
                                                    </select>
                                                    @error('bid_use')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="Bid_Instructions_link">Link</label>
                                                    <input id="Bid_Instructions_link" name="Bid_Instructions_link"
                                                           class="form-control"
                                                           value="{{ $Bid_Instructions_link }}">
                                                    @error('Bid_Instructions_link')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="Bid_Instructions_file">
                                                        <a target="_blank" href="{{ imageExist(env('UPLOAD_SETTING'),$Bid_Instructions_file) }}">
                                                            <i class="fa fa-paperclip"></i>
                                                        </a>
                                                        File
                                                    </label>
                                                    <input id="Bid_Instructions_file" type="file"
                                                           name="Bid_Instructions_file"
                                                           class="form-control"
                                                           value="">
                                                    @error('Bid_Instructions_file')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    GTC
                                                    <hr>
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="gtc_use">What Do You Want To Use For GTC ?</label>
                                                    <select id="gtc_use" name="gtc_use" class="form-control">
                                                        <option {{ $gtc_use=='Link' ? 'selected' : '' }} value="Link">
                                                            Link
                                                        </option>
                                                        <option {{ $gtc_use=='File' ? 'selected' : '' }} value="File">
                                                            File
                                                        </option>
                                                    </select>
                                                    @error('gtc_use')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="gtc_Link">Link</label>
                                                    <input id="gtc_Link" name="gtc_Link"
                                                           class="form-control"
                                                           value="{{ $gtc_Link }}">
                                                    @error('gtc_Link')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="gtc_file">
                                                        <a target="_blank" href="{{ imageExist(env('UPLOAD_SETTING'),$gtc_file) }}">
                                                            <i class="fa fa-paperclip"></i>
                                                        </a>
                                                        File

                                                    </label>

                                                    <input id="gtc_file" type="file" name="gtc_file"
                                                           class="form-control"
                                                           value="">
                                                    @error('gtc_file')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-primary btn-block btn-sm">
                                                        Edit
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
    <script>
        CKEDITOR.replace('bid_deposit_text_area', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });

    </script>
@endpush

