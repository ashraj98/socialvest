@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="capitalOne">
        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Map</div>

                    <div class="panel-body">
                        <g-map></g-map>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Latest Transactions</div>

                    <div class="panel-body">
                        <latest-transactions></latest-transactions>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
