<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $this->viewBuilder()->disableAutoLayout();
        if ($this->request->is('post')) {
            if ($this->request->getData('captcha_code') == $this->request->getSession()->read('captcha_code')) {
                $user = $this->Users->find()->where(['email' => $this->request->getData('email'), 'password' => $this->request->getData('password')]);
                if ($user->count() > 0) {
                    $user = $user->first();
                    if ($user->isactive == 1) {
                        $user->last_login_ip = $this->request->clientIp();
                        $user->last_login_time = date('Y-m-d H:i:s');
                        $this->Users->save($user);
                        $session = $this->request->getSession();
                        $session->write('Auth.User.id', $user->id);
                        $session->write('Auth.User.name', $user->name);
                        $session->write('Auth.User.role', $user->role);
                        $this->Flash->info(__('Welcome <strong>' . $this->request->getSession()->read('Auth.User.name') . '</strong> <i class="bi bi-emoji-sunglasses"></i>'), ['escape' => false]);
                        return $this->redirect(['controller' => 'Dashboards', 'action' => 'home']);
                    } else {
                        $this->Flash->error(__('Your credential has been blocked.'));
                    }
                } else {
                    $this->Flash->error(__('Invalid user details. Please, try again.'));
                }
            } else {
                $this->Flash->error(__('Invalid captcha.'));
            }
        }
    }

    function logout()
    {
        $session = $this->request->getSession();
        $userId = $session->read('Auth.User.id');
        if ($userId) {
            $user = $this->Users->get($userId);
            $user->last_logout_ip = $this->request->clientIp();
            $user->last_logout_time = date('Y-m-d H:i:s');
            $this->Users->save($user);
            $session->delete('Auth.User.id');
            $session->delete('Auth.User.name');
            $session->delete('Auth.User.role');
        }
        $this->Flash->success(__('<i class="bi bi-check2"></i> Logout Successfully.'), ['escape' => false]);
        return $this->redirect(['action' => 'login']);
    }

    function profile()
    {
        $this->viewBuilder()->setLayout('user');
        $session = $this->request->getSession();
        $id = $session->read('Auth.User.id');
        $user = $this->Users->get($id);
        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Profile Updated.'));
                return $this->redirect(['action' => 'profile']);
            } else {
                $this->Flash->error(__('Profile Not Updated.'));
            }
        }
        $this->set(compact('user'));
    }

    function changePassword()
    {
        $this->viewBuilder()->setLayout('user');
        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $session = $this->request->getSession();
            $id = $session->read('Auth.User.id');
            $user = $this->Users->get($id);
            if ($user->password != $data['current_password']) {
                $this->Flash->error('Invalid current password correct.');
            } elseif ($data['new_password'] != $data['confirm_password']) {
                $this->Flash->error('Password confirmation failed.');
            } elseif ($user->password == $data['new_password']) {
                $this->Flash->error('New password couldn\'t not be same as current password.');
            } else {
                $user->password = $data['new_password'];
                $user->last_password_change_ip = $this->request->clientIp();
                $user->last_password_change_time = date('Y-m-d H:i:s');
                if ($this->Users->save($user)) {
                    $session->delete('Auth.User.id');
                    $session->delete('Auth.User.name');
                    $this->Flash->success('Password changed. Login with new password.');
                    return $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error('Failed to change password.');
                }
            }
        }
    }

    function manageUsers()
    {
        $this->viewBuilder()->setLayout('user');
        $users = $this->Users->find()->all();
        $this->set(compact('users'));
    }

    function inactive($id = null)
    {
        $user = $this->Users->get($id);
        $user->isactive = 0;
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been inactive.'));
        } else {
            $this->Flash->error(__('The user could not be inactive. Please, try again.'));
        }
        return $this->redirect(['action' => 'manage_users']);
    }

    function active($id = null)
    {
        $user = $this->Users->get($id);
        $user->isactive = 1;
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been active.'));
        } else {
            $this->Flash->error(__('The user could not be active. Please, try again.'));
        }
        return $this->redirect(['action' => 'manage_users']);
    }

    /* public function getCaptcha()
    {
        // Disable automatic template rendering
        $this->viewBuilder()->disableAutoLayout();

        $width = 150;
        $height = 50;
        $font_size = 18;
        $font = WWW_ROOT . 'tahomabd.ttf'; // Ensure font file exists in webroot

        $chars_length = 6;
        $captcha_characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // Create image
        $image = imagecreatetruecolor($width, $height);
        $bg_color = imagecolorallocate($image, 25, 34, 156);
        $font_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);

        // Add background noise lines
        $vert_line = (int) round($width / 5);
        $color = imagecolorallocate($image, 227, 223, 223);
        for ($i = 0; $i < $vert_line; $i++) {
            imageline(
                $image,
                rand(0, $width),
                rand(0, $height),
                rand(0, $height),
                rand(0, $width),
                $color
            );
        }

        $text_pos = $height / 2 + $font_size / 2;
        $xw = ($width / $chars_length);
        $font_gap = $xw / 2 - $font_size / 2;
        $token = '';

        // Draw characters
        for ($i = 0; $i < $chars_length; $i++) {
            $letter = $captcha_characters[rand(0, strlen($captcha_characters) - 1)];
            $token .= $letter;
            $x = ($i === 0 ? 0 : $xw * $i);
            imagettftext(
                $image,
                $font_size,
                rand(-20, 20),
                (int) round($x + $font_gap), // FIX: cast to int
                (int) round($text_pos),      // FIX: cast to int
                $font_color,
                $font,
                $letter
            );
        }

        // Store captcha code in session
        $this->request->getSession()->write('captcha_code', $token);

        // Capture PNG output
        ob_start();
        imagepng($image);
        imagedestroy($image);
        $imageData = ob_get_clean();

        // Return as CakePHP response
        return $this->response
            ->withType('png')
            ->withStringBody($imageData);
    } */

    function getCaptcha()
    {
        $this->autoRender = false;

        // Generate two random numbers
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $operator = '+'; // Fixed to addition only

        // Calculate the result
        $result = $num1 + $num2;

        // Store the result in the session for validation
        $this->getRequest()->getSession()->write('captcha_code', $result);

        // Create a blank image
        $width = 150;
        $height = 50;
        $image = imagecreatetruecolor($width, $height);

        // Allocate colors
        $bgColor = imagecolorallocate($image, 255, 255, 255); // White background
        $textColor = imagecolorallocate($image, 0, 0, 0); // Black text
        $lineColor = imagecolorallocate($image, 150, 150, 150); // Gray noise lines

        // Fill the background
        imagefill($image, 0, 0, $bgColor);

        // Add some noise lines
        // for ($i = 0; $i < 5; $i++) {
        //     imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
        // }

        // CAPTCHA question
        $captchaText = "{$num1} + {$num2} = ?";

        // Add the math question
        imagestring($image, 5, 30, 15, $captchaText, $textColor);

        // Clear output buffer
        if (ob_get_length()) {
            ob_end_clean();
        }

        // Set response type to image/png
        $this->response = $this->response->withType('image/png');

        // Output the image
        imagepng($image);

        // Free memory
        imagedestroy($image);

        return $this->response;
    }
}
