<!-- ============================================================
     COSMEET — Register View
     ============================================================ -->
<section class="auth-section section">
  <div class="auth-container">

    <!-- Decorative orbit rings -->
    <div class="auth-orbit" aria-hidden="true">
      <div class="orbit-ring orbit-ring-1"></div>
      <div class="orbit-ring orbit-ring-2"></div>
      <div class="orbit-ring orbit-ring-3"></div>
      <div class="orbit-planet"></div>
    </div>

    <div class="auth-card glass reveal">
      <!-- Header -->
      <div class="auth-header text-center mb-4">
        <div class="auth-icon" aria-hidden="true">🚀</div>
        <h1 class="h2 mb-1">Begin Your Journey</h1>
        <p class="text-dim">Join humanity's next great adventure</p>
      </div>

      <!-- Errors -->
      <?php if (!empty($errors)): ?>
        <div class="alert alert-error mb-3" role="alert">
          <?php foreach ($errors as $e): ?>
            <div>⚠ <?= htmlspecialchars($e) ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <form method="POST" action="<?= APP_URL ?>/register" novalidate class="auth-form">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= htmlspecialchars($csrf) ?>">

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="first_name">First Name</label>
            <input class="form-input" type="text" id="first_name" name="first_name"
                   value="<?= htmlspecialchars($old['first_name'] ?? '') ?>"
                   placeholder="Neil" required autocomplete="given-name">
          </div>
          <div class="form-group">
            <label class="form-label" for="last_name">Last Name</label>
            <input class="form-input" type="text" id="last_name" name="last_name"
                   value="<?= htmlspecialchars($old['last_name'] ?? '') ?>"
                   placeholder="Armstrong" required autocomplete="family-name">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <input class="form-input" type="email" id="email" name="email"
                 value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                 placeholder="neil@cosmeet.space" required autocomplete="email">
        </div>

        <div class="form-group">
          <label class="form-label" for="phone">Phone Number <span class="text-dim">(Optional)</span></label>
          <input class="form-input" type="tel" id="phone" name="phone"
                 value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
                 placeholder="+1 555 000 0000" autocomplete="tel">
        </div>

        <div class="form-group">
          <label class="form-label" for="nationality">Nationality <span class="text-dim">(Optional)</span></label>
          <input class="form-input" type="text" id="nationality" name="nationality"
                 value="<?= htmlspecialchars($old['nationality'] ?? '') ?>"
                 placeholder="e.g. Ethiopian, American…">
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-password-wrap">
              <input class="form-input" type="password" id="password" name="password"
                     placeholder="Min. 8 characters" required autocomplete="new-password" minlength="8">
              <button type="button" class="toggle-password" aria-label="Show password" data-target="password">👁</button>
            </div>
            <div class="password-strength" id="password-strength" aria-live="polite">
              <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
              <span class="strength-label text-xs font-mono" id="strength-label"></span>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label" for="confirm_password">Confirm Password</label>
            <div class="input-password-wrap">
              <input class="form-input" type="password" id="confirm_password" name="confirm_password"
                     placeholder="Repeat password" required autocomplete="new-password">
              <button type="button" class="toggle-password" aria-label="Show password" data-target="confirm_password">👁</button>
            </div>
          </div>
        </div>

        <!-- Terms -->
        <div class="form-group" style="display:flex;align-items:flex-start;gap:0.75rem;">
          <input type="checkbox" id="terms" name="terms" required
                 style="width:1rem;height:1rem;margin-top:0.2rem;accent-color:var(--aurora-cyan);flex-shrink:0;">
          <label for="terms" class="text-sm text-dim" style="cursor:pointer;line-height:1.5;">
            I agree to the <a href="#" class="link-glow">Mission Terms</a> and understand that space travel
            carries inherent risks. I confirm I am 18 years or older.
          </label>
        </div>

        <button type="submit" class="btn btn-glow w-full btn-xl mt-2">
          <span>🚀 Launch My Account</span>
        </button>
      </form>

      <div class="auth-footer text-center mt-3">
        <p class="text-dim text-sm">Already a traveler?
          <a href="<?= APP_URL ?>/login" class="link-glow">Return to Mission Control</a>
        </p>
      </div>
    </div>

    <!-- Side taglines -->
    <div class="auth-taglines" aria-hidden="true">
      <div class="tagline-item reveal reveal-delay-1">
        <span class="tagline-icon">🛸</span>
        <span>1,247 travelers registered</span>
      </div>
      <div class="tagline-item reveal reveal-delay-2">
        <span class="tagline-icon">🌍</span>
        <span>48 countries represented</span>
      </div>
      <div class="tagline-item reveal reveal-delay-3">
        <span class="tagline-icon">⭐</span>
        <span>4 missions launching 2026</span>
      </div>
    </div>

  </div>
</section>
