<?php

use App\MutualFundUser;
use App\User;
use App\UserDocument;
use App\MutualFundInvestmentHist;
use App\UserSipInvestement;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Client : {{$client['name']}} [{{$client['id']}}]</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>
                    <li class="breadcrumb-item active">Client : {{$client['name']}}[{{$client['id']}}]</li>
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
                            <?= Utils::successAndFailMessage() ?>
                            <a href="{{route('client.edit', $client['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            <?= Utils::deleteBtn(route('client.destroy', $client['id'])) ?>
                            <a href="{{route('client.change-password', $client['id'])}}" class="btn btn-sm btn-warning">Change Password</a>
                            <a href="{{route('client.person-detail.user-document', [$client['id'], $client['id']])}}" class="btn btn-sm btn-primary">Upload Document</a>
                            <img src="{{ User::getProfileImg($client['profile']) }}" style="width: 100px" class="rounded-circle shadow float-right">
                            <div class="row">
                                <table class="col-lg-6 table mt-2">
                                    <tr>
                                        <th>{{ User::attributes('name') }}</th>
                                        <td>{{ $client['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ User::attributes('email') }}</th>
                                        <td>{{ $client['email'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ User::attributes('birthdate') }}</th>
                                        <td>{{ Utils::getFormatedDate($client['birthdate']) }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ User::attributes('mobile_no') }}</th>
                                        <td>{{ $client['mobile_no'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ User::attributes('pan_no') }}</th>
                                        <td>{{ $client['pan_no'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ User::attributes('status') }}</th>
                                        <td>{{ Utils::setStatus($client['status']) }}</td>
                                    </tr>
                                </table>
                                <table class="col-lg-6 table mt-2">
                                    @foreach($userDocuments as $doc)
                                    <tr>
                                        <td>
                                            <p><b>{{ $doc['title'] }}</b></p>
                                        </td>
                                        <td>
                                            <a href="{{ UserDocument::getUserDoc($doc['document']) }}" target="_blank" class="btn btn-sm btn-success">
                                                View
                                            </a>
                                            <?= Utils::deleteBtn(route('userdocument.destroy', $doc['id'])) ?>
                                        </td>
                                    </tr>
                                    @endforeach

                                </table>
                                <table class="col-lg-6 table mt-2">
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Persons -->
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="card card-default">
                <div class="card-header">
                    Persons
                    <a href="<?= route('person.create', ['client_id' => $client['id']]) ?>" class="btn btn-sm btn-success float-right">Add</a>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-bordered" id="client_persons">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
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
</section>

<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="card card-default">
                <div class="card-body">
                    <?= Utils::getFilterSelectElement($persons, 'id="select_person" class="w-100"') ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Goal Plan Mutual Fund -->
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-header">Goal Plans : <b>Mutual Funds</b></div>
                        <div class="card-body">
                            <table class="table table-responsive table-bordered" id="goal_user_tbl">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th><?= MutualFundUser::attributes('start_date') ?></th>
                                        <th><?= MutualFundUser::attributes('folio_no') ?></th>
                                        <th><?= MutualFundUser::attributes('matual_fund_id') ?></th>
                                        <th><?= MutualFundUser::attributes('invested_amount') ?></th>
                                        <th>Plan | Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Goal Plan Insurance -->
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-header">Goal Plans : <b>Insurance</b></div>
                        <div class="card-body">
                            <table class="table table-responsive table-bordered" id="goal_user_insurance_tbl">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Plan</th>
                                        <th>Policy Number</th>
                                        <th>Plan | Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Matual Fund -->
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-header">Mutual Funds</div>
                        <div class="card-body">
                            <table class="table table-responsive table-bordered" id="mutual_fund_user_tbl">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th><?= MutualFundUser::attributes('start_date') ?></th>
                                        <th><?= MutualFundUser::attributes('folio_no') ?></th>
                                        <th><?= MutualFundUser::attributes('matual_fund_id') ?></th>
                                        <th><?= MutualFundUser::attributes('invested_amount') ?></th>
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
<!-- Insurance -->
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-header">Insurance Policies</div>
                        <div class="card-body">
                            <table class="table table-responsive table-bordered" id="insurance_policy_user_tbl">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Type</th>
                                        <th>Plan</th>
                                        <th>Policy Number</th>
                                        <!-- <th>Installment Amount</th>
                                        <th>Due Date</th> -->
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
        var mft = $('#mutual_fund_user_tbl').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= route('client.muFund', $client['id']) ?>?person_ids=<?= $person_id ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'folio_no',
                    name: 'folio_no'
                },
                {
                    data: 'mutual_fund_name',
                    name: 'mutual_fund_name'
                },
                {
                    data: 'invested_amount',
                    name: 'invested_amount',
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
                    var input = "";
                    if (column[0][0] == 0) {
                        input = '';
                    } else if (column[0][0] == 5) {
                        input = '';
                    } else {
                        input = '<input type="text" style="width:100%">';
                    }
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    mft.on('order.dt search.dt', function() {
                        mft.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                });
            }
        });
        var t = $('#client_persons').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= route('person.data', ['client_id' => $client['id']]) ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: '_status',
                    name: '_status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = "";
                    if (column[0][0] == 0) {
                        input = '';
                    } else if (column[0][0] == 2) {
                        input = `<?= single_quote(Utils::getFilterSelectElement(Utils::getStatus())) ?>`;
                    } else {
                        input = '<input type="text" style="width:100%">';
                    }
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, true).draw();
                        });
                });
            }
        });
    });
    $(document).ready(function() {

        <?php if (!empty(request()->route()->parameters['person_id'])) : ?>
            $('#select_person').val(<?= request()->route()->parameters['person_id'] ?>);
        <?php endif; ?>
        $('#select_person').select2().on('change', function(e) {
            if ($('#select_person').val()) {
                window.location.href = '<?= route('client.person-detail', ['id' => $client->id, 'person_id' => '']) ?>/' + $('#select_person').val()
            } else {
                window.location.href = '<?= route('client.show', ['id' => $client->id]) ?>'
            }
        });

        var row = "";

        var gut = $('#goal_user_tbl').DataTable({
            searching: false,
            lengthChange: false,
            processing: true,
            serverSide: true,
            ajax: '<?= route('client.goalPlan', $client['id']) ?>?person_ids=<?= $person_id ?>',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'folio_no',
                    name: 'folio_no'
                },
                {
                    data: 'mutual_fund_name',
                    name: 'mutual_fund_name'
                },
                {
                    data: 'invested_amount',
                    name: 'invested_amount'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = "";
                    if (column[0][0] == 0) {
                        input = '';
                    } else if (column[0][0] == 2) {
                        input = `<?= single_quote(Utils::getFilterSelectElement(Utils::getStatus())) ?>`;
                    } else {
                        input = '<input type="text" style="width:100%">';
                    }
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    gut.on('order.dt search.dt', function() {
                        gut.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                });
            }
        });


        var goali = $('#goal_user_insurance_tbl').DataTable({
            searching: false,
            lengthChange: false,
            processing: true,
            serverSide: true,
            ajax: '<?= route('client.goalPlanInsurance', $client['id']) ?>?person_ids=<?= $person_id ?>',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'plan_name',
                    name: 'plan_name'
                },
                {
                    data: 'policy_no',
                    name: 'policy_no'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            initComplete: function() {
                function drawInit() {
                    if ($('#filter_type').val()) {
                        $('#insurance_policy_user_tbl tfoot input').show()
                    } else {
                        $('#insurance_policy_user_tbl tfoot input').hide()
                    }
                }
                this.api().columns().every(function() {
                    var column = this;
                    var input = "";
                    if (column[0][0] == 0) {
                        input = '';
                    } else if (column[0][0] == 1) {
                        input = `<?= single_quote(Utils::getFilterSelectElement(Utils::optionForPolicyType(), 'id="filter_type"')) ?>`;;
                    } else {
                        input = '<input type="text" style="width:100%">';
                    }
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    drawInit()
                });
                goali.on('draw', drawInit);
            }
        });

        var ipt = $('#insurance_policy_user_tbl').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= route('client.insurance-polices', $client['id']) ?>?person_ids=<?= $person_id ?>',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'plan_name',
                    name: 'plan_name'
                },
                {
                    data: 'policy_no',
                    name: 'policy_no'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            initComplete: function() {
                function drawInit() {
                    if ($('#filter_type').val()) {
                        $('#insurance_policy_user_tbl tfoot input').show()
                    } else {
                        $('#insurance_policy_user_tbl tfoot input').hide()
                    }
                }
                this.api().columns().every(function() {
                    var column = this;
                    var input = "";
                    if (column[0][0] == 0) {
                        input = '';
                    } else if (column[0][0] == 1) {
                        input = `<?= single_quote(Utils::getFilterSelectElement(Utils::optionForPolicyType(), 'id="filter_type"')) ?>`;;
                    } else {
                        input = '<input type="text" style="width:100%">';
                    }
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    drawInit()
                });
                ipt.on('draw', drawInit);
            }
        });

    });

    function setUserFundToPlan(url, plan_id, user_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'PUT',
            data: {
                plan_id: plan_id.value,
                user_id: user_id
            },
            complete: function() {
                alert("Plan changed successfully !!");
            }
        })
    }
</script>
@endpush