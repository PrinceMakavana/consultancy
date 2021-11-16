<?php

use App\Utils;
use App\InsuranceField;
use App\MutualFundType;
use App\LifeInsuranceUlip;
use App\InsuranceFieldDetail;
use App\UlipActualValueRequest;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Actual Value Request</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-ulip.index') }}">User Ulip Insurance</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('life-insurance-ulip.actual-value-request.index') }}">Actual Value Requests</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('life-insurance-ulip.show', ['policy_id' => $model->ulip->id] ) }}">
                            <?= $model->ulip['policy_no'] ?>
                        </a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <th><?= UlipActualValueRequest::attributes('policy_id') ?></th>
                                    <td>
                                        <?= $model->ulip['plan_name'] ?>
                                        <br>
                                        <?= $model->ulip['policy_no'] ?>
                                        <br>
                                        <a target="_blank" class="btn btn-sm btn-success" href="{{ route('life-insurance-ulip.show', ['policy_id' => $model->ulip->id] ) }}">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?= UlipActualValueRequest::attributes('request_by') ?></th>
                                    <td><?= $model->client->name ?></td>
                                </tr>
                                <tr>
                                    <th><?= UlipActualValueRequest::attributes('created_at') ?></th>
                                    <td><?= Utils::getFormatedDate($model->created_at) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if (!$model->canSendDetails()) : ?>
                        <div class="alert alert-secondary">
                            <?php $date = Utils::getFormatedDate($model->getStatusDate($model->status)); ?>
                            <?= Utils::updateMessage(UlipActualValueRequest::$responseMsg['status_msg'], ['status' => $model->status, 'date' => $date]) ?>
                        </div>
                    <?php endif; ?>

                    <div class="card card-default">
                        <div class="card-body">


                            <?php if (in_array($model->status, ['requested', 'done'])) : ?>
                                <table class="table table-sm">

                                    <tr>
                                        <th><?= UlipActualValueRequest::attributes('actual_units') ?></th>
                                        <td><?= $model->actual_units ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= UlipActualValueRequest::attributes('actual_value') ?></th>
                                        <td><?= $model->actual_value ?></td>
                                    </tr>
                                    <tr>
                                        <th><?= UlipActualValueRequest::attributes('actual_nav') ?></th>
                                        <td><?= $model->actual_nav ?></td>
                                    </tr>
                                </table>
                            <?php endif; ?>

                            <?php if ($model->canSendDetails()) : ?>
                                <form class="d-inline-block" method="POST" action="<?= route('life-insurance-ulip.actual-value-request.update', $model->id) ?>">
                                    {{ csrf_field() }}
                                    {{method_field('PUT')}}
                                    <?php
                                    $fields = [
                                        [
                                            [
                                                'name' => 'actual_units',
                                                'type' => 'hidden',
                                                'label' => UlipActualValueRequest::attributes('actual_units'),
                                                'value' => $model->actual_units,
                                                'col' => 12
                                            ],
                                            [
                                                'name' => 'actual_value',
                                                'type' => 'hidden',
                                                'label' => UlipActualValueRequest::attributes('actual_value'),
                                                'value' => $model->actual_value,
                                                'col' => 12
                                            ],
                                            [
                                                'name' => 'actual_nav',
                                                'type' => 'hidden',
                                                'label' => UlipActualValueRequest::attributes('actual_nav'),
                                                'value' => $model->actual_nav,
                                                'col' => 12
                                            ],
                                        ],
                                    ];
                                    ?>
                                    <div class="d-none">
                                        @include('layouts.form', ['form' => $fields])
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            Send Details
                                        </button>
                                    </div>
                                </form>

                                <?= Utils::deleteBtn(route('life-insurance-ulip.actual-value-request.destroy', $model->id), 'Cancel') ?>
                                <a target="_blank" href="<?= route('insurance-nav-update-ulip.form', ['policy_id' => $model->ulip->id, 'tbl_key' => LifeInsuranceUlip::$tablename]) ?>" class="btn btn-sm btn-secondary float-right">
                                    Update NAV</a>
                            <?php endif; ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')
<script>
    $('#state').on('change', function(e) {
        console.log(e);
        var state_id = e.target.value;

        $.get('{{ url('
            information ') }}/create/ajax-state?state_id=' + state_id,
            function(data) {
                console.log(data);
                $('#city').empty();
                $.each(data, function(index, subCatObj) {
                    $('#city').append('' + subCatObj.name + '');
                });
            });
    });


    var $disabledResults = $("#user_id");
    $disabledResults.select2();


    var $disabledResults = $("#company_id");
    $disabledResults.select2();

    var $disabledResults = $("#category_id");
    $disabledResults.select2();

    var $disabledResults = $("#sub_category_id");
    $disabledResults.select2();

    var $disabledResults = $("#insurance_field_id");
    $disabledResults.select2();
</script>
@endpush