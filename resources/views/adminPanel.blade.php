@extends('layouts.app')

@section('title')
Admin Panel
@endsection

@section('content')
    <script>
        $(document).ready(function () {
            $("#sub").click(function (event) {
                event.preventDefault();
                var name = $("#name").val();
                var email = $("#email").val();
                var password = $("#password").val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: `/adminPanel`,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        _token: CSRF_TOKEN, name: name, email:email, password:password
                    }
                })
                    .done(function (data) {
                        $.notify({
                            title: '<strong>User Created</strong>',
                            message: 'Fund successfully created. '+data
                        },{
                            type: 'success'
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function () {
                        console.log("error");
                        $.notify({
                            title: '<strong>User creation failed</strong>',
                            message: 'There was an error while creating fund, try again.'
                        },{
                            type: 'danger'
                        });
                    })
            });

            $(".setAdmin").click(function (event) {
                event.preventDefault();
                var set = 1;
                var id = $(this).parent().attr('id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: `/users/${id}`,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        _token: CSRF_TOKEN, set: set
                    }
                })
                    .done(function (data) {
                        $.notify({
                            title: '<strong>Admin Set</strong>',
                            message: 'Admin successfully Set. '
                        },{
                            type: 'success'
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function () {
                        console.log("error");
                        $.notify({
                            title: '<strong>Set Admin failed</strong>',
                            message: 'There was an error while setting admin, try again.'
                        },{
                            type: 'danger'
                        });
                    })
            });

            $(".unsetAdmin").click(function (event) {
                event.preventDefault();
                var set = 0;
                var id = $(this).parent().attr('id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: `/users/${id}`,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        _token: CSRF_TOKEN, set: set
                    }
                })
                    .done(function (data) {
                        $.notify({
                            title: '<strong>Admin Unset</strong>',
                            message: 'Admin successfully Unset. '
                        },{
                            type: 'success'
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function () {
                        console.log("error");
                        $.notify({
                            title: '<strong>Unset Admin failed</strong>',
                            message: 'There was an error while unsetting admin, try again.'
                        },{
                            type: 'danger'
                        });
                    })
            });

            $(".deleteUser").click(function (event) {
                event.preventDefault();
                var id = $(this).parent().attr('id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: `/users/${id}`,
                    type: 'post',
                    dataType: 'html',
                    data: {
                        _token: CSRF_TOKEN, _method: 'DELETE'
                    }
                })
                    .done(function (data) {
                        $.notify({
                            title: '<strong>Delete User Successful</strong>',
                            message: 'User successfully deleted. '
                        },{
                            type: 'success'
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function () {
                        console.log("error");
                        $.notify({
                            title: '<strong>User Delete failed</strong>',
                            message: 'There was an error while deleting user, try again.'
                        },{
                            type: 'danger'
                        });
                    })
            });
        });
    </script>



    <div class="container pt-2 pb-2">
        <div class="row">

            <div class="col-sm-4">
                <div class="row">
                    <div class="card col-sm-12 p-0">
                        <h3 class="jumbotron bg-primary" style="color: white">Hello, {{auth()->user()->name}}. Welcome</h3>
                    </div>
                    <div class="col-sm-6 p-0 pr-2">
                        <div class="card mt-3 text-center">
                            <a href="{{ url('/import') }}" style="text-decoration: none; color: black">
                                <img class="card-img-top mt-3" src="{{asset('img/import.png')}}" height="100px" alt="Card image cap">
                                <div class="card-block">
                                    <div class="card-text text-center">
                                        <h3>Import</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6 p-0 pl-2">
                        <div class="card mt-3 text-center">
                            <a href="{{ url('/homepage') }}" style="text-decoration: none; color: black">
                                <img class="card-img-top mt-3" src="{{asset('img/search.png')}}" height="100px" alt="Card image cap">
                                <div class="card-block">
                                    <div class="card-text text-center">
                                        <h3>Search</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-6 p-0 pr-2">
                        <div class="card mt-3 text-center">
                            <a href="{{ url('/addFund') }}" style="text-decoration: none; color: black">
                                <img class="card-img-top mt-3" src="{{asset('img/plus.png')}}" height="100px" alt="Card image cap">
                                <div class="card-block">
                                    <div class="card-text text-center">
                                        <h3>New</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{--<div class="col-sm-6 p-0 pl-2">--}}
                        {{--<div class="card mt-3 text-center">--}}
                            {{--<a href="{{ url('/report') }}" style="text-decoration: none; color: black ">--}}
                                {{--<img class="card-img-top mt-3" src="{{asset('img/report3.png')}}" height="100px" alt="Card image cap">--}}
                                {{--<div class="card-block">--}}
                                    {{--<div class="card-text text-center">--}}
                                        {{--<h3>Report</h3>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                </div>

            </div>
            <div class="col-sm-8">
                <div class="list-group">
                    <h2 class="list-group-item active">Users</h2>
                    @foreach($users as $user)
                        <div class="list-group-item justify-content-between">
                            {{$user->name}}

                            <span class="right" id="{{$user->id}}">
                                @if($user->is_admin)
                                    <span class="badge badge-primary badge-pill align-middle">Admin</span>
                                    @if($user->id != Auth::user()->id)
                                        <span  class="btn btn-danger btn-sm unsetAdmin">Remove Admin</span>
                                    @endif
                                @else
                                    <span class="btn btn-success btn-sm setAdmin">Make Admin</span>
                                @endif
                                @if($user->id != Auth::user()->id)
                                    <span class="btn btn-danger btn-sm deleteUser">Delete</span>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="card mt-3 list-group">
                    <h3 class="list-group-item active">Register New Users</h3>
                    <div class="card-block pb-3">
                        <form class="form-group">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" id="name">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" id="password">
                            </div>

                            <button class="btn btn-primary mt-2 flex-items-middle" id="sub">
                                Register
                            </button>

                        </form>
                    </div>
                </div>

                <div class="card mt-3 list-group">
                    <h3 class="list-group-item active">Country reports</h3>
                    @foreach($countries as $country)
                        <div class="card-block pb-3">
                            <a href="{{ url('/report/'.$country->name) }}" target="_blank" class="btn btn-success col-sm-12">
                                {{$country->name}}
                            </a>
                        </div>
                    @endforeach
            </div>
        </div>

    </div>

@endsection