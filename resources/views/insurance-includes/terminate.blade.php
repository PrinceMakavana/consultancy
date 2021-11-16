<?php

use App\Utils;
use App\PolicyMaster;
use App\LifeInsuranceUlip;
use App\LifeInsuranceTraditional;

?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Terminate : <?= $policy['policy_no'] ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>

                    <?php if ($policy->table == LifeInsuranceUlip::$tablename) : ?>
                        <?php $submitTo = route('insurance-terminate-ulip.save', ['policy_id'=> $policy->id, 'tbl_key' => LifeInsuranceUlip::$tablename]); ?>
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
                        <?php $submitTo = route('insurance-terminate-traditional.save', ['policy_id'=> $policy->id, 'tbl_key' => LifeInsuranceTraditional::$tablename]); ?>
                        <li class="breadcrumb-item"><a href="{{ route('life-insurance-traditional.index') }}">
                                <?= Utils::titles('life_traditional_insurance') ?>
                            </a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('life-insurance-traditional.show', ['policy_id' => $policy->id] ) }}">
                                {{$policy['policy_no']}}
                            </a>
                        </li>
                    <?php elseif ($policy->table == PolicyMaster::$tablename) : ?>
                        <?php $submitTo = route('insurance-terminate-general.save', ['policy_id'=> $policy->id, 'tbl_key' => PolicyMaster::$tablename]); ?>
                        <li class="breadcrumb-item"><a href="{{ route('policy.index') }}">
                                <?= Utils::titles('general_insurance') ?>
                            </a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('policy.show', ['policy_id' => $policy->id] ) }}">
                                {{$policy['policy_no']}}
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="breadcrumb-item active">Terminate</li>

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
                                'name' => 'terminate_reason',
                                'type' => 'textarea',
                                'label' => LifeInsuranceTraditional::attributes('terminate'),
                                'value' => '',
                            ],
                            [
                                'name' => 'terminate_at',
                                'type' => 'datepicker',
                                'label' => LifeInsuranceTraditional::attributes('terminate_at'),
                                'date-format' => 'DD-MM-YYYY',
                                'value' => '',
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