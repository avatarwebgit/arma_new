@extends('home.homelayout.app')

@section('style')
    <style>
        td, th {
            border: none !important;
        }

        th {
            color: #036f88 !important;
            position: relative;
        }

        th:before {
            content: "";
            position: absolute;
            top: 8px !important;
            left: 10px !important;
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

    </script>
@endsection



@section('content')
    <div>
        <div class="landing-feature container">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Result For <span class="text-danger text-bold">{{ $value }}</span>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-12">
                            <h3>
                                Search in Blogs
                                <hr>
                            </h3>
                        </div>
                        @if(count($blogs)>0)
                            @foreach($blogs as $blog)
                                <div class="col-12 col-md-4">
                                    <div class="landing-feature-item">
                                        <div class="img-blog w-100 ">
                                            <img class="w-100"
                                                 src="{{imageExist(env('UPLOAD_IMAGE_BLOG'),$blog->image)}}"
                                                 alt="">
                                        </div>
                                        <h2>

                                            <a href="{{route('home.blog.show',['blog'=>$blog->id])}}"
                                               class="cursor-pointer text-dark">
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
                        @else
                            <div class="col-12">
                                <div class="alert alert-info text-center">No Blogs Found</div>
                            </div>
                        @endif

                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-12">
                            <h3>
                                Search in Pages
                                <hr>
                            </h3>
                        </div>
                        @if(count($pages)>0)
                            @foreach($pages as $page)
                                @if(count($page->Menus)>0)
                                    <div class="col-12 col-md-4 mb-3">
                                        <div class="landing-feature-item">
                                            <h5>
                                                <a href="{{route('home.menus',['menus'=>$page->Menus[0]->id])}}"
                                                   class="cursor-pointer text-dark">
                                                    {{$page->title}}
                                                </a>
                                            </h5>
                                            <h4 class="text-muted">

                                            </h4>
                                            {!! strip_tags(Str::limit($page->description,200),'<p><br>') !!}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    No Pages Found
                                </div>
                            </div>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
