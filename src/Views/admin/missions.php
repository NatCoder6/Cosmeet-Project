<!-- ============================================================
     COSMEET — Admin: Manage Missions
     ============================================================ -->
<section class="section" style="padding-top:7rem;">
  <div class="container">

    <div class="reveal mb-5" style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;">
      <div>
        <div class="eyebrow" style="color:var(--aurora-gold);">⭐ Admin</div>
        <h1 class="display-3">Manage <span class="gradient-text">Missions</span></h1>
      </div>
      <a href="<?= APP_URL ?>/admin" class="btn btn-ghost btn-sm">← Dashboard</a>
    </div>

    <!-- Add Mission Form -->
    <div class="glass p-5 rounded-lg mb-6 reveal">
      <h2 class="h4 mb-4" style="color:var(--aurora-cyan);">+ Create New Mission</h2>
      <form method="POST" action="<?= APP_URL ?>/admin/missions" class="auth-form">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= htmlspecialchars($csrf) ?>">

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Mission Title *</label>
            <input class="form-input" type="text" name="title" required placeholder="Lunar Horizon Alpha">
          </div>
          <div class="form-group">
            <label class="form-label">Destination *</label>
            <select class="form-input" name="destination" required>
              <option value="">Select destination…</option>
              <option value="Low Earth Orbit">Low Earth Orbit</option>
              <option value="Lunar Orbit">Lunar Orbit</option>
              <option value="Moon Landing">Moon Landing</option>
              <option value="Mars Transit">Mars Transit</option>
              <option value="Space Station">Space Station</option>
              <option value="Deep Space">Deep Space</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Mission Description *</label>
          <textarea class="form-input" name="description" required rows="3"
                    placeholder="Describe the mission experience, objectives, and highlights…"
                    style="resize:vertical;"></textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Spacecraft *</label>
            <select class="form-input" name="spacecraft_id" required>
              <option value="">Select spacecraft…</option>
              <?php foreach ($spacecraft as $sc): ?>
                <option value="<?= $sc['id'] ?>"><?= htmlspecialchars($sc['name']) ?> (Capacity: <?= $sc['capacity'] ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Mission Type *</label>
            <select class="form-input" name="mission_type" required>
              <option value="orbital">Orbital</option>
              <option value="lunar">Lunar</option>
              <option value="deep_space">Deep Space</option>
              <option value="station">Station</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Launch Date *</label>
            <input class="form-input" type="datetime-local" name="launch_date" required>
          </div>
          <div class="form-group">
            <label class="form-label">Return Date *</label>
            <input class="form-input" type="datetime-local" name="return_date" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Total Seats *</label>
            <input class="form-input" type="number" name="seats_total" required min="1" max="500" placeholder="20">
          </div>
          <div class="form-group">
            <label class="form-label">Ticket Price (USD) *</label>
            <input class="form-input" type="number" name="price_usd" required min="1000" step="500" placeholder="250000">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Difficulty Level</label>
            <select class="form-input" name="difficulty_level">
              <option value="beginner">Beginner</option>
              <option value="intermediate" selected>Intermediate</option>
              <option value="advanced">Advanced</option>
              <option value="expert">Expert</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Status</label>
            <select class="form-input" name="status">
              <option value="upcoming">Upcoming</option>
              <option value="active">Active</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label style="display:flex;gap:0.75rem;align-items:center;cursor:pointer;">
            <input type="checkbox" name="featured" style="accent-color:var(--aurora-gold);width:1rem;height:1rem;">
            <span class="text-sm">⭐ Feature this mission on homepage</span>
          </label>
        </div>

        <button type="submit" class="btn btn-glow btn-lg">Create Mission</button>
      </form>
    </div>

    <!-- Missions List -->
    <div class="glass p-4 rounded-lg reveal">
      <h2 class="h4 mb-4">All Missions (<?= count($missions) ?>)</h2>

      <?php if (empty($missions)): ?>
        <p class="text-dim text-center py-4">No missions created yet.</p>
      <?php else: ?>
        <div style="overflow-x:auto;">
          <table class="admin-table" style="width:100%;">
            <thead>
              <tr>
                <th>Mission</th>
                <th>Destination</th>
                <th>Spacecraft</th>
                <th>Launch</th>
                <th>Seats</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($missions as $m): ?>
                <?php
                  $avail = (int)$m['seats_available'];
                  $sc = [
                    'upcoming'  => 'var(--aurora-cyan)',
                    'active'    => 'var(--aurora-gold)',
                    'completed' => 'var(--aurora-purple)',
                    'cancelled' => '#ff4757',
                  ][$m['status']] ?? 'var(--star-dim)';
                ?>
                <tr>
                  <td>
                    <div class="text-sm" style="font-weight:600;"><?= htmlspecialchars($m['title']) ?></div>
                    <?php if ($m['featured']): ?>
                      <span class="badge" style="background:rgba(255,160,0,0.1);color:var(--aurora-gold);font-size:0.65rem;">⭐ Featured</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-sm text-dim"><?= htmlspecialchars($m['destination']) ?></td>
                  <td class="text-sm text-dim"><?= htmlspecialchars($m['spacecraft_name']) ?></td>
                  <td class="font-mono text-xs"><?= date('d M Y', strtotime($m['launch_date'])) ?></td>
                  <td>
                    <div class="text-xs font-mono <?= $avail <= 3 ? 'text-gold' : 'text-cyan' ?>">
                      <?= $avail ?>/<?= $m['seats_total'] ?>
                    </div>
                    <div class="seat-bar" style="height:3px;width:60px;margin-top:3px;">
                      <div class="seat-bar-fill <?= $avail <= 3 ? 'seat-bar-fill--critical' : '' ?>"
                           style="width:<?= $m['seats_total'] > 0 ? round(($m['seats_reserved']/$m['seats_total'])*100) : 0 ?>%"></div>
                    </div>
                  </td>
                  <td class="font-mono text-sm">$<?= number_format($m['price_usd'], 0) ?></td>
                  <td>
                    <span class="badge" style="background:<?= $sc ?>1a;color:<?= $sc ?>;border:1px solid <?= $sc ?>40;font-size:0.7rem;">
                      <?= ucfirst($m['status']) ?>
                    </span>
                  </td>
                  <td>
                    <div style="display:flex;gap:0.5rem;">
                      <a href="<?= APP_URL ?>/missions/<?= htmlspecialchars($m['slug']) ?>"
                         class="btn btn-ghost btn-sm" target="_blank" title="View public page">👁</a>
                      <form method="POST" action="<?= APP_URL ?>/admin/missions/delete/<?= $m['id'] ?>"
                            onsubmit="return confirm('Delete mission \'<?= htmlspecialchars(addslashes($m['title'])) ?>\'? This cannot be undone.');">
                        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= htmlspecialchars($csrf) ?>">
                        <button type="submit" class="btn btn-sm"
                                style="background:rgba(255,50,50,0.1);color:#ff4757;border:1px solid rgba(255,50,50,0.3);"
                                title="Delete mission">✕</button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

  </div>
</section>
