<?php
// ============================================================
// COSMEET — Admin Controller
// ============================================================
namespace Cosmeet\Controllers;

use Cosmeet\Core\Auth;
use Cosmeet\Core\Database;
use Cosmeet\Models\MissionModel;
use Cosmeet\Models\ReservationModel;
use Cosmeet\Models\UserModel;

class AdminController extends BaseController {

    public function dashboard(): void {
        Auth::requireAdmin();
        $db     = Database::getInstance();
        $mStats = (new MissionModel())->getStats();
        $rStats = (new ReservationModel())->getStats();
        $users  = (new UserModel())->getTotalCount();

        $recentRes = (new ReservationModel())->getAll(1);
        $revenue   = $db->fetchOne("SELECT SUM(amount_usd) AS total FROM payments WHERE status='completed'");

        $this->view('admin/dashboard', [
            'title'     => 'Admin Dashboard — Cosmeet',
            'mStats'    => $mStats,
            'rStats'    => $rStats,
            'userCount' => $users,
            'recentRes' => $recentRes,
            'revenue'   => $revenue['total'] ?? 0,
        ]);
    }

    public function missions(): void {
        Auth::requireAdmin();
        $missions   = (new MissionModel())->getAll([], 1);
        $db         = Database::getInstance();
        $spacecraft = $db->fetchAll('SELECT * FROM spacecraft ORDER BY name');
        $this->view('admin/missions', [
            'title'      => 'Manage Missions — Cosmeet',
            'missions'   => $missions,
            'spacecraft' => $spacecraft,
        ]);
    }

    public function storeMission(): void {
        Auth::requireAdmin();
        $this->validateCsrf();
        $model = new MissionModel();
        $model->create([
            'spacecraft_id'    => (int)$_POST['spacecraft_id'],
            'title'            => $this->sanitize($_POST['title'] ?? ''),
            'destination'      => $this->sanitize($_POST['destination'] ?? ''),
            'description'      => $this->sanitize($_POST['description'] ?? ''),
            'mission_type'     => $this->sanitize($_POST['mission_type'] ?? 'orbital'),
            'launch_date'      => $_POST['launch_date'] ?? '',
            'return_date'      => $_POST['return_date'] ?? '',
            'seats_total'      => (int)$_POST['seats_total'],
            'price_usd'        => (float)$_POST['price_usd'],
            'status'           => $this->sanitize($_POST['status'] ?? 'upcoming'),
            'difficulty_level' => $this->sanitize($_POST['difficulty_level'] ?? 'intermediate'),
            'featured'         => isset($_POST['featured']) ? 1 : 0,
        ]);
        $this->flash('success', 'Mission created successfully.');
        $this->redirect('/admin/missions');
    }

    public function deleteMission(int $id): void {
        Auth::requireAdmin();
        $this->validateCsrf();
        (new MissionModel())->delete($id);
        $this->flash('success', 'Mission deleted.');
        $this->redirect('/admin/missions');
    }

    public function reservations(): void {
        Auth::requireAdmin();
        $page         = max(1, (int)($_GET['page'] ?? 1));
        $reservations = (new ReservationModel())->getAll($page);
        $this->view('admin/reservations', [
            'title'        => 'Reservations — Cosmeet Admin',
            'reservations' => $reservations,
            'page'         => $page,
        ]);
    }

    public function users(): void {
        Auth::requireAdmin();
        $page  = max(1, (int)($_GET['page'] ?? 1));
        $users = (new UserModel())->getAll($page);
        $this->view('admin/users', [
            'title' => 'Users — Cosmeet Admin',
            'users' => $users,
            'page'  => $page,
        ]);
    }
}
