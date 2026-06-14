<!-- ============================================================
     COSMEET — Login View
     ============================================================ -->
<section class="auth-section section">
  <div class="auth-container auth-container--narrow">

    <div class="auth-orbit" aria-hidden="true">
      <div class="orbit-ring orbit-ring-1"></div>
      <div class="orbit-ring orbit-ring-2"></div>
      <div class="orbit-planet"></div>
    </div>

    <div class="auth-card glass reveal">
      <div class="auth-header text-center mb-4">
        <div class="auth-icon">🛸</div>
        <h1 class="h2 mb-1">Mission Control</h1>
        <p class="text-dim">Authenticate to access your journey</p>
      </div>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-error mb-3" role="alert">
          <?php foreach ($errors as $e): ?>
            <div>⚠ <?= htmlspecialchars($e) ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?= APP_URL ?>/login" novalidate class="auth-form">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= htmlspecialchars($csrf) ?>">

        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <input class="form-input" type="email" id="email" name="email"
                 value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                 placeholder="neil@cosmeet.space" required autocomplete="email">
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <div class="input-password-wrap">
            <input class="form-input" type="password" id="password" name="password"
                   placeholder="••••••••" required autocomplete="current-password">
            <button type="button" class="toggle-password" aria-label="Show password" data-target="password">👁</button>
          </div>
        </div>

        <div style="display:flex;justify-content:flex-end;margin-bottom:1.25rem;">
          <a href="#" class="text-sm link-glow">Forgot your access code?</a>
        </div>

        <button type="submit" class="btn btn-glow w-full btn-xl">
          <span>🔓 Authenticate</span>
        </button>
      </form>

      <div class="auth-footer text-center mt-3">
        <p class="text-dim text-sm">New to Cosmeet?
          <a href="<?= APP_URL ?>/register" class="link-glow">Register for a seat</a>
        </p>
      </div>

      <!-- Demo credentials hint -->
      <div class="demo-hint mt-3 text-center" style="border-top:1px solid rgba(255,255,255,0.05);padding-top:1rem;">
        <p class="text-xs font-mono text-dim" style="letter-spacing:0.05em;">
          ADMIN DEMO: admin@cosmeet.space / password
        </p>
      </div>
    </div>

  </div>
</section>
