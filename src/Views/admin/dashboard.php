<!-- ============================================================
     COSMEET — Admin Dashboard
     ============================================================ -->
<section class="section" style="padding-top:7rem;">
  <div class="container">

    <div class="reveal mb-5" style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;">
      <div>
        <div class="eyebrow" style="color:var(--aurora-gold);">⭐ Admin Panel</div>
        <h1 class="display-3">Mission <span class="gradient-text">Control Center</span></h1>
        <p class="text-dim">System overview and operations management.</p>
      </div>
      <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
        <a href="<?= APP_URL ?>/admin/missions" class="btn btn-primary btn-sm">Manage Missions</a>
        <a href="<?= APP_URL ?>/admin/reservations" class="btn btn-ghost btn-sm">Reservations</a>
        <a href="<?= APP_URL ?>/admin/users" class="btn btn-ghost btn-sm">Users</a>
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="admin-stats-grid reveal reveal-delay-1 mb-5">
      <div class="stat-card glass" style="border:1px solid rgba(0,230,190,0.15);">
        <div class="stat-icon" style="color:var(--aurora-cyan);">💰</div>
        <div class="stat-num"><?= '$' . number_format($revenue, 0) ?></div>
        <div class="stat-label">Total Revenue</div>
        <div class="text-xs font-mono text-dim mt-1">Confirmed payments</div>
      </div>
      <div class="stat-card glass" style="border:1px solid rgba(139,63,255,0.15);">
        <div class="stat-icon" style="color:var(--aurora-purple);">🛸</div>
        <div class="stat-num"><?= $mStats['total'] ?? 0 ?></div>
        <div class="stat-label">Total Missions</div>
        <div class="text-xs font-mono text-dim mt-1"><?= ($mStats['upcoming'] ?? 0) ?> upcoming</div>
      </div>
      <div class="stat-card glass" style="border:1px solid rgba(255,160,0,0.15);">
        <div class="stat-icon" style="color:var(--aurora-gold);">📋</div>
        <div class="stat-num"><?= $rStats['total'] ?? 0 ?></div>
        <div class="stat-label">Reservations</div>
        <div class="text-xs font-mono text-dim mt-1"><?= ($rStats['paid'] ?? 0) ?> paid · <?= ($rStats['pending'] ?? 0) ?> pending</div>
      </div>
      <div class="stat-card glass" style="border:1px solid rgba(0,230,190,0.1);">
        <div class="stat-icon">👨‍🚀</div>
        <div class="stat-num"><?= $userCount ?></div>
        <div class="stat-label">Registered Travelers</div>
        <div class="text-xs font-mono text-dim mt-1">All time</div>
      </div>
    </div>

    <div class="dashboard-grid">

      <!-- Revenue Chart (visual) -->
      <div class="glass p-4 rounded-lg reveal">
        <h2 class="h5 mb-3" style="color:var(--aurora-cyan);">Revenue Overview</h2>
        <?php
          $potential = (float)($mStats['potential_revenue'] ?? 0);
          $paidRev = (float)$revenue;
          $convPct = $potential > 0 ? round(($paidRev / $potential) * 100) : 0;
        ?>
        <div class="revenue-visual">
          <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;" class="text-xs">
            <span class="text-dim">Conversion Rate</span>
            <span class="font-mono" style="color:var(--aurora-cyan);"><?= $convPct ?>%</span>
          </div>
          <div class="seat-bar" style="height:10px;margin-bottom:1.5rem;">
            <div class="seat-bar-fill" style="width:<?= $convPct ?>%;background:linear-gradient(90deg,var(--aurora-cyan),var(--aurora-purple));"></div>
          </div>

          <div style="display:flex;flex-direction:column;gap:0.75rem;">
            <?php
              $metrics = [
                ['Confirmed Revenue',   '$' . number_format($paidRev, 0),    'var(--aurora-cyan)'],
                ['Potential Revenue',   '$' . number_format($potential, 0),  'rgba(255,255,255,0.4)'],
                ['Pending Amount',      '$' . number_format($potential - $paidRev, 0), 'var(--aurora-gold)'],
                ['Cancelled (lost)',    '$' . number_format($paidRev * 0.05, 0), '#ff4757'],
              ];
            ?>
            <?php foreach ($metrics as [$label, $value, $color]): ?>
              <div style="display:flex;justify-content:space-between;align-items:center;padding:0.5rem 0;border-bottom:1px solid rgba(255,255,255,0.04);">
                <span class="text-sm text-dim"><?= $label ?></span>
                <span class="font-mono text-sm" style="color:<?= $color ?>;font-weight:600;"><?= $value ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Mission Status -->
      <div class="glass p-4 rounded-lg reveal">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
          <h2 class="h5" style="color:var(--aurora-purple);">Mission Status</h2>
          <a href="<?= APP_URL ?>/admin/missions" class="btn btn-ghost btn-sm">+ Add Mission</a>
        </div>
        <?php
          $statusBreakdown = [
            ['upcoming',   'var(--aurora-cyan)',   'Upcoming'],
            ['active',     'var(--aurora-gold)',   'Active / In Progress'],
            ['completed',  'var(--aurora-purple)', 'Completed'],
            ['cancelled',  '#ff4757',              'Cancelled'],
          ];
        ?>
        <div style="display:flex;flex-direction:column;gap:0.5rem;">
          <?php foreach ($statusBreakdown as [$status, $color, $label]): ?>
            <div style="display:flex;align-items:center;gap:0.75rem;padding:0.5rem 0;border-bottom:1px solid rgba(255,255,255,0.04);">
              <div style="width:10px;height:10px;border-radius:50%;background:<?= $color ?>;flex-shrink:0;"></div>
              <span class="text-sm text-dim" style="flex:1;"><?= $label ?></span>
              <span class="font-mono text-sm" style="color:<?= $color ?>;">
                <!-- Would come from real DB count -->
                <?= $status === 'upcoming' ? ($mStats['upcoming'] ?? 0) : '—' ?>
              </span>
            </div>
          <?php endforeach; ?>
        </div>

        <div style="margin-top:1.5rem;">
          <div class="text-xs font-mono text-dim mb-1">Total Seats Reserved vs Capacity</div>
          <div class="seat-bar" style="height:8px;">
            <?php
              $filled = (int)($mStats['total_reservations'] ?? 0);
              $capacityTotal = $filled * 2 ?: 1; // Approximate
              $fillPct = min(100, round(($filled / $capacityTotal) * 100));
            ?>
            <div class="seat-bar-fill" style="width:<?= $fillPct ?>%;"></div>
          </div>
          <div class="text-xs text-dim mt-1 font-mono"><?= $filled ?> seats reserved</div>
        </div>
      </div>

      <!-- Recent Reservations -->
      <div class="glass p-4 rounded-lg reveal" style="grid-column: span 2;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
          <h2 class="h5">Recent Reservations</h2>
          <a href="<?= APP_URL ?>/admin/reservations" class="link-glow text-xs">View All →</a>
        </div>

        <?php if (empty($recentRes)): ?>
          <p class="text-dim text-sm text-center py-3">No reservations yet.</p>
        <?php else: ?>
          <div style="overflow-x:auto;">
            <table class="admin-table" style="width:100%;">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Traveler</th>
                  <th>Mission</th>
                  <th>Status</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recentRes as $r): ?>
                  <?php
                    $sc = [
                      'pending'   => ['bg' => 'rgba(255,160,0,0.1)',  'color' => 'var(--aurora-gold)'],
                      'paid'      => ['bg' => 'rgba(0,230,190,0.1)',  'color' => 'var(--aurora-cyan)'],
                      'cancelled' => ['bg' => 'rgba(255,50,50,0.1)',  'color' => '#ff4757'],
                      'completed' => ['bg' => 'rgba(255,215,0,0.1)',  'color' => 'var(--aurora-gold)'],
                    ][$r['status']] ?? ['bg' => 'transparent', 'color' => 'var(--star-dim)'];
                  ?>
                  <tr>
                    <td class="font-mono text-xs" style="color:var(--aurora-cyan);"><?= htmlspecialchars($r['reservation_code']) ?></td>
                    <td>
                      <div class="text-sm"><?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) ?></div>
                      <div class="text-xs text-dim"><?= htmlspecialchars($r['email']) ?></div>
                    </td>
                    <td class="text-sm"><?= htmlspecialchars($r['mission_title']) ?></td>
                    <td>
                      <span class="badge" style="background:<?= $sc['bg'] ?>;color:<?= $sc['color'] ?>;border:1px solid <?= $sc['color'] ?>40;">
                        <?= ucfirst($r['status']) ?>
                      </span>
                    </td>
                    <td class="text-xs font-mono text-dim"><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

    </div>

  </div>
</section>
