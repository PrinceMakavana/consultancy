<?php

use App\LifeInsuranceTraditional;
use App\Utils;
use App\PremiumMaster;
use App\LifeInsuranceUlip;
use App\PolicyDocuments;
use App\PolicyMaster;
use SebastianBergmann\ObjectReflector\ObjectReflector;

?>
@extends('layouts.app')

@section('content')

<style>
    #withdraw_amount_div,
    #units_div {
        display: none
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit : <?= $document->title ?></h1>
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
                    <?php elseif ($policy->table == LifeInsuranceTraditional::$tablename) : ?>
                        <li class="breadcrumb-item"><a href="{{ route('life-insurance-traditional.index') }}">
                                <?= Utils::titles('life_traditional_insurance') ?>
                            </a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('life-insurance-traditional.show', ['policy_id' => $policy->id] ) }}">
                                {{$policy['policy_no']}}
                            </a>
                        </li>
                    <?php elseif ($policy->table == PolicyMaster::$tablename) : ?>
                        <li class="breadcrumb-item"><a href="{{ route('policy.index') }}">
                                <?= Utils::titles('general_insurance') ?>
                            </a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('policy.show', ['policy_id' => $policy->id] ) }}">
                                {{$policy['policy_no']}}
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="breadcrumb-item active">Edit Document</li>
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
                            <?php
                            if ($tbl_key == LifeInsuranceTraditional::$tablename) {
                                $url = route('insurance-documents-traditional.update',  ['policy_id' => $policy->id, 'tbl_key' => $policy->table, 'document' => $document->id]);
                            } else if ($tbl_key == LifeInsuranceUlip::$tablename) {
                                $url = route('insurance-documents-ulip.update',  ['policy_id' => $policy->id, 'tbl_key' => $policy->table, 'document' => $document->id]);
                            } else if ($tbl_key == PolicyMaster::$tablename) {
                                $url = route('insurance-documents-general.update',  ['policy_id' => $policy->id, 'tbl_key' => $policy->table, 'document' => $document->id]);
                            }
                            ?>
                            <form class="form-horizontal" method="POST" action="{{ $url }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{method_field('PUT')}}
                                <?php
                                $request = Request();
                                $url =  $request->fullUrl('tbl_key');
                                $fields = [
                                    [
                                        [
                                            'name' => 'title',
                                            'type' => 'text',
                                            'label' => PolicyDocuments::attributes('title'),
                                            'value' => $document->title,
                                            'col' => 12
                                        ],
                                        [
                                            'name' => 'document',
                                            'type' => 'file',
                                            'label' => PolicyDocuments::attributes('document'),
                                            'value' => $document->document,
                                            'accept' => '1',
                                            'col' => 12
                                        ],
                                        [
                                            'name' => 'notes',
                                            'type' => 'textarea',
                                            'label' => PolicyDocuments::attributes('notes'),
                                            'value' => $document->notes,
                                            'col' => 12
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
@stop
@push('scripts')
<script>
    $('#document').on('change', function() {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })
</script>
@endpush