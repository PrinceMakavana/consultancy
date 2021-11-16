<?php

use App\Utils;
?>
@extends('layouts.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Insurance Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Insurance Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= @$total_insurances ?></h3>
            <p>Total Insurances</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-4">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= @$types['traditional'] ?></h3>
            <p>Traditional</p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-4">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= @$types['ulip'] ?></h3>
            <p>Ulip</p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-4">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= !empty($types['general']) ? $types['general'] : 0 ?></h3>
            <p>General</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-2 col-4">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= !empty($status['open']) ? $status['open'] : 0 ?></h3>
            <p>Open</p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-4">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= !empty($status['complete']) ? $status['complete'] : 0 ?></h3>
            <p>Complete</p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-4">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= !empty($status['close']) ? $status['close'] : 0 ?></h3>
            <p>Close</p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-4">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= !empty($status['surrender']) ? $status['surrender']: 0 ?></h3>
            <p>Surrender</p>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-4">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= !empty($status['terminated']) ? $status['terminated']: 0 ?></h3>
            <p>Terminated</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop