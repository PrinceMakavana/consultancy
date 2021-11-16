<?php

use App\MutualFundUser;
use App\UserPlan;
use App\UserPlanSip;
use App\Utils;
use App\User;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Plan </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('plan.index') }}">User Plan</a>
                    </li>
                    <li class="breadcrumb-item active">User : {{$plan['user']['name']}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="container">
            {{Utils::successAndFailMessage()}}
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-body">
                        <a href="{{route('plan.edit', $plan['id'])}}" class="btn btn-sm btn-primary">Edit</a>
                            <?php $delete_link = route('plan.destroy', $plan->id);
                                $delete = Utils::deleteBtn($delete_link);
                                echo $delete ;
                                $years = UserPlan::getYears($plan['start_at'], $plan['end_at']);
                            ?>
                            <table class="table mt-2">
                                <tr>
                                    <th>{{ UserPlan::attributes('type') }}</th>
                                    <td><?= UserPlan::setPlanType($plan['type'])['title'] ?></td>
                                </tr>
                                <tr>
                                    <th>{{ UserPlan::attributes('user_id') }}</th>
                                    <td>
                                        <a href="{{route('client.show', $plan['user_id'])}}" target="_blank">{{ $plan['user']['name'] }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ UserPlan::attributes('target_amount') }}</th>
                                    <td>{{ $plan['target_amount'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ UserPlan::attributes('return_rate') }}</th>
                                    <td>{{ $plan['return_rate'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ UserPlan::attributes('start_at') }}</th>
                                    <td>{{ Utils::getFormatedDate($plan['start_at']) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ UserPlan::attributes('years') }}</th>
                                    <td><?= $years['years_view'] ?></td>
                                </tr>
                                <tr>
                                    <th>{{ UserPlan::attributes('remaining') }}</th>
                                    <td><?= $years['remaining_view'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
