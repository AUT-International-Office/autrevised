@extends('layouts.app')

@section('title')
Edit Fund - {{stripslashes($selectedfund->name)}}
@endsection

@section('content')

    <script type="text/javascript">

        $(document).ready(function() {
            $(".List").select2();
            $('#formCategory').select2({
                placeholder: "Choose one or more categories"
            });
            $('#formRelated').select2({
                placeholder: "Choose one or more related funds"
            });
            $('#formOrg').select2({
                placeholder: "Choose a funding organization",
                allowClear: true
            });

            $('#newCatParent').select2({
                placeholder: "Choose a Category",
                allowClear: true
            });
        });

    </script>
    <script src="{{asset('js/editPageAjax.js')}}"></script>
    <script src="{{asset('js/addAjax.js')}}"></script>
    <script src="{{asset('js/editAjax.js')}}"></script>
    <script src="{{asset('js/deleteAjax.js')}}"></script>

<div class="container my-whole-page">
    <div class="row pl-3">
        <div class="card p-3 mt-3 col-lg-3 col-sm-3">
            <h2 class="title">Add</h2>
            <ul class="nav nav-pills flex-column mb-sm-4">

                <li class="nav-item">
                    <a data-toggle="collapse" href="#categoryPan" id="filterCategory">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Category</span>
                    </a>
                </li>
                <div class="collapse" id="categoryPan">
                    <div class="form-group">
                        <label class="control-label" for="newCatName">Name:</label>
                        <input type="text" class="form-control" id="newCatName" placeholder="For example Sabbatical, student">
                        <label class="control-label" for="newCatParent">Parent:</label>
                        <select class="form-control List js-states" title="Choose your option..." style="width: 100%" id="newCatParent">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">
                                    {{$category->real}} - {{$category->description}}
                                </option>
                            @endforeach
                        </select>
                        <div class="text-center">
                            <button class="btn btn-success my-btn" style="margin: 15px 0 5px 0;" type="submit" id="catAddButton">Add</button>
                        </div>
                    </div>



                </div>


                <li class="nav-item">
                    <a data-toggle="collapse" href="#orgPan"  id="filterOrganization">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Funding Organization</span>
                    </a>
                </li>
                <div class="collapse" id="orgPan">
                    <div class="form-group">
                        <label class="control-label" for="newOrgName">Name:</label>
                        <input type="text" class="form-control" id="newOrgName" placeholder="For example DAAD, MPG">
                        <label class="control-label" for="newOrgCountry">Country:</label>
                        <select class="List js-states form-control" style="width: 100%" id="newOrgCountry">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">
                                    {{$country->name}}
                                </option>
                            @endforeach
                        </select>

                        <div class="text-center">
                            <button id="addOrgButton" class="btn btn-success my-btn" style="margin: 15px 0 5px 0;" type="submit">Add</button>
                        </div>
                    </div>






                </div>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#countryPan" id="filterCountry">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Country</span>
                    </a>
                </li>
                <div class="collapse" id="countryPan">
                    <div class="form-group">
                        <label class="control-label" for="newCountryName">Name:</label>
                        <input type="text" class="form-control" id="newCountryName" placeholder="For example Germany, France">
                        <div class="text-center">
                            <button id="addCountryButton" class="btn btn-success my-btn" style="margin: 15px 0 5px 0;" type="submit">Add</button>
                        </div>
                    </div>
                </div>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#researchPan"  id="filterResearch">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Research Area</span>
                    </a>
                </li>
                <div class="collapse" id="researchPan">
                    <div class="form-group">
                        <label class="control-label" for="newResearchName">Name:</label>
                        <input type="text" class="form-control" id="newResearchName" placeholder="For example Germany, France">
                        <div class="text-center">
                            <button id="addResearchButton" class="btn btn-success my-btn" style="margin: 15px 0 5px 0;" type="submit">Add</button>
                        </div>
                    </div>
                </div>


            </ul>

            <h2 class="title">Edit</h2>
            <ul class="nav nav-pills flex-column mb-sm-4">

                <li class="nav-item">
                    <a data-toggle="collapse" href="#categoryEdit" id="filterEditCategory">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Category</span>
                    </a>
                </li>
                <div class="collapse" id="categoryEdit">
                    <div class="form-group">
                        <label class="control-label" for="catIdEdit">Category:</label>
                        <select class="form-control List js-states" title="Choose your option..." style="width: 100%" id="catIdEdit">
                        @foreach($categories as $category)
                                <option value="{{$category->id}}">
                                    {{$category->real}} - {{$category->description}}
                                </option>
                            @endforeach
                        </select>

                        <label class="control-label" for="catNewParent">New Parent:</label>
                        <select class="form-control List js-states" title="Choose your option..." style="width: 100%" id="catNewParent">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">
                                    {{$category->real}} - {{$category->description}}
                                </option>
                            @endforeach
                        </select>

                        <label class="control-label" for="catNewName">New Name:</label>
                        <input type="text" class="form-control" id="catNewName" placeholder="For example Sabbatical, student">

                        <div class="text-center">
                            <button id="catEditButton" class="btn btn-info my-btn" style="margin: 15px 0 5px 0;" type="submit">Submit</button>
                        </div>
                    </div>



                </div>


                <li class="nav-item">
                    <a data-toggle="collapse" href="#orgEdit"  id="filterEditOrganization">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Funding Organization</span>
                    </a>
                </li>
                <div class="collapse" id="orgEdit">
                    <div class="form-group">
                        <label class="control-label" for="orgIdEdit"><strong>Organization:</strong></label>
                        <select class="List js-states form-control" style="width: 100%" id="orgIdEdit">
                            @foreach($organizations as $org)
                                <option value="{{$org->id}}">
                                    {{$org->name}} - {{$org->country->name}}
                                </option>
                            @endforeach
                        </select>

                        <label class="control-label" for="orgNewCountry"><strong>New Country:</strong></label>
                        <select class="List js-states form-control" style="width: 100%" id="orgNewCountry">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">
                                    {{$country->name}}
                                </option>
                            @endforeach
                        </select>
                        <label class="control-label" for="orgNewName"><strong>New Name:</strong></label>
                        <input type="text" class="form-control" id="orgNewName" placeholder="For example DAAD, MPG">

                        <div class="text-center">
                            <button id="orgEditButton" class="btn btn-info my-btn" style="margin: 15px 0 5px 0;" type="submit">Submit</button>
                        </div>
                    </div>






                </div>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#countryEdit" id="filterEditCountry">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Country</span>
                    </a>
                </li>
                <div class="collapse" id="countryEdit">
                    <div class="form-group">
                        <label class="control-label" for="countryIdEdit"><strong>Country:</strong></label>
                        <select class="List js-states form-control" style="width: 100%" id="countryIdEdit">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">
                                    {{$country->name}}
                                </option>
                            @endforeach
                        </select>

                        <label class="control-label" for="countryNewName"><strong>New Name:</strong></label>
                        <input type="text" class="form-control" id="countryNewName" placeholder="For example Germany, France">
                        <div class="text-center">
                            <button id="editCountryButton" class="btn btn-info my-btn" style="margin: 15px 0 5px 0;" type="submit">Submit</button>
                        </div>
                    </div>
                </div>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#researchEdit"  id="filterEditResearch">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Research Area</span>
                    </a>
                </li>
                <div class="collapse" id="researchEdit">
                    <div class="form-group">
                        <label class="control-label" for="fieldIdEdit"><strong>Research Area:</strong></label>
                        <select class="List js-states form-control" style="width: 100%" id="fieldIdEdit">
                            @foreach($fields as $field)
                                <option value="{{$field->id}}">
                                    {{$field->title}}
                                </option>
                            @endforeach
                        </select>

                        <label class="control-label" for="fieldNewName"><strong>New Name:</strong></label>
                        <input type="text" class="form-control" id="fieldNewName" placeholder="For example Mining, Computer">
                        <div class="text-center">
                            <button id="editFieldButton" class="btn btn-success my-btn" style="margin: 15px 0 5px 0;" type="submit">Add</button>
                        </div>
                    </div>
                </div>


            </ul>

            <h2 class="title">Delete</h2>
            <ul class="nav nav-pills flex-column mb-sm-4">

                <li class="nav-item">
                    <a data-toggle="collapse" href="#categoryDelete" id="filterDeleteCategory">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Category</span>
                    </a>
                </li>
                <div class="collapse" id="categoryDelete">
                    <div class="form-group">
                        <label class="control-label" for="catIdDelete">Category:</label>
                        <select class="form-control List js-states" title="Choose your option..." style="width: 100%" id="catIdDelete">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">
                                    {{$category->real}} - {{$category->description}}
                                </option>
                            @endforeach
                        </select>


                        <div class="text-center">
                            <button id="catDeleteButton" class="btn btn-danger my-btn" style="margin: 15px 0 5px 0;" type="submit">Delete</button>
                        </div>
                    </div>



                </div>


                <li class="nav-item">
                    <a data-toggle="collapse" href="#orgDelete"  id="filterDeleteOrganization">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Funding Organization</span>
                    </a>
                </li>
                <div class="collapse" id="orgDelete">
                    <div class="form-group">
                        <label class="control-label" for="orgIdDelete"><strong>Organization:</strong></label>
                        <select class="List js-states form-control" style="width: 100%" id="orgIdDelete">
                            @foreach($organizations as $org)
                                <option value="{{$org->id}}">
                                    {{$org->name}} - {{$org->country->name}}
                                </option>
                            @endforeach
                        </select>

                        <div class="text-center">
                            <button id="orgDeleteButton" class="btn btn-danger my-btn" style="margin: 15px 0 5px 0;" type="submit">Delete</button>
                        </div>
                    </div>






                </div>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#countryDelete" id="filterDeleteCountry">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Country</span>
                    </a>
                </li>
                <div class="collapse" id="countryDelete">
                    <div class="form-group">
                        <label class="control-label" for="countryIdDelete"><strong>Country:</strong></label>
                        <select class="List js-states form-control" style="width: 100%" id="countryIdDelete">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">
                                    {{$country->name}}
                                </option>
                            @endforeach
                        </select>

                        <div class="text-center">
                            <button id="deleteCountryButton" class="btn btn-danger my-btn" style="margin: 15px 0 5px 0;" type="submit">Delete</button>
                        </div>
                    </div>
                </div>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#researchDelete"  id="filterDeleteResearch">
                        <i class="fa fa-caret-right" style="font-size: 25px" aria-hidden="true"></i>
                        <span class="list-span">Research Area</span>
                    </a>
                </li>
                <div class="collapse" id="researchDelete">
                    <div class="form-group">
                        <label class="control-label" for="fieldIdDelete"><strong>Research Area:</strong></label>
                        <select class="List js-states form-control" style="width: 100%" id="fieldIdDelete">
                            @foreach($fields as $field)
                                <option value="{{$field->id}}">
                                    {{$field->title}}
                                </option>
                            @endforeach
                        </select>

                         <div class="text-center">
                            <button id="deleteFieldButton" class="btn btn-danger my-btn" style="margin: 15px 0 5px 0;" type="submit">Delete</button>
                        </div>
                    </div>
                </div>


            </ul>

        </div>

        <div class=" col-sm-9 col-lg-9">
            <div  class="card p-3" style="margin: 15px 0 15px 0;">
                <h2 class="title">Edit Fund</h2>
                <hr>
                <div id="mainPanel" class="card p-3">
                    <div class="form-group">
                        <label class="control-label" for="name"><strong>Fund name:</strong></label>
                        <input class="form-control field" placeholder="For example Postdoctoral Researchers’ Networking Tour …" type="text" id="name" value="{{stripslashes($selectedfund->name)}}">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="category"><strong>Category:</strong></label>
                        <select class="form-control List js-states field" title="Choose your option..." style="width: 100%" id="category" multiple="multiple">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                @foreach($fundCategories as $fcat)
                                    @if($fcat->id == $category->id)
                                        selected="selected"
                                    @endif
                                @endforeach
                                @if($category->is_parent)
                                        disabled="disabled"
                                @endif
                                >
                                    {{$category->real}} - {{$category->description}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="related"><strong>Related Funds:</strong></label>
                        <select class="form-control List js-states field" style="width: 100%" id="related" multiple="multiple">
                            @foreach($funds as $fund)
                                <option value="{{$fund->id}}">
                                    {{$fund->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="organization"><strong>Fund Organization:</strong></label>
                        <select class="form-control List js-states field" style="width: 100%" id="organization">
                            @foreach($organizations as $org)
                                <option value="{{$org->id}}"
                                        @if($fundOrganizations->id == $org->id)
                                        selected="selected"
                                        @endif

                                >
                                    {{$org->name}} - {{$org->country->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="field"><strong>Research Area:</strong></label>
                        <select class="form-control List js-states field" style="width: 100%" id="field" multiple="multiple">
                            @foreach($fields as $field)
                                <option value="{{$field->id}}"
                                        @foreach($fundFields as $ffield)
                                        @if($ffield->id == $field->id)
                                        selected="selected"
                                        @endif
                                        @endforeach

                                >
                                    {{$field->title}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="rating"><strong>Rating:</strong></label>
                        <input class="form-control field" type="number" id="rating" value="{{$selectedfund->rating}}">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="description"><strong>Description:</strong></label>
                        <textarea class="form-control align-middle field" name="formDescription" id="description" cols="30" rows="10" placeholder="Describe everything about this fund">{{stripslashes($selectedfund->description)}}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="duration"><strong>Duration:</strong></label>
                        <textarea class="form-control align-middle field" name="formDuration" id="duration" rows="2" placeholder="Describe everything about duration">{{stripslashes($selectedfund->duration)}}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="financial"><strong>Financial Support:</strong></label>
                        <textarea class="form-control align-middle field" name="formFinancial" id="financial" rows="2" placeholder="Describe everything about financial support">{{stripslashes($selectedfund->financial)}}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="requirements"><strong>Requirements:</strong></label>
                        <textarea class="form-control align-middle field" name="formRequirements" id="requirements" rows="5" placeholder="Describe everything about requirements">{{stripslashes($selectedfund->requirements)}}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="deadline"><strong>Deadline:</strong></label>
                        <textarea class="form-control align-middle field" name="formDeadline" id="deadline" rows="2" placeholder="Describe everything about deadline">{{stripslashes($selectedfund->deadline)}}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="link1"><strong>Link 1:</strong></label>
                        <textarea class="form-control align-middle field" name="formLink1" id="link1" rows="2" placeholder="Put a link for fund here">{{$selectedfund->link1}}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="link2"><strong>Link 1:</strong></label>
                        <textarea class="form-control align-middle field" name="formLink2" id="link2" rows="2" placeholder="Put a link for fund here">{{$selectedfund->link2}}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="memo"><strong>Memo:</strong></label>
                        <textarea class="form-control align-middle field" name="formMemo" id="memo" rows="4" placeholder="Write a memo for this fund">{{stripslashes($selectedfund->memo)}}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="farsi"><strong>Persian Description:</strong></label>
                        <textarea class="form-control align-middle field" name="formFarsi" id="farsi" rows="4" placeholder="چند خطی به فارسی درباره‌ی این فاند بنویسید">{{stripslashes($selectedfund->farsi)}}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="comments"><strong>Comments:</strong></label>
                        <textarea class="form-control align-middle field" name="formComments" id="comments" rows="4" placeholder="Write any comments about this fund here">{{stripslashes($selectedfund->comments)}}</textarea>
                    </div>

                    <div class="form-group text-center">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input align-middle field" name="formVisible" id="visible" type="checkbox"
                                   @if($selectedfund->visible)
                                   checked="checked"
                                    @endif
                            >
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description"><strong>Visible</strong></span>
                        </label>
                    </div>

                    <div class="text-center">
                        <button id="deleteButton" class="btn btn-danger my-btn" style="margin: 15px 0 5px 0;" type="submit">Delete</button>
                        <a class="btn btn-primary my-btn" style="margin: 15px 0 5px 0;" href="{{'../show/fund/'.$selectedfund->id}}">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/my-js1.js')}}"></script>


@endsection
