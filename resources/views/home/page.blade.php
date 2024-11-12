@extends('home.homelayout.app')

@section('title')
    {{ isset($page->title)   ? $page->title : 'صفحه وجود ندارد' }}
@endsection

@section('style')
    <style>
        span {
            line-height: 9pt !important;
        }

        .red td {
            color: #c20000 !important;
        }

        .green td {
            color: green !important;
        }

        @media screen and (max-width: 768px) {
            span {
                font-size: 10pt !important;
            }

            p {
                line-height: 17px !important;
                margin: 0 !important;
            }
        }

        td, td {
            border: none !important;
            padding-left: 10px !important;
        }

        tbody td:hover {
            background: #d9d9d9;
        }

        .daily_report tr:hover {
            background: #d9d9d9 !important;
            cursor: pointer;
        }

        .daily_report tbody tr:nth-child(2n+1) {
            background: #f8f8f8;
        }

        thead td {
            color: black !important;
            font-weight: bold !important;
        }


        td {
            color: #036f88 !important;
            position: relative;
            padding-left: 10px !important;
        }

        td:before {
            content: "";
            position: absolute;
            top: 8px !important;
            left: 0 !important;
            widtd: 2px;
            height: 20px !important;
            background-color: #ffa700;
        }

        .landing-feature {
            text-align: justify !important;
        }

        label {
            font-size: 16px;
        }

        #url, #option_value {
            display: none;
        }

        .table td {
            padding: 6px 18px !important;
        }
    </style>
@endsection

@section('script')
    <script>
        $('.more_btn').click(function () {
            let is_close = $(tdis).hasClass('is_close');
            let button_html = '';
            if (is_close) {
                button_html = `show less
                    <i class="fa fa-angle-up ml-3"></i>`;
                $(tdis).parent().find('.text_want_to_hide').slideDown(2000);
                $(tdis).removeClass('is_close');
            } else {
                button_html = `show more
                    <i class="fa fa-angle-down ml-3"></i>`;
                $(tdis).parent().find('.text_want_to_hide').slideUp(2000);
                $(tdis).addClass('is_close');
            }
            $(tdis).html(button_html);
        })

        function selectType(tag) {

            if ($(tag).val() == 'Article Update') {
                $('#url').fadeIn();
                $('#option_value').fadeIn();
            } else {
                $('#url').fadeOut();
                $('#option_value').fadeOut();
            }

        }
    </script>
@endsection



@section('content')

    {{--    <div class="btn more_btn is_close">--}}
    {{--        show more--}}
    {{--        <i class="fa fa-angle-down ml-3"></i>--}}
    {{--     </div>--}}
    @if($page==null)
        <div class="landing-feature container">
            <div class="col-12">
                <div class="alert alert-success text-center">
                    tdis Menu Doesn't Have A Page.Please Create A Page For tdis Menu
                </div>
            </div>
        </div>
    @else
        <div>
            @if($page->active_banner ==1)
                <div class="position-relative">
                    <img style="widtd: 100%;height: auto" alt="banner"
                         src="{{ imageExist(env('UPLOAD_BANNER_PAGE'),$page->banner) }}">
                    <div style="position: absolute;top: 0;padding: 40px">
                        {!! $page->banner_description !!}
                    </div>
                </div>
            @endif
            <div class="landing-feature container">
                @if($page!=null)
                    <div class="row">
                        {{--                        @if($menus->id!=2)--}}
                        {{--                            <div class="col-md-12">--}}
                        {{--                                <h2>{{ $page->title }}</h2>--}}
                        {{--                            </div>--}}
                        {{--                        @endif--}}
                        <div class="{{$page->id == 20 ? 'col-md-6' : 'col-md-12'}}">
                            {!! $page->description !!}
                        </div>
                        @if($page->id == 20)
                            <div class="col-md-6">
                                <div>
                                    <form metdod="post" action="{{route('form.contact')}}">
                                        @csrf
                                        @metdod('POST')
                                        <div class="form-group">
                                            <label for="" class="form-label fw-600">Your email address
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="email">
                                            @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label fw-600">

                                                <span class="text-danger">*</span>
                                            </label>
                                            <select onchange="selectType(tdis)" class="form-select form-control"
                                                    name="type">
                                                <option>-</option>
                                                <option>Article Update</option>
                                                <option>Password Reset</option>
                                                <option>Unsubscribe</option>
                                                <option>Delete my Account</option>
                                                <option>Content Licensing</option>
                                                <option>General Support</option>
                                                <option>Report a Bug</option>
                                                <option>Otder</option>

                                            </select>
                                            @error('type')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label fw-600">Description
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea rows="8" class="form-control" name="description"></textarea>
                                            <span>Please enter tde details of your request below.</span>
                                            @error('description')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div id="url" class="form-group">
                                            <label for="" class="form-label fw-600">URL of article or web page
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="url">
                                            @error('url')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div id="option_value" class="form-group">
                                            <label for="" class="form-label fw-600">
                                                Please select one of tde article update options below:

                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select form-control" name="option_value">
                                                <option>-</option>
                                                <option>Corrections</option>
                                                <option>Outdated content</option>
                                                <option>Typos or Grammer</option>
                                            </select>
                                            @error('option')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label fw-600">
                                                Attachments

                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" class="form-control" name="file">
                                            @error('file')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group text-center">

                                            <button type="submit" class="btn btn-primary w-100">submit</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if($menus->id == 4)

                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table daily_report">
                                        <thead>
                                        <tr style="background-color: #d9d9d9 !important">
                                            <td>
              <span>
            Date
            </span>
                                            </td>
                                            <td>
            <span>
            Commodity
            </span>
                                            </td>

                                            <td>
            <span>
              Quantity
            </span>
                                            </td>
                                            <td>
             <span>
            Min Order
            </span>
                                            </td>
                                            <td>
            <span>
            Packing
            </span>
                                            </td>
                                            <td>
             <span>
            Delivery
            </span>
                                            </td>
                                            <td>
                        <span>

            Region
            </span>
                                            </td>
                                            <td>
                        <span>

            Price Type
            </span>
                                            </td>
                                            <td>
                        <span>

            Offer Price
            </span>
                                            </td>
                                            <td>
                        <span>

            Highest Bid
            </span>
                                            </td>
                                            <td>
                        <span>

           Quantity
            </span>
                                            </td>
                                            <td>
                        <span>

           Status
            </span>
                                            </td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($markets as $market)
                                            @php
                                                $bid=$market->Bids()->orderBy('price','desc')->first();
                                                if ($bid){
                                                    $highest=$bid->price;
                                                }else{
                                                    $highest=0;
                                                }

                                                $has_winner=$market->Bids()->where('is_win')->exists();
                                                if ($has_winner){
                                                    $status_color='green';
                                                    $status_text='Done';
                                                }else{
                                                     $status_color='red';
                                                    $status_text='Failed';
                                                }
                                                if ($market->SalesForm->unit=='other' or $market->SalesForm->unit=='Other'){
                                                    $unit=$market->SalesForm->unit_other;
                                                }else{
                                                    $unit=$market->SalesForm->unit;
                                                }
                                            @endphp
                                            <tr class="{{ $status_color }}">
                                                <td>
              <span>
            {{ $market->date }}
            </span>
                                                </td>
                                                <td>
            <span>
            {{ $market->SalesForm->commodity }}
            </span>
                                                </td>

                                                <td>
            <span>

             {{ $market->SalesForm->max_quantity.'('.$unit.')' }}
            </span>
                                                </td>
                                                <td>
             <span>
                  @php
                      $minQuantity=str_replace(',','',$market->SalesForm->min_order);
                  @endphp
                 {{ number_format($minQuantity) }}
            </span>
                                                </td>
                                                <td>
            <span>
             {{ $market->SalesForm->packing }}
            </span>
                                                </td>
                                                <td>
             <span>
            {{ str_replace('-','/',$market->SalesForm->loading_from).' - '.str_replace('-','/',$market->SalesForm->loading_to) }}
            </span>
                                                </td>
                                                <td>
                        <span>

            {{ $market->SalesForm->origin_country }}
            </span>
                                                </td>
                                                <td>
                        <span>

            {{ $market->SalesForm->price_type }}
            </span>
                                                </td>
                                                @if($market->SalesForm->price_type=='Fix')
                                                    <td>{{ number_format($market->SalesForm->price) }}</td>
                                                @else
                                                    <td>{{ number_format($market->SalesForm->alpha)  }}</td>
                                                @endif
                                                <td>
                        <span>



                            {{ $highest==0 ? 'N.A' : '' }}

            </span>
                                                </td>
                                                <td>
                        <span>

           Quantity
            </span>
                                                </td>
                                                <td>
                        <span>

           {{ $status_text }}
            </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif

@endsection
