<?php

use App\Utils;
use App\MutualFund;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update : {{$funds['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('funds.index') }}">Mutual Funds</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('funds.show', $funds['id']) }}">{{$funds['name']}}</a></li>
                    <li class="breadcrumb-item active">Update</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('funds.update', $funds['id']) }}">
                    {{method_field('PUT')}}
                    {{ csrf_field() }}

                    <?php
                    $fields = [
                        [
                            [
                                'name' => 'main_type',
                                'type' => 'select',
                                'label' => MutualFund::attributes('main_type'),
                                'options' => Utils::getMainTypes(),
                                'prompt' => 'Select ' . MutualFund::attributes('main_type'),
                                'value' => $funds['main_type']
                            ],
                            [
                                'name' => 'direct_or_regular',
                                'type' => 'select',
                                'label' => MutualFund::attributes('direct_or_regular'),
                                'options' => Utils::getDirectOrRegular(),
                                'prompt' => 'Select ' . MutualFund::attributes('direct_or_regular'),
                                'value' => $funds['direct_or_regular']
                            ],

                        ],
                        [
                            [
                                'name' => 'company_id',
                                'type' => 'select',
                                'label' => MutualFund::attributes('company_id'),
                                'options' => MutualFund::optionsForCompany(),
                                'prompt' => 'Select ' . MutualFund::attributes('company_id'),
                                'value' => $funds['company_id']
                            ],
                            [
                                'name' => 'type_id',
                                'type' => 'select',
                                'label' => MutualFund::attributes('type_id'),
                                'options' => MutualFund::optionsForFundType(),
                                'prompt' => 'Select ' . MutualFund::attributes('type_id'),
                                'value' => $funds['type_id']
                            ],


                        ],
                        [
                            ['name' => 'name', 'type' => 'text', 'label' => MutualFund::attributes('name'), 'value' => $funds['name']],
                            [
                                'name' => 'nav',
                                'type' => 'number',
                                'label' => MutualFund::attributes('nav'),
                                'value' => $funds['nav']
                            ],


                        ],
                        [
                            [
                                'name' => 'min_sip_amount',
                                'type' => 'number',
                                'label' => MutualFund::attributes('min_sip_amount'),
                                'value' => $funds['min_sip_amount']
                            ],
                            ['name' => 'status', 'type' => 'select', 'label' => MutualFund::attributes('status'), 'value' => $funds['status'], 'options' => Utils::getStatus(), 'prompt' => 'Select Status'],
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

@push('scripts')
<script>
    var $disabledResults = $("#main_type");
    $disabledResults.select2();

    var $disabledResults = $("#company_id");
    $disabledResults.select2();

    var $disabledResults = $("#type_id");
    $disabledResults.select2();
</script>
@endpush