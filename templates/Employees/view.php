<?php
$this->assign('title', 'View Employee');
?>

<div class="container py-5">
    <h3 class="text-center mb-3"><strong><?= __('View Employee') ?></strong></h3>
    <?= $this->Html->link(__('<i class="bi bi-caret-left-fill"></i>Back'), ['action' => 'index'], ['class' => 'btn btn-danger mb-3', 'escape' => false]) ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td><?= strtoupper(h($employee->name)) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= strtolower(h($employee->email)) ?></td>
                </tr>
                <tr>
                    <th>Mobile</th>
                    <td><?= h($employee->mobile) ?></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?= h($employee->gender) ?></td>
                </tr>
                <tr>
                    <th>DOB</th>
                    <td><?= date('d-m-Y', strtotime(h($employee->dob))) ?></td>
                </tr>
                <tr>
                    <th>State</th>
                    <td><?= h($employee->state->name) ?></td>
                </tr>
                <tr>
                    <th>District</th>
                    <td><?= h($employee->district->name) ?></td>
                </tr>
                <tr>
                    <th>Photo</th>
                    <td><a href="<?= $this->Url->build('/') ?>webroot/img/<?= h($employee->photo) ?>" target="_blank">View</a></td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td><?= date('d-m-Y h:i A', strtotime(h($employee->created_at))) ?></td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td><?= date('d-m-Y h:i A', strtotime(h($employee->updated_at))) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>