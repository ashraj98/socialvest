@extends('layouts.app')

@section('content')
<div class="container-fluid" id="capitalOne">
    <div class="row">
        <div class="col-sm-12">
        @include('flash::message')
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(empty(Auth::user()->capitalOneID))
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">Create New Capital One ID</button>
                        {{--<button class="btn btn-info btn-block" href="">Connect Existing Capital One ID</button>--}}
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Enter Your Location</h4>
                                    </div>
                                    {{ Form::open(['route' => 'user.newCO', 'method' => 'POST']) }}
                                    <div class="modal-body">
                                        {{ Form::label("street_number", "Street Number", ["class" => "control-label"]) }}
                                        {{ Form::text("street_number", null, ["class" => "form-control"]) }}
                                        {{ Form::label("street_name", "Street Name", ["class" => "control-label"]) }}
                                        {{ Form::text("street_name", null, ["class" => "form-control"]) }}
                                        {{ Form::label("city", "City", ["class" => "control-label"]) }}
                                        {{ Form::text("city", null, ["class" => "form-control"]) }}
                                        {{ Form::label("state", "State", ["class" => "control-label"]) }}
                                        {{ Form::text("state", null, ["class" => "form-control"]) }}
                                        {{ Form::label("zip", "Zip Code", ["class" => "control-label"]) }}
                                        {{ Form::text("zip", null, ["class" => "form-control"]) }}
                                    </div>
                                    <div class="modal-footer">
                                        {{ Form::submit("Create User", ['class' => 'btn btn-primary']) }}
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                    {{ Form::close() }}
                                </div>

                            </div>
                        </div>
                    @else
                        <accounts caponeid="{{ Auth::user()->capitalOneID ?? '' }}"></accounts>
                    @endunless
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">Invest</div>
                <div class="panel-body">
                    <buy-stock coid="{{ Auth::user()->capitalOneID ?? '' }}"></buy-stock>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-danger">
                <!-- Default panel contents -->
                <div class="panel-heading">Withdrawals</div>

                <!-- Table -->
                <withdrawals cap_one_id="{{ Auth::user()->capitalOneID ?? '' }}"></withdrawals>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-success">
                <!-- Default panel contents -->
                <div class="panel-heading">Deposits</div>

                <!-- Table -->
                <deposits cap_id="{{ Auth::user()->capitalOneID ?? '' }}"></deposits>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-warning">
                <!-- Default panel contents -->
                <div class="panel-heading">Positions</div>

                <div class="panel-body">
                    <positions user_id="{{ Auth::id() }}"></positions>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
