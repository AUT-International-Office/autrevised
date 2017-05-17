@extends('layouts.app')

@section('title')
Report
@endsection

@section('content')
    <div class="container-fluid">
        <div class="tableOfContents p-4">
            <div class="card-title">
                <h2>
                    Table of contents
                </h2>
            </div>
            @foreach($funds as $arr)

                @if(!$arr["funds"]->isEmpty() || !$arr["tag"]["mainTag"]->children->isEmpty())
                    @if($arr["tag"]["mainTag"]["is_parent"] && $arr["tag"]["mainTag"]->parent_id == 0)
                        @if($loop->index != 0)
                            <div class="card p-2" style="width: 100%">
                                <div class="row tagParent">
                                    <div class="col-sm-1 tagReal">{{$arr["tag"]["mainTag"]->real}}</div>
                                    <div class="col-sm-10 tagDescription">{{$arr["tag"]["mainTag"]->description}}</div>
                                    <div class="col-sm-1 tagPage pl-3 text-right">{{$funds[$loop->index-1]["lengthTotal"]+1}}</div>
                                </div>
                            </div>
                        @else
                            <div class="card p-2" style="width: 100%">
                                <div class="row tagParent">
                                    <div class="col-sm-1 tagReal">{{$arr["tag"]["mainTag"]->real}}</div>
                                    <div class="col-sm-10 tagDescription">{{$arr["tag"]["mainTag"]->description}}</div>
                                    <div class="col-sm-1 pl-3 text-right">1</div>
                                </div>
                            </div>
                        @endif
                    @else
                            @if($loop->index != 0)
                                <div class="card p-2" style="width: 100%">
                                    <div class="row tagParent">
                                        <div class="col-sm-1 tagReal">{{$arr["tag"]["mainTag"]->real}}</div>
                                        <div class="col-sm-10 tagDescription">{{$arr["tag"]["mainTag"]->description}}</div>
                                        <div class="col-sm-1 pl-3 text-right">{{$funds[$loop->index-1]["lengthTotal"]+1}}</div>
                                    </div>
                                </div>
                            @endif
                    @endif
                @endif
            @endforeach
        </div>
        @foreach($funds as $arr)

            @if(!$arr["funds"]->isEmpty() || !$arr["tag"]["mainTag"]->children->isEmpty())
                @if($arr["tag"]["mainTag"]["is_parent"] && $arr["tag"]["mainTag"]->parent_id == 0)
                    <div class="row flex-column pageBreak">
                        <div class="card justify-content-middle middleThing" style="background: #276bb0; color: whitesmoke">
                            <div class="card-block">
                                <div class="card-title align-middle text-center">
                                        {{$arr["tag"]["mainTag"]->description}}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="container pageBreak">
                        <div class="row flex-column">
                            <div class="card justify-content-middle bg-success middleThing" style="color: whitesmoke">
                                <div class="card-block">
                                    <div class="card-title align-middle text-center">
                                        {{$arr["tag"]["mainTag"]->description}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @foreach($arr["funds"] as $tag=>$fund)
                    <style>
                        .btn{
                            border-radius: 25px;
                        }

                        .pageBreak{
                            page-break-after: always;
                            page-break-before: always;
                        }
                    </style>


                    <div class="printed">
                        @if(isset($loop->index))
                            <div class="PageNum">
                                @if($loop->parent->index != 0)
                                    {{$funds[$loop->parent->index-1]["lengthTotal"] + $loop->index+1}}
                                @else
                                    {{$loop->index+1}}
                                @endif
                            </div>
                        @endif
                        <div class="p-2">
                            @foreach($arr["tag"]["parents"] as $indexTag)
                                <div class="btn btn-success mr-1">
                                    {{$indexTag->real}} - {{$indexTag->description}}
                                </div>
                            @endforeach
                                <hr>
                        </div>
                        <div>
                            <div>
                                <div class="px-4">
                                    <h1 class="justify-content-between">
                                        {{stripslashes($fund->name)}}
                                    </h1>
                                    <div class="row ml-1">
                                        @foreach($fund->tags as $categoryArray)
                                            <span class="badge badge-default badge-pill mr-1">
                                                @foreach($categoryArray as $category)
                                                    {{$category->description}}
                                                    @if(!($loop->last))
                                                        >
                                                    @endif
                                                @endforeach
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="row ml-1 mt-2">
                                        <h3 class="pull-left">
                                            <span class="badge badge-success badge-pill   ml-1">{{$fund->organization->name}}</span>
                                            <span class="badge badge-primary badge-pill  ">{{$fund->organization->country->name}}</span>
                                            <span class="m-2">
                                                @foreach($fund->fields as $field)
                                                    <h4 style="display: inline"><span class="badge badge-primary badge-pill mb-2">{{$field->title}}</span></h4>
                                                @endforeach
                                            </span>
                                        </h3>
                                    </div>
                                </div>
                                <hr>




                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="card-text text-justify">
                                                {{stripslashes($fund->description)}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card bg-primary mt-2">
                                        <div class="card-block">
                                            <div class="card-text text-center text-justify">
                                                <strong style="color: whitesmoke; font-size: 20px">Rating: {{$fund->rating}}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-2">
                                        <div class="card-block">
                                            <div dir="rtl" lang="fa" class="card-text farsiDesc">
                                                <p>{{stripslashes($fund->farsi)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="duration" class="card mt-2">
                                        <div class="row">
                                            <div class="card-block col-sm-11">
                                                <div class="card-text text-justify pl-3">
                                                    {{stripslashes($fund->duration)}}
                                                </div>
                                            </div>
                                            <div class="col-sm-1 mt-2">
                                                <img id="clock" src="{{asset('img/clock.png')}}" width="50px" alt="">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="financial" class="card mt-2">
                                        <div class="row">
                                            <div class="card-block col-sm-11">
                                                <div class="card-text text-justify pl-3">
                                                    <strong>Financial Support: </strong>{{stripslashes($fund->financial)}}
                                                </div>
                                            </div>
                                            <div class="col-sm-1 mt-2">
                                                <img id="money" src="{{asset('img/money.png')}}" width="50px" alt="">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="requirements" class="card mt-2">
                                        <div class="row">
                                            <div class="card-block col-sm-11">
                                                <div class="card-text text-justify pl-3">
                                                    <strong>Requirements: </strong>{{stripslashes($fund->requirements)}}
                                                </div>
                                            </div>
                                            <div class="col-sm-1 mt-2">
                                                <img id="cv" src="{{asset('img/cv.png')}}" width="50px" alt="">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="deadline" class="card mt-2">
                                        <div class="row">
                                            <div class="card-block col-sm-11">
                                                <div class="card-text text-justify pl-3">
                                                    <strong>Deadline: </strong>{{stripslashes($fund->deadline)}}
                                                </div>
                                            </div>
                                            <div class="col-sm-1 mt-2">
                                                <img id="clockfire" src="{{asset('img/deadline2.png')}}" width="50px" alt="">
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div id="comments" class="card mt-2">--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="card-block col-sm-11">--}}
                                                {{--<div class="card-text text-justify pl-3">--}}
                                                    {{--<strong></strong>{{stripslashes($fund->comments)}}--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-sm-1 mt-2">--}}
                                                {{--<img id="commentIcon" src="{{asset('img/comment.png')}}" width="50px" alt="">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        @endforeach
    </div>
    <script src="{{asset('js/reportScript.js')}}"></script>
@endsection