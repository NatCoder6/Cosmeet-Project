<!-- ============================================================
     COSMEET — User Dashboard
     ============================================================ -->
<section class="section" style="padding-top:7rem;">
  <div class="container">

    <!-- Welcome Header -->
    <div class="reveal mb-6" style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1.5rem;">
      <div>
        <div class="eyebrow">Mission Control</div>
        <h1 class="display-3">Welcome, <span class="gradient-text"><?= htmlspecialchars($user['first_name']) ?></span></h1>
        <p class="text-dim">Your personal space operations center.</p>
      </div>
      <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
        <a href="<?= APP_URL ?>/missions" class="btn btn-primary btn-sm">🚀 Browse Missions</a>
        <a href="<?= APP_URL ?>/readiness" class="btn btn-ghost btn-sm">🏅 Readiness Test</a>
      </div>
    </div>

    <!-- Stats Row -->
    <div class="dashboard-stats reveal reveal-delay-1 mb-5">
      <div class="stat-card glass">
        <div class="stat-icon">🛸</div>
        <div class="stat-num"><?= count($reservations) ?></div>
        <div class="stat-label">Missions Reserved</div>
      </div>
      <div class="stat-card glass">
        <div class="stat-icon">✓</div>
        <div class="stat-num"><?= count(array_filter($reservations, fn($r) => $r['status'] === 'paid')) ?></div>
        <div class="stat-label">Confirmed Flights</div>
      </div>
      <div class="stat-card glass">
        <div class="stat-icon">🏅</div>
        <div class="stat-num"><?= $readiness ? $readiness['total_score'] . '/100' : '—' ?></div>
        <div class="stat-label">Readiness Score</div>
      </div>
      <div class="stat-card glass">
        <div class="stat-icon">📅</div>
        <div class="stat-num"><?= count($timeline) ?></div>
        <div class="stat-label">Journey Events</div>
      </div>
    </div>

    <div class="dashboard-grid">

      <!-- LEFT COLUMN -->
      <div>

        <!-- ── DIGITAL SPACE PASSPORT ── -->
        <div class="glass rounded-lg p-5 mb-4 reveal" id="space-passport">
          <div class="section-eyebrow mb-3">
            <span style="color:var(--aurora-cyan);">◈</span> Digital Space Passport
          </div>

          <?php if ($passport): ?>
            <div class="passport-card" id="passport-card-flip" tabindex="0" role="button"
                 aria-label="Space passport card — click to flip" title="Click to flip">
              <!-- Front -->
              <div class="passport-face passport-front">
                <div class="passport-header">
                  <div>
                    <div class="passport-country font-mono text-xs" style="color:rgba(255,255,255,0.5);letter-spacing:0.2em;">COSMEET · SPACE AUTHORITY</div>
                    <div class="passport-type font-mono text-xs" style="color:rgba(255,255,255,0.4);">SPACE TRAVEL DOCUMENT</div>
                  </div>
                  <div style="font-size:1.5rem;">🚀</div>
                </div>

                <div class="passport-photo-section">
                  <div class="passport-photo" aria-hidden="true">
                    <?= strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)) ?>
                  </div>
                  <div style="flex:1;">
                    <div class="passport-field">
                      <div class="passport-field-label">SURNAME</div>
                      <div class="passport-field-value"><?= htmlspecialchars(strtoupper($user['last_name'])) ?></div>
                    </div>
                    <div class="passport-field">
                      <div class="passport-field-label">GIVEN NAMES</div>
                      <div class="passport-field-value"><?= htmlspecialchars(strtoupper($user['first_name'])) ?></div>
                    </div>
                    <div class="passport-field">
                      <div class="passport-field-label">NATIONALITY</div>
                      <div class="passport-field-value"><?= htmlspecialchars(strtoupper($user['nationality'] ?? 'EARTH CITIZEN')) ?></div>
                    </div>
                  </div>
                </div>

                <div style="display:flex;justify-content:space-between;margin-top:1rem;">
                  <div class="passport-field">
                    <div class="passport-field-label">PASSPORT NO.</div>
                    <div class="passport-field-value font-mono" style="color:var(--aurora-cyan);">
                      <?= htmlspecialchars($passport['passport_number']) ?>
                    </div>
                  </div>
                  <div class="passport-field" style="text-align:right;">
                    <div class="passport-field-label">ISSUED</div>
                    <div class="passport-field-value font-mono">
                      <?= date('d.m.Y', strtotime($passport['issued_at'] ?? $user['created_at'])) ?>
                    </div>
                  </div>
                </div>

                <!-- MRZ strip -->
                <div class="passport-mrz font-mono">
                  P&lt;CSM<?= strtoupper(str_pad($user['last_name'], 20, '<')) ?><br>
                  <?= substr(preg_replace('/[^A-Z0-9]/', '<', strtoupper($passport['passport_number'])), 0, 9) ?>
                  &lt;CSM<?= strtoupper(str_pad($user['first_name'], 15, '<')) ?>
                </div>

                <div class="text-xs text-center font-mono" style="color:rgba(255,255,255,0.3);margin-top:0.5rem;">
                  CLICK TO VIEW MISSIONS & BADGES
                </div>
              </div>

              <!-- Back -->
              <div class="passport-face passport-back">
                <div class="passport-back-header">
                  <div class="font-mono text-xs" style="color:rgba(255,255,255,0.4);letter-spacing:0.2em;margin-bottom:1rem;">MISSION RECORD & BADGES</div>
                </div>

                <?php
                  $paidMissions = array_filter($reservations, fn($r) => $r['status'] === 'paid');
                  $rank = count($paidMissions) >= 5 ? 'Interplanetary Pioneer' :
                          (count($paidMissions) >= 3 ? 'Orbital Commander' :
                          (count($paidMissions) >= 1 ? 'Space Explorer' : 'Aspiring Traveler'));
                ?>
                <div style="text-align:center;margin-bottom:1rem;">
                  <div class="text-xs text-dim">TRAVELER RANK</div>
                  <div style="font-family:var(--font-display);font-size:1rem;font-weight:700;color:var(--aurora-gold);">
                    <?= $rank ?>
                  </div>
                </div>

                <!-- Missions list -->
                <div style="max-height:140px;overflow-y:auto;" class="text-xs font-mono">
                  <?php if (empty($paidMissions)): ?>
                    <div class="text-dim" style="text-align:center;padding:1rem;">No completed missions yet.</div>
                  <?php else: ?>
                    <?php foreach (array_slice($paidMissions, 0, 4) as $pm): ?>
                      <div style="display:flex;gap:0.5rem;align-items:center;margin-bottom:0.4rem;color:rgba(255,255,255,0.7);">
                        <span style="color:var(--aurora-cyan);">▸</span>
                        <?= htmlspecialchars($pm['title']) ?>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>

                <!-- Badges -->
                <div class="badge-row" style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-top:1rem;">
                  <?php if (!empty($readiness)): ?>
                    <div class="passport-badge" title="Readiness Assessed">🏅</div>
                  <?php endif; ?>
                  <?php if (count($reservations) >= 1): ?>
                    <div class="passport-badge" title="First Reservation">🛸</div>
                  <?php endif; ?>
                  <?php if (count($paidMissions) >= 1): ?>
                    <div class="passport-badge" title="Mission Paid">💫</div>
                  <?php endif; ?>
                  <div class="passport-badge" title="Account Created">🌍</div>
                </div>

                <div class="text-xs text-center font-mono mt-3" style="color:rgba(255,255,255,0.3);">
                  CLICK TO RETURN TO ID PAGE
                </div>
              </div>
            </div>
          <?php else: ?>
            <p class="text-dim text-sm">Passport being generated… refresh in a moment.</p>
          <?php endif; ?>
        </div>

        <!-- ── READINESS PROFILE ── -->
        <?php if ($readiness): ?>
          <div class="glass rounded-lg p-4 mb-4 reveal">
            <div class="section-eyebrow mb-3">
              <span style="color:var(--aurora-purple);">◈</span> Space Readiness Profile
            </div>
            <div style="display:flex;gap:1.5rem;align-items:center;flex-wrap:wrap;">
              <div style="position:relative;width:80px;height:80px;flex-shrink:0;">
                <svg viewBox="0 0 80 80" style="transform:rotate(-90deg);width:80px;height:80px;">
                  <circle cx="40" cy="40" r="34" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="8"/>
                  <circle cx="40" cy="40" r="34" fill="none" stroke="var(--aurora-cyan)" stroke-width="8"
                          stroke-dasharray="<?= round(213.6 * $readiness['total_score'] / 100) ?> 213.6"
                          stroke-linecap="round"/>
                </svg>
                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:1.1rem;font-weight:700;">
                  <?= $readiness['total_score'] ?>
                </div>
              </div>
              <div>
                <div style="font-family:var(--font-display);font-size:1.2rem;color:var(--aurora-gold);">
                  <?= htmlspecialchars($readiness['traveler_profile']) ?>
                </div>
                <div class="text-sm text-dim mt-1" style="max-width:320px;line-height:1.6;">
                  <?= htmlspecialchars($readiness['feedback']) ?>
                </div>
              </div>
            </div>
            <div class="readiness-mini-bars mt-3">
              <?php
                $cats = [
                  ['Physical', $readiness['physical_score'], 'var(--aurora-cyan)'],
                  ['Psychological', $readiness['psychological_score'], 'var(--aurora-purple)'],
                  ['Adventure', $readiness['adventure_score'], 'var(--aurora-gold)'],
                  ['Knowledge', $readiness['knowledge_score'], 'var(--aurora-cyan)'],
                ];
                foreach ($cats as [$label, $score, $color]):
              ?>
                <div style="margin-bottom:0.5rem;">
                  <div style="display:flex;justify-content:space-between;margin-bottom:0.25rem;" class="text-xs">
                    <span class="text-dim"><?= $label ?></span>
                    <span class="font-mono" style="color:<?= $color ?>"><?= $score ?>/25</span>
                  </div>
                  <div class="seat-bar" style="height:4px;">
                    <div class="seat-bar-fill" style="width:<?= ($score/25)*100 ?>%;background:<?= $color ?>;"></div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php else: ?>
          <div class="glass rounded-lg p-4 mb-4 reveal" style="border:1px dashed rgba(0,230,190,0.2);">
            <div class="text-center">
              <div style="font-size:2rem;margin-bottom:0.75rem;">🏅</div>
              <div class="h5 mb-1">Take Your Readiness Assessment</div>
              <p class="text-dim text-sm mb-3">Discover your Space Traveler profile and personalized mission recommendations.</p>
              <a href="<?= APP_URL ?>/readiness" class="btn btn-primary btn-sm">Start Assessment →</a>
            </div>
          </div>
        <?php endif; ?>

      </div>

      <!-- RIGHT COLUMN: Journey Timeline + Reservations -->
      <div>

        <!-- ── PERSONAL SPACE JOURNEY TIMELINE ── -->
        <div class="glass rounded-lg p-4 mb-4 reveal">
          <div class="section-eyebrow mb-3">
            <span style="color:var(--aurora-gold);">◈</span> Space Journey Timeline
          </div>

          <?php if (empty($timeline)): ?>
            <p class="text-dim text-sm text-center">No timeline events yet.</p>
          <?php else: ?>
            <div class="journey-timeline">
              <?php foreach ($timeline as $i => $event): ?>
                <?php
                  $statusIcon = $event['status'] === 'completed' ? '✓' :
                                ($event['status'] === 'active' ? '▶' : '○');
                  $statusColor = $event['status'] === 'completed' ? 'var(--aurora-cyan)' :
                                 ($event['status'] === 'active' ? 'var(--aurora-gold)' : 'rgba(255,255,255,0.2)');
                  $iconMap = [
                    'rocket' => '🚀', 'satellite' => '🛸', 'check-circle' => '✅',
                    'activity' => '🏅', 'flag' => '🏳', 'star' => '⭐', 'map-pin' => '📍',
                  ];
                  $displayIcon = $iconMap[$event['icon']] ?? '●';
                ?>
                <div class="timeline-event <?= $event['status'] ?>" style="animation-delay:<?= $i * 0.05 ?>s">
                  <div class="timeline-dot" style="background:<?= $statusColor ?>;border-color:<?= $statusColor ?>;">
                    <span style="font-size:0.6rem;"><?= $statusIcon ?></span>
                  </div>
                  <div class="timeline-content">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:0.5rem;">
                      <div class="timeline-title text-sm" style="font-weight:600;">
                        <?= $displayIcon ?> <?= htmlspecialchars($event['title']) ?>
                      </div>
                      <div class="timeline-date font-mono" style="font-size:0.65rem;color:rgba(255,255,255,0.3);white-space:nowrap;">
                        <?= date('d M Y', strtotime($event['event_date'])) ?>
                      </div>
                    </div>
                    <?php if (!empty($event['description'])): ?>
                      <div class="timeline-desc text-xs text-dim" style="margin-top:0.2rem;line-height:1.5;">
                        <?= htmlspecialchars($event['description']) ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>

              <!-- Future placeholder events -->
              <?php
                $hasMission = !empty(array_filter($reservations, fn($r) => in_array($r['status'], ['paid','pending'])));
                if ($hasMission):
              ?>
                <div class="timeline-event future" style="opacity:0.4;">
                  <div class="timeline-dot" style="background:rgba(255,255,255,0.1);border-color:rgba(255,255,255,0.1);">
                    <span style="font-size:0.6rem;">○</span>
                  </div>
                  <div class="timeline-content">
                    <div class="timeline-title text-sm text-dim">Pre-Flight Training</div>
                    <div class="timeline-desc text-xs text-dim">T-30 days · Upcoming</div>
                  </div>
                </div>
                <div class="timeline-event future" style="opacity:0.25;">
                  <div class="timeline-dot" style="background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.05);">
                    <span style="font-size:0.6rem;">○</span>
                  </div>
                  <div class="timeline-content">
                    <div class="timeline-title text-sm text-dim" style="color:var(--aurora-gold);">🚀 LAUNCH DAY</div>
                    <div class="timeline-desc text-xs text-dim">The journey begins</div>
                  </div>
                </div>
                <div class="timeline-event future" style="opacity:0.15;">
                  <div class="timeline-dot" style="background:rgba(255,255,255,0.03);border-color:rgba(255,255,255,0.03);">
                    <span style="font-size:0.6rem;">○</span>
                  </div>
                  <div class="timeline-content">
                    <div class="timeline-title text-sm text-dim" style="color:var(--aurora-purple);">🌌 SPACE MISSION</div>
                    <div class="timeline-desc text-xs text-dim">You are no longer of this Earth</div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- ── RECENT RESERVATIONS ── -->
        <div class="glass rounded-lg p-4 reveal">
          <div class="section-eyebrow mb-3">
            <span style="color:var(--aurora-cyan);">◈</span> Recent Reservations
            <a href="<?= APP_URL ?>/my-reservations" class="link-glow text-xs ml-2" style="float:right;">View All →</a>
          </div>

          <?php if (empty($reservations)): ?>
            <div class="text-center py-4">
              <p class="text-dim text-sm mb-3">No missions reserved yet.</p>
              <a href="<?= APP_URL ?>/missions" class="btn btn-primary btn-sm">Browse Missions</a>
            </div>
          <?php else: ?>
            <?php foreach (array_slice($reservations, 0, 3) as $r): ?>
              <?php
                $sc = [
                  'pending'   => ['color' => 'var(--aurora-gold)',  'label' => '⏳ Pending'],
                  'paid'      => ['color' => 'var(--aurora-cyan)',  'label' => '✓ Confirmed'],
                  'cancelled' => ['color' => '#ff4757',             'label' => '✕ Cancelled'],
                  'completed' => ['color' => 'var(--aurora-gold)',  'label' => '🏅 Completed'],
                ][$r['status']] ?? ['color' => 'var(--star-dim)', 'label' => ucfirst($r['status'])];
              ?>
              <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem 0;border-bottom:1px solid rgba(255,255,255,0.05);">
                <div>
                  <div class="text-sm" style="font-weight:600;"><?= htmlspecialchars($r['title']) ?></div>
                  <div class="text-xs font-mono text-dim">
                    <?= htmlspecialchars($r['destination']) ?> · <?= date('d M Y', strtotime($r['launch_date'])) ?>
                  </div>
                </div>
                <div style="text-align:right;">
                  <div class="text-xs font-mono" style="color:<?= $sc['color'] ?>"><?= $sc['label'] ?></div>
                  <?php if ($r['status'] === 'pending'): ?>
                    <a href="<?= APP_URL ?>/payment/<?= htmlspecialchars($r['reservation_code']) ?>"
                       class="text-xs link-glow">Pay now →</a>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

      </div>
    </div>

  </div>
</section>

<script>
// Passport flip
const card = document.getElementById('passport-card-flip');
if (card) {
  let flipped = false;
  function flipPassport() {
    flipped = !flipped;
    card.style.transform = flipped ? 'rotateY(180deg)' : 'rotateY(0deg)';
  }
  card.addEventListener('click', flipPassport);
  card.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') flipPassport(); });
}
</script>
