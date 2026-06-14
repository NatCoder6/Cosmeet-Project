<?php
// ============================================================
// COSMEET — Mission Controller
// ============================================================
namespace Cosmeet\Controllers;

use Cosmeet\Models\MissionModel;

class MissionController extends BaseController {

    public function index(): void {
        $model   = new MissionModel();
        $filters = [
            'search'      => $this->sanitize($_GET['search'] ?? ''),
            'destination' => $this->sanitize($_GET['destination'] ?? ''),
            'type'        => $this->sanitize($_GET['type'] ?? ''),
        ];
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $missions = $model->getAll($filters, $page);
        $this->view('missions/index', [
            'title'    => 'Missions — Cosmeet',
            'missions' => $missions,
            'filters'  => $filters,
            'page'     => $page,
        ]);
    }

    public function show(string $slug): void {
        $model   = new MissionModel();
        $mission = $model->findBySlug($slug);
        if (!$mission) {
            http_response_code(404);
            require VIEW_PATH . '/errors/404.php';
            return;
        }
        $this->view('missions/show', [
            'title'   => $mission['title'] . ' — Cosmeet',
            'mission' => $mission,
        ]);
    }
}
