<?php
// ============================================================
// COSMEET — Payment Controller
// ============================================================
namespace Cosmeet\Controllers;

use Cosmeet\Core\Auth;
use Cosmeet\Core\Database;
use Cosmeet\Models\ReservationModel;

class PaymentController extends BaseController {

    public function show(string $code): void {
        Auth::requireLogin();
        $model = new ReservationModel();
        $res   = $model->findByCode($code);
        if (!$res) { $this->redirect('/dashboard'); }
        $user  = Auth::user();
        if ($res['user_id'] != $user['id'] && !Auth::isAdmin()) { $this->redirect('/dashboard'); }

        $this->view('payment/checkout', [
            'title'       => 'Complete Payment — Cosmeet',
            'reservation' => $res,
        ]);
    }

    public function process(): void {
        Auth::requireLogin();
        $this->validateCsrf();
        $code  = $this->sanitize($_POST['reservation_code'] ?? '');
        $model = new ReservationModel();
        $res   = $model->findByCode($code);

        if (!$res) { $this->redirect('/dashboard'); }

        // Simulate payment processing
        $db   = Database::getInstance();
        $txId = 'TXN-' . strtoupper(bin2hex(random_bytes(8)));
        $db->execute(
            "INSERT INTO payments (reservation_id, transaction_id, amount_usd, payment_method, status, paid_at)
             VALUES (?,?,?,'simulation','completed', NOW())",
            [$res['id'], $txId, $res['price_usd']]
        );
        $model->confirmPayment($res['id']);

        // Timeline update
        $db->execute(
            "INSERT INTO journey_timelines (user_id, reservation_id, event_type, title, description, event_date, status, icon)
             VALUES (?,?,?,?,?,NOW(),?,?)",
            [$res['user_id'], $res['id'], 'payment_confirmed',
             'Payment Confirmed',
             'Payment of $' . number_format($res['price_usd'], 2) . ' confirmed. Transaction: ' . $txId,
             'completed', 'check-circle']
        );

        // Store txId in session so receipt() can verify ownership even if the
        // redirect query fails to find the row immediately (race-condition guard).
        $_SESSION['last_txn'] = $txId;

        $this->redirect('/receipt/' . $txId);
    }

    public function receipt(string $txId): void {
        Auth::requireLogin();
        $user = Auth::user();
        $db   = Database::getInstance();

        // Sanitise the txId from the URL — only allow the characters we generate
        $txId = preg_replace('/[^A-Z0-9\-]/', '', strtoupper($txId));

        $pay = $db->fetchOne(
            "SELECT p.*, r.reservation_code, r.user_id,
                    m.title AS mission_title, m.launch_date, m.destination,
                    s.name  AS spacecraft_name,
                    u.first_name, u.last_name, u.email
             FROM payments p
             JOIN reservations r ON r.id   = p.reservation_id
             JOIN missions     m ON m.id   = r.mission_id
             JOIN spacecraft   s ON s.id   = m.spacecraft_id
             JOIN users        u ON u.id   = r.user_id
             WHERE p.transaction_id = ?",
            [$txId]
        );

        // If the row wasn't found, redirect gracefully instead of showing an error page
        if (!$pay) {
            $this->flash('error', 'Receipt not found. Your payment was recorded — check your reservations.');
            $this->redirect('/my-reservations');
        }

        // Ownership check — only the paying user or an admin may view the receipt
        if ($pay['user_id'] != $user['id'] && !Auth::isAdmin()) {
            $this->redirect('/dashboard');
        }

        $this->view('payment/receipt', [
            'title'   => 'Mission Confirmed — Cosmeet',
            'payment' => $pay,
        ]);
    }
}