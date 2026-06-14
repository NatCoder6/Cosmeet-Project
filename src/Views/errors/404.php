<!-- ============================================================
     COSMEET — 404 Not Found
     ============================================================ -->
<?php require VIEW_PATH . '/layouts/header.php'; ?>
<section class="section" style="padding-top:10rem;text-align:center;min-height:80vh;display:flex;align-items:center;">
  <div class="container">
    <div class="reveal">
      <div style="font-size:6rem;margin-bottom:1rem;opacity:0.3;">🛸</div>
      <div class="font-mono" style="font-size:0.75rem;letter-spacing:0.3em;color:var(--aurora-cyan);margin-bottom:1rem;">ERROR · 404</div>
      <h1 class="display-2 mb-3">Lost in <span class="gradient-text">Deep Space</span></h1>
      <p class="text-dim" style="max-width:480px;margin:0 auto 2.5rem;font-size:1.05rem;line-height:1.8;">
        The coordinates you entered don't exist in our mission database. The page may have been decommissioned or never launched.
      </p>
      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
        <a href="<?= APP_URL ?>/" class="btn btn-glow btn-lg">🚀 Return to Earth</a>
        <a href="<?= APP_URL ?>/missions" class="btn btn-outline btn-lg">Browse Missions</a>
      </div>
    </div>
  </div>
</section>
<?php require VIEW_PATH . '/layouts/footer.php'; ?>
