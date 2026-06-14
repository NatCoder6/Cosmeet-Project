<!-- ============================================================
     COSMEET — Admin: Reservations
     ============================================================ -->
<section class="section" style="padding-top:7rem;">
  <div class="container">

    <div class="reveal mb-5" style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;">
      <div>
        <div class="eyebrow" style="color:var(--aurora-gold);">⭐ Admin</div>
        <h1 class="display-3">All <span class="gradient-text">Reservations</span></h1>
        <p class="text-dim">Page <?= $page ?> · <?= count($reservations) ?> records shown</p>
      </div>
      <a href="<?= APP_URL ?>/admin" class="btn btn-ghost btn-sm">← Dashboard</a>
    </div>

    <div class="glass p-4 rounded-lg reveal">
      <?php if (empty($reservations)): ?>
        <p class="text-dim text-center py-5">No reservations found.</p>
      <?php else: ?>
        <div style="overflow-x:auto;">
          <table class="admin-table" style="width:100%;">
            <thead>
              <tr>
                <th>Code</th>
                <th>Traveler</th>
                <th>Mission</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Booked</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reservations as $r):
                $statusStyles = [
                  'pending'   => ['rgba(255,160,0,0.12)',   'var(--aurora-gold)',   '⏳'],
                  'paid'      => ['rgba(0,230,190,0.12)',   'var(--aurora-cyan)',   '✓'],
                  'cancelled' => ['rgba(255,50,50,0.12)',   '#ff4757',             '✕'],
                  'completed' => ['rgba(255,215,0,0.12)',   'var(--aurora-gold)',   '🏅'],
                ];
                [$sbg, $sc, $sico] = $statusStyles[$r['status']] ?? ['transparent','var(--star-dim)','?'];
              ?>
                <tr>
                  <td>
                    <span class="font-mono text-xs" style="color:var(--aurora-cyan);">
                      <?= htmlspecialchars($r['reservation_code']) ?>
                    </span>
                  </td>
                  <td>
                    <div class="text-sm" style="font-weight:600;">
                      <?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) ?>
                    </div>
                    <div class="text-xs text-dim"><?= htmlspecialchars($r['email']) ?></div>
                  </td>
                  <td>
                    <div class="text-sm"><?= htmlspecialchars($r['mission_title']) ?></div>
                  </td>
                  <td class="font-mono text-sm" style="color:var(--star-bright);">
                    $<?= number_format($r['price_usd'], 0) ?>
                  </td>
                  <td>
                    <span class="badge" style="background:<?= $sbg ?>;color:<?= $sc ?>;border:1px solid <?= $sc ?>40;">
                      <?= $sico ?> <?= ucfirst($r['status']) ?>
                    </span>
                  </td>
                  <td class="font-mono text-xs text-dim">
                    <?= date('d M Y', strtotime($r['created_at'])) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <nav class="text-center mt-4" aria-label="Reservation pages">
          <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn btn-ghost btn-sm">← Previous</a>
          <?php endif; ?>
          <span class="text-dim font-mono text-sm" style="padding:0 1rem;">Page <?= $page ?></span>
          <?php if (count($reservations) >= 20): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-ghost btn-sm">Next →</a>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
    </div>

  </div>
</section>
