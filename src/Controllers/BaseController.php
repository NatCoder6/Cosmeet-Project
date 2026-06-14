<?php
// ============================================================
// COSMEET — Base Controller
// ============================================================
namespace Cosmeet\Controllers;

use Cosmeet\Core\Auth;

abstract class BaseController {

    protected function view(string $template, array $data = []): void {
        extract($data);
        $user  = Auth::user();
        $csrf  = Auth::generateCsrf();
        $flash = $this->getFlash();
        require VIEW_PATH . '/layouts/header.php';
        require VIEW_PATH . '/' . $template . '.php';
        require VIEW_PATH . '/layouts/footer.php';
    }

    protected function viewPartial(string $template, array $data = []): void {
        extract($data);
        require VIEW_PATH . '/' . $template . '.php';
    }

    protected function redirect(string $path, int $code = 302): void {
        header('Location: ' . APP_URL . $path, true, $code);
        exit;
    }

    protected function json(mixed $data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function flash(string $type, string $message): void {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    protected function getFlash(): ?array {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    protected function sanitize(string $input): string {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    protected function validateCsrf(): void {
        $token = $_POST[CSRF_TOKEN_NAME] ?? '';
        if (!Auth::verifyCsrf($token)) {
            http_response_code(403);
            exit('Invalid CSRF token.');
        }
    }
}
