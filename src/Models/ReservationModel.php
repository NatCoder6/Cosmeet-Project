<?php
// ============================================================
// COSMEET — Reservation Model
// ============================================================
namespace Cosmeet\Models;

use Cosmeet\Core\Database;

class ReservationModel {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create(int $userId, int $missionId, string $specialRequests = ''): array|false {
        $mission = (new MissionModel())->findById($missionId);
        if (!$mission) return false;
        if ($mission['seats_available'] <= 0) return false;

        // Check not already reserved
        $existing = $this->db->fetchOne(
            'SELECT id FROM reservations WHERE user_id=? AND mission_id=? AND status != "cancelled"',
            [$userId, $missionId]
        );
        if ($existing) return false;

        $this->db->beginTransaction();
        try {
            $code = $this->generateCode();
            $this->db->execute(
                'INSERT INTO reservations (reservation_code, user_id, mission_id, special_requests)
                 VALUES (?,?,?,?)',
                [$code, $userId, $missionId, $specialRequests]
            );
            $resId = (int)$this->db->lastInsertId();
            // Increment seats
            $this->db->execute(
                'UPDATE missions SET seats_reserved = seats_reserved + 1 WHERE id=?',
                [$missionId]
            );
            // Timeline entry
            $this->db->execute(
                'INSERT INTO journey_timelines (user_id, reservation_id, event_type, title, description, event_date, status, icon)
                 VALUES (?,?,?,?,?,?,?,?)',
                [$userId, $resId, 'mission_selected', 'Mission Selected: ' . $mission['title'],
                 'You have reserved a seat aboard ' . $mission['spacecraft_name'] . '.',
                 date('Y-m-d H:i:s'), 'completed', 'satellite']
            );
            $this->db->commit();
            return ['id' => $resId, 'code' => $code];
        } catch (\Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function getUserReservations(int $userId): array {
        return $this->db->fetchAll(
            "SELECT r.*, m.title, m.destination, m.launch_date, m.price_usd, m.slug,
                    s.name AS spacecraft_name
             FROM reservations r
             JOIN missions m ON m.id = r.mission_id
             JOIN spacecraft s ON s.id = m.spacecraft_id
             WHERE r.user_id = ? ORDER BY r.created_at DESC",
            [$userId]
        );
    }

    public function getAll(int $page = 1): array {
        $offset = ($page - 1) * PER_PAGE;
        return $this->db->fetchAll(
            "SELECT r.*, u.first_name, u.last_name, u.email, m.title AS mission_title,
                    m.price_usd
             FROM reservations r
             JOIN users u ON u.id = r.user_id
             JOIN missions m ON m.id = r.mission_id
             ORDER BY r.created_at DESC LIMIT ? OFFSET ?",
            [PER_PAGE, $offset]
        );
    }

    public function findByCode(string $code): array|false {
        return $this->db->fetchOne(
            "SELECT r.*, u.first_name, u.last_name, u.email,
                    m.title AS mission_title, m.launch_date, m.destination, m.price_usd,
                    s.name AS spacecraft_name
             FROM reservations r
             JOIN users u ON u.id = r.user_id
             JOIN missions m ON m.id = r.mission_id
             JOIN spacecraft s ON s.id = m.spacecraft_id
             WHERE r.reservation_code = ?",
            [$code]
        );
    }

    public function cancel(int $id, int $userId): bool {
        $res = $this->db->fetchOne('SELECT * FROM reservations WHERE id=? AND user_id=?', [$id, $userId]);
        if (!$res || $res['status'] === 'cancelled') return false;
        $this->db->beginTransaction();
        try {
            $this->db->execute("UPDATE reservations SET status='cancelled' WHERE id=?", [$id]);
            $this->db->execute('UPDATE missions SET seats_reserved = seats_reserved - 1 WHERE id=?', [$res['mission_id']]);
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function confirmPayment(int $reservationId): void {
        $this->db->execute("UPDATE reservations SET status='paid' WHERE id=?", [$reservationId]);
    }

    public function getStats(): array {
        return $this->db->fetchOne(
            "SELECT COUNT(*) AS total,
                    SUM(CASE WHEN status='paid' THEN 1 ELSE 0 END) AS paid,
                    SUM(CASE WHEN status='pending' THEN 1 ELSE 0 END) AS pending,
                    SUM(CASE WHEN status='cancelled' THEN 1 ELSE 0 END) AS cancelled
             FROM reservations"
        );
    }

    private function generateCode(): string {
        return 'CSM-' . strtoupper(bin2hex(random_bytes(4))) . '-' . date('y');
    }
}
