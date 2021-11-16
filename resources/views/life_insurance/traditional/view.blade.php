<?php

use App\Utils;
use App\PremiumMaster;
use App\PolicyBenefits;
use App\LifeInsuranceTraditional;

$death_benefits = PolicyBenefits::isDeathBenifitReceived($policy->id, LifeInsuranceTraditional::$tablename);
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= Utils::titles('life_traditional_insurance') ?> : <?= $policy['policy_no'] ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-traditional.index') }}"><?= Utils::titles('life_traditional_insurance') ?></a>
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
            <?php endif; ?>

            <?php if ($policy->status == 'open' && empty($death_benefit) &&  $policy['is_policy_statement_done'] != 1) : ?>
                <div class="alert alert-danger">Confirm Assured Payout Details
                    <a class="badge badge-success p-2 float-right" href="<?= route('life-traditional.assured-payouts.create', ['policy_id' => $policy['id']]) ?>">Confirm</a>
                </div>
            <?php endif; ?>
            <?php if ($policy->status == 'open' && !empty($death_benefit)) : ?>
                <div class="alert alert-danger">
                    Received Death Benefits on <?= Utils::getFormatedDate($death_benefit['received_at']) ?>
                    <?php if ($policy->status == 'open') : ?>
                        <a class="badge float-right badge-success p-2" href="<?= route('life-insurance-traditional.change-status', ['policy' => $policy->id, 'status' => 'close']) ?>">
                            Close Policy
                        </a>
                    <?php endif; ?>
                </div>
            <?php elseif ($policy->status == 'open' && $next) : ?>
                <div class="alert alert-success">
                    <?= $next[0]['type'] == 'premium' ? 'Premium' : Utils::getBenefitType()[$next[0]['type']] ?>
                    On <?= Utils::getFormatedDate($next[0]['date']) ?>
                </div>
            <?php elseif ($policy->status == 'open') : ?>
                <div class="alert alert-danger">
                    All done.
                    <a class="badge float-right badge-success p-2" href="<?= route('life-insurance-traditional.change-status', ['policy' => $policy->id, 'status' => 'complete']) ?>">
                        Complete Policy
                    </a>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">

                            <?php
                            $delete_link = route('life-insurance-traditional.destroy', $policy->id);
                            $delete = Utils::deleteBtn($delete_link);
                            echo $delete;
                            ?>
                            <a href="{{ route('life-insurance-traditional.statement', ['policy_id'=>$policy->id] ) }}" class="btn btn-sm btn-success">View Statement</a>

                            <?php if ($policy->status == 'open' && !$death_benefits && $next) : ?>
                                <a class="badge badge-success p-2 float-right" href="<?= route('life-traditional.assured-payouts.create', ['policy_id' => $policy['id']]) ?>">Assured Payouts</a>
                            <?php endif; ?>

                            <table class="table mt-2">
                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('user_id') }}</th>
                                    <td>{{ $policy['user']['name'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('plan_name') }}</th>
                                    <td>{{ $policy['plan_name'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('investment_through') }}</th>
                                    <td>{{ Utils::setAmc($policy['investment_through']) }}</td>
                                </tr>

                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('policy_no') }}</th>
                                    <td>{{ $policy['policy_no'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('policy_term') }}</th>
                                    <td>{{ $policy['policy_term'] }} Year</td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('permium_paying_term') }}</th>
                                    <td>{{ $policy['permium_paying_term'] }} Year</td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <table class="table">
                                            <tr>
                                                <th colspan="100%">
                                                    {{ LifeInsuranceTraditional::attributes('premium_mode') }}
                                                    <?php if ($policy->status == 'open' && !$death_benefits && $next) : ?>
                                                        <a href="{{ route('life-traditional.premium-mode.edit', ['policy_id'=>$policy->id] ) }}" class="btn btn-xs float-right btn-warning">Change Premium Mode</a>
                                                    <?php endif; ?>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th><?= LifeInsuranceTraditional::attributes('from_date') ?></th>
                                                <th><?= LifeInsuranceTraditional::attributes('premium_mode') ?></th>
                                                <th><?= LifeInsuranceTraditional::attributes('premium_amount') ?></th>
                                            </tr>
                                            <?php foreach ($policy['premiummode'] as $key => $value) : ?>
                                                <tr>
                                                    <td><?= Utils::getFormatedDate($value['from_date']) ?></td>
                                                    <td><?= LifeInsuranceTraditional::setPremiumMode($value['premium_mode']) ?></td>
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
                                <a href="{{ route('insurance-premiums-traditional.create', ['policy_id'=>$policy->id,'tbl_key'=>LifeInsuranceTraditional::$tablename] ) }}" class="btn btn-sm btn-success">
                                    Add Premium (<?= Utils::getFormatedDate($policy['next_premium']['date']) ?>)
                                </a>
                            <?php endif; ?>

                            <table class="table mt-2">
                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('status') }}</th>
                                    <td style="text-transform: capitalize">
                                        {{ $policy['status'] }}
                                        <br>
                                        <?php if ($policy['status'] == 'open') : ?>
                                            <a class="btn btn-xs btn-danger" href="<?= route('insurance-terminate-traditional.form', ['policy_id' => $policy['id'], 'tbl_key' => LifeInsuranceTraditional::$tablename]) ?>">Terminate Policy</a>
                                        <?php endif; ?>
                                        <?php if ($policy->canSurrenderPolicy()) : ?>
                                            <a class="btn btn-xs btn-danger" href="<?= route('insurance-surrender-ulip.form', ['policy_id' => $policy['id'], 'tbl_key' => LifeInsuranceTraditional::$tablename]) ?>">Surrender Policy</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('company_id') }}</th>
                                    <td>{{ $policy['company']['name']}} </td>
                                </tr>

                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('sum_assured') }}</th>
                                    <td>{{ $policy['sum_assured']}} <?= config('app.currency') ?> </td>
                                </tr>

                                <tr>
                                    <th>Started Date of Policy</th>
                                    <td>{!! Utils::getFormatedDate($policy['issue_date']) !!}</td>
                                </tr>

                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('last_premium_date') }}</th>
                                    <td>{!! Utils::getFormatedDate(@$policy['last_premium']['date']) !!} </td>
                                </tr>
                                <tr>
                                    <th>{{ LifeInsuranceTraditional::attributes('last_policy_term_date') }}</th>
                                    <td>{!! Utils::getFormatedDate($policy['last_policy_term_date']) !!} </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('policy-document.view', ['tbl_key' => LifeInsuranceTraditional::$tablename, 'type' => 'insurance-documents-traditional'])

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
                            <h3>
                                Benefits
                                <?php if ($policy->status == 'open' && !PolicyBenefits::isDeathBenifitReceived($policy->id, LifeInsuranceTraditional::$tablename)) : ?>
                                    <?php if (!PolicyBenefits::isMaturityBenifitReceived($policy->id, LifeInsuranceTraditional::$tablename)) : ?>
                                        <a href="{{ route('insurance-benefits-traditional.create', ['policy_id'=>$policy->id,'tbl_key'=>LifeInsuranceTraditional::$tablename,'benefit_type'=>'maturity_benefit']) }}" class="btn btn-sm btn-info float-right ml-3">Add {{Utils::setBenefitType('maturity_benefit')}}</a>
                                        <?php if (!empty($policy['next_assured'])) : ?>
                                            <a href="{{ route('insurance-benefits-traditional.create', ['policy_id'=>$policy->id,'tbl_key'=>LifeInsuranceTraditional::$tablename,'benefit_type'=>'assured_benefit']) }}" class="btn btn-sm btn-success float-right ml-3">
                                                Add {{Utils::setBenefitType('assured_benefit')}}
                                                (<?= Utils::getFormatedDate($policy['next_assured']['date']) ?>)
                                            </a>
                                        <?php endif; ?>
                                        <a href="{{ route('insurance-benefits-traditional.create', ['policy_id'=>$policy->id,'tbl_key'=>LifeInsuranceTraditional::$tablename,'benefit_type'=>'death_benefit']) }}" class="btn btn-sm btn-danger float-right ml-3">Add {{Utils::setBenefitType('death_benefit')}}</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </h3>
                            <table class="table table-responsive table-bordered" id="benefits">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>{{ PolicyBenefits::attributes('date') }}</th>
                                        <th>{{ PolicyBenefits::attributes('benefit_type') }}</th>
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
        var t = $('#type_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: `<?= route('premium.data', ['policy_id' => $policy['id'], 'tbl_key' => LifeInsuranceTraditional::$tablename]) ?>`,
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
            ajax: '<?= route('benefits.data', ['policy_id' => $policy['id'], 'tbl_key' => LifeInsuranceTraditional::$tablename]) ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'date',
                    name: 'date'
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