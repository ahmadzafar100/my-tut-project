<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?></title>

    <meta name="csrf-token" content="<?= $this->request->getAttribute('csrfToken') ?>">

    <?= $this->Html->css('bootstrap.min') ?>
    <?= $this->Html->css('custom') ?>
    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css') ?>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,regular,500,600,700,800,900,300italic,italic,500italic,600italic,700italic,800italic,900italic" rel="stylesheet" />

    <?= $this->Html->script('bootstrap.bundle.min') ?>
    <?= $this->Html->script('jquery') ?>
    <?= $this->Html->script('counter') ?>
</head>

<body>
    <?php
    $session = $this->request->getSession();
    $userName = $session->read('Auth.User.name');
    $userRole = $session->read('Auth.User.role');
    ?>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $this->Url->build('/') ?>dashboards/home"><strong><i class="bi bi-cake2"></i> CakePHP 5</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->Url->build('/') ?>dashboards/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->Url->build('/') ?>employees/add">Add</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">View</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= $this->Url->build('/') ?>employees/">View All</a></li>
                            <li><a class="dropdown-item" href="<?= $this->Url->build('/') ?>employees/?type=activated">View Activated</a></li>
                            <li><a class="dropdown-item" href="<?= $this->Url->build('/') ?>employees/?type=deactivated">View Deactivated</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->Url->build('/') ?>employees/send-email">Send Email</a>
                    </li>
                    <?php if ($userRole === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->Url->build('/') ?>users/manage_users">Manage User</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="ms-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link disabled" href="#">
                                <i class="bi bi-calendar"></i>
                                <span id="date">--</span>
                            </a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link disabled" href="#">
                                <i class="bi bi-clock"></i>
                                <span id="time">--:--:--</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown dropstart">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-person-circle"></i> My Account</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <h5 class="dropdown-header"><i class="bi bi-emoji-smile"></i> Hey, <?= $userName ?></h5>
                                </li>
                                <li><a class="dropdown-item" href="<?= $this->Url->build('/') ?>users/profile"><i class="bi bi-person"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="<?= $this->Url->build('/') ?>users/change_password"><i class="bi bi-key"></i> Change Password</a></li>
                                <li><a class="dropdown-item" href="<?= $this->Url->build('/') ?>users/logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <?= $this->fetch('content') ?>

    <script>
        // Formats: 12-hour time with seconds; full date in Indian style
        const timeFmt = new Intl.DateTimeFormat('en-IN', {
            timeZone: 'Asia/Kolkata',
            hour: 'numeric',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        });

        // Example full date: Wednesday, 13 August 2025
        const longDateFmt = new Intl.DateTimeFormat('en-IN', {
            timeZone: 'Asia/Kolkata',
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        // If you strictly want 13/08/2025 style, use this instead:
        const shortDateFmt = new Intl.DateTimeFormat('en-IN', {
            timeZone: 'Asia/Kolkata',
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });

        const elTime = document.getElementById('time');
        const elDate = document.getElementById('date');

        function tick() {
            const now = new Date();
            elTime.textContent = timeFmt.format(now);
            // Choose one line below depending on your preferred date style:
            // elDate.textContent = longDateFmt.format(now); // e.g., Wednesday, 13 August 2025
            // elDate.textContent = shortDateFmt.format(now); // e.g., 13/08/2025

            // Format date manually as dd-mm-yyyy
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const year = now.getFullYear();
            elDate.textContent = `${day}/${month}/${year}`;
        }

        tick(); // initial paint
        setInterval(tick, 1000); // update every second

        setTimeout(() => {
            const alerts = document.querySelectorAll(".alert-primary");
            alerts.forEach(alertBox => alertBox.remove());
        }, 5000);
    </script>
</body>

</html>