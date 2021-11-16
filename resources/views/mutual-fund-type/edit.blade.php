<?php

use App\Utils;
use App\MutualFundType;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update Mutual Fund Type : {{$type['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('type.index') }}">Mutual Fund Types</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('type.show', $type['id']) }}">Mutual Fund Types : {{$type['name']}}</a></li>
                    <li class="breadcrumb-item active">Update Mutual Fund Type</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('type.update', $type['id']) }}">
                    {{method_field('PUT')}}
                    {{ csrf_field() }}

                    <?php
                    $fields = [
                        [
                            [
                                'name' => 'main_type',
                                'type' => 'select',
                                'label' => MutualFundType::attributes('name'),
                                'options' => Utils::getMainTypes(),
                                'prompt' => 'Select ' . MutualFundType::attributes('main_type'),
                                'value' => $type['main_type']
                            ],
                            ['name' => 'name', 'type' => 'text', 'label' => MutualFundType::attributes('name'), 'value' => $type['name']],
                        ],
                        [
                            ['name' => 'description', 'type' => 'textarea', 'label' => MutualFundType::attributes('description'), 'value' => $type['description']],
                            ['name' => 'status', 'type' => 'select', 'label' => MutualFundType::attributes('status'), 'value' => $type['status'], 'options' => Utils::getStatus(), 'prompt' => 'Select Status'],
                        ],
                    ];
                    ?>

                    @include('layouts.form', ['form' => $fields])

                    <div class="form-group">
                        <div class="d-flax pl-2">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                            <a class="btn btn-secondary" href="{{ route('type.show', $type['id']) }}">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection