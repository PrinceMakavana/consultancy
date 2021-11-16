<?php

use App\MutualFundType;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Type : {{$type['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('type.index') }}">Types</a></li>
                    <li class="breadcrumb-item active">Type : {{$type['name']}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            {{Utils::successAndFailMessage()}}
                            <a href="{{route('type.edit', $type['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            {!! Utils::deleteBtn(route('type.destroy', $type['id'])) !!}

                            <div class="row">
                                <table class="col-lg-6 table mt-2">
                                    <tr>
                                        <th>{{ MutualFundType::attributes('main_type') }}</th>
                                        <td>{{ Utils::setMainTypes($type['main_type']) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFundType::attributes('name') }}</th>
                                        <td>{{ $type['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFundType::attributes('created_at') }}</th>
                                        <td>{{ $type['created_at'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MutualFundType::attributes('status') }}</th>
                                        <td>{{ Utils::setStatus($type['status']) }}</td>
                                    </tr>
                                </table>
                                <table class="col-lg-6 table mt-2">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

