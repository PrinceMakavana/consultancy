<?php

use App\InsuranceCompany;
use App\Utils;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Insurance Company</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('insurance-company.index') }}"><?= Utils::titles('insurance_companies') ?></a></li>
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
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('insurance-company.store') }}">
                                {{ csrf_field() }}
                                <?php
                                    $fields = [
                                        [
                                            [
                                                'name' => 'name',
                                                'type' => 'text',
                                                'label' => InsuranceCompany::attributes('name'),
                                                'value' => ''
                                            ],
                                            [
                                                'name' => 'image',
                                                'type' => 'file',
                                                'label' => InsuranceCompany::attributes('image'),
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

@endpush