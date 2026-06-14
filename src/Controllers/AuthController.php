<?php
// ============================================================
// COSMEET — Auth Controller
// ============================================================
namespace Cosmeet\Controllers;

use Cosmeet\Core\Auth;
use Cosmeet\Models\UserModel;

class AuthController extends BaseController {

    public function showRegister(): void {
        if (Auth::check()) $this->redirect('/dashboard');
        $this->view('auth/register', ['title' => 'Begin Your Journey — Cosmeet']);
    }

    public function register(): void {
        $this->validateCsrf();

        $firstName = $this->sanitize($_POST['first_name'] ?? '');
        $lastName  = $this->sanitize($_POST['last_name'] ?? '');
        $email     = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $password  = $_POST['password'] ?? '';
        $confirm   = $_POST['confirm_password'] ?? '';
        $phone     = $this->sanitize($_POST['phone'] ?? '');
        $nationality = $this->sanitize($_POST['nationality'] ?? '');

        $errors = [];
        if (!$firstName) $errors[] = 'First name is required.';
        if (!$lastName)  $errors[] = 'Last name is required.';
        if (!$email)     $errors[] = 'A valid email address is required.';
        if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
        if ($password !== $confirm) $errors[] = 'Passwords do not match.';

        $model = new UserModel();
        if ($email && $model->findByEmail($email)) $errors[] = 'This email is already registered.';

        if ($errors) {
            $this->view('auth/register', ['title' => 'Register', 'errors' => $errors, 'old' => $_POST]);
            return;
        }

        $userId = $model->create([
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'email'       => $email,
            'password'    => $password,
            'phone'       => $phone,
            'nationality' => $nationality,
        ]);

        $user = $model->findById($userId);
        Auth::login($user);
        $this->flash('success', 'Welcome to Cosmeet, ' . $firstName . '! Your space journey begins now.');
        $this->redirect('/dashboard');
    }

    public function showLogin(): void {
        if (Auth::check()) $this->redirect('/dashboard');
        $this->view('auth/login', ['title' => 'Mission Control — Cosmeet']);
    }

    public function login(): void {
        $this->validateCsrf();
        $email    = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        $model = new UserModel();
        $user  = $email ? $model->findByEmail($email) : null;

        if (!$user || !$model->verifyPassword($user, $password)) {
            $this->view('auth/login', [
                'title'  => 'Login',
                'errors' => ['Invalid email or password. Please try again.'],
                'old'    => ['email' => $email],
            ]);
            return;
        }

        if ($user['status'] === 'suspended') {
            $this->view('auth/login', [
                'title'  => 'Login',
                'errors' => ['Your account has been suspended. Contact mission control.'],
            ]);
            return;
        }

        Auth::login($user);
        $redirect = $_GET['redirect'] ?? '/dashboard';
        $this->redirect($redirect);
    }

    public function logout(): void {
        Auth::logout();
        $this->redirect('/');
    }
}
