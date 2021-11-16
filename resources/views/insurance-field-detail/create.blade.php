<?php

use App\InsuranceField;
use App\InsuranceFieldDetail;
use App\Utils;
use Hamcrest\Util;

?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Field</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('field.index') }}">Insurance Fields</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('field.show', ['field' => $field->id]) }}"><?= $field->name ?></a></li>
                    <li class="breadcrumb-item active">Add Field</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="card card-default">
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('field.field-detail.store', ['field'=>$field->id]) }}">
                            <div class="pb-3">
                                <?= csrf_field() ?>
                                <?php
                                $fields = [
                                    [
                                        [
                                            'name' => 'fieldname',
                                            'type' => 'text',
                                            'label' => InsuranceFieldDetail::attributes('fieldname'),
                                            'value' => '',
                                            'col' => '12'
                                        ],
                                        [
                                            'name' => 'description',
                                            'type' => 'textarea',
                                            'label' => InsuranceFieldDetail::attributes('description'),
                                            'value' => '',
                                            'col' => '12'
                                        ],
                                        [
                                            'name' => 'type',
                                            'type' => 'select',
                                            'label' => InsuranceFieldDetail::attributes('type'),
                                            'value' => '',
                                            'options' => InsuranceFieldDetail::optionForType(),
                                            'col' => '12'
                                        ],
                                    ], [
                                        [
                                            'name' => 'is_required',
                                            'type' => 'radio',
                                            'label' => InsuranceFieldDetail::attributes('is_required'),
                                            'options' => InsuranceFieldDetail::optionForIsRequired(),
                                            'value' => '',
                                            'col' => '12'
                                        ],
                                        [
                                            'name' => 'options',
                                            'type' => 'textarea',
                                            'label' => InsuranceFieldDetail::attributes('options'),
                                            'value' => '',
                                            'col' => '12',
                                            'warn' => "Write option with comma separated value."
                                        ],
                                        [
                                            'name' => 'status',
                                            'type' => 'select',
                                            'label' => InsuranceFieldDetail::attributes('status'),
                                            'value' => '1',
                                            'options' => Utils::getStatus(),
                                            'col' => '12'
                                        ],
                                    ]
                                ];
                                ?>
                                @include('layouts.form', ['form' => $fields])
                            </div>
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
</section>

@endsection
@push('scripts')
<script>
</script>
@endpush