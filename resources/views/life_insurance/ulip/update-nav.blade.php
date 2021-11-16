<?php

use App\Utils;
use App\LifeInsuranceUlip;
use App\LifeInsuranceUlipUnitHist;

?>
@extends('layouts.app')

@section('content')

<style>
    /* #withdraw_amount_div,
    #units_div {
        display: none
    } */
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update NAV</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <?php if ($policy->table == LifeInsuranceUlip::$tablename) : ?>
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
                    <?php endif; ?>

                    <li class="breadcrumb-item active">Update NAV</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        {{Utils::successAndFailMessage()}}
        <div>
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <h3>Available Units : <?= Utils::numberFormatedValue($policy->units) ?></h3>
                            <?php
                            $url = route('insurance-nav-update-ulip.save',  ['policy_id' => $policy->id, 'tbl_key' => $policy->table]);
                            ?>
                            <form class="form-horizontal" method="POST" action="{{ $url }}">
                                {{ csrf_field() }}
                                <?php
                                $request = Request();
                                $url =  $request->fullUrl('tbl_key');

                                $fields = [
                                    [
                                        [
                                            'name' => 'nav',
                                            'type' => 'number',
                                            'label' => LifeInsuranceUlip::attributes('nav'),
                                            'value' => $policy['nav']
                                        ],
                                    ]
                                ];
                                ?>
                                @include('layouts.form', ['form' => $fields])

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Update
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
@stop
@push('scripts')

@endpush