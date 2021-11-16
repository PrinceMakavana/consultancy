<?php

use App\User;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Create Client</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>
                    <li class="breadcrumb-item active">Create Client</li>
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
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('client.store') }}">
                            {{ csrf_field() }}

                            <?php
                            $fields = [
                                [
                                    ['name' => 'name', 'type' => 'text', 'label' => User::attributes('name'), 'value' => ''],
                                    ['name' => 'email', 'type' => 'email', 'label' => User::attributes('email'), 'value' => ''],
                                ],
                                [
                                    ['name' => 'country_code', 'type' => 'text', 'label' => 'County Code', 'value' => config('app.country_code')[0], 'other' => "readonly=''", 'col' => 2],
                                    ['name' => 'mobile_no', 'type' => 'text', 'label' => User::attributes('mobile_no'), 'value' => '', 'col' => 4],
                                    ['name' => 'password', 'type' => 'password', 'label' => User::attributes('password'), 'value' => ''],
                                ],
                                [
                                    ['name' => 'birthdate', 'type' => 'datepicker', 'date-format' => 'DD-MM-YYYY', 'label' => User::attributes('birthdate'), 'value' => date("d-m-Y", strtotime("-1 day")), 'col' => 6],
                                    [
                                        'name' => 'pan_no', 'type' => 'text', 'label' => User::attributes('pan_no'), 'value' => '', 'col' => 6,
                                        'info' => "Example : AAAAA9999A"
                                    ],
                                    // ['name' => 'pan_card_img', 'type' => 'file', 'label' => User::attributes('pan_card_img'), 'value' => ''],
                                ],
                                [
                                    ['name' => 'status', 'type' => 'select', 'label' => User::attributes('status'), 'value' => 1, 'options' => Utils::getStatus(), 'prompt' => 'Select Status'],
                                    ['name' => 'profile', 'type' => 'file', 'label' => User::attributes('profile'), 'value' => ''],
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
</section>
@endsection