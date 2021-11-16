<?php

use App\Utils;
use App\InsuranceCategory;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update : {{$category['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categories</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category.show', $category['id']) }}">{{$category['name']}}</a></li>
                    <li class="breadcrumb-item active">Update Insurance Category</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col">
                    <div class="card card-default">
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('category.update', $category['id']) }}">
                                {{method_field('PUT')}}
                                {{ csrf_field() }}

                                <?php
                                $fields = [
                                    [
                                        ['name' => 'name', 'type' => 'text', 'label' => InsuranceCategory::attributes('name'), 'value' => $category['name']],
                                    ],
                                    [
                                        ['name' => 'status', 'type' => 'select', 'label' => InsuranceCategory::attributes('status'), 'value' => $category['status'], 'options' => Utils::getStatus(), 'prompt' => 'Select Status'],
                                    ]
                                ];
                                ?>

                                @include('layouts.form', ['form' => $fields])

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection