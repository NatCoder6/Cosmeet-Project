<!-- ============================================================
     COSMEET — Missions Index
     ============================================================ -->

<!-- Page Hero -->
<section class="page-hero section" style="padding-top:8rem;padding-bottom:3rem;text-align:center;">
  <div class="eyebrow reveal">Mission Registry · <?= date('Y') ?></div>
  <h1 class="display-2 reveal reveal-delay-1">
    Choose Your <span class="gradient-text">Destination</span>
  </h1>
  <p class="text-dim reveal reveal-delay-2" style="max-width:600px;margin:0 auto 2.5rem;font-size:1.1rem;line-height:1.8;">
    From low-Earth orbit to lunar flyby — every mission is a one-way door to a new perspective on existence.
  </p>

  <!-- Filters -->
  <form method="GET" action="<?= APP_URL ?>/missions" class="mission-filters glass reveal reveal-delay-3" role="search">
    <div class="filter-group">
      <input class="form-input" type="search" name="search" id="mission-search"
             value="<?= htmlspecialchars($filters['search']) ?>"
             placeholder="🔍 Search missions…" aria-label="Search missions">
    </div>
    <div class="filter-group">
      <select class="form-input" name="destination" aria-label="Filter by destination">
        <option value="">All Destinations</option>
        <option value="Low Earth Orbit" <?= $filters['destination'] === 'Low Earth Orbit' ? 'selected' : '' ?>>Low Earth Orbit</option>
        <option value="Lunar Orbit" <?= $filters['destination'] === 'Lunar Orbit' ? 'selected' : '' ?>>Lunar Orbit</option>
        <option value="Moon Landing" <?= $filters['destination'] === 'Moon Landing' ? 'selected' : '' ?>>Moon Landing</option>
        <option value="Mars Transit" <?= $filters['destination'] === 'Mars Transit' ? 'selected' : '' ?>>Mars Transit</option>
        <option value="Space Station" <?= $filters['destination'] === 'Space Station' ? 'selected' : '' ?>>Space Station</option>
      </select>
    </div>
    <div class="filter-group">
      <select class="form-input" name="type" aria-label="Filter by type">
        <option value="">All Types</option>
        <option value="orbital" <?= $filters['type'] === 'orbital' ? 'selected' : '' ?>>Orbital</option>
        <option value="lunar" <?= $filters['type'] === 'lunar' ? 'selected' : '' ?>>Lunar</option>
        <option value="deep_space" <?= $filters['type'] === 'deep_space' ? 'selected' : '' ?>>Deep Space</option>
        <option value="station" <?= $filters['type'] === 'station' ? 'selected' : '' ?>>Station</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    <?php if (array_filter($filters)): ?>
      <a href="<?= APP_URL ?>/missions" class="btn btn-ghost btn-sm">Clear</a>
    <?php endif; ?>
  </form>
</section>

<!-- Mission Grid -->
<section class="section" style="padding-top:1rem;">
  <div class="container">

    <?php if (empty($missions)): ?>
      <div class="empty-state text-center glass p-5 reveal">
        <div style="font-size:3rem;margin-bottom:1rem;">🌌</div>
        <h2 class="h3 mb-2">No missions found</h2>
        <p class="text-dim mb-4">Try different filters or check back later for new missions.</p>
        <a href="<?= APP_URL ?>/missions" class="btn btn-primary">View All Missions</a>
      </div>
    <?php else: ?>
      <div class="mission-grid">
        <?php foreach ($missions as $i => $m): ?>
          <?php
            $pct = $m['seats_total'] > 0
              ? round(($m['seats_reserved'] / $m['seats_total']) * 100)
              : 0;
            $launchTs = strtotime($m['launch_date']);
            $daysLeft = max(0, ceil(($launchTs - time()) / 86400));
            $urgency = $m['seats_available'] <= 3 ? 'urgent' : ($m['seats_available'] <= 10 ? 'low' : '');
            $diffColors = [
              'beginner' => 'var(--aurora-cyan)',
              'intermediate' => 'var(--aurora-purple)',
              'advanced' => 'var(--aurora-gold)',
              'expert' => '#ff4757',
            ];
            $diffColor = $diffColors[$m['difficulty_level']] ?? 'var(--aurora-cyan)';
          ?>
          <article class="mission-card glass reveal" style="animation-delay:<?= $i * 0.08 ?>s"
                   data-mission-id="<?= $m['id'] ?>">

            <!-- Card Header Visual -->
            <div class="mission-card-visual">
              <div class="mission-destination-badge">
                <?= htmlspecialchars($m['destination']) ?>
              </div>
              <?php if ($m['featured']): ?>
                <div class="mission-featured-badge">⭐ Featured</div>
              <?php endif; ?>
              <div class="mission-card-bg" data-dest="<?= htmlspecialchars($m['destination']) ?>" aria-hidden="true"></div>
            </div>

            <!-- Card Body -->
            <div class="mission-card-body">
              <div class="mission-type-row">
                <span class="badge badge-outline" style="text-transform:capitalize;"><?= htmlspecialchars($m['mission_type']) ?></span>
                <span class="badge" style="background:<?= $diffColor ?>20;color:<?= $diffColor ?>;border:1px solid <?= $diffColor ?>40;text-transform:capitalize;">
                  <?= htmlspecialchars($m['difficulty_level']) ?>
                </span>
              </div>

              <h2 class="mission-title h4">
                <a href="<?= APP_URL ?>/missions/<?= htmlspecialchars($m['slug']) ?>" class="stretched-link">
                  <?= htmlspecialchars($m['title']) ?>
                </a>
              </h2>

              <div class="mission-craft text-xs font-mono text-dim">
                🛸 <?= htmlspecialchars($m['spacecraft_name']) ?>
                &nbsp;·&nbsp;
                ⭐ Safety: <?= $m['safety_rating'] ?>/10
              </div>

              <!-- Launch countdown -->
              <div class="mission-launch-info">
                <div class="launch-date">
                  <span class="text-xs text-dim font-mono">LAUNCH</span>
                  <strong style="font-family:var(--font-display);color:var(--aurora-cyan);">
                    <?= date('d M Y', $launchTs) ?>
                  </strong>
                </div>
                <?php if ($daysLeft > 0): ?>
                  <div class="countdown-pill font-mono <?= $daysLeft < 30 ? 'countdown-urgent' : '' ?>">
                    T–<?= $daysLeft ?>d
                  </div>
                <?php else: ?>
                  <div class="countdown-pill countdown-urgent">LAUNCHING</div>
                <?php endif; ?>
              </div>

              <!-- Seat availability bar -->
              <div class="seat-bar-wrap">
                <div style="display:flex;justify-content:space-between;margin-bottom:0.4rem;">
                  <span class="text-xs text-dim">Seats</span>
                  <span class="text-xs font-mono <?= $urgency ? 'text-gold' : 'text-cyan' ?>">
                    <?= $m['seats_available'] ?> / <?= $m['seats_total'] ?> available
                    <?= $urgency === 'urgent' ? '🔥' : '' ?>
                  </span>
                </div>
                <div class="seat-bar">
                  <div class="seat-bar-fill <?= $pct >= 90 ? 'seat-bar-fill--critical' : '' ?>"
                       style="width:<?= $pct ?>%"></div>
                </div>
              </div>

              <!-- Price & CTA -->
              <div class="mission-card-footer">
                <div class="mission-price">
                  <span class="price-label text-xs font-mono text-dim">FROM</span>
                  <span class="price-value" style="font-family:var(--font-display);font-size:1.4rem;font-weight:700;color:var(--star-bright);">
                    $<?= number_format($m['price_usd'], 0) ?>
                  </span>
                  <span class="text-xs text-dim">/ seat</span>
                </div>
                <a href="<?= APP_URL ?>/missions/<?= htmlspecialchars($m['slug']) ?>"
                   class="btn btn-primary btn-sm">
                  View Mission →
                </a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <!-- Pagination -->
      <?php if ($page > 1 || count($missions) >= 12): ?>
        <nav class="pagination text-center mt-6" aria-label="Mission pages">
          <?php if ($page > 1): ?>
            <a href="?<?= http_build_query(array_merge($filters, ['page' => $page - 1])) ?>"
               class="btn btn-ghost btn-sm">← Previous</a>
          <?php endif; ?>
          <span class="text-dim font-mono text-sm" style="padding:0 1rem;">Page <?= $page ?></span>
          <?php if (count($missions) >= 12): ?>
            <a href="?<?= http_build_query(array_merge($filters, ['page' => $page + 1])) ?>"
               class="btn btn-ghost btn-sm">Next →</a>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
    <?php endif; ?>

  </div>
</section>
