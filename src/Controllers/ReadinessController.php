<?php
// ============================================================
// COSMEET — Readiness Assessment Controller
// ============================================================
namespace Cosmeet\Controllers;

use Cosmeet\Core\Auth;
use Cosmeet\Core\Database;

class ReadinessController extends BaseController {

    public function show(): void {
        Auth::requireLogin();
        $this->view('readiness/assessment', ['title' => 'Space Traveler Readiness — Cosmeet']);
    }

    public function submit(): void {
        Auth::requireLogin();
        $this->validateCsrf();
        $user = Auth::user();

        $physical  = min(25, (int)($_POST['q_physical'] ?? 0));
        $psych     = min(25, (int)($_POST['q_psych'] ?? 0));
        $adventure = min(25, (int)($_POST['q_adventure'] ?? 0));
        $knowledge = min(25, (int)($_POST['q_knowledge'] ?? 0));
        $total     = $physical + $psych + $adventure + $knowledge;

        $profile  = $this->getProfile($total);
        $feedback = $this->getFeedback($total, $physical, $psych, $adventure, $knowledge);

        $db = Database::getInstance();
        $db->execute(
            "INSERT INTO readiness_assessments (user_id, physical_score, psychological_score, adventure_score, knowledge_score, total_score, traveler_profile, feedback)
             VALUES (?,?,?,?,?,?,?,?)",
            [$user['id'], $physical, $psych, $adventure, $knowledge, $total, $profile, $feedback]
        );

        $db->execute(
            "INSERT INTO journey_timelines (user_id, event_type, title, description, event_date, status, icon)
             VALUES (?,?,?,?,NOW(),?,?)",
            [$user['id'], 'readiness_completed', 'Readiness Assessment Completed',
             'Profile: ' . $profile . ' | Score: ' . $total . '/100%, 'completed', 'activity']
        );

        $this->view('readiness/result', [
            'title'    => 'Your Readiness Profile — Cosmeet',
            'total'    => $total,
            'profile'  => $profile,
            'feedback' => $feedback,
            'scores'   => compact('physical', 'psych', 'adventure', 'knowledge'),
        ]);
    }

    private function getProfile(int $total): string {
        if ($total >= 90) return 'Interplanetary Pioneer';
        if ($total >= 75) return 'Orbital Commander';
        if ($total >= 60) return 'Space Explorer';
        if ($total >= 45) return 'Lunar Voyager';
        if ($total >= 30) return 'Aspiring Traveler';
        return 'Earth Dreamer';
    }

    private function getFeedback(int $total, int $p, int $ps, int $a, int $k): string {
        $areas = [];
        if ($p < 15)  $areas[] = 'physical conditioning';
        if ($ps < 15) $areas[] = 'psychological resilience';
        if ($a < 15)  $areas[] = 'adventure mindset';
        if ($k < 15)  $areas[] = 'space knowledge';

        if ($total >= 90) return 'Outstanding! You are among the most prepared civilian space travelers we have assessed. Your profile matches elite mission candidates.';
        if ($total >= 75) return 'Excellent readiness. With some refinement in ' . (implode(' and ', $areas) ?: 'all areas') . ', you will be mission-ready.';
        if ($total >= 60) return 'Good foundation. Focus on improving your ' . implode(' and ', $areas) . ' to advance your mission eligibility.';
        if ($total >= 45) return 'You show genuine potential. Consistent work on ' . implode(' and ', $areas) . ' will prepare you for entry-level missions.';
        return 'Your journey is just beginning. We recommend our pre-mission preparation program to build your readiness.';
    }
}
