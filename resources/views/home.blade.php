<?php

use App\Utils;

$unique_user = array();
foreach ($missed_instalments as $m) {
  $user[] = $m['user_name'];
}
$unique_user = array_count_values($user);
$unique_instalments = array();
$instalments_user = [];
foreach ($instalments as $i) {
  $instalments_user[] = $i['user_name'];
}
$unique_instalments = array_count_values($instalments_user);

?>
@extends('layouts.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= $clients ?></h3>
            <p>Total Active Clients</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= $active_sips ?></h3>
            <p>Active SIPs</p>
          </div>
          <div class="icon">
            <i class="fas fa-chart-bar"></i>
          </div>
          {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= count($missed_instalments) ?></h3>

            <p>Missed Installments</p>
          </div>
          <div class="icon">
            <i class="fas fa-calendar-day"></i>
          </div>
          {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <?php if (!empty($missed_instalments)) : ?>
          <div class="card">
            <div class="card-header border-0 bg-danger">
              <h3 class="card-title"><b>Missed Installments to Pay</b></h3>
            </div>
            <div class="card-body">
              <table class="table table-striped table-valign-middle" id="missedInstalments">
                <thead>
                  <tr>
                    <th>Due date</th>
                    <th>Client</th>
                    <th>Counts</th>
                    <th>Fund</th>
                    <th>Folio no.</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <?php foreach ($unique_user as $key => $user_count) : ?>
                    <?php for ($k = 0; $k < sizeof($missed_instalments); $k++) : ?>
                      <?php if ($missed_instalments[$k]['user_name'] == $key) : ?>
                        <tr>
                          <td>
                            <a class="badge bg-primary" href="<?= route('user-sip.show', $missed_instalments[$k]['id']) ?>"><i class="fas fa-eye"></i></a>
                            <?= Utils::getFormatedDate($missed_instalments[$k]['duedate']) ?>
                          </td>
                          <td> <?= $missed_instalments[$k]['user_name'] ?></td>
                          <td> <?= $user_count ?></td>
                          <td> <?= $missed_instalments[$k]['fund_name'] ?> </td>
                          <td> <?= $missed_instalments[$k]['folio_no'] ?> </td>
                        </tr>
                        <?php break; ?>
                      <?php endif; ?>
                    <?php endfor; ?>
                  <?php endforeach; ?>

                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title"><b>Installments to Pay</b></h3>
          </div>
          <div class="card-body">
            <table class="table table-striped table-valign-middle" id="instalments">
              <thead>
                <tr>
                  <th>Due date</th>
                  <th>Client</th>
                  <th>Counts</th>
                  <th>Fund</th>
                  <th>Folio no.</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($unique_instalments as $key => $instalment_count) : ?>
                    <?php for ($k = 0; $k < sizeof($instalments); $k++) : ?>
                      <?php if ($instalments[$k]['user_name'] == $key) : ?>
                        <tr>
                          <td>
                            <a class="badge bg-primary" href="<?= route('user-sip.show', $instalments[$k]['id']) ?>"><i class="fas fa-eye"></i></a>
                            <?= Utils::getFormatedDate($instalments[$k]['duedate']) ?>
                          </td>
                          <td> <?= $instalments[$k]['user_name'] ?></td>
                          <td> <?= $instalment_count ?></td>
                          <td> <?= $instalments[$k]['fund_name'] ?> </td>
                          <td> <?= $instalments[$k]['folio_no'] ?> </td>
                        </tr>
                        <?php break; ?>
                      <?php endif; ?>
                    <?php endfor; ?>
                  <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@stop

@push('scripts')
<script>
  $(document).ready(function() {
    $('#missedInstalments').DataTable({
      "aaSorting": []
    });
    $('#instalments').DataTable({
      "aaSorting": []
    });
  });
</script>
@endpush