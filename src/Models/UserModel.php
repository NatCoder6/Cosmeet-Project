<?php
// ============================================================
// COSMEET — User Model

namespace Cosmeet\Models;

use Cosmeet\Core\Database;

class UserModel {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByEmail(string $email): array|false {
        return $this->db->fetchOne('SELECT * FROM users WHERE email = ?', [$email]);
    }

    public function findById(int $id): array|false {
        return $this->db->fetchOne('SELECT * FROM users WHERE id = ?', [$id]);
    }

    public function findByUuid(string $uuid): array|false {
        return $this->db->fetchOne('SELECT * FROM users WHERE uuid = ?', [$uuid]);
    }

    public function create(array $data): int {
        $uuid = $this->generateUuid();
        $this->db->execute(
            'INSERT INTO users (uuid, first_name, last_name, email, password_hash, phone, nationality, date_of_birth)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $uuid,
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => BCRYPT_COST]),
                $data['phone'] ?? null,
                $data['nationality'] ?? null,
                $data['dob'] ?? null,
            ]
        );
        $userId = (int)$this->db->lastInsertId();
        // Auto-create passport and timeline entry
        $this->createPassport($userId, $uuid);
        $this->createInitialTimeline($userId);
        return $userId;
    }

    public function update(int $id, array $data): void {
        $this->db->execute(
            'UPDATE users SET first_name=?, last_name=?, phone=?, nationality=?, bio=?, updated_at=NOW()
             WHERE id=?',
            [$data['first_name'], $data['last_name'], $data['phone'] ?? null,
             $data['nationality'] ?? null, $data['bio'] ?? null, $id]
        );
    }

    public function verifyPassword(array $user, string $password): bool {
        return password_verify($password, $user['password_hash']);
    }

    public function getAll(int $page = 1): array {
        $offset = ($page - 1) * PER_PAGE;
        return $this->db->fetchAll(
            'SELECT id, uuid, first_name, last_name, email, role, status, created_at
             FROM users ORDER BY created_at DESC LIMIT ? OFFSET ?',
            [PER_PAGE, $offset]
        );
    }

    public function getTotalCount(): int {
        return (int)$this->db->fetchOne('SELECT COUNT(*) AS c FROM users')['c'];
    }

    private function createPassport(int $userId, string $uuid): void {
        $passportNumber = 'CSM-' . strtoupper(substr($uuid, 0, 8));
        $this->db->execute(
            'INSERT INTO space_passports (user_id, passport_number) VALUES (?, ?)',
            [$userId, $passportNumber]
        );
    }

    private function createInitialTimeline(int $userId): void {
        $this->db->execute(
            'INSERT INTO journey_timelines (user_id, event_type, title, description, event_date, status, icon)
             VALUES (?, ?, ?, ?, NOW(), ?, ?)',
            [$userId, 'account_created', 'Account Created', 'Welcome to Cosmeet. Your journey to the stars begins here.', 'completed', 'rocket']
        );
    }

    private function generateUuid(): string {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
