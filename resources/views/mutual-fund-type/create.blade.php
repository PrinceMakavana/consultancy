<?php 

use App\MutualFundType;
    use App\Utils;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Mutual Fund Type</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('type.index') }}">Mutual Fund Type</a></li>
                    <li class="breadcrumb-item active">Create Mutual Fund Type</li>
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
                    <form class="form-horizontal" method="POST" action="{{ route('type.store') }}">
                        {{ csrf_field() }}
                        @php
                            $fields = [
                                [
                                    [
                                        'name' => 'main_type', 
                                        'type' => 'select', 
                                        'label' => MutualFundType::attributes('main_type'), 
                                        'options' => Utils::getMainTypes(), 
                                        'prompt' => 'Select '.MutualFundType::attributes('main_type'), 
                                        'value' => ''
                                    ],
                                    [
                                        'name' => 'name', 
                                        'type' => 'text', 
                                        'label' => MutualFundType::attributes('name'), 
                                        'value' => ''
                                    ],
                                ],
                                
                                [
                                    [
                                        'name' => 'description', 
                                        'type' => 'textarea', 
                                        'label' => MutualFundType::attributes('description'), 
                                        'value' => ''
                                    ],
                                ]

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
<script>
    $(document).ready(function(){
        load_form_data.select_tag('add_user_sip', 'user_id', 'get_all_clients');
    })
</script>
@endpush
