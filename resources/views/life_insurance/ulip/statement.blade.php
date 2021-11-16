<?php

use App\MutualFundUser;
use App\MutualFundInvestmentHist;
use App\UserSipInvestement;
use App\LifeInsuranceUlip;
use App\PolicyBenefits;
use App\PremiumMaster;
use App\Utils;
use App\User;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Ulip Life Insurance : <?= $policy['policy_no'] ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-traditional.index') }}">Ulip Life Insurance</a>
                    </li>
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
            <!-- <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">

                            <?php $delete_link = route('life-insurance-traditional.destroy', $policy->id);
                            $delete = Utils::deleteBtn($delete_link);
                              echo $delete ;
                          ?>
                            <table class="table mt-2">
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('user_id') }}</th>
                                    <td>{{ $policy['user']['name'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('plan_name') }}</th>
                                    <td>{{ $policy['plan_name'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('policy_no') }}</th>
                                    <td>{{ $policy['policy_no'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('policy_term') }}</th>
                                    <td>{{ $policy['policy_term'] }} Year</td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('permium_paying_term') }}</th>
                                    <td>{{ $policy['permium_paying_term'] }} Year</td>
                                </tr>

                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('premium_mode') }}</th>
                                    <td><?= LifeInsuranceUlip::setPremiumMode($policy['premium_mode']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
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
                            <table class="table table-responsive table-bordered statement" >
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
                                <!-- <?php echo "<pre>";print_r($statement); ?> -->
                                    @foreach($statement as $key => $state)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{Utils::getMFormatedDate($state['due_date'])}}</td>
                                            <td>{{Utils::numberFormatedValue($state['premium_amount'])}}</td>
                                            <td>{{Utils::getMFormatedDate($state['payment_date'])}}</td>
                                            <td>{{Utils::numberFormatedValue($state['assured_benefit'])}}</td>
                                            <td>{{Utils::numberFormatedValue($state['maturity_benefit'])}}</td>
                                            <td><span class="btn-sm {{$state['status_class']}}">{{$state['status']}}</span></td>
                                            
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th>{{ Utils::numberFormatedValue($policy->total_premium_amount) }}</th>
                                            <th></th>
                                            <th>{{Utils::numberFormatedValue($policy->total_assured_benefit)}}</th>
                                            <th>{{Utils::numberFormatedValue($policy->maturity_benefit)}}</th>
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
