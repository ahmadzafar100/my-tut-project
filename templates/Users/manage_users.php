<?php $this->assign('title', 'Manage Users') ?>

<div class="container py-5">
    <h3 class="text-center mb-3"><strong>Manage Users</strong></h3>
    <?= $this->Flash->render() ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr class="table-light">
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($users as $user): ?>
                    <tr>
                        <td><?= $i++ ?>.</td>
                        <td><?= $user->name ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= ucfirst($user->role) ?></td>
                        <td>
                            <?php
                            if ($user->role == 'admin') {
                                if ($user->isactive == 1) {
                                    echo '<span class="badge bg-success">Active</span>';
                                } else {
                                    echo '<span class="badge bg-danger">Inactive</span>';
                                }
                            } else {
                                if ($user->isactive == 1) {
                                    echo $this->Html->link('Active', ['action' => 'inactive', $user->id], ['class' => 'badge bg-success', 'title' => 'Click to Inactive']);
                                } else {
                                    echo $this->Html->link('Inactive', ['action' => 'active', $user->id], ['class' => 'badge bg-danger', 'title' => 'Click to Active']);
                                }
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>