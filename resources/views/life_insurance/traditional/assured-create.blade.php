<?php

use App\InsuranceField;
use App\MutualFundType;
use App\LifeInsuranceTraditional;
use App\InsuranceFieldDetail;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Assured Payout Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-traditional.index') }}"><?= Utils::titles('life_traditional_insurance') ?></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-traditional.show', ['policy_id' => $policy->id] ) }}">
                            {{$policy['policy_no']}}
                        </a></li>

                    <li class="breadcrumb-item active">Assured Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content" ng-app="app" ng-controller="mainCtrl">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                <div class="card card-default">
                    <div class="card-header"> Confirm Assured Payouts</div>
                    <div class="card-body p-0">
                        <form class="form-horizontal" method="POST">
                            {{ csrf_field() }}
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td class="w-auto">Policy Year</td>
                                        <td>Date</td>
                                        <td>Amount</td>
                                        <td><a ng-click="addPayout()" class="btn btn-sm text-light btn-primary">+</a></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="(k, val) in assuredPayouts" ng-if="!val.is_deleted.value">
                                        <td class="w-auto">
                                            <input step="any" type="number" ng-change="policyYearChange(k)" ng-model="val.policy_year.value" class="form-control" name="policy_year[]" style="width: 70px;">
                                        </td>
                                        <td>
                                            <input step="any" type="text" disabled ng-model="val.date.value" class="form-control datepicker" name="date[]">
                                        </td>
                                        <td>
                                            <input step="any" type="number" ng-model="val.amount.value" class="form-control" name="amount[]">
                                        </td>
                                        <td>
                                            <a ng-if="val.is_done.value" style="cursor: not-allowed;" ng-click="removePayout(k)" class="btn btn-sm text-light btn-danger">-</a>
                                            <a ng-if="!val.is_done.value" ng-click="removePayout(k)" class="btn btn-sm text-light btn-danger">-</a>
                                        </td>
                                    </tr>
                                    <tr ng-if="!assuredPayouts.length">
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-footer">
                                <a ng-click="saveDetails()" ng-disabled="!submitting" class="btn btn-primary text-light">
                                    Save
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-body p-0">
                        <table class="table">
                            <tr>
                                <th>Started Date of Policy</th>
                                <td>{!! Utils::getFormatedDate($policy['issue_date']) !!}</td>
                            </tr>

                            <tr>
                                <th>{{ LifeInsuranceTraditional::attributes('maturity_date') }}</th>
                                <td>{!! Utils::getFormatedDate(@$policy['maturity_date']) !!} </td>
                            </tr>
                            <tr>
                                <th>{{ LifeInsuranceTraditional::attributes('maturity_amount') }}</th>
                                <td>{!! Utils::getFormatedAmount($policy['maturity_amount']) !!} </td>
                            </tr>
                            <tr>
                                <th>{{ LifeInsuranceTraditional::attributes('maturity_amount_8_per') }}</th>
                                <td>{!! Utils::getFormatedAmount($policy['maturity_amount_8_per']) !!} </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')
<script>
    var app = angular.module('app', []);
    app.controller('mainCtrl', function($scope, $http) {
        $scope.assuredPayouts = [];
        $scope.initDatepicker = () => {
            $(document).ready(function() {
                $('input.datepicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                });
            })
        }
        $scope.payoutForm = {
            id: {
                value: ''
            },
            policy_year: {
                value: '',
                errors: [],
                type: 'number'
            },
            date: {
                value: '',
                errors: [],
                type: 'text'
            },
            amount: {
                value: '',
                errors: [],
                type: 'text'
            },
            is_deleted: {
                value: ''
            },
            is_done: {
                value: ''
            }
        }

        $scope.initPayouts = () => {
            let payouts = JSON.parse(`<?= json_encode($assured_payouts) ?>`)
            if (payouts && payouts.length) {
                payouts = payouts.map(e => {
                    let a = $scope.freshForm();
                    a.id.value = e.id
                    a.date.value = moment(e.date, 'YYYY-MM-DD').format('DD/MM/YYYY')
                    a.amount.value = e.amount
                    a.policy_year.value = parseInt(e.policy_year)
                    a.is_done.value = e.is_done
                    $scope.assuredPayouts.push(a);
                })
                $scope.initDatepicker()
            }
        }

        $scope.freshForm = () => {
            return JSON.parse(JSON.stringify($scope.payoutForm))
        }
        $scope.addPayout = () => {
            $scope.assuredPayouts.push($scope.freshForm());
            $scope.initDatepicker()
        }
        $scope.initPayouts();
        if (!$scope.assuredPayouts.length) {
            $scope.addPayout();
        }
        $scope.removePayout = (index) => {
            if ($scope.assuredPayouts[index].is_done.value != 1) {
                if ($scope.assuredPayouts[index].id.value) {
                    if (confirm("Are you sure?")) $scope.assuredPayouts[index].is_deleted.value = true
                } else {
                    if (confirm("Are you sure?")) $scope.assuredPayouts.splice(index, 1);
                }
            } else {
                alert('This benefits already done.');
            }
            $scope.initDatepicker()
        }

        $scope.saveDetails = () => {
            $scope.submitting = true;
            let formdata = JSON.parse(JSON.stringify($scope.assuredPayouts));
            if (formdata.length) {
                formdata = formdata.map(e => {
                    return {
                        id: e.id.value,
                        policy_year: e.policy_year.value,
                        date: e.date.value,
                        amount: e.amount.value,
                        is_done: e.is_done.value,
                        is_deleted: e.is_deleted.value,
                    }
                })
                let data = {
                    url: `<?= route('life-traditional.assured-payouts.store', ['policy_id' => $policy->id]) ?>`,
                    method: "POST",
                    data: formdata
                }

                $http(data)
                    .then(function(response) {
                        $scope.submitting = false;
                        if (response.data.status) {
                            if (response.data.msg) alert(response.data.msg);
                            window.location.href = `<?= route('life-insurance-traditional.show', ['policy_id' => $policy->id]) ?>`
                        }
                    }, er => {
                        $scope.submitting = false;
                        if (!er.data.status) {
                            if (er.data.meta.errors) {
                                let err = Object.values(er.data.meta.errors)
                                if (err[0][0])
                                    alert(err[0][0]);
                            }
                        }
                    });
            } else {
                alert('You have not added any details.');
            }
        }

        $scope.policyYearChange = (index) => {
            let policy_year = $scope.assuredPayouts[index].policy_year.value;
            let issue_date = '<?= date('d-m-Y', strtotime($policy['issue_date'])) ?>';
            let policy_term = policy_year;

            issue_date = moment(issue_date, 'DD-MM-YYYY');
            let maturity_date = issue_date.add(policy_term, 'year')
            $scope.assuredPayouts[index].date.value = maturity_date.format('DD/MM/YYYY')
            // policy_year
        }

    });
</script>
@endpush