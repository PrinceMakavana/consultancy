<?php
use App\Utils;
use App\PolicyBenefits;
?>
@extends('layouts.app')

@section('content')

<style>
    #withdraw_amount_div,
    #units_div {
        display: none
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Benefit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('policy.index') }}">Policy</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('policy.show' , ['id'=>$policy->id]) }}">Policy :
                            {{$policy['policy_no']}}</a></li>
                    <li class="breadcrumb-item active">Edit Benefit</li>
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
                            <form class="form-horizontal" method="POST"
                                action="{{ route('benefits.update' ,  ['policy_id'=>$policy->id, 'id' => $benefit->id] ) }}">
                                {{method_field('PUT')}}
                                {{ csrf_field() }}
                                <?php
                                 $fields = [
                                [
                                    [
                                        'name' => 'notes',
                                        'type' => 'textarea',
                                        'label' => PolicyBenefits::attributes('notes'),
                                        'value' => $benefit->notes,
                                        'col' => '12'
                                    ],
                                ],
                                [
                                    [
                                        'name' => 'amount',
                                        'type' => 'number',
                                        'label' => PolicyBenefits::attributes('amount'),
                                        'value' => $benefit->amount
                                    ],
                                    [
                                        'name' => 'received_at',
                                        'type' => 'datepicker',
                                        'label' => PolicyBenefits::attributes('received_at'),
                                        'date-format'=> 'DD-MM-YYYY',
                                        'value' => date('d-m-Y', strtotime($benefit->received_at))
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
        </div>
    </div>
</section>
@stop
@push('scripts')
@endpush
