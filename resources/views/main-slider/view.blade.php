<?php

use App\MainSlider;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1 class="m-0 text-dark">Slider Image : {{$mnslider['name']}}</h1> -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('main-slider.index') }}">Slider Images</a></li>
                    <!-- <li class="breadcrumb-item active">Slider Image : {{$mnslider['name']}}</li> -->
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
                            <a href="{{route('main-slider.edit', $mnslider['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            {!! Utils::deleteBtn(route('main-slider.destroy', $mnslider['id'])) !!}
                            
                            <div class="row">
                                <table class="col-lg-6 table mt-2">
                                    <tr>
                                        <td>
                                            <p><b>{{ MainSlider::attributes('image') }}</b></p>
                                        </td>
                                        <td>
                                            <a href="{{ MainSlider::getSliderImg($mnslider['image']) }}" target="_blank">
                                            <img src="{{ MainSlider::getSliderImg($mnslider['image']) }}" style="width: 200px">
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                <table class="col-lg-6 table mt-2">
                                    <tr>
                                        <th>{{ MainSlider::attributes('created_at') }}</th>
                                        <td>{{ $mnslider['created_at'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ MainSlider::attributes('status') }}</th>
                                        <td>{{ Utils::setStatus($mnslider['status']) }}</td>
                                    </tr>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

