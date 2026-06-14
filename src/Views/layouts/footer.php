</main>

<!-- Footer -->
<footer style="position:relative;z-index:1;border-top:1px solid rgba(255,255,255,0.05);padding:4rem 2rem;margin-top:6rem;">
  <div class="container">
    <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:3rem;margin-bottom:3rem;">

      <div>
        <div class="nav-logo" style="margin-bottom:1rem;display:flex;align-items:center;gap:0.6rem;">
          <div class="logo-icon">🚀</div>
          COSMEET
        </div>
        <p style="font-size:0.875rem;color:var(--star-dim);line-height:1.8;max-width:280px;">
          Humanity's premier space travel reservation platform. Your seat on history is waiting.
        </p>
        <div style="display:flex;gap:1rem;margin-top:1.5rem;">
          <a href="#" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;
             border-radius:50%;border:1px solid var(--star-ghost);color:var(--star-dim);font-size:0.85rem;
             transition:all 0.3s;" onmouseenter="this.style.borderColor='var(--aurora-cyan)';this.style.color='var(--aurora-cyan)'"
             onmouseleave="this.style.borderColor='var(--star-ghost)';this.style.color='var(--star-dim)'">𝕏</a>
          <a href="#" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;
             border-radius:50%;border:1px solid var(--star-ghost);color:var(--star-dim);font-size:0.85rem;
             transition:all 0.3s;" onmouseenter="this.style.borderColor='var(--aurora-cyan)';this.style.color='var(--aurora-cyan)'"
             onmouseleave="this.style.borderColor='var(--star-ghost)';this.style.color='var(--star-dim)'">in</a>
        </div>
      </div>

      <div>
        <h4 style="font-family:var(--font-display);font-size:0.75rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--star-dim);margin-bottom:1.25rem;">Missions</h4>
        <ul style="list-style:none;display:flex;flex-direction:column;gap:0.6rem;">
          <li><a href="<?= APP_URL ?>/missions" style="font-size:0.875rem;color:var(--star-dim);" onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--star-dim)'">Browse Missions</a></li>
          <li><a href="<?= APP_URL ?>/missions?type=orbital" style="font-size:0.875rem;color:var(--star-dim);" onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--star-dim)'">Orbital Flights</a></li>
          <li><a href="<?= APP_URL ?>/missions?type=lunar" style="font-size:0.875rem;color:var(--star-dim);" onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--star-dim)'">Lunar Missions</a></li>
          <li><a href="<?= APP_URL ?>/missions?type=mars" style="font-size:0.875rem;color:var(--star-dim);" onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--star-dim)'">Mars Expeditions</a></li>
        </ul>
      </div>

      <div>
        <h4 style="font-family:var(--font-display);font-size:0.75rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--star-dim);margin-bottom:1.25rem;">Travelers</h4>
        <ul style="list-style:none;display:flex;flex-direction:column;gap:0.6rem;">
          <li><a href="<?= APP_URL ?>/register" style="font-size:0.875rem;color:var(--star-dim);" onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--star-dim)'">Create Account</a></li>
          <li><a href="<?= APP_URL ?>/readiness" style="font-size:0.875rem;color:var(--star-dim);" onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--star-dim)'">Readiness Check</a></li>
          <li><a href="<?= APP_URL ?>/dashboard" style="font-size:0.875rem;color:var(--star-dim);" onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--star-dim)'">My Dashboard</a></li>
          <li><a href="<?= APP_URL ?>/my-reservations" style="font-size:0.875rem;color:var(--star-dim);" onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--star-dim)'">My Reservations</a></li>
        </ul>
      </div>

      <div>
        <h4 style="font-family:var(--font-display);font-size:0.75rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--star-dim);margin-bottom:1.25rem;">Mission Control</h4>
        <ul style="list-style:none;display:flex;flex-direction:column;gap:0.6rem;">
          <li><a href="mailto:hello@cosmeet.space" style="font-size:0.875rem;color:var(--star-dim);" onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='var(--star-dim)'">hello@cosmeet.space</a></li>
          <li style="font-size:0.875rem;color:var(--star-ghost);">Cape Canaveral, FL</li>
          <li style="font-size:0.875rem;color:var(--star-ghost);">Boca Chica, TX</li>
        </ul>
      </div>
    </div>

    <div style="display:flex;justify-content:space-between;align-items:center;padding-top:2rem;border-top:1px solid rgba(255,255,255,0.05);flex-wrap:wrap;gap:1rem;">
      <p style="font-size:0.75rem;color:var(--star-ghost);font-family:var(--font-mono);letter-spacing:0.08em;">
        © <?= date('Y') ?> COSMEET SPACE AUTHORITY. ALL RIGHTS RESERVED.
      </p>
      <p style="font-size:0.75rem;color:var(--star-ghost);font-family:var(--font-mono);">
        MISSION REF: CMT-<?= date('Y') ?>-ACTIVE
      </p>
    </div>
  </div>
</footer>

<script src="<?= APP_URL ?>/js/cosmeet.js" defer></script>
</body>
</html>
