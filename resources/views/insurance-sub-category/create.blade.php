<?php 

use App\InsuranceCategory;
use App\InsuranceSubCategory;
use App\Utils;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Insurance Sub Category</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sub-category.index') }}">Insurance Sub Category</a></li>
                    <li class="breadcrumb-item active">Create Insurance Sub Category</li>
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
                    <form class="form-horizontal" method="POST" action="{{ route('sub-category.store') }}">
                        {{ csrf_field() }}
                        @php
                            $fields = [
                                [  
                                    [
                                        'name' => 'category_id', 
                                        'type' => 'select', 
                                        'label' => InsuranceSubCategory::attributes('category_id'), 
                                        'options' => InsuranceCategory::getInsuranceCategories(), 
                                        'prompt' => 'Select '.InsuranceSubCategory::attributes('category_id'), 
                                        'value' => ''
                                    ],
                                    [
                                        'name' => 'name', 
                                        'type' => 'text', 
                                        'label' => InsuranceSubCategory::attributes('name'), 
                                        'value' => ''
                                    ],
                                ],

                            ];
                        @endphp

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
