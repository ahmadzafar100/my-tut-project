<?php
$this->assign('title', 'Dashboard');
?>

<div class="container py-3">
    <?= $this->Flash->render() ?>
    <div class="row dashboard">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card">
                <div class="card-header bg-grad text-white text-center"><strong>Employees Total</strong></div>
                <div class="card-body">
                    <h1 class="text-center"><strong><span class="counter"><?= $total ?></span></strong></h1>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card">
                <div class="card-header bg-grad text-white text-center"><strong>Employees Activated</strong></div>
                <div class="card-body">
                    <h1 class="text-center"><strong><span class="counter"><?= $active ?></span></strong></h1>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card">
                <div class="card-header bg-grad text-white text-center"><strong>Employees Deactivated</strong></div>
                <div class="card-body">
                    <h1 class="text-center"><strong><span class="counter"><?= $deactive ?></span></strong></h1>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card">
                <div class="card-header bg-grad text-white text-center"><strong>Total Users</strong></div>
                <div class="card-body">
                    <h1 class="text-center"><strong><span class="counter"><?= $totalU ?></span></strong></h1>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card">
                <div class="card-header bg-grad text-white text-center"><strong>Activated Users</strong></div>
                <div class="card-body">
                    <h1 class="text-center"><strong><span class="counter"><?= $activeU ?></span></strong></h1>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card">
                <div class="card-header bg-grad text-white text-center"><strong>Deactivated Users</strong></div>
                <div class="card-body">
                    <h1 class="text-center"><strong><span class="counter"><?= $deactiveU ?></span></strong></h1>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card">
                <div class="card-header bg-grad text-white text-center"><strong>Total Admins</strong></div>
                <div class="card-body">
                    <h1 class="text-center"><strong><span class="counter"><?= $adminU ?></span></strong></h1>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card">
                <div class="card-header bg-grad text-white text-center"><strong>Total General Users</strong></div>
                <div class="card-body">
                    <h1 class="text-center"><strong><span class="counter"><?= $generalU ?></span></strong></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /* let box = new CountUp('.counter', 8137);
    if (!box.error) {
        box.start();
    } else {
        console.error(box.error);
    } */
</script>