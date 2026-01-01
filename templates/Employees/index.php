<?php
$this->assign('title', 'Employee List');

$this->Paginator->setTemplates([
    'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'current' => '<li class="page-item active"><span class="page-link">{{text}}</span></li>',
    'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'prevDisabled' => '<li class="page-item disabled"><span class="page-link">{{text}}</span></li>',
    'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'nextDisabled' => '<li class="page-item disabled"><span class="page-link">{{text}}</span></li>',
    'first' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'last' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
]);
?>
<div class="container py-3">
    <h3 class="text-center mb-3"><strong><?= __('Employees List') ?></strong></h3>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
    <div class="row mb-3">
        <div class="col-md-7">
            <?= $this->Html->link(__('<i class="bi bi-plus"></i> Add New'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm', 'escapeTitle' => false]) ?>
        </div>
        <div class="col-md-5 text-end">
            <div class="input-group">
                <?= $this->Form->control('field', ['templates' => ['inputContainer' => '{{content}}'], 'options' => ['name' => 'Search By Name', 'email' => 'Search By Email', 'mobile' => 'Search By Mobile', 'dob' => 'Search By DOB', 'gender' => 'Search By Gender'], 'label' => false, 'id' => 'typebox', 'class' => 'form-select form-select-sm']) ?>

                <?= $this->Form->control('value', ['templates' => ['inputContainer' => '{{content}}'], 'label' => false, 'class' => 'form-control form-control-sm', 'id' => 'textbox', 'placeholder' => 'Search...', 'required' => 'required']) ?>
                <?= $this->Form->control('value', ['templates' => ['inputContainer' => '{{content}}'], 'label' => false, 'class' => 'form-control form-control-sm', 'id' => 'dobbox', 'type' => 'date', 'min' => '1950-01-01', 'max' => '2000-12-31', 'placeholder' => 'Search...', 'style' => 'display:none']) ?>
                <?= $this->Form->control('value', ['templates' => ['inputContainer' => '{{content}}'], 'label' => false, 'class' => 'form-select form-select-sm', 'id' => 'genbox', 'options' => ['Male' => 'Male', 'Female' => 'Female'], 'style' => 'display:none']) ?>

                <?= $this->Form->button('<i class="bi bi-search"></i> Search', ['templates' => ['inputContainer' => '{{content}}'], 'class' => 'btn btn-success btn-sm', 'escapeTitle' => false]) ?>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr class="table-light">
                    <th><?= __('S.No.') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('mobile') ?></th>
                    <th><?= $this->Paginator->sort('gender') ?></th>
                    <th><?= $this->Paginator->sort('dob') ?></th>
                    <th><?= $this->Paginator->sort('photo') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if ($count > 0):
                    foreach ($employees as $employee):
                ?>
                        <tr>
                            <td><?= $this->Number->format($i++) ?>.</td>
                            <td><?= strtoupper(h($employee->name)) ?></td>
                            <td><?= strtolower(h($employee->email)) ?></td>
                            <td><?= h($employee->mobile) ?></td>
                            <td><?= h($employee->gender) ?></td>
                            <td><?= date('d-m-Y', strtotime(h($employee->dob))) ?></td>
                            <td><a href="<?= $this->Url->build('/') ?>webroot/img/<?= h($employee->photo) ?>" target="_blank">View</a></td>
                            <td><?= date('d-m-Y h:i A', strtotime(h($employee->created_at))) ?></td>
                            <td><?= date('d-m-Y h:i A', strtotime(h($employee->updated_at))) ?></td>
                            <td class="actions">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><?= $this->Html->link(__('<i class="bi bi-eye"></i> View'), ['action' => 'view', $employee->id], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
                                        <li><?= $this->Html->link(__('<i class="bi bi-pencil-square"></i> Edit'), ['action' => 'edit', $employee->id], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
                                        <li>
                                            <?= $this->Form->postLink(
                                                __('<i class="bi bi-trash"></i> Delete'),
                                                ['action' => 'delete', $employee->id],
                                                ['class' => 'dropdown-item', 'escapeTitle' => false],
                                                [
                                                    'method' => 'delete',
                                                    'confirm' => __('Are you sure you want to delete # {0}?', $employee->id),
                                                ]
                                            ) ?>
                                        </li>
                                        <li>
                                            <?php
                                            if ($employee->isactive) :
                                                echo $this->Html->link(__('<i class="bi bi-ban"></i> Deactivate'), ['action' => 'deactivate', $employee->id], ['class' => 'dropdown-item', 'escapeTitle' => false]);
                                            else:
                                                echo $this->Html->link(__('<i class="bi bi-check2"></i> Activate'), ['action' => 'activate', $employee->id], ['class' => 'dropdown-item', 'escapeTitle' => false]);
                                            endif;
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                else:
                    ?>
                    <tr>
                        <td colspan="10">
                            <h5 class="text-danger text-uppercase text-center mb-0"><strong>No Data Found...</strong></h5>
                        </td>
                    </tr>
                <?php
                endif;
                ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="paginator">
                <ul class="pagination pagination-sm">
                    <?= $this->Paginator->first('<<') ?>
                    <?= $this->Paginator->prev('<') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('>') ?>
                    <?= $this->Paginator->last('>>') ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 text-sm-end">
            <p class="text-sm"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#typebox').change(function() {
            let type = $(this).val();
            if (type == 'name' || type == 'email' || type == 'mobile') {
                $('#textbox').css('display', 'block');
                $('#textbox').attr('name', 'value');
                $('#textbox').attr('required', 'required');

                $('#genbox').css('display', 'none');
                $('#genbox').attr('name', '');
                $('#genbox').removeAttr('required');

                $('#dobbox').css('display', 'none');
                $('#dobbox').attr('name', '');
                $('#dobbox').removeAttr('required');
            } else if (type == 'dob') {
                $('#textbox').css('display', 'none');
                $('#textbox').attr('name', '');
                $('#textbox').removeAttr('required');

                $('#genbox').css('display', 'none');
                $('#genbox').attr('name', '');
                $('#genbox').removeAttr('required');

                $('#dobbox').css('display', 'block');
                $('#dobbox').attr('name', 'value');
                $('#dobbox').attr('required', 'required');
            } else {
                $('#textbox').css('display', 'none');
                $('#textbox').attr('name', '');
                $('#textbox').removeAttr('required');

                $('#genbox').css('display', 'block');
                $('#genbox').attr('name', 'value');
                $('#genbox').attr('required', 'required');

                $('#dobbox').css('display', 'none');
                $('#dobbox').attr('name', '');
                $('#dobbox').removeAttr('required');
            }
        })
    });
</script>