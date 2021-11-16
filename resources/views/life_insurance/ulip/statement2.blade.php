<?php

use App\Utils;
use App\PremiumMaster;
use Hamcrest\Util;

?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Statement : <?= $policy['policy_no'] ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('life-insurance-ulip.index') }}">Ulip Life Insurance</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-ulip.show', ['policy_id' => $policy->id] ) }}">
                            Policy : {{$policy['policy_no']}}
                        </a></li>
                    <li class="breadcrumb-item active">Statement</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="container">
            {{Utils::successAndFailMessage()}}
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <h3>Premium Statement</h3>

                            <?php if (!empty($death_benefit)) : ?>
                                <div class="alert alert-danger">
                                    Received Death Benefits on <?= Utils::getFormatedDate($death_benefit['received_at']) ?>
                                </div>
                            <?php endif; ?>

                            <table class="table table-responsive table-bordered statement">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>{{ PremiumMaster::attributes('premium_date') }}</th>
                                        <th>{{ PremiumMaster::attributes('amount') }}</th>
                                        <th>{{ PremiumMaster::attributes('paid_at') }}</th>
                                        <th>Assured Benifits</th>
                                        <th>Maturity Benifits</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    @foreach($statement as $key => $state)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{Utils::getMFormatedDate($state['date'])}}</td>
                                        <td>{{Utils::numberFormatedValue(@$state['premium_amount'])}}</td>
                                        <td>{{Utils::getMFormatedDate(@$state['payment_date'])}}</td>
                                        <td>{{Utils::numberFormatedValue(@$state['assured_amount'])}}</td>
                                        <td>{{@$state['maturity_amount']}}</td>
                                        <td style="text-transform: capitalize;">{{$state['status']}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th>{{ Utils::numberFormatedValue(Utils::getSum($statement, 'premium_amount') )}}</th>
                                        <th></th>
                                        <th>{{ Utils::numberFormatedValue(Utils::getSum($statement, 'assured_amount') )}}</th>
                                        <th>{{Utils::numberFormatedValue(Utils::getSum($statement, 'maturity_amount'))}}</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@stop
@push('scripts')
<script>


</script>

@endpush