@extends('home.homelayout.app')

@section('style')
    <style>
        td,th{
            border: none !important;
        }
        th{
            color: #036f88  !important;
            position: relative;
        }
        th:before{
            content: "";
            position: absolute;
            top: 8px !important;
            left: 10px !important;
            width: 2px;
            height: 20px !important;
            background-color: #ffa700;
        }
        .landing-feature{
            text-align: justify !important;
        }
        label{
            font-size: 16px;
        }

        #url,#option_value{
            display: none;
        }

        .img-blog{
            object-fit: cover;

        }

        .img-blog img{
            height: auto !important;
        }
    </style>
@endsection

@section('script')
    <script>
        $('.more_btn').click(function(){
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

        function selectType(tag)
        {

            if($(tag).val() == 'Article Update'){
                $('#url').fadeIn();
                $('#option_value').fadeIn();
            }else{
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
    <div class="landing-feature">

    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                <h2> Blogs</h2>
            </div>
            @foreach($blogs as $blog)


            <div class="col-md-4">
                <div class="landing-feature-item">
<div class="img-blog w-100 ">
    <img class="w-100" src="{{imageExist(env('UPLOAD_IMAGE_BLOG'),$blog->image)}}" alt="">
</div>
                    <h2>

                   <a href="{{route('home.blog.show',['blog'=>$blog->id])}}" class="cursor-pointer text-dark">
                       {{$blog->title}}
                   </a>
                    </h2>
                    <h4 class="text-muted">{{$blog->Category->title}}</h4>
                    <p>
                        {{$blog->short_description}}
                    </p>
                </div>
            </div>

                @endforeach

        </div>
    </div>
@endsection
