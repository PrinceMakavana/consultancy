<?php

use App\Greetings;
    use App\Utils;
    use App\User;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update Greeting : {{$greeting['title']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('greetings.index') }}">Greetings</a></li>
                    <li class="breadcrumb-item active">Update Greeting</li>
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
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('greetings.update', $greeting['id']) }}">
                        {{method_field('PUT')}}
                        {{ csrf_field() }}

                        @php
                            $fields = [
                                [
                                    [
                                        'name' => 'title', 
                                        'type' => 'text', 
                                        'label' => Greetings::attributes('title'), 
                                        'value' => $greeting['title'],
                                        'col' => 12
                                    ],
                                    [
                                        'name' => 'body', 
                                        'type' => 'textarea', 
                                        'label' => Greetings::attributes('body'), 
                                        'value' => $greeting['body'],
                                    ],
                                    [
                                        'name' => 'image', 
                                        'type' => 'file', 
                                        'label' => Greetings::attributes('image'), 
                                        'value' => '',
                                    ]
                                ],
                                [
                                    [
                                        'name' => 'date', 
                                        'type' => 'datepicker', 
                                        'label' => Greetings::attributes('date'), 
                                        'date-format'=> 'DD-MM-YYYY',
                                        'value' => date('d-m-Y', strtotime($greeting['date']))
                                    ],
                                    [
                                        'name' => 'status', 
                                        'type' => 'select', 
                                        'label' => Greetings::attributes('status'), 
                                        'options' => Greetings::optionsForStatus(),
                                        'value' => $greeting['status']
                                    ]
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
