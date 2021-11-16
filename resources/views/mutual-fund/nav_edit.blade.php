<?php

use App\Utils;
use App\MutualFund;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1 class="m-0 text-dark">Update NAV</h1>
            </div><!-- /.col -->
            <div class="col-sm-8">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('funds.index') }}">Mutual Funds</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('funds.show', $funds['id']) }}">{{$funds['name']}}</a></li>
                    <li class="breadcrumb-item active">Update NAV</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('funds.nav_update', $funds['id']) }}">
                    {{method_field('PUT')}}
                    {{ csrf_field() }}

                    <?php
                    $fields = [

                        [
                            [
                                'name' => 'nav',
                                'type' => 'number',
                                'label' => MutualFund::attributes('nav'),
                                'value' => $funds['nav']
                            ],
                        ],
                    ];
                    ?>

                    @include('layouts.form', ['form' => $fields])

                    <div class="form-group">
                        <div class="d-flax pl-2">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                            <a class="btn btn-secondary" href="{{ route('funds.show', $funds['id']) }}">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection