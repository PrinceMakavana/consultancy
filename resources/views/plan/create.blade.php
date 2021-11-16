<?php

use App\UserPlan;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Plan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('plan.index') }}">User Plan</a></li>
                    <li class="breadcrumb-item active">Create Plan</li>
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
                            <form class="form-horizontal" method="POST" action="{{ route('plan.store') }}">
                                {{ csrf_field() }}
                                <?php
                                $plans = UserPlan::getPlanTypes();
                                $plans = array_map(function($val){
                                    $val = $val['title'];
                                    return $val;
                                }, $plans);
                                $fields = [
                                    [
                                        [
                                            'name' => 'user_id',
                                            'type' => 'select',
                                            'label' => UserPlan::attributes('user_id'),
                                            'options' => UserPlan::optionsForUserId(),
                                            'prompt' => 'Select '.UserPlan::attributes('user_id'),
                                            'value' => UserPlan::optionsForOnlyUserId(),
                                        ],

                                    ],
                                    [
                                        [
                                            'name' => 'type',
                                            'type' => 'select',
                                            'label' => UserPlan::attributes('type'),
                                            'options' => $plans,
                                            'prompt' => 'Select '.UserPlan::attributes('type'),
                                            'value' => "",
                                            'col' => 4
                                        ],


                                        [
                                            'name' => 'return_rate',
                                            'type' => 'number',
                                            'label' => UserPlan::attributes('return_rate'),
                                            'value' => '12',
                                            'col' => 2
                                        ],
                                        [
                                            'name' => 'target_amount',
                                            'type' => 'number',
                                            'label' => UserPlan::attributes('target_amount'),
                                            'value' => '',
                                            'col' => 4
                                        ],
                                    ],
                                    [
                                        [
                                            'name' => 'start_at',
                                            'type' => 'datepicker',
                                            'label' => UserPlan::attributes('start_at'),
                                            'date-format'=> 'DD-MM-YYYY',
                                            'value' => '',
                                        ],
                                        [
                                            'name' => 'years',
                                            'type' => 'number',
                                            'label' => UserPlan::attributes('years'),
                                            'value' => '10',
                                        ],

                                    ],
                                    [
                                        ['name' => 'status', 'type' => 'select', 'label' => UserPlan::attributes('status'), 'value' => 1, 'options' => Utils::getStatus(), 'prompt' => 'Select Status'],
                                    ]
                                ];
                                ?>

                                @include('layouts.form', ['form' => $fields])

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Next
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
@push('scripts')
<script>

var $disabledResults = $("#user_id");
$disabledResults.select2();


var $disabledResults = $("#type");
$disabledResults.select2();

</script>
@endpush
