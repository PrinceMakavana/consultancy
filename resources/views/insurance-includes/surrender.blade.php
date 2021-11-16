<?php

use App\Utils;
use App\PolicyMaster;
use App\LifeInsuranceUlip;
use App\LifeInsuranceTraditional;
use App\PolicySurrender;

?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Surrender : <?= $policy['policy_no'] ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>

                    <?php if ($policy->table == LifeInsuranceUlip::$tablename) : ?>
                        <?php $submitTo = route('insurance-surrender-ulip.save', ['policy_id' => $policy->id, 'tbl_key' => LifeInsuranceUlip::$tablename]); ?>
                        <li class="breadcrumb-item">
                            <a href="{{ route('life-insurance-ulip.index') }}">
                                <?= Utils::titles('life_ulip_insurance') ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('life-insurance-ulip.show', ['policy_id' => $policy->id] ) }}">
                                {{$policy['policy_no']}}
                            </a>
                        </li>
                    <?php elseif ($policy->table == LifeInsuranceTraditional::$tablename) : ?>
                        <?php $submitTo = route('insurance-surrender-ulip.save', ['policy_id' => $policy->id, 'tbl_key' => LifeInsuranceTraditional::$tablename]); ?>
                        <li class="breadcrumb-item">
                            <a href="{{ route('life-insurance-traditional.index') }}">
                                <?= Utils::titles('life_traditional_insurance') ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('life-insurance-traditional.show', ['policy_id' => $policy->id] ) }}">
                                {{$policy['policy_no']}}
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="breadcrumb-item active">Surrender</li>

                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" method="post" action="<?= $submitTo ?>">
                    {{ csrf_field() }}

                    <?php
                    $fields = [
                        [
                            [
                                'name' => 'notes',
                                'type' => 'textarea',
                                'label' => PolicySurrender::attributes('notes'),
                                'value' => '',
                                'col' => '12'
                            ],
                        ], [
                            [
                                'name' => 'amount',
                                'type' => 'number',
                                'label' => PolicySurrender::attributes('amount'),
                                'date-format' => 'DD-MM-YYYY',
                                'value' => '',
                            ],
                            [
                                'name' => 'date',
                                'type' => 'datepicker',
                                'label' => PolicySurrender::attributes('date'),
                                'date-format' => 'DD-MM-YYYY',
                                'value' => '',
                                'info' => 'Surrender policy must only after 3 year of issue date. <br> Issue date : ' . Utils::getFormatedDate($policy->issue_date)
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
</section>
@stop