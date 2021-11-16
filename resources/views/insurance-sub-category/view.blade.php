<?php

use App\InsuranceCategory;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Insurance Category : {{$category['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active">Insurance Category : {{$category['name']}}</li>
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
                            <a href="{{route('category.edit', $category['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            {!! Utils::deleteBtn(route('category.destroy', $category['id'])) !!}

                            <div class="row">
                                <table class="col-lg-6 table mt-2">
                                    <tr>
                                        <th>{{ InsuranceCategory::attributes('name') }}</th>
                                        <td>{{ $category['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ InsuranceCategory::attributes('created_at') }}</th>
                                        <td>{{ $category['created_at'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ InsuranceCategory::attributes('updated_at') }}</th>
                                        <td>{{ $category['updated_at'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ InsuranceCategory::attributes('status') }}</th>
                                        <td>{{ Utils::setStatus($category['status']) }}</td>
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

