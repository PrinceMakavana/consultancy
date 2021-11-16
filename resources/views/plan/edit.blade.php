<?php
    use App\Utils;
    use App\User;
    use App\UserPlan;

?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Plan : {!! @UserPlan::setPlanType($plan['type'])['title'] !!} for {{$plan['user']['name']}} </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('plan.index') }}">User Plan :
                            {{$plan['user']['name']}} </a></li>
                    <li class="breadcrumb-item active">Update Plan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                                action="{{ route('plan.update', $plan['id']) }}">
                                {{ method_field('PUT') }}
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
                                        'value' => $plan['user_id']
                                    ],

                                ],
                                [
                                    [
                                        'name' => 'type',
                                        'type' => 'select',
                                        'label' => UserPlan::attributes('type'),
                                        'options' => $plans,
                                        'prompt' => 'Select '.UserPlan::attributes('type'),
                                        'value' => $plan['type']
                                    ],
                                    [
                                        'name' => 'return_rate',
                                        'type' => 'number',
                                        'label' => UserPlan::attributes('return_rate'),
                                        'value' => $plan['return_rate'],
                                        'col' => 2
                                    ],
                                    [
                                        'name' => 'target_amount',
                                        'type' => 'number',
                                        'label' => UserPlan::attributes('target_amount'),
                                        'value' => $plan['target_amount'],
                                        'col' => 4
                                    ],

                                ],

                                [
                                    [
                                        'name' => 'start_at',
                                        'type' => 'datepicker',
                                        'label' => UserPlan::attributes('start_at'),
                                        'date-format'=> 'DD-MM-YYYY',
                                        'value' => date('d-m-Y', strtotime($plan['start_at'])),
                                    ],
                                    [
                                        'name' => 'years',
                                        'type' => 'number',
                                        'label' => UserPlan::attributes('years'),
                                        'value' => $plan['years']['years'],
                                    ],
                                ],
                                [
                                    ['name' => 'status', 'type' => 'select', 'label' => UserPlan::attributes('status'), 'value' => $plan['status'], 'options' => Utils::getStatus(), 'prompt' => 'Select Status'],
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


@push('scripts')
<script>

var $disabledResults = $("#user_id");
$disabledResults.select2();


var $disabledResults = $("#type");
$disabledResults.select2();

</script>
@endpush
