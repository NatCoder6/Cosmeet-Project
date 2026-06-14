<?php
// ============================================================
// COSMEET — Session & Auth Helper
// ============================================================
namespace Cosmeet\Core;

class Auth {

    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'secure'   => false, // set true on HTTPS
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }
    }

    public static function login(array $user): void {
        session_regenerate_id(true);
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_uuid'] = $user['uuid'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name']  = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name']  = $user['last_name'];
        $_SESSION['user_email']= $user['email'];
    }

    public static function logout(): void {
        session_unset();
        session_destroy();
    }

    public static function check(): bool {
        return !empty($_SESSION['user_id']);
    }

    public static function user(): ?array {
        if (!self::check()) return null;
        return [
            'id'         => $_SESSION['user_id'],
            'uuid'       => $_SESSION['user_uuid'],
            'role'       => $_SESSION['user_role'],
            'name'       => $_SESSION['user_name'],
            'email'      => $_SESSION['user_email'],
            'first_name' => $_SESSION['first_name'] ?? '',
            'last_name'  => $_SESSION['last_name']  ?? '',
        ];
    }

    public static function isAdmin(): bool {
        return ($_SESSION['user_role'] ?? '') === 'admin';
    }

    public static function requireLogin(): void {
        if (!self::check()) {
            header('Location: ' . APP_URL . '/login?redirect=' . urlencode($_SERVER['REQUEST_URI']));
            exit;
        }
    }

    public static function requireAdmin(): void {
        self::requireLogin();
        if (!self::isAdmin()) {
            http_response_code(403);
            exit('Forbidden');
        }
    }

    // CSRF
    public static function generateCsrf(): string {
        if (empty($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }

    public static function verifyCsrf(string $token): bool {
        return hash_equals($_SESSION[CSRF_TOKEN_NAME] ?? '', $token);
    }

    public static function csrfField(): string {
        return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . self::generateCsrf() . '">';
    }
}
