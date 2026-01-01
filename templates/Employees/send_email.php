<?php $this->assign('title', 'Send Email'); ?>

<div class="container py-3">
    <?= $this->Form->create() ?>
    <h3 class="text-center mb-3"><strong><?= __('Send Email') ?></strong></h3>
    <?= $this->Flash->render() ?>
    <div class="row">
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('to', ['label' => 'To*', 'type' => 'email', 'class' => 'form-control', 'required' => true]) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('subject', ['label' => 'Subject*', 'class' => 'form-control', 'required' => true]) ?>
        </div>
        <div class="col-md-8 col-sm-8 mb-3">
            <?= $this->Form->control('message', ['label' => 'Message*', 'type' => 'textarea', 'rows' => '5', 'class' => 'form-control', 'required' => true]) ?>
        </div>
        <!-- <div class="col-md-4 col-sm-6 mb-3"></div> -->
        <div class="col-md-12">
            <?= $this->Form->button('Send', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>