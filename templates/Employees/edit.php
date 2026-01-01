<?php $this->assign('title', 'Edit Employee Data'); ?>

<style>
    .error-message {
        color: red;
        font-size: 80%;
    }
</style>

<div class="container py-5">
    <?= $this->Form->create($employee, ['type' => 'file']) ?>
    <h3 class="text-center mb-3"><strong>Edit Employee Data</strong></h3>
    <?= $this->Flash->render() ?>
    <div class="row">
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('name', ['label' => 'Name*', 'class' => 'form-control']) ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('email', ['label' => 'Email*', 'class' => 'form-control', 'type' => 'email']); ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('mobile', ['label' => 'Mobile*', 'class' => 'form-control', 'type' => 'tel']); ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('gender', ['label' => 'Gender*', 'empty' => 'Select Gender', 'options' => ['Male' => 'Male', 'Female' => 'Female'], 'class' => 'form-select']); ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('dob', ['label' => 'DOB*', 'class' => 'form-control', 'type' => 'date', 'min' => '1950-01-01', 'max' => '2000-12-31']); ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('state_id', ['label' => 'State*', 'empty' => 'Select State', 'options' => $states, 'class' => 'form-select', 'id' => 'state_id']); ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('district_id', ['label' => 'District*', 'empty' => 'Select District', 'options' => $districts, 'class' => 'form-select', 'id' => 'district_id']); ?>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <?= $this->Form->control('photo', ['label' => 'Photo', 'class' => 'form-control', 'type' => 'file']); ?>
            <a style="font-size: 80%;" href="<?= $this->Url->build('/') . 'webroot/img/' . $employee->photo ?>" target="_blank">View Photo</a>
        </div>
        <div class="col-md-12 mb-3">
            <?= $this->Form->button('Submit', ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-danger', 'escape' => false]) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<script>
    $(document).ready(function() {
        $('#state_id').change(function() {
            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build(['controller' => 'Employees', 'action' => 'get_districts']) ?>',
                data: {
                    'state_id': $(this).val(),
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') // ✅ Correct header name
                },
                success: function(r) {
                    $('#district_id').html(r);
                }
            })
        })
    })
</script>