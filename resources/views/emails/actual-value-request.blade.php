<?php

use App\PolicyMaster;

?>
<div>
    <p><b>Subject : <?= config('app.company_name') ?> – Regarding your request - <?= $details->ulip->plan_name ?></b></p>
    <p>Hi <?= !empty($details->client['name']) ? $details->client['name'] : @$details->client['email'] ?>,</p>
    <br>
    <p>I hope you are doing well.</p>
    <p>Current value is <?= $details->actual_value ?>, and NAV is <?= $details->actual_nav ?></p>
    <p>Thank You,</p>

    <center>
        <h3>Policy Details</h3>
    </center>
    <table border="1">
        <tr>
            <th>Plan Name </th>
            <td><?= @$details->ulip['plan_name'] ?></td>
        </tr>
        <tr>
            <th>Policy No. </th>
            <td><?= @$details->ulip['policy_no'] ?></td>
        </tr>
        <tr>
            <th>Current value </th>
            <td><?= @$details->actual_value ?> <?= config('app.currency') ?></td>
        </tr>
        <tr>
            <th>Units </th>
            <td><?= @$details->actual_units ?></td>
        </tr>
        <tr>
            <th>NAV </th>
            <td><?= @$details->actual_nav ?> <?= config('app.currency') ?></td>
        </tr>
        <tr>
            <th>Duration Of Policy</th>
            <td><?= @$details->ulip['policy_term'] ?> Years</td>
        </tr>
    </table>

</div>