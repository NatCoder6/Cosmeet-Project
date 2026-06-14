<?php
// ============================================================
// COSMEET — User Dashboard Controller
// ============================================================
namespace Cosmeet\Controllers;

use Cosmeet\Core\Auth;
use Cosmeet\Core\Database;
use Cosmeet\Models\ReservationModel;

class DashboardController extends BaseController {

    public function index(): void {
        Auth::requireLogin();
        $user = Auth::user();
        $db   = Database::getInstance();

        $passport = $db->fetchOne('SELECT * FROM space_passports WHERE user_id=?', [$user['id']]);
        $timeline = $db->fetchAll(
            'SELECT * FROM journey_timelines WHERE user_id=? ORDER BY created_at ASC',
            [$user['id']]
        );
        $reservations = (new ReservationModel())->getUserReservations($user['id']);
        $readiness    = $db->fetchOne('SELECT * FROM readiness_assessments WHERE user_id=? ORDER BY completed_at DESC LIMIT 1', [$user['id']]);

        $this->view('user/dashboard', [
            'title'        => 'Mission Control — Cosmeet',
            'passport'     => $passport,
            'timeline'     => $timeline,
            'reservations' => $reservations,
            'readiness'    => $readiness,
        ]);
    }
}
