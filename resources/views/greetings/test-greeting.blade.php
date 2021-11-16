<?php 

use App\Greetings;
use App\UserLampSumInvestment;
    use App\Utils;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Test Greeting</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('greetings.index') }}">Greetings</a></li>
                    <li class="breadcrumb-item active">Test Greeting</li>
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
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('greetings.send-test-greeting') }}">
                        {{ csrf_field() }}
                        @php
                            $fields = [
                                [
                                    [
                                        'name' => 'greeting', 
                                        'type' => 'select', 
                                        'prompt' => "Select " . Greetings::attributes('greeting'),
                                        'label' => Greetings::attributes('greeting'), 
                                        'options' => Greetings::optionsForGreetings(),
                                        'value' => ''
                                    ],
                                    [
                                        'name' => 'client', 
                                        'type' => 'select', 
                                        'prompt' => "Select " . Greetings::attributes('client'),
                                        'label' => Greetings::attributes('client'), 
                                        'options' => Greetings::optionsForClients(),
                                        'value' => ''
                                    ],
                                ]
                            ];
                        @endphp

                        @include('layouts.form', ['form' => $fields])

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Greeting
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
