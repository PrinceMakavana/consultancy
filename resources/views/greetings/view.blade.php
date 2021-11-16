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
                <h1 class="m-0 text-dark">Greeting : {{$greeting['title']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('greetings.index') }}">Greetings</a></li>
                    <li class="breadcrumb-item active">Greeting</li>
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
                            {{Utils::successAndFailMessage()}}
                            <a href="{{route('greetings.edit', $greeting['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            {!! Utils::deleteBtn(route('greetings.destroy', $greeting['id'])) !!}
                            <table class="table mt-2">
                                <tr>
                                    <th>{{ Greetings::attributes('title') }}</th>
                                    <td>{{ $greeting['title'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ Greetings::attributes('body') }}</th>
                                    <td>{{ $greeting['body'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ Greetings::attributes('status') }}</th>
                                    <td>{{ Utils::setStatus($greeting['status']) }}</td>
                                </tr>
                                <?php if(!empty(Greetings::getImg($greeting['image']))): ?>
                                <tr>
                                    <th>{{ Greetings::attributes('image') }}</th>
                                    <td><img class="mw-100" src="{{ Greetings::getImg($greeting['image']) }}" ></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
