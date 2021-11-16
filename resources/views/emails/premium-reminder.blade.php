<?php

use App\PolicyMaster;

?>
<div>
    <p><b>Subject : <?= config('app.company_name') ?> – Premium Reminder - <?= $policy['plan_name'] ?></b></p>
    <p>Hello <?= !empty($policy['user_name']) ? $policy['user_name'] : @$policy['user_email'] ?>,</p>
    <br>
    <p>I hope you are doing well.</p>
    <p>I am contacting you on behalf of <?= config('app.company_name') ?> concerning the payment of next premium, which
        we sent on <b><?= date('d F, Y', strtotime($policy['premium_date'])) ?></b>. You can check policy details.
    </p>
    <p>I’m sure you are busy, but it would be great if you spare some time and look over the invoice when you get a
        chance. Please let me know in case of any questions.</p>
    <p>Thank You,</p>

    <center>
        <h3>Policy Details</h3>
    </center>
    <table border="1">
        <tr>
            <th>Company </th>
            <td><?= @$policy['company_name'] ?></td>
        </tr>
        <tr>
            <th>Plan Name </th>
            <td><?= @$policy['plan_name'] ?></td>
        </tr>
        <tr>
            <th>Policy No. </th>
            <td><?= @$policy['policy_no'] ?></td>
        </tr>
        <tr>
            <th>Premium Amount </th>
            <td><?= @$policy['premium_amount'] ?> <?= config('app.currency') ?></td>
        </tr>
        <tr>
            <th>Duration Of Policy</th>
            <td><?= @$policy['policy_term'] ?> Years</td>
        </tr>
        <tr>
            <th>Premium Mode </th>
            <td><?= PolicyMaster::setPremiumMode($policy['premium_mode']) ?></td>
        </tr>
    </table>

</div>
