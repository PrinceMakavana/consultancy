<?php

use App\Utils;
use App\User;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$person['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.show', $client['id']) }}">Client : {{$client['name']}}</a></li>
                    <li class="breadcrumb-item active">Update Person</li>
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
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="<?= route('person.update', ['client_id' => $client['id'], 'person' => $person['id']]) ?>">
                                {{method_field('PUT')}}
                                {{ csrf_field() }}

                                <?php
                                $fields = [
                                    [
                                        ['name' => 'name', 'type' => 'text', 'label' => User::attributes('name'), 'value' => $person['name']],
                                        // ['name' => 'email', 'type' => 'email', 'label' => User::attributes('email'), 'value' => $person['email']],
                                    ],
                                    // [
                                    //     ['name' => 'country_code', 'type' => 'text', 'label' => 'County Code', 'value' => config('app.country_code')[0], 'other' => "readonly=''", 'col' => 2],
                                    //     ['name' => 'mobile_no', 'type' => 'text', 'label' => User::attributes('mobile_no'), 'value' => Utils::getNumber($person['mobile_no'])['number'], 'col' => 4],
                                    //     ['name' => 'doc_limit', 'type' => 'number', 'label' => User::attributes('doc_limit'), 'value' => $person['doc_limit']],

                                    // ],
                                    [
                                        ['name' => 'birthdate', 'type' => 'datepicker', 'date-format' => 'DD-MM-YYYY', 'label' => User::attributes('birthdate'), 'value' => date('d-m-Y', strtotime($person['birthdate'])), 'col' => 6],
                                        ['name' => 'pan_no', 'type' => 'text', 'label' => User::attributes('pan_no'), 'value' => $person['pan_no'], 'col' => 6],
                                        // ['name' => 'pan_card_img', 'type' => 'file', 'label' => User::attributes('pan_card_img'), 'value' => ''],
                                    ],

                                    [
                                        ['name' => 'status', 'type' => 'select', 'label' => User::attributes('status'), 'value' => $person['status'], 'options' => Utils::getStatus(), 'prompt' => 'Select Status'],
                                        ['name' => 'profile', 'type' => 'file', 'label' => User::attributes('profile'), 'value' => ''],
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