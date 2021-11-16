<?php

use App\Utils;
use App\InsuranceField;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update : {{$field['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('field.index') }}">Insurance Fields</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('field.show', $field['id']) }}">{{$field['name']}}</a></li>
                    <li class="breadcrumb-item active">Update</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('field.update', $field['id']) }}">
                                {{method_field('PUT')}}
                                {{ csrf_field() }}

                                <?php
                                $fields = [
                                    [
                                        ['name' => 'name', 'type' => 'text', 'label' => InsuranceField::attributes('name'), 'value' => $field['name']],
                                        ['name' => 'status', 'type' => 'select', 'label' => InsuranceField::attributes('status'), 'value' => $field['status'], 'options' => Utils::getStatus(), 'prompt' => 'Select Status'],
                                    ], [
                                        ['name' => 'benefit_name', 'type' => 'text', 'label' => InsuranceField::attributes('benefit_name'), 'value' => $field['benefit_name']],
                                        [
                                            'name' => 'has_multiple_benefits', 'type' => 'select', 'label' => InsuranceField::attributes('has_multiple_benefits'),
                                            'value' => $field['has_multiple_benefits'],
                                            'options' => InsuranceField::optionForHasMultipleBenefits(), 'prompt' => 'Select'
                                        ],
                                    ],
                                    [
                                        [
                                            'name' => 'image',
                                            'type' => 'file',
                                            'label' => InsuranceField::attributes('image'),
                                            'value' => ''
                                        ]
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