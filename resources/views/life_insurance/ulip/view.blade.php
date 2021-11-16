<?php

use App\User;
use App\Utils;
use App\PremiumMaster;
use App\MutualFundUser;
use App\PolicyBenefits;
use App\PolicyDocuments;
use App\LifeInsuranceUlip;
use App\UserSipInvestement;
use App\MutualFundInvestmentHist;
use App\LifeInsuranceUlipUnitHist;

$death_benefits = PolicyBenefits::isDeathBenifitReceived($policy->id, LifeInsuranceUlip::$tablename);
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
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-ulip.index') }}">Ulip Life Insurance</a>
                    </li>
                    <li class="breadcrumb-item active"><?= $policy['policy_no'] ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div>
            {{Utils::successAndFailMessage()}}

            <?php if ($policy->status == 'terminated') : ?>
                <div class="alert alert-danger">
                    Policy is terminated on <?= Utils::getFormatedDate($policy->terminate_at) ?>
                </div>
            <?php elseif ($policy->status == 'surrender' && !empty($policy->surrender)) : ?>
                <div class="alert alert-danger">
                    Policy is surrender on <?= Utils::getFormatedDate($policy->surrender->date) ?>
                </div>
            <?php endif; ?>

            <?php if ($policy->status == 'open' && !empty($death_benefit)) : ?>
                <div class="alert alert-danger">
                    Received Death Benefits on <?= Utils::getFormatedDate($death_benefit['received_at']) ?>
                    <?php if ($policy->status == 'open') : ?>
                        <a class="badge float-right badge-success p-2" href="<?= route('life-insurance-ulip.change-status', ['policy' => $policy->id, 'status' => 'close']) ?>">
                            Close Policy
                        </a>
                    <?php endif; ?>
                </div>
            <?php elseif ($policy->status == 'open' && $next) : ?>
                <div class="alert alert-success">
                    <?= $next[0]['type'] == 'premium' ? 'Premium' : Utils::getBenefitType()[$next[0]['type']] ?>
                    On <?= Utils::getFormatedDate($next[0]['date']) ?>
                </div>
            <?php elseif ($policy->status == 'open' && $policy->status == 'open') : ?>
                <div class="alert alert-danger">
                    All done.
                    <a class="badge float-right badge-success p-2" href="<?= route('life-insurance-ulip.change-status', ['policy' => $policy->id, 'status' => 'complete']) ?>">
                        Complete Policy
                    </a>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">

                            <?php $delete_link = route('life-insurance-ulip.destroy', $policy->id);
                            $delete = Utils::deleteBtn($delete_link);
                            echo $delete;
                            ?>
                            <a href="{{ route('life-insurance-ulip.statement', ['policy_id'=>$policy->id] ) }}" class="btn btn-sm btn-success">View Statement</a>
                            <?php if (!empty($policy->canUpdateNav())) : ?>
                                <a href="<?= route('insurance-nav-update-ulip.form', ['policy_id' => $policy->id, 'tbl_key' => LifeInsuranceUlip::$tablename]) ?>" class="btn btn-sm btn-primary">Update NAV</a>
                            <?php endif; ?>

                            <table class="table mt-2">
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('user_id') }}</th>
                                    <td>
                                        <a target="_blank" href="{{ route('client.show', $policy['user']['id'] ) }}">
                                            {{ $policy['user']['name'] }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('plan_name') }}</th>
                                    <td>{{ $policy['plan_name'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('investment_through') }}</th>
                                    <td>{{ Utils::setAmc($policy['investment_through']) }}</td>
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
                                    <td colspan="2">
                                        <table class="table">
                                            <tr>
                                                <th colspan="100%">
                                                    <?= LifeInsuranceUlip::attributes('premium_mode') ?>
                                                    <?php if ($policy->status == 'open' && !$death_benefits && $next) : ?>
                                                        <a href="{{ route('life-ulip.premium-mode.edit', ['policy_id'=>$policy->id] ) }}" class="btn btn-xs btn-warning float-right">Change Premium Mode</a>
                                                    <?php endif; ?>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><?= LifeInsuranceUlip::attributes('from_date') ?></th>
                                                <th><?= LifeInsuranceUlip::attributes('premium_mode') ?></th>
                                                <th><?= LifeInsuranceUlip::attributes('premium_amount') ?></th>
                                            </tr>
                                            <?php foreach ($policy['premiummode'] as $key => $value) : ?>
                                                <tr>
                                                    <td><?= Utils::getFormatedDate($value['from_date']) ?></td>
                                                    <td><?= LifeInsuranceUlip::setPremiumMode($value['premium_mode']) ?></td>
                                                    <td><?= $value['premium_amount'] ?> <?= config('app.currency') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <?php if ($policy->status == 'open' && !empty($policy['next_premium'])) : ?>
                                <a href="{{ route('insurance-premiums-ulip.create', ['policy_id'=>$policy->id,'tbl_key'=>LifeInsuranceUlip::$tablename] ) }}" class="btn btn-sm btn-success">
                                    Add Premium (<?= Utils::getFormatedDate($policy['next_premium']['date']) ?>)
                                </a>
                            <?php endif; ?>
                            <?php if ($policy->status == 'open') : ?>
                                <a href="{{ route('insurance-withdraw-ulip.form', ['policy_id'=>$policy->id,'tbl_key'=>LifeInsuranceUlip::$tablename] ) }}" class="btn btn-sm btn-primary float-right">
                                    Withdraw Units
                                </a>
                            <?php endif; ?>

                            <table class="table mt-2">
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('status') }}</th>
                                    <td style="text-transform: capitalize">
                                        <?= $policy['status'] ?>
                                        <br>
                                        <?php if ($policy['status'] == 'open') : ?>
                                            <a class="btn btn-xs btn-danger" href="<?= route('insurance-terminate-ulip.form', ['policy_id' => $policy['id'], 'tbl_key' => LifeInsuranceUlip::$tablename]) ?>">Terminate Policy</a>
                                        <?php endif; ?>
                                        <?php if ($policy->canSurrenderPolicy()) : ?>
                                            <a class="btn btn-xs btn-danger" href="<?= route('insurance-surrender-ulip.form', ['policy_id' => $policy['id'], 'tbl_key' => LifeInsuranceUlip::$tablename]) ?>">Surrender Policy</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('company_id') }}</th>
                                    <td>{{ $policy['company']['name']}} </td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('nav') }}</th>
                                    <td>{{ Utils::numberFormatedValue($policy['nav']) }} <?= config('app.currency') ?> </td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('units') }}</th>
                                    <td>{{ Utils::numberFormatedValue($policy['units']) }} </td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('sum_assured') }}</th>
                                    <td>{{ $policy['sum_assured'] }} <?= config('app.currency') ?> </td>
                                </tr>
                                <tr>
                                    <th>Started Date of Policy</th>
                                    <td><?= Utils::getFormatedDate($policy['issue_date']) ?></td>
                                </tr>

                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('last_premium_date') }}</th>
                                    <td><?= Utils::getFormatedDate($policy['last_premium_date']) ?> </td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceUlip::attributes('last_policy_term_date') }}</th>
                                    <td><?= Utils::getFormatedDate($policy['last_policy_term_date']) ?> </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('policy-document.view', ['tbl_key' => LifeInsuranceUlip::$tablename, 'type' => 'insurance-documents-ulip'])

<section class="content">
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col-md col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <h3>Premium History</h3>
                            <table class="table table-responsive table-bordered" id="type_table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th><?= PremiumMaster::attributes('premium_date') ?></th>
                                        <th>{{ PremiumMaster::attributes('paid_at') }}</th>
                                        <th>{{ PremiumMaster::attributes('amount') }}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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
<section class="content">
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col-md col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <h3>Unit History</h3>
                            <table class="table table-bordered text-right" id="withdraw_units_table">
                                <thead>
                                    <tr>
                                        <th class="text-left">Date</th>
                                        <th class="text-left"><?= LifeInsuranceUlipUnitHist::attributes('type') ?></th>
                                        <th><?= LifeInsuranceUlipUnitHist::attributes('nav') ?></th>
                                        <th><?= LifeInsuranceUlipUnitHist::attributes('units') ?></th>
                                        <th><?= LifeInsuranceUlipUnitHist::attributes('amount') ?></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($policy['withdraw'] as $key => $withdraw) : ?>
                                        <tr>
                                            <td class="text-left"><?= Utils::getFormatedDate($withdraw['added_at']) ?></td>
                                            <td class="text-left">
                                                <?= @LifeInsuranceUlipUnitHist::optionsForType()[$withdraw['type']] ?>
                                            </td>
                                            <td>
                                                <?= Utils::numberFormatedValue($withdraw['nav']) ?> <?= config('app.currency') ?>
                                            </td>
                                            <td><?= Utils::numberFormatedValue($withdraw['units']) ?></td>
                                            <td>
                                                <?= Utils::numberFormatedValue($withdraw['amount']) ?> <?= config('app.currency') ?>
                                            </td>
                                            <td>
                                                <?php if ($withdraw['type'] == 'withdraw' && !empty($withdraw['can_delete'])) : ?>
                                                    <?= Utils::deleteBtn(route('insurance-withdraw-ulip.destroy', [
                                                        'policy_id' => $policy->id, 'tbl_key' => LifeInsuranceUlip::$tablename, 'id' => $withdraw['id']
                                                    ])) ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col-md col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <h3>
                                Benefits
                                <?php if ($policy->status == 'open' && !PolicyBenefits::isDeathBenifitReceived($policy->id, LifeInsuranceUlip::$tablename)) : ?>
                                    <?php if (!PolicyBenefits::isMaturityBenifitReceived($policy->id, LifeInsuranceUlip::$tablename)) : ?>
                                        <a href="{{ route('insurance-benefits-ulip.create', ['policy_id'=>$policy->id,'tbl_key'=>LifeInsuranceUlip::$tablename,'benefit_type'=>'maturity_benefit']) }}" class="btn btn-sm btn-info float-right ml-3">Add {{Utils::setBenefitType('maturity_benefit')}}</a>
                                    <?php endif; ?>
                                    <a href="{{ route('insurance-benefits-ulip.create', ['policy_id'=>$policy->id,'tbl_key'=>LifeInsuranceUlip::$tablename,'benefit_type'=>'death_benefit']) }}" class="btn btn-sm btn-danger float-right ml-3">Add {{Utils::setBenefitType('death_benefit')}}</a>
                                <?php endif; ?>
                            </h3>
                            <table class="table table-responsive table-bordered" id="benefits">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th><?= PolicyBenefits::attributes('benefit_type') ?></th>
                                        <th>{{ PolicyBenefits::attributes('notes') }}</th>
                                        <th>{{ PolicyBenefits::attributes('received_at') }}</th>
                                        <th>{{ PolicyBenefits::attributes('amount') }}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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
    $(function() {
        $('#withdraw_units_table').DataTable()
        var t = $('#type_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= route('premium.ulip.data', ['policy_id' => $policy['id'], 'tbl_key' => LifeInsuranceUlip::$tablename]) ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'premium_date',
                    name: 'premium_date'
                },
                {
                    data: 'paid_at',
                    name: 'paid_at'
                },
                {
                    data: 'amount',
                    name: 'amount',
                    className: 'text-right'
                },
                {
                    data: 'action',
                    name: 'action'
                },

            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    if (column[0][0] == 0) {
                        var input = '';
                    } else {
                        var input = document.createElement("input");
                    }
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, false, true).draw();
                        });
                    t.on('order.dt search.dt', function() {
                        t.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                });
            }
        });
        var t = $('#benefits').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= route('benefits.ulip.data', ['policy_id' => $policy['id'], 'tbl_key' => LifeInsuranceUlip::$tablename]) ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'benefit_type',
                    name: 'benefit_type'
                },
                {
                    data: 'notes',
                    name: 'notes'
                },
                {
                    data: 'received_at',
                    name: 'received_at'
                },
                {
                    data: 'amount',
                    name: 'amount',
                    className: 'text-right'
                },
                {
                    data: 'action',
                    name: 'action'
                },

            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    if (column[0][0] == 0) {
                        var input = '';
                    } else {
                        var input = document.createElement("input");
                    }
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, false, true).draw();
                        });
                    t.on('order.dt search.dt', function() {
                        t.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                });
            }
        });
    });
</script>

@endpush