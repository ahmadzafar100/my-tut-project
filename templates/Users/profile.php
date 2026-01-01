<?php $this->assign('title', 'Profile');  ?>

<div class="container py-5">
    <h3 class="text-center mb-3"><strong>My Profile</strong></h3>
    <?= $this->Form->create($user) ?>
    <?= $this->Flash->render() ?>
    <div class="row">
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('name', ['label' => 'Name', 'class' => 'form-control', 'required' => 'required']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control', 'required' => 'required']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('created_at', ['label' => 'Created At', 'class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('updated_at', ['label' => 'Updated At', 'class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('last_password_change_ip', ['label' => 'Last Password Change IP', 'class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('last_password_change_time', ['label' => 'Last Password Change Time', 'class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('last_login_ip', ['label' => 'Last Login IP', 'class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('last_login_time', ['label' => 'Last Login Time', 'class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('last_logout_ip', ['label' => 'Last Logout IP', 'class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('last_logout_time', ['label' => 'Last Logout Time', 'class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled']) ?>
        </div>
        <div class="col-md-12">
            <?= $this->Form->button('Update', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>