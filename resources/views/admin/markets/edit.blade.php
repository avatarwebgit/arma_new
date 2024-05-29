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
                                        <a href="{{ route('admin.markets.index') }}"
                                           class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST"
                                              action="{{ route('admin.market.update',['market'=>$market->id]) }}">
                                            @csrf
                                            @method('put')
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="date">start(Date)</label>
                                                    <input onchange="getDate(this)" id="date" type="date" name="date"
                                                           class="form-control"
                                                           value="{{ $market->date }}">
                                                    <p id="DayName" class="mt-2">

                                                    </p>
                                                    @error('date')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="start">start(Time)</label>
                                                    {{--                                                    ///clockpicker--}}
                                                    <div class="input-group " data-placement="left" data-align="top"
                                                         data-autoclose="true">
                                                        <input type="time" class="form-control"
                                                               value="{{ $market->time }}" name="time">
                                                        <span class="input-group-addon">
        <span class="glyphicon glyphicon-time"></span>
    </span>
                                                    </div>
                                                    @error('bid_deposit')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="min_wallet">Commodity</label>
                                                    <select onchange="CheckHasAlpha(this)"
                                                            class="form-control" id="commodity_id" name="commodity_id">
                                                        <option value="">select</option>
                                                        @foreach($sales_offer_form as $item)
                                                            <option data-type="{{ $item->price_type }}"
                                                                    {{ $market->commodity_id==$item->id?'selected':'' }} value="{{ $item->id }}">
                                                                Commodity:{{ $item->commodity }}
                                                                /User:{{ $item->User->email }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('commodity_id')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="bid_deposit">Bid Deposit</label>
                                                    <input id="bid_deposit" name="bid_deposit" class="form-control"
                                                           value="{{ $market->bid_deposit }}">
                                                    @error('bid_deposit')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="step_price_competition">Step Price In
                                                        Competition</label>
                                                    <input id="step_price_competition" name="step_price_competition"
                                                           min="1" class="form-control"
                                                           value="{{ $market->step_price_competition }}">
                                                    @error('step_price_competition')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="market_value">Market Value ($)</label>
                                                    <input id="market_value" name="market_value" class="form-control"
                                                           value="{{ $market->market_value }}" type="number">
                                                    @error('market_value')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="ready_to_open">Ready to Open(min)</label>
                                                    <input id="ready_to_open" type="number" name="ready_to_open"
                                                           class="form-control"
                                                           value="{{ $market->ready_to_open }}">
                                                    @error('ready_to_open')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="date">Opening(min)</label>
                                                    <input id="opening" type="number" name="opening"
                                                           class="form-control"
                                                           value="{{ $market->opening }}">
                                                    @error('opening')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="date">Quotation 1/2 (min)</label>
                                                    <input id="q_1" type="number" name="q_1" class="form-control"
                                                           value="{{ $market->q_1 }}">
                                                    @error('q_1')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="date">Quotation 2/2 (min)</label>
                                                    <input id="q_2" type="number" name="q_2" class="form-control"
                                                           value="{{ $market->q_2 }}">
                                                    @error('q_2')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="q_3">Competition(min)</label>
                                                    <input id="q_3" type="number" name="q_3" class="form-control"
                                                           value="{{ $market->q_3 }}">
                                                    @error('q_3')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3 d-none" id="alpha_parent">
                                                    <label for="step_price_competition">Alpha</label>
                                                    <input id="alpha" name="alpha" class="form-control"
                                                           value="{{ $market->alpha }}">
                                                    @error('alpha')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="term_conditions">Term & Conditions</label>
                                                    <textarea id="term_conditions" name="term_conditions"
                                                              class="form-control text_area">{{ $market->term_conditions }}</textarea>
                                                    @error('term_conditions')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-primary btn-block btn-sm">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                            <input id="show_alpha" name="show_alpha" type="hidden" value="0">
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
        $(document).ready(function () {
            var element = $('#commodity_id')[0]; // انتخاب المان با آی‌دی مورد نظر
            CheckHasAlpha(element); // فراخوانی تابع CheckHasAlpha() با المان مورد نظر به عنوان ورودی
        })
        function CheckHasAlpha(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var dataType = selectedOption.getAttribute('data-type');
            let show_alpha = 0;
            if (dataType == 'Formulla') {
                show_alpha = 1;
            }
            AlphaInput(show_alpha);
        }

        function AlphaInput(show_alpha) {
            $('#alpha_parent').removeClass('d-none');
            $('#alpha_parent').addClass('d-none');
            if (show_alpha === 1) {
                $('#alpha_parent').removeClass('d-none');
            }
            $('#show_alpha').val(show_alpha);
        }

        function getDate(tag) {
            let date = $(tag).val();
            date = date.replaceAll('-', '/', date);
            date = new Date(date);

            let day = date.getDay();
            let DayName;
            if (day === 0) {
                DayName = "Sunday";
            } else if (day === 1) {
                DayName = "Monday";
            } else if (day === 2) {
                DayName = "Tuesday";
            } else if (day === 3) {
                DayName = "Wednesday";
            } else if (day === 4) {
                DayName = "Thursday";
            } else if (day === 5) {
                DayName = "Friday";
            } else if (day === 6) {
                DayName = "Saturday";
            }
            $('#DayName').text(DayName);
        }

        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('term_conditions', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush

