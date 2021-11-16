<?php

use App\MutualFund;
    use App\Utils;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Mutual Fund</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('funds.index') }}">Mutual Fund</a></li>
                    <li class="breadcrumb-item active">Create Mutual Fund</li>
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
                    <form class="form-horizontal" method="POST" action="{{ route('funds.store') }}">
                        {{ csrf_field() }}
                        <?php
                            $fields = [
                                [
                                    [
                                        'name' => 'main_type',
                                        'type' => 'select',
                                        'label' => MutualFund::attributes('main_type'),
                                        'options' => Utils::getMainTypes(),
                                        'prompt' => 'Select '.MutualFund::attributes('main_type'),
                                        'value' => ''
                                    ],
                                    [
                                        'name' => 'direct_or_regular',
                                        'type' => 'select',
                                        'label' => MutualFund::attributes('direct_or_regular'),
                                        'options' => Utils::getDirectOrRegular(),
                                        'prompt' => 'Select '.MutualFund::attributes('direct_or_regular'),
                                        'value' => ''
                                    ],

                                ],
                                [
                                    [
                                        'name' => 'company_id',
                                        'type' => 'select',
                                        'label' => MutualFund::attributes('company_id'),
                                        'options' => MutualFund::optionsForCompany(),
                                        'prompt' => 'Select '.MutualFund::attributes('company_id'),
                                        'value' => ''
                                    ],
                                    [
                                        'name' => 'type_id',
                                        'type' => 'select',
                                        'label' => MutualFund::attributes('type_id'),
                                        'options' => MutualFund::optionsForFundType(),
                                        'prompt' => 'Select '.MutualFund::attributes('type_id'),
                                        'value' => ''
                                    ],

                                ],
                                [
                                    [
                                        'name' => 'name',
                                        'type' => 'text',
                                        'label' => MutualFund::attributes('name'),
                                        'value' => ''
                                    ],

                                    [
                                        'name' => 'nav',
                                        'type' => 'number',
                                        'label' => MutualFund::attributes('nav'),
                                        'value' => ''
                                    ],

                                ],
                                [
                                    [
                                        'name' => 'min_sip_amount',
                                        'type' => 'number',
                                        'label' => MutualFund::attributes('min_sip_amount'),
                                        'value' => ''
                                    ],
                                ],

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
    $(document).ready(function(){
        load_form_data.select_tag('add_user_sip', 'user_id', 'get_all_clients');
    })


    var $disabledResults = $("#company_id");
$disabledResults.select2();

var $disabledResults = $("#type_id");
$disabledResults.select2();

var $disabledResults = $("#main_type");
$disabledResults.select2();

</script>
@endpush
