<?php
// ============================================================
// COSMEET — Mission Model
// ============================================================
namespace Cosmeet\Models;

use Cosmeet\Core\Database;

class MissionModel {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(array $filters = [], int $page = 1): array {
        $where  = ['1=1'];
        $params = [];

        if (!empty($filters['search'])) {
            $where[]  = '(m.title LIKE ? OR m.destination LIKE ?)';
            $params[] = '%' . $filters['search'] . '%';
            $params[] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['destination'])) {
            $where[]  = 'm.destination = ?';
            $params[] = $filters['destination'];
        }
        if (!empty($filters['type'])) {
            $where[]  = 'm.mission_type = ?';
            $params[] = $filters['type'];
        }
        if (!empty($filters['status'])) {
            $where[]  = 'm.status = ?';
            $params[] = $filters['status'];
        }

        $offset   = ($page - 1) * PER_PAGE;
        $sql      = "SELECT m.*, s.name AS spacecraft_name, s.safety_rating,
                            s.mission_duration_days,
                            (m.seats_total - m.seats_reserved) AS seats_available
                     FROM missions m
                     JOIN spacecraft s ON s.id = m.spacecraft_id
                     WHERE " . implode(' AND ', $where) . "
                     ORDER BY m.featured DESC, m.launch_date ASC
                     LIMIT ? OFFSET ?";
        $params[] = PER_PAGE;
        $params[] = $offset;
        return $this->db->fetchAll($sql, $params);
    }

    public function getFeatured(int $limit = 4): array {
        return $this->db->fetchAll(
            "SELECT m.*, s.name AS spacecraft_name, s.safety_rating,
                    s.mission_duration_days,
                    (m.seats_total - m.seats_reserved) AS seats_available
             FROM missions m
             JOIN spacecraft s ON s.id = m.spacecraft_id
             WHERE m.featured=1 AND m.status='upcoming'
             ORDER BY m.launch_date ASC LIMIT ?",
            [$limit]
        );
    }

    public function findBySlug(string $slug): array|false {
        return $this->db->fetchOne(
            "SELECT m.*, s.name AS spacecraft_name, s.model, s.capacity,
                    s.launch_site, s.safety_rating, s.description AS craft_description,
                    s.image_path AS craft_image,
                    (m.seats_total - m.seats_reserved) AS seats_available
             FROM missions m
             JOIN spacecraft s ON s.id = m.spacecraft_id
             WHERE m.slug = ?",
            [$slug]
        );
    }

    public function findById(int $id): array|false {
        return $this->db->fetchOne(
            "SELECT m.*, s.name AS spacecraft_name, (m.seats_total - m.seats_reserved) AS seats_available
             FROM missions m JOIN spacecraft s ON s.id = m.spacecraft_id
             WHERE m.id = ?",
            [$id]
        );
    }

    public function create(array $data): int {
        $slug = $this->makeSlug($data['title']);
        $this->db->execute(
            "INSERT INTO missions (spacecraft_id, title, slug, destination, description, mission_type,
             launch_date, return_date, seats_total, price_usd, status, difficulty_level, featured)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [$data['spacecraft_id'], $data['title'], $slug, $data['destination'], $data['description'],
             $data['mission_type'], $data['launch_date'], $data['return_date'], $data['seats_total'],
             $data['price_usd'], $data['status'] ?? 'upcoming', $data['difficulty_level'] ?? 'intermediate',
             $data['featured'] ?? 0]
        );
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void {
        $this->db->execute(
            "UPDATE missions SET spacecraft_id=?, title=?, destination=?, description=?, mission_type=?,
             launch_date=?, return_date=?, seats_total=?, price_usd=?, status=?, difficulty_level=?,
             featured=?, updated_at=NOW() WHERE id=?",
            [$data['spacecraft_id'], $data['title'], $data['destination'], $data['description'],
             $data['mission_type'], $data['launch_date'], $data['return_date'], $data['seats_total'],
             $data['price_usd'], $data['status'], $data['difficulty_level'], $data['featured'] ?? 0, $id]
        );
    }

    public function delete(int $id): void {
        $this->db->execute('DELETE FROM missions WHERE id=?', [$id]);
    }

    public function getStats(): array {
        return $this->db->fetchOne(
            "SELECT COUNT(*) AS total,
                    SUM(CASE WHEN status='upcoming' THEN 1 ELSE 0 END) AS upcoming,
                    SUM(seats_reserved) AS total_reservations,
                    SUM(seats_reserved * price_usd) AS potential_revenue
             FROM missions"
        );
    }

    private function makeSlug(string $title): string {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
        $slug = trim($slug, '-');
        $base = $slug;
        $i    = 1;
        while ($this->db->fetchOne('SELECT id FROM missions WHERE slug=?', [$slug])) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
