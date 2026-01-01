<?php

declare(strict_types=1);

namespace App\Controller;

// use App\Controller\AppController;

use Cake\Event\EventInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

use App\Model\States;
use Cake\Mailer\Mailer;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 */
class EmployeesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    public function initialize(): void
    {
        parent::initialize();
        // $this->loadModel('States');
        $this->States = TableRegistry::getTableLocator()->get('States');
        $this->Districts = TableRegistry::getTableLocator()->get('Districts');
    }

    public function index()
    {
        try {
            $type = $this->request->getQuery('type');
            if ($type === 'activated') $isactive = 1;
            else $isactive = 0;

            $this->paginate = [
                'limit' => 10,
                'order' => ['Employees.id' => 'DESC']
            ];

            if ($this->request->is('post')) {
                if (isset($type)) {
                    $query = $this->Employees->find()
                        ->where([$this->request->getData('field') => $this->request->getData('value'), 'isactive' => $isactive]);
                    $count = $this->Employees->find()
                        ->where([$this->request->getData('field') => $this->request->getData('value'), 'isactive' => $isactive])->count();
                } else {
                    $query = $this->Employees->find()
                        ->where([$this->request->getData('field') => $this->request->getData('value')]);
                    $count = $this->Employees->find()
                        ->where([$this->request->getData('field') => $this->request->getData('value')])->count();
                }
            } else {
                if (isset($type)) {
                    $query = $this->Employees->find()->where(['isactive' => $isactive]);
                    $count = $this->Employees->find()->where(['isactive' => $isactive])->count();
                } else {
                    $query = $this->Employees->find();
                    $count = $this->Employees->find()->count();
                }
            }

            $this->viewBuilder()->setLayout('user');
            $employees = $this->paginate($query);
            $this->set(compact('employees', 'count'));
        } catch (NotFoundException $e) {
            return $this->redirect(['action' => 'index', '?' => ['page' => 1] + $this->request->getQuery()]);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $name = null)
    {
        $this->viewBuilder()->setLayout('user');
        // $employee = $this->Employees->get($id, contain: ['States', 'Districts']);
        $employee = $this->Employees->find()
            ->select($this->Employees)
            ->select(['Users.name', 'States.name', 'Districts.name'])
            ->join([
                'Users' =>
                [
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => 'Users.id = Employees.added_by'
                ]
            ])
            ->contain(['States', 'Districts'])
            ->where(['Employees.id' => $id])
            ->firstOrFail();
        $this->set(compact('employee'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('user');
        $states = $this->States->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])
            ->orderAsc('name')
            ->toArray();
        $employee = $this->Employees->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $photo = $this->request->getData('photo') ?? null;

            if ($photo && $photo->getError() === UPLOAD_ERR_OK) {
                $filename = $photo->getClientFileName();
                $ex = pathinfo($filename, PATHINFO_EXTENSION);
                $filename = time() . '.' . $ex;
                $photo->moveTo(WWW_ROOT . 'img' . DS . $filename);
                $data['photo'] = $filename;
            }
            $data['added_by'] = $this->request->getSession()->read('Auth.User.id');
            $employee = $this->Employees->patchEntity($employee, $data);
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $this->set(compact('employee', 'states'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('user');
        $employee = $this->Employees->get($id, contain: []);
        $states = $this->States->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])
            ->orderAsc('name')
            ->toArray();

        $districts = $this->Districts->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['state_id' => $employee->state_id])->orderAsc('name')->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $photo = $this->request->getData('photo') ?? null;
            if ($photo && $photo->getError() === UPLOAD_ERR_OK) {
                $filename = $photo->getClientFileName();
                $ex = pathinfo($filename, PATHINFO_EXTENSION);
                $filename = time() . '.' . $ex;
                $photo->moveTo(WWW_ROOT . 'img' . DS . $filename);
                $data['photo'] = $filename;
            } else {
                $data['photo'] = $employee->photo;
            }
            $employee = $this->Employees->patchEntity($employee, $data);
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $this->set(compact('employee', 'states', 'districts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employee = $this->Employees->get($id);
        if ($this->Employees->delete($employee)) {
            $this->Flash->success(__('The employee has been deleted.'));
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    function deactivate($id = null)
    {
        $employee = $this->Employees->get($id);
        $employee->isactive = 0;
        if ($this->Employees->save($employee)) {
            $this->Flash->success(__('The employee has been deactivated.'));
        } else {
            $this->Flash->error(__('The employee could not be deactivated. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    function activate($id = null)
    {
        $employee = $this->Employees->get($id);
        $employee->isactive = 1;
        if ($this->Employees->save($employee)) {
            $this->Flash->success(__('The employee has been activated.'));
        } else {
            $this->Flash->error(__('The employee could not be activated. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    function getDistricts()
    {
        // $this->viewBuilder()->disableAutoLayout();
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        $stateId = $this->request->getData('state_id');
        $districts = $this->Districts->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['state_id' => $stateId])->orderAsc('name')->toArray();

        echo '<option value="">Select District</option>';
        foreach ($districts as $id => $val) {
            echo '<option value="' . $id . '">' . $val . '</option>';
        }
    }

    function sendEmail()
    {
        $this->viewBuilder()->setLayout('user');

        if ($this->request->is('post')) {
            $to = $this->request->getData('to');
            $subject = $this->request->getData('subject');
            $message = $this->request->getData('message');

            $mailer = new Mailer('default'); // use the "default" profile

            $mailer
                ->setFrom(['ahmadzafar100@gmail.com' => 'ahmadzafar100@gmail.com'])
                ->setTo($to)
                ->setSubject($subject)
                ->deliver($message);

            $this->Flash->success('Email sent successfully!');
            return $this->redirect(['action' => 'sendEmail']);
        }
    }
}
