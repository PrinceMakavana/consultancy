<?php
use App\UserLampSumInvestment;
use App\MutualFundInvestmentHist;
    use App\UserSipInvestement;
use App\MutualFundUser;
use App\Utils;
use App\WithdrawUserFund;
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
                <h1 class="m-0 text-dark">Withdraw Fund : <?= $user_fund->folio_no ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user-mutual-fund.index') }}">User Mutual Funds</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('user-mutual-fund.show', $user_fund->id ) }}"><?= $user_fund->folio_no ?></a>
                    </li>
                    <li class="breadcrumb-item active">Withdraw</li>
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
                                action="{{ route('withdraw.store' ,  $user_fund->id ) }}">
                                {{ csrf_field() }}
                                <?php
                                $fields = [
                                [

                                [
                                'name' => 'withdraw_type',
                                'type' => 'select',
                                'label' => WithdrawUserFund::attributes('withdraw_type'),
                                'options' => WithdrawUserFund::optionsInvestmentType(),
                                'prompt' => 'Select '.WithdrawUserFund::attributes('withdraw_type'),
                                'value' => '',
                                ],
                                ],


                                [
                                [
                                'name' => 'units',
                                'type' => 'number',
                                'label' => WithdrawUserFund::attributes('units'),
                                'value' => ''
                                ],
                                [
                                'name' => 'withdraw_amount',
                                'type' => 'number',
                                'label' => WithdrawUserFund::attributes('withdraw_amount'),
                                'value' => ''
                                ],
                                ],


                                [
                                [
                                'name' => 'nav_on_date',
                                'type' => 'number',
                                'label' => WithdrawUserFund::attributes('nav_on_date'),
                                'value' => ''
                                ],
                                [
                                'name' => 'withdraw_date',
                                'type' => 'datepicker',
                                'label' => WithdrawUserFund::attributes('withdraw_date'),
                                'date-format'=> 'DD-MM-YYYY',
                                'value' => '',
                                ],
                                ],


                                [
                                [
                                'name' => 'remark',
                                'type' => 'textarea',
                                'label' => WithdrawUserFund::attributes('remark'),
                                'value' => ''
                                ],
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
@stop
@push('scripts')
<script>
    function checkWithdraw(){
    if ($('#withdraw_type').val() == 'Unit') {
        $("#withdraw_amount_div").hide();
        $("#units_div").show();
    }
    else if ($('#withdraw_type').val() == 'Amount') {
        $("#withdraw_amount_div").show();
        $("#units_div").hide();
    }
    else {
        $("#withdraw_amount_div").hide();
        $("#units_div").hide();
    }
}
$(document).ready(function () {
    checkWithdraw();
    $('#withdraw_type').on('change', checkWithdraw);
})

</script>
@endpush
