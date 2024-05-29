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
                                              action="{{ route('admin.markets.settings.update') }}">
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

