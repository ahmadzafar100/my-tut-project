<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

/**
 * Dashboards Controller
 *
 */
class DashboardsController extends AppController
{
    public function index()
    {
        $query = $this->Dashboards->find();
        $dashboards = $this->paginate($query);

        $this->set(compact('dashboards'));
    }

    function home()
    {
        $this->viewBuilder()->setLayout('user');
        $Employees = $this->fetchTable('Employees');
        $total = $Employees->find()->count();
        $active = $Employees->find()->where(['isactive' => 1])->count();
        $deactive = $Employees->find()->where(['isactive' => 0])->count();

        $Users = $this->fetchTable('Users');
        $totalU = $Users->find()->count();
        $activeU = $Users->find()->where(['isactive' => 1])->count();
        $deactiveU = $Users->find()->where(['isactive' => 0])->count();
        $adminU = $Users->find()->where(['role' => 'admin'])->count();
        $generalU = $Users->find()->where(['role' => 'user'])->count();

        $this->set(compact('total', 'active', 'deactive', 'totalU', 'activeU', 'deactiveU', 'adminU', 'generalU'));
    }
}
