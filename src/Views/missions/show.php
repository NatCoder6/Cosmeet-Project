<!-- ============================================================
     COSMEET — Mission Detail
     ============================================================ -->
<?php
  $launchTs = strtotime($mission['launch_date']);
  $returnTs = strtotime($mission['return_date']);
  $daysLeft = max(0, ceil(($launchTs - time()) / 86400));
  $duration = $returnTs > $launchTs ? ceil(($returnTs - $launchTs) / 86400) : 'N/A';
  $seatsAvail = (int)$mission['seats_available'];
  $pct = $mission['seats_total'] > 0
    ? round(($mission['seats_reserved'] / $mission['seats_total']) * 100) : 0;
?>

<!-- Mission Hero -->
<section class="mission-hero" aria-labelledby="mission-title">
  <div class="mission-hero-bg" data-dest="<?= htmlspecialchars($mission['destination']) ?>" aria-hidden="true"></div>
  <div class="mission-hero-overlay" aria-hidden="true"></div>

  <div class="mission-hero-content reveal">
    <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
      <span class="badge badge-outline" style="text-transform:capitalize;"><?= htmlspecialchars($mission['mission_type']) ?></span>
      <span class="badge badge-outline"><?= htmlspecialchars($mission['difficulty_level']) ?></span>
      <span class="badge" style="background:<?= $seatsAvail > 5 ? 'rgba(0,230,190,0.15)' : 'rgba(255,160,0,0.15)' ?>;color:<?= $seatsAvail > 5 ? 'var(--aurora-cyan)' : 'var(--aurora-gold)' ?>;border:1px solid currentColor;">
        <?= $seatsAvail ?> seats left
      </span>
    </div>

    <h1 class="display-2 mb-3" id="mission-title"><?= htmlspecialchars($mission['title']) ?></h1>
    <p class="text-dim" style="font-size:1.1rem;max-width:680px;line-height:1.8;margin-bottom:2rem;">
      <?= htmlspecialchars($mission['description']) ?>
    </p>

    <!-- Quick Stats -->
    <div class="mission-quick-stats">
      <div class="quick-stat">
        <span class="quick-stat-label font-mono">DESTINATION</span>
        <span class="quick-stat-value">🌍 <?= htmlspecialchars($mission['destination']) ?></span>
      </div>
      <div class="quick-stat">
        <span class="quick-stat-label font-mono">LAUNCH DATE</span>
        <span class="quick-stat-value">📅 <?= date('d M Y', $launchTs) ?></span>
      </div>
      <div class="quick-stat">
        <span class="quick-stat-label font-mono">DURATION</span>
        <span class="quick-stat-value">⏱ <?= is_numeric($duration) ? $duration . ' days' : $duration ?></span>
      </div>
      <div class="quick-stat">
        <span class="quick-stat-label font-mono">T-MINUS</span>
        <span class="quick-stat-value" style="color:var(--aurora-gold);">⏳ <?= $daysLeft ?> days</span>
      </div>
    </div>
  </div>

  <!-- Countdown overlay -->
  <div class="hero-countdown reveal reveal-delay-2" aria-label="Countdown to launch">
    <div class="countdown-unit">
      <span class="countdown-num" id="cd-days"><?= str_pad(floor($daysLeft), 2, '0', STR_PAD_LEFT) ?></span>
      <span class="countdown-unit-label">DAYS</span>
    </div>
    <div class="countdown-sep">:</div>
    <div class="countdown-unit">
      <span class="countdown-num" id="cd-hours">00</span>
      <span class="countdown-unit-label">HRS</span>
    </div>
    <div class="countdown-sep">:</div>
    <div class="countdown-unit">
      <span class="countdown-num" id="cd-mins">00</span>
      <span class="countdown-unit-label">MIN</span>
    </div>
    <div class="countdown-sep">:</div>
    <div class="countdown-unit">
      <span class="countdown-num" id="cd-secs">00</span>
      <span class="countdown-unit-label">SEC</span>
    </div>
  </div>
  <script>
    (function() {
      const target = new Date('<?= date('Y-m-d\TH:i:s', $launchTs) ?>').getTime();
      function tick() {
        const now = Date.now(), diff = target - now;
        if (diff <= 0) { document.querySelector('.hero-countdown').innerHTML = '<div class="launch-live-badge">🔴 LIVE — LAUNCHING NOW</div>'; return; }
        const d = Math.floor(diff/86400000), h = Math.floor((diff%86400000)/3600000),
              m = Math.floor((diff%3600000)/60000), s = Math.floor((diff%60000)/1000);
        const pad = n => String(n).padStart(2,'0');
        document.getElementById('cd-days').textContent = pad(d);
        document.getElementById('cd-hours').textContent = pad(h);
        document.getElementById('cd-mins').textContent = pad(m);
        document.getElementById('cd-secs').textContent = pad(s);
      }
      tick(); setInterval(tick, 1000);
    })();
  </script>
</section>

<!-- Mission Content -->
<section class="section">
  <div class="container">
    <div class="mission-detail-grid">

      <!-- Left: Details -->
      <div>
        <!-- Spacecraft Card -->
        <div class="glass p-4 rounded-lg mb-4 reveal">
          <h2 class="h4 mb-3" style="color:var(--aurora-cyan);">🛸 Spacecraft</h2>
          <div style="display:flex;gap:1.5rem;align-items:flex-start;flex-wrap:wrap;">
            <div class="spacecraft-avatar" aria-hidden="true">🚀</div>
            <div style="flex:1;">
              <div class="h4 mb-1"><?= htmlspecialchars($mission['spacecraft_name']) ?></div>
              <?php if (!empty($mission['model'])): ?>
                <div class="text-xs font-mono text-dim mb-2"><?= htmlspecialchars($mission['model']) ?></div>
              <?php endif; ?>
              <div class="spacecraft-specs">
                <div class="spec-item">
                  <span class="spec-label">Capacity</span>
                  <span class="spec-value"><?= $mission['capacity'] ?? 'N/A' ?> travelers</span>
                </div>
                <div class="spec-item">
                  <span class="spec-label">Safety Rating</span>
                  <span class="spec-value" style="color:var(--aurora-cyan);">
                    <?= str_repeat('★', (int)$mission['safety_rating']) ?><?= str_repeat('☆', 10 - (int)$mission['safety_rating']) ?>
                    &nbsp;<?= $mission['safety_rating'] ?>/10
                  </span>
                </div>
                <div class="spec-item">
                  <span class="spec-label">Launch Site</span>
                  <span class="spec-value"><?= htmlspecialchars($mission['launch_site'] ?? 'TBD') ?></span>
                </div>
              </div>
              <?php if (!empty($mission['craft_description'])): ?>
                <p class="text-dim text-sm mt-2" style="line-height:1.7;">
                  <?= htmlspecialchars($mission['craft_description']) ?>
                </p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Seat Availability -->
        <div class="glass p-4 rounded-lg mb-4 reveal">
          <h2 class="h4 mb-3">🪑 Seat Availability</h2>
          <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;">
            <span class="text-dim">Reserved</span>
            <span class="font-mono text-sm"><?= $mission['seats_reserved'] ?> / <?= $mission['seats_total'] ?></span>
          </div>
          <div class="seat-bar" style="height:12px;margin-bottom:0.75rem;">
            <div class="seat-bar-fill <?= $pct >= 90 ? 'seat-bar-fill--critical' : '' ?>"
                 style="width:<?= $pct ?>%;transition:width 1s ease;"></div>
          </div>
          <?php if ($seatsAvail <= 3 && $seatsAvail > 0): ?>
            <p class="text-gold text-sm font-mono">⚠ Only <?= $seatsAvail ?> seat<?= $seatsAvail !== 1 ? 's' : '' ?> remaining!</p>
          <?php elseif ($seatsAvail === 0): ?>
            <p style="color:#ff4757;" class="text-sm font-mono">✖ Mission fully booked</p>
          <?php else: ?>
            <p class="text-cyan text-sm font-mono">✓ <?= $seatsAvail ?> seats available</p>
          <?php endif; ?>
        </div>

        <!-- Mission Timeline Preview -->
        <div class="glass p-4 rounded-lg reveal">
          <h2 class="h4 mb-3">📅 Mission Timeline</h2>
          <div class="timeline-preview">
            <div class="tl-item tl-item--done">
              <div class="tl-dot"></div>
              <div>
                <div class="tl-title">Registration Opens</div>
                <div class="tl-meta font-mono text-xs text-dim">NOW</div>
              </div>
            </div>
            <div class="tl-item">
              <div class="tl-dot"></div>
              <div>
                <div class="tl-title">Pre-Flight Briefing</div>
                <div class="tl-meta font-mono text-xs text-dim">T–30 days</div>
              </div>
            </div>
            <div class="tl-item">
              <div class="tl-dot"></div>
              <div>
                <div class="tl-title">Launch Day</div>
                <div class="tl-meta font-mono text-xs text-dim"><?= date('d M Y', $launchTs) ?></div>
              </div>
            </div>
            <div class="tl-item">
              <div class="tl-dot"></div>
              <div>
                <div class="tl-title">Mission Complete · Return</div>
                <div class="tl-meta font-mono text-xs text-dim">
                  <?= $returnTs > $launchTs ? date('d M Y', $returnTs) : 'TBD' ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: Booking Panel -->
      <div>
        <div class="booking-panel glass p-5 rounded-lg reveal" style="position:sticky;top:6rem;">
          <div class="text-center mb-4">
            <div class="price-display">
              <span class="text-dim text-xs font-mono">SEAT PRICE</span>
              <div class="price-big" style="font-family:var(--font-display);font-size:2.5rem;font-weight:800;">
                $<?= number_format($mission['price_usd'], 0) ?>
              </div>
              <span class="text-dim text-xs">per traveler</span>
            </div>
          </div>

          <?php if ($seatsAvail > 0): ?>
            <?php if (\Cosmeet\Core\Auth::check()): ?>
              <a href="<?= APP_URL ?>/reserve/<?= htmlspecialchars($mission['slug']) ?>"
                 class="btn btn-glow w-full btn-xl text-center mb-3">
                🚀 Reserve Your Seat
              </a>
            <?php else: ?>
              <a href="<?= APP_URL ?>/register" class="btn btn-glow w-full btn-xl text-center mb-2">
                🚀 Join to Reserve
              </a>
              <a href="<?= APP_URL ?>/login" class="btn btn-outline w-full text-center mb-3">
                Already a member? Login
              </a>
            <?php endif; ?>
          <?php else: ?>
            <button class="btn w-full btn-xl text-center mb-3" disabled
                    style="opacity:0.4;cursor:not-allowed;background:rgba(255,255,255,0.05);">
              Mission Fully Booked
            </button>
          <?php endif; ?>

          <ul class="booking-perks text-sm">
            <li>✓ Instant reservation confirmation</li>
            <li>✓ Digital Space Passport issued</li>
            <li>✓ Journey timeline activated</li>
            <li>✓ Free cancellation up to 90 days</li>
            <li>✓ 24/7 Mission Support</li>
          </ul>
        </div>

        <!-- Readiness nudge -->
        <div class="glass p-3 rounded-lg mt-3 reveal" style="border:1px solid rgba(0,230,190,0.2);">
          <div style="display:flex;align-items:center;gap:0.75rem;">
            <div style="font-size:1.5rem;">🏅</div>
            <div>
              <div class="text-sm" style="font-weight:600;">Are you mission-ready?</div>
              <a href="<?= APP_URL ?>/readiness" class="link-glow text-xs">
                Take the Space Readiness Assessment →
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Back link -->
    <div class="mt-6">
      <a href="<?= APP_URL ?>/missions" class="btn btn-ghost btn-sm">← All Missions</a>
    </div>
  </div>
</section>
