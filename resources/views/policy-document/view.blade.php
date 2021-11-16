<?php

use App\Utils;
use App\PolicyDocuments;
?>
<section class="content">
    <div class="container-fluid">
        <div>
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <div class="card card-default">
                        <div class="card-header">
                            Documents
                            <a href="<?= route($type . '.create', ['policy_id' => $policy->id, 'tbl_key' => $tbl_key]) ?>" class="btn btn-sm btn-success float-right">
                                Add Document
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <table class="table">
                                <tr>
                                    <th><?= PolicyDocuments::attributes('title') ?></th>
                                    <th><?= PolicyDocuments::attributes('notes') ?></th>
                                    <th class="text-right"><?= PolicyDocuments::attributes('document') ?></th>
                                </tr>
                                <?php $document = json_decode(json_encode($policy->documents), true); ?>
                                <?php if (!empty($document)) : ?>
                                    <?php foreach ($document as $key => $value) : ?>
                                        <tr>
                                            <td><?= $value['title'] ?></td>
                                            <td><?= $value['notes'] ?></td>
                                            <td class="text-right">
                                                <a href="<?= route($type . '.show', ['policy_id' => $policy->id, 'tbl_key' => $tbl_key, 'document' => $value['id']]) ?>" target="_blank">
                                                    <?= $value['document_name'] ?>
                                                </a>
                                                <?php $delete_link = $delete_link = route($type . '.destroy', ['policy_id' => $policy->id, 'tbl_key' => $tbl_key, 'document' => $value['id']]); ?>
                                                <?php $edit = ' <a href="' . route($type . '.edit', ['policy_id' => $policy->id, 'tbl_key' => $tbl_key, 'document' => $value['id']]) . '" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>'; ?>
                                                <?= $edit . Utils::deleteBtn($delete_link); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="100%">No Documents found.</td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>