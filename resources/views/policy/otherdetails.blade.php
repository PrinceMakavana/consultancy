<?php

use App\InsuranceField;
use App\MutualFundType;
use App\PolicyMaster;
use App\Utils;
?>
@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Policy Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('policy.index') }}"><?= Utils::titles('general_insurance') ?></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('policy.show', $policy['id']) }}">Policy : <?= $policy['policy_no'] ?></a></li>
                    <li class="breadcrumb-item active">Add Policy Details</li>
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
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('policy.store-details', $policy['id']) }}">
                            {{ csrf_field() }}

                            <?php if(!empty($fields)): ?> 
                                @include('layouts.form', ['form' => $fields])
                            <?php else: ?> 
                                <h3>No need to submit any details.</h3>
                            <?php endif; ?>

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

</section>

@endsection

@push('scripts')

@endpush