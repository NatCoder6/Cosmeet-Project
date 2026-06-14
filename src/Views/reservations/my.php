<!-- ============================================================
     COSMEET — My Reservations
     ============================================================ -->
<section class="section" style="padding-top:8rem;">
  <div class="container">

    <div class="page-header reveal mb-5">
      <div class="eyebrow">Your Records</div>
      <h1 class="display-3">My <span class="gradient-text">Reservations</span></h1>
      <p class="text-dim" style="max-width:540px;">Track all your mission bookings, payment status, and launch details.</p>
    </div>

    <?php if (empty($reservations)): ?>
      <div class="glass p-5 rounded-lg text-center reveal" style="max-width:560px;margin:0 auto;">
        <div style="font-size:3rem;margin-bottom:1rem;">🪐</div>
        <h2 class="h3 mb-2">No reservations yet</h2>
        <p class="text-dim mb-4">You haven't reserved a seat on any mission. The universe awaits.</p>
        <a href="<?= APP_URL ?>/missions" class="btn btn-glow btn-lg">Browse Missions</a>
      </div>
    <?php else: ?>
      <div style="display:flex;flex-direction:column;gap:1.5rem;">
        <?php foreach ($reservations as $i => $r): ?>
          <?php
            $launchTs = strtotime($r['launch_date']);
            $statusColors = [
              'pending'   => ['bg' => 'rgba(255,160,0,0.1)',  'color' => 'var(--aurora-gold)',   'icon' => '⏳'],
              'paid'      => ['bg' => 'rgba(0,230,190,0.1)',  'color' => 'var(--aurora-cyan)',   'icon' => '✓'],
              'cancelled' => ['bg' => 'rgba(255,50,50,0.1)',  'color' => '#ff4757',              'icon' => '✕'],
              'completed' => ['bg' => 'rgba(255,215,0,0.1)',  'color' => 'var(--aurora-gold)',   'icon' => '🏅'],
            ];
            $sc = $statusColors[$r['status']] ?? $statusColors['pending'];
          ?>
          <div class="reservation-card glass rounded-lg overflow-hidden reveal" style="animation-delay:<?= $i * 0.06 ?>s;">
            <div style="display:flex;align-items:stretch;flex-wrap:wrap;">

              <!-- Left accent bar -->
              <div style="width:4px;background:<?= $sc['color'] ?>;flex-shrink:0;"></div>

              <!-- Body -->
              <div style="flex:1;padding:1.5rem;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:1rem;">
                  <div>
                    <div class="h4 mb-1"><?= htmlspecialchars($r['title']) ?></div>
                    <div class="text-xs font-mono text-dim">
                      <?= htmlspecialchars($r['spacecraft_name']) ?>
                      &nbsp;·&nbsp; <?= htmlspecialchars($r['destination']) ?>
                    </div>
                  </div>
                  <div>
                    <span class="badge" style="background:<?= $sc['bg'] ?>;color:<?= $sc['color'] ?>;border:1px solid <?= $sc['color'] ?>40;font-size:0.8rem;">
                      <?= $sc['icon'] ?> <?= ucfirst($r['status']) ?>
                    </span>
                  </div>
                </div>

                <div style="display:flex;gap:2rem;flex-wrap:wrap;margin-bottom:1rem;">
                  <div>
                    <div class="text-xs text-dim">Reservation Code</div>
                    <div class="font-mono text-sm" style="color:var(--aurora-cyan);">
                      <?= htmlspecialchars($r['reservation_code']) ?>
                    </div>
                  </div>
                  <div>
                    <div class="text-xs text-dim">Launch Date</div>
                    <div class="font-mono text-sm"><?= date('d M Y', $launchTs) ?></div>
                  </div>
                  <div>
                    <div class="text-xs text-dim">Seat Price</div>
                    <div class="font-mono text-sm" style="color:var(--star-bright);">
                      $<?= number_format($r['price_usd'], 0) ?>
                    </div>
                  </div>
                  <div>
                    <div class="text-xs text-dim">Booked</div>
                    <div class="font-mono text-sm"><?= date('d M Y', strtotime($r['created_at'])) ?></div>
                  </div>
                </div>

                <!-- Actions -->
                <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
                  <a href="<?= APP_URL ?>/missions/<?= htmlspecialchars($r['slug']) ?>"
                     class="btn btn-ghost btn-sm">View Mission</a>

                  <?php if ($r['status'] === 'pending'): ?>
                    <a href="<?= APP_URL ?>/payment/<?= htmlspecialchars($r['reservation_code']) ?>"
                       class="btn btn-primary btn-sm">Complete Payment →</a>
                  <?php endif; ?>

                  <?php if (in_array($r['status'], ['pending', 'paid']) && $launchTs > time() + 7776000): ?>
                    <form method="POST" action="<?= APP_URL ?>/cancel-reservation/<?= $r['id'] ?>"
                          onsubmit="return confirm('Cancel this reservation? This cannot be undone.');">
                      <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= htmlspecialchars($csrf) ?>">
                      <button type="submit" class="btn btn-sm"
                              style="background:rgba(255,50,50,0.1);color:#ff4757;border:1px solid rgba(255,50,50,0.3);">
                        Cancel
                      </button>
                    </form>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="text-center mt-5 reveal">
        <a href="<?= APP_URL ?>/missions" class="btn btn-primary btn-lg">+ Reserve Another Mission</a>
      </div>
    <?php endif; ?>

  </div>
</section>
