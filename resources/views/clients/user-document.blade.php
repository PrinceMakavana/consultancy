<?php

use App\UserDocument;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Upload Document</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.show', $client['id']) }}">Client : {{$client['name']}}</a></li>
                    <li class="breadcrumb-item active">Upload Document</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">

    <div class="container-fluid">
        <div class="container">
            <div class="card card-default">
                <div class="card-body">

                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ route('userdocument.store') }}">
                        {{ csrf_field() }}
                        <?php
                        
                        $fields = [
                            [
                                [
                                    'name' => 'user_id',
                                    'type' => 'hidden',
                                    'value' => $client['id'],
                                ],
                            ], [
                                [
                                    'name' => 'type',
                                    'type' => 'select',
                                    'label' => "Document",
                                    'options' => array_combine($document_types, $document_types),
                                    'prompt' => 'Select Document',
                                    'value' => '',
                                    'col' => 6
                                ],
                                [
                                    'name' => 'title',
                                    'type' => 'text',
                                    'label' => UserDocument::attributes('title'),
                                    'value' => '',
                                    'col' => 6
                                ],
                            ],
                            [
                                [
                                    'name' => 'document',
                                    'type' => 'file',
                                    'label' => UserDocument::attributes('document'),
                                    'value' => '',
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
</section>
@stop