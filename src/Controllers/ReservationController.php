<?php
// ============================================================
// COSMEET — Reservation Controller
// ============================================================
namespace Cosmeet\Controllers;

use Cosmeet\Core\Auth;
use Cosmeet\Models\MissionModel;
use Cosmeet\Models\ReservationModel;

class ReservationController extends BaseController {

    public function create(string $slug): void {
        Auth::requireLogin();
        $missionModel = new MissionModel();
        $mission = $missionModel->findBySlug($slug);
        if (!$mission || $mission['seats_available'] <= 0) {
            $this->flash('error', 'This mission is not available for reservation.');
            $this->redirect('/missions/' . $slug);
        }
        $this->view('reservations/create', [
            'title'   => 'Reserve Your Seat — Cosmeet',
            'mission' => $mission,
        ]);
    }

    public function store(): void {
        Auth::requireLogin();
        $this->validateCsrf();
        $user      = Auth::user();
        $missionId = (int)($_POST['mission_id'] ?? 0);
        $requests  = $this->sanitize($_POST['special_requests'] ?? '');

        $model  = new ReservationModel();
        $result = $model->create($user['id'], $missionId, $requests);

        if (!$result) {
            $this->flash('error', 'Reservation failed. Seat may no longer be available.');
            $this->redirect('/missions');
            return;
        }

        $this->redirect('/payment/' . $result['code']);
    }

    public function myReservations(): void {
        Auth::requireLogin();
        $user  = Auth::user();
        $model = new ReservationModel();
        $reservations = $model->getUserReservations($user['id']);
        $this->view('reservations/my', [
            'title'        => 'My Reservations — Cosmeet',
            'reservations' => $reservations,
        ]);
    }

    public function cancel(int $id): void {
        Auth::requireLogin();
        $this->validateCsrf();
        $user  = Auth::user();
        $model = new ReservationModel();
        $ok    = $model->cancel($id, $user['id']);
        $this->flash($ok ? 'success' : 'error', $ok ? 'Reservation cancelled.' : 'Could not cancel reservation.');
        $this->redirect('/my-reservations');
    }
}
