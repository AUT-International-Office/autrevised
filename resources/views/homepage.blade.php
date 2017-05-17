


@extends('layouts.app')

@section('title')
AUT Fund Search
@endsection

@section('content')
    <script>
        $(document).ready(function () {
            $(".List").select2();
            $("#resetFilters").click(function (event) {
                event.preventDefault();
                $(".List").val(null).trigger("change");
            })
        });

    </script>

    <style>
        input{
            font-family: "Shabnam", Raleway, SansSerif;
        }
    </style>

<div class="container my-whole-page">
    <div class="row pl-3">
        <div class="card p-3 col-lg-3 col-sm-3">
            <h2 class="title">Filters</h2>
            <ul class="nav nav-pills flex-column">
                <div class="btn btn-success" id="resetFilters">Reset all</div>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#categoryPan" id="Category">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Category</span>
                    </a>
                </li>
                <div class="collapse" id="categoryPan">
                    <select class="form-control List js-states" title="Choose your option..." style="width: 100%" id="CategoryFilter" multiple="multiple">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">
                                {{$category->real}} - {{$category->description}}
                            </option>
                        @endforeach
                    </select>
                </div>


                <li class="nav-item">
                    <a data-toggle="collapse" href="#orgPan"  id="Organization">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Funding Organization</span>
                    </a>
                </li>
                <div class="collapse" id="orgPan">
                    <select class="List js-states form-control" style="width: 100%" id="OrgFilter" multiple="multiple">
                        @foreach($organizations as $org)
                            <option value="{{$org->id}}">
                                {{$org->name}} - {{$org->country->name}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#countryPan" id="Country">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Country</span>
                    </a>
                </li>
                <div class="collapse" id="countryPan">
                    <select class="List js-states form-control" style="width: 100%" id="CountryFilter" multiple="multiple">
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">
                                {{$country->name}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#researchPan"  id="Research">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Research Area</span>
                    </a>
                </li>
                <div class="collapse" id="researchPan">
                    <select class="List js-states form-control" style="width: 100%" id="ResearchFilter" multiple="multiple">
                        @foreach($fields as $field)
                            <option value="{{$field->id}}">
                                {{$field->title}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#ratingPan"  id="Rating">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Rating</span>
                    </a>
                </li>
                <div class="collapse" id="ratingPan">
                    <select class="List js-states form-control" style="width: 100%" id="RatingFilter" multiple="multiple">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                    </select>
                </div>

                @if(!\Illuminate\Support\Facades\Auth::guest())
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#visiblePan" id="Visible">
                            <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                            <span class="list-span">Visible</span>
                        </a>
                    </li>
                    <div class="collapse" id="visiblePan">
                        <select class="form-control List js-states" title="Choose your option..." style="width: 100%" id="VisibleFilter">
                                <option value=1>
                                    True
                                </option>
                                <option value=0>
                                    False
                                </option>
                        </select>
                    </div>
                @endif


            </ul>
        </div>
        <div class="card p-3 ml-sm-3 col-sm-8 col-lg-8">

            <input class="form-control form-control-lg" placeholder="Search..." type="search" id="searchbox">
            <div class="p-3 p-sm-3 mt-0" style="margin: 15px 0 15px 0;">
                <h2 class="title">Search Results</h2>
                <hr>
                {{--<nav class="card bg-success">--}}



                    <div id="myTabContent" class="tab-content mb-3">


                        <ul class="list-group tab-pane active" id="list" style="margin-top: 10px">
                            @foreach($funds as $fund)
                                <li id="{{$fund->id}}" class="list-group-item my-list fundItem">
                                    <a style="text-decoration: none; color: inherit" data-toggle="collapse" href="#description-{{$fund->id}}" >
                                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                                        <span class="list-span">
                                            {{$fund->name}}
                                        </span>
                                    </a>
                                    <div class="collapse pull-right description" id="description-{{$fund->id}}">
                                            {{$fund->farsi}}
                                        <span id="editViewLinks" class="pull-left m-3">
                                          @if(!\Illuminate\Support\Facades\Auth::guest())
                                                <a href="fund/{{$fund->id}}" target="_blank" class="btn btn-sm btn-success ml-1 editLink">Edit</a>
                                            @endif
                                            <a href="show/fund/{{$fund->id}}" target="_blank" class="btn btn-sm btn-primary pull-left viewLink">View</a>
                                        </span>

                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                    <nav aria-label="Page navigation" >
                        <ul class="pagination justify-content-center">
                            <li class="page-item"><a class="page-link">&laquo;</a></li>
                            @foreach($count as $num)
                                <li class="page-item"><a class="page-link">{{$num}}</a></li>
                            @endforeach
                            <li class="page-item"><a class="page-link">&raquo;</a></li>
                        </ul>
                    </nav>
                {{--</div>--}}
            </div>
        </div>
    </div>

</div>

<script src="{{asset('js/my-js1.js')}}"></script>


@endsection