<?php
$this->assign('title', 'Change Password');
?>

<div class="container py-5">
    <h3 class="text-center mb-3"><strong>Change Password</strong></h3>
    <?= $this->Form->create() ?>
    <?= $this->Flash->render() ?>
    <div class="row">
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('current_password', ['label' => 'Current Password*', 'type' => 'password', 'class' => 'form-control', 'required' => 'required']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('new_password', ['label' => 'New Password*', 'type' => 'password', 'class' => 'form-control', 'required' => 'required']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('confirm_password', ['label' => 'Confirm Password*', 'type' => 'password', 'class' => 'form-control', 'required' => 'required']) ?>
        </div>
        <div class="col-md-12">
            <?= $this->Form->button('Change', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>