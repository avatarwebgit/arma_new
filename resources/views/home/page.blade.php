@extends('home.homelayout.app')

@section('title')
    {{ $page->title }}
@endsection

@section('style')
    <style>
        td, th {
            border: none !important;
            padding-left: 10px !important;
        }

        tbody td:hover {
            background: #f6f8f9;
        }


        th {
            color: #036f88 !important;
            position: relative;
            padding-left: 10px !important;
        }

        th:before {
            content: "";
            position: absolute;
            top: 8px !important;
            left: 0 !important;
            width: 2px;
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
    </style>
@endsection

@section('script')
    <script>
        $('.more_btn').click(function () {
            let is_close = $(this).hasClass('is_close');
            let button_html = '';
            if (is_close) {
                button_html = `show less
                    <i class="fa fa-angle-up ml-3"></i>`;
                $(this).parent().find('.text_want_to_hide').slideDown(2000);
                $(this).removeClass('is_close');
            } else {
                button_html = `show more
                    <i class="fa fa-angle-down ml-3"></i>`;
                $(this).parent().find('.text_want_to_hide').slideUp(2000);
                $(this).addClass('is_close');
            }
            $(this).html(button_html);
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
                    THis Menu Doesn't Have A Page.Please Create A Page For This Menu
                </div>
            </div>
        </div>
    @else
        <div>
            @if($page->active_banner ==1)
                <div class="position-relative">
                    <img style="width: 100%;height: auto" alt="banner"
                         src="{{ imageExist(env('UPLOAD_BANNER_PAGE'),$page->banner) }}">
                    <div style="position: absolute;top: 0;padding: 40px">
                        {!! $page->banner_description !!}
                    </div>
                </div>
            @endif
            <div class="landing-feature container">
                @if($page!=null)
                    <div class="row">
                        @if($menus->id!=2)
                            <div class="col-md-12">
                                <h2>{{ $page->title }}</h2>
                            </div>
                        @endif
                        <div class="{{$page->id == 20 ? 'col-md-6' : 'col-md-12'}}">
                            {!! $page->description !!}
                        </div>
                        @if($page->id == 20)
                            <div class="col-md-6">
                                <div>
                                    <form method="post" action="{{route('form.contact')}}">
                                        @csrf
                                        @method('POST')
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
                                            <select onchange="selectType(this)" class="form-select form-control"
                                                    name="type">
                                                <option>-</option>
                                                <option>Article Update</option>
                                                <option>Password Reset</option>
                                                <option>Unsubscribe</option>
                                                <option>Delete my Account</option>
                                                <option>Content Licensing</option>
                                                <option>General Support</option>
                                                <option>Report a Bug</option>
                                                <option>Other</option>

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
                                            <span>Please enter the details of your request below.</span>
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
                                                Please select one of the article update options below:

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
                    </div>
                @endif
            </div>
        </div>
    @endif

@endsection
