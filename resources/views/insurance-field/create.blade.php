<?php

use App\InsuranceField;
use App\Utils;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Insurance Field</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('field.index') }}">Insurance Fields</a></li>
                    <li class="breadcrumb-item active">Create</li>
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
                            <form class="form-horizontal" method="POST" action="{{ route('field.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <?php
                                $fields = [
                                    [
                                        [
                                            'name' => 'name',
                                            'type' => 'text',
                                            'label' => InsuranceField::attributes('name'),
                                            'value' => ''
                                        ],
                                        [
                                            'name' => 'status', 'type' => 'select', 'label' => InsuranceField::attributes('status'), 
                                            'value' => '1',
                                            'options' => Utils::getStatus(), 'prompt' => 'Select Status'
                                        ],
                                    ],
                                    [
                                        [
                                            'name' => 'benefit_name',
                                            'type' => 'text',
                                            'label' => InsuranceField::attributes('benefit_name'),
                                            'value' => ''
                                        ],
                                        ['name' => 'has_multiple_benefits', 'type' => 'select', 'label' => InsuranceField::attributes('has_multiple_benefits'), 'value' => '', 'options' => InsuranceField::optionForHasMultipleBenefits(), 'prompt' => 'Select'],
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
@push('scripts')
<script>
    $(document).ready(function() {
        load_form_data.select_tag('add_user_sip', 'user_id', 'get_all_clients');
    })
</script>
@endpush