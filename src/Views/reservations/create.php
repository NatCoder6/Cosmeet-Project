<!-- ============================================================
     COSMEET — Reserve Seat View
     ============================================================ -->
<?php
  $launchTs = strtotime($mission['launch_date']);
  $daysLeft = max(0, ceil(($launchTs - time()) / 86400));
?>
<section class="section" style="padding-top:8rem;">
  <div class="container" style="max-width:780px;">

    <!-- Mission Summary Bar -->
    <div class="glass p-3 rounded-lg mb-5 reveal" style="border:1px solid rgba(0,230,190,0.2);">
      <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;">
        <div class="spacecraft-avatar" aria-hidden="true" style="font-size:2rem;">🚀</div>
        <div style="flex:1;">
          <div class="h4 mb-0"><?= htmlspecialchars($mission['title']) ?></div>
          <div class="text-xs font-mono text-dim">
            <?= htmlspecialchars($mission['spacecraft_name']) ?>
            &nbsp;·&nbsp; <?= htmlspecialchars($mission['destination']) ?>
            &nbsp;·&nbsp; Launch: <?= date('d M Y', $launchTs) ?>
          </div>
        </div>
        <div style="text-align:right;">
          <div style="font-family:var(--font-display);font-size:1.6rem;font-weight:700;">
            $<?= number_format($mission['price_usd'], 0) ?>
          </div>
          <div class="text-xs text-dim">per seat</div>
        </div>
      </div>
    </div>

    <!-- Progress steps -->
    <div class="booking-steps reveal reveal-delay-1">
      <div class="step step--active">
        <div class="step-num">1</div>
        <div class="step-label">Review</div>
      </div>
      <div class="step-connector"></div>
      <div class="step">
        <div class="step-num">2</div>
        <div class="step-label">Payment</div>
      </div>
      <div class="step-connector"></div>
      <div class="step">
        <div class="step-num">3</div>
        <div class="step-label">Confirmed</div>
      </div>
    </div>

    <!-- Reservation Form -->
    <div class="glass p-5 rounded-lg reveal reveal-delay-2">
      <h1 class="h3 mb-1">Confirm Your Seat</h1>
      <p class="text-dim mb-4">Review the details below and confirm your reservation. Payment follows in the next step.</p>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-error mb-3" role="alert">
          <?php foreach ($errors as $e): ?>
            <div>⚠ <?= htmlspecialchars($e) ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?= APP_URL ?>/reserve">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= htmlspecialchars($csrf) ?>">
        <input type="hidden" name="mission_id" value="<?= $mission['id'] ?>">

        <!-- Traveler Info (read-only) -->
        <div class="reservation-info-card mb-4" style="background:rgba(0,230,190,0.04);border:1px solid rgba(0,230,190,0.15);border-radius:var(--radius);padding:1.25rem;">
          <h2 class="text-xs font-mono text-dim mb-3" style="letter-spacing:0.1em;text-transform:uppercase;">Traveler Details</h2>
          <div class="grid-2">
            <div>
              <div class="text-xs text-dim">Full Name</div>
              <div class="font-mono" style="color:var(--star-bright);">
                <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
              </div>
            </div>
            <div>
              <div class="text-xs text-dim">Email</div>
              <div class="font-mono" style="color:var(--star-bright);"><?= htmlspecialchars($user['email']) ?></div>
            </div>
          </div>
        </div>

        <!-- Mission Details -->
        <div class="reservation-info-card mb-4" style="background:rgba(139,63,255,0.04);border:1px solid rgba(139,63,255,0.15);border-radius:var(--radius);padding:1.25rem;">
          <h2 class="text-xs font-mono text-dim mb-3" style="letter-spacing:0.1em;text-transform:uppercase;">Mission Details</h2>
          <div class="grid-2">
            <div>
              <div class="text-xs text-dim">Mission</div>
              <div style="color:var(--star-bright);"><?= htmlspecialchars($mission['title']) ?></div>
            </div>
            <div>
              <div class="text-xs text-dim">Destination</div>
              <div style="color:var(--aurora-cyan);"><?= htmlspecialchars($mission['destination']) ?></div>
            </div>
            <div>
              <div class="text-xs text-dim">Spacecraft</div>
              <div><?= htmlspecialchars($mission['spacecraft_name']) ?></div>
            </div>
            <div>
              <div class="text-xs text-dim">Launch Date</div>
              <div><?= date('d M Y', $launchTs) ?></div>
            </div>
            <div>
              <div class="text-xs text-dim">Seats Available</div>
              <div style="color:<?= $mission['seats_available'] <= 5 ? 'var(--aurora-gold)' : 'var(--aurora-cyan)' ?>;">
                <?= $mission['seats_available'] ?> remaining
              </div>
            </div>
            <div>
              <div class="text-xs text-dim">Countdown</div>
              <div class="font-mono" style="color:var(--aurora-gold);">T-<?= $daysLeft ?> days</div>
            </div>
          </div>
        </div>

        <!-- Special Requests -->
        <div class="form-group">
          <label class="form-label" for="special_requests">
            Special Requests <span class="text-dim">(Optional)</span>
          </label>
          <textarea class="form-input" id="special_requests" name="special_requests"
                    rows="3" maxlength="500"
                    placeholder="Dietary needs, medical considerations, preferred seat area, special accommodations…"
                    style="resize:vertical;"></textarea>
          <div class="text-xs text-dim mt-1">Maximum 500 characters</div>
        </div>

        <!-- Price Breakdown -->
        <div class="price-breakdown glass p-3 rounded mb-4" style="border:1px solid rgba(255,255,255,0.06);">
          <h2 class="text-xs font-mono text-dim mb-3" style="letter-spacing:0.1em;text-transform:uppercase;">Price Breakdown</h2>
          <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;" class="text-sm">
            <span>Seat reservation</span>
            <span>$<?= number_format($mission['price_usd'], 2) ?></span>
          </div>
          <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;" class="text-sm text-dim">
            <span>Space tourism levy</span>
            <span>$<?= number_format($mission['price_usd'] * 0.05, 2) ?></span>
          </div>
          <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;" class="text-sm text-dim">
            <span>Mission support fee</span>
            <span>$<?= number_format($mission['price_usd'] * 0.02, 2) ?></span>
          </div>
          <div style="border-top:1px solid rgba(255,255,255,0.08);margin:0.75rem 0;padding-top:0.75rem;display:flex;justify-content:space-between;">
            <strong>Total</strong>
            <strong style="font-family:var(--font-display);font-size:1.25rem;color:var(--aurora-cyan);">
              $<?= number_format($mission['price_usd'] * 1.07, 2) ?>
            </strong>
          </div>
        </div>

        <!-- Acknowledgements -->
        <div class="form-group mb-4">
          <label style="display:flex;gap:0.75rem;align-items:flex-start;cursor:pointer;">
            <input type="checkbox" name="acknowledge_risk" required
                   style="width:1rem;height:1rem;margin-top:0.2rem;accent-color:var(--aurora-cyan);flex-shrink:0;">
            <span class="text-sm text-dim">
              I understand that space travel involves inherent risks. I certify that I have reviewed the
              <a href="#" class="link-glow">mission safety briefing</a> and accept these conditions.
            </span>
          </label>
        </div>

        <div style="display:flex;gap:1rem;flex-wrap:wrap;">
          <button type="submit" class="btn btn-glow btn-xl" style="flex:1;">
            🚀 Confirm & Proceed to Payment
          </button>
          <a href="<?= APP_URL ?>/missions/<?= htmlspecialchars($mission['slug']) ?>"
             class="btn btn-ghost btn-xl">
            ← Back
          </a>
        </div>
      </form>
    </div>

  </div>
</section>
