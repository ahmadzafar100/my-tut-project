<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login Page from github 1</title>

    <?= $this->Html->css('bootstrap.min') ?>
    <?= $this->Html->css('custom') ?>
    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css') ?>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
</head>

<body>
    <div class="container py-3">
        <div class="row py-3">
            <div class="col-md-5 col-sm-6 mx-auto py-3">
                <div class="card login">
                    <div class="card-header login-bg">Login <i class="bi bi-box-arrow-in-left"></i></div>
                    <div class="card-body">
                        <?= $this->Form->create() ?>
                        <div class="mb-3">
                            <?= $this->Flash->render() ?>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <div class="form-floating">
                                <?= $this->Form->control('email', ['class' => 'form-control', 'type' => 'text', 'required' => 'required', 'label' => 'Enter Email*', 'placeholder' => 'Enter Email*', 'templates' => [
                                    'inputContainer' => '{{content}}',
                                    'formGroup' => '{{input}}{{label}}'
                                ]]) ?>
                            </div>
                        </div>
                        <div class="input-group mb-0">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <div class="form-floating">
                                <?= $this->Form->control('password', ['class' => 'form-control', 'type' => 'password', 'required' => 'required', 'label' => 'Enter Password*', 'placeholder' => 'Enter Password*', 'templates' => [
                                    'inputContainer' => '{{content}}',
                                    'formGroup' => '{{input}}{{label}}'
                                ]]) ?>
                            </div>
                        </div>
                        <div class="mb-0 text-center">
                            <?= $this->Html->image(['controller' => 'Users', 'action' => 'get_captcha'], ['class' => 'w-50']) ?>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <div class="form-floating">
                                <?= $this->Form->control('captcha_code', ['class' => 'form-control', 'type' => 'text', 'required' => 'required', 'label' => 'Enter Captcha*', 'placeholder' => 'Enter Captcha*', 'templates' => [
                                    'inputContainer' => '{{content}}',
                                    'formGroup' => '{{input}}{{label}}'
                                ]]) ?>
                            </div>
                        </div>
                        <div class="d-grid">
                            <?= $this->Form->button('Login <i class="bi bi-box-arrow-in-left"></i>', ['class' => 'btn btn-dark btn-block', 'escapeTitle' => false]) ?>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Html->script('bootstrap.min') ?>
</body>

</html>
