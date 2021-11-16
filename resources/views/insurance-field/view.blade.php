<?php

use App\InsuranceField;
use App\InsuranceFieldDetail;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$field['name']}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('field.index') }}">Insurance Fields</a></li>
                    <li class="breadcrumb-item active">{{$field['name']}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="card card-default">
                    <div class="card-header">
                        {{Utils::successAndFailMessage()}}

                        <a href="{{route('field.edit', $field['id'])}}" class="btn btn-sm btn-primary">Edit</a>

                        {!! Utils::deleteBtn(route('field.destroy', $field['id'])) !!}
                    </div>
                    <div class="card-body p-0">

                        <div class="row m-0">
                            <table class="col-lg-6 table">
                                <tr>
                                    <th>{{ InsuranceField::attributes('name') }}</th>
                                    <td>{{ $field['name'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ InsuranceField::attributes('benefit_name') }}</th>
                                    <td>{{ $field['benefit_name'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ InsuranceField::attributes('status') }}</th>
                                    <td>{{ Utils::setStatus($field['status']) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ InsuranceField::attributes('has_multiple_benefits') }}</th>
                                    <td><?= InsuranceField::valueForHasMultipleBenefits($field['has_multiple_benefits']) ?></td>
                                </tr>
                            </table>
                            <div class="col-lg-6">
                                <img src="<?= $field->image ?>" style="height: 100px; float:right">
                                <table class="table">
                                    <tr>
                                        <th>{{ InsuranceField::attributes('updated_at') }}</th>
                                        <td>{{ $field['updated_at'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ InsuranceField::attributes('created_at') }}</th>
                                        <td>{{ $field['created_at'] }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-md-offset-2">
                <div class="card">
                    <div class="card-header">
                        <h5>Fields for Insurance
                            <a href="{{ route('field.field-detail.create', ['field' => $field->id]) }}" class="float-right btn btn-sm btn-success">Add</a>
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive table-bordered" id="field_table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><?= InsuranceFieldDetail::attributes('fieldname') ?></th>
                                    <th><?= InsuranceFieldDetail::attributes('type') ?></th>
                                    <th><?= InsuranceFieldDetail::attributes('is_required') ?></th>
                                    <th><?= InsuranceFieldDetail::attributes('options') ?></th>
                                    <th><?= InsuranceFieldDetail::attributes('status') ?></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($field_details as $key => $value) : ?>
                                    <tr>
                                        <td></td>
                                        <td><?= $value['fieldname'] ?></td>
                                        <td><?= $value['type'] ?></td>
                                        <td><?= $value['is_required'] ?></td>
                                        <td><?= $value['options'] ?></td>
                                        <td><?= Utils::setStatus($value['status']) ?></td>
                                        <td>
                                            <?php
                                            $edit = ' <a href="' . route('field.field-detail.edit', ['field' => $value->insurance_field_id, 'field_detail' => $value->id]) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                                            $delete_link = route('field.field-detail.destroy', ['field' => $value->insurance_field_id, 'field_detail' => $value->id]);
                                            $delete = Utils::deleteBtn($delete_link);
                                            ?>
                                            <?= $edit . $delete ?>
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
</section>


@endsection

@push('scripts')
<script>
    $(function() {
        var t = $('#field_table').DataTable({
            rowReorder: true,
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [1, 'asc']
            ]
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
</script>
@endpush