<!-- ============================================================
     COSMEET — Home / Storytelling Landing Page
     ============================================================ -->

<!-- ── SECTION 1: THE BEGINNING ── -->
<section class="hero story-section" id="section-beginning" aria-labelledby="hero-headline">
  <!-- Earth visual -->
  <div class="hero-earth" aria-hidden="true"></div>
  <div class="hero-atmosphere" aria-hidden="true"></div>

  <!-- Floating particles -->
  <div aria-hidden="true" id="hero-particles"></div>

  <div class="hero-content reveal">
    <div class="eyebrow">Cosmeet · Est. 2026 · Earth Orbit</div>
    <h1 class="display-1 mb-4" id="hero-headline">
      Humanity Was Never<br>
      <span class="gradient-text">Meant To Stay</span><br>
      On One Planet.
    </h1>
    <p style="font-size:1.25rem;font-weight:300;color:var(--star-dim);max-width:580px;margin:0 auto 2.5rem;line-height:1.8;" class="reveal reveal-delay-1">
      For the first time in history, a seat on a spacecraft isn't reserved for astronauts.
      It's reserved for <em>you</em>.
    </p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;" class="reveal reveal-delay-2">
      <a href="<?= APP_URL ?>/missions" class="btn btn-glow btn-xl">
        🚀 Explore Missions
      </a>
      <a href="<?= APP_URL ?>/register" class="btn btn-outline btn-xl">
        Begin Your Journey
      </a>
    </div>

    <!-- Stats ticker -->
    <div style="display:flex;gap:3rem;justify-content:center;margin-top:4rem;flex-wrap:wrap;" class="reveal reveal-delay-3">
      <div style="text-align:center;">
        <div style="font-family:var(--font-display);font-size:2rem;font-weight:700;color:var(--aurora-cyan);" data-count="4" data-suffix="+" data-decimals="0">4+</div>
        <div style="font-size:0.75rem;color:var(--star-dim);font-family:var(--font-mono);letter-spacing:0.1em;text-transform:uppercase;margin-top:0.25rem;">Active Missions</div>
      </div>
      <div style="text-align:center;">
        <div style="font-family:var(--font-display);font-size:2rem;font-weight:700;color:var(--aurora-purple);" data-count="42" data-suffix=" seats" data-decimals="0">42 seats</div>
        <div style="font-size:0.75rem;color:var(--star-dim);font-family:var(--font-mono);letter-spacing:0.1em;text-transform:uppercase;margin-top:0.25rem;">Available Now</div>
      </div>
      <div style="text-align:center;">
        <div style="font-family:var(--font-display);font-size:2rem;font-weight:700;color:var(--aurora-gold);" data-count="400" data-suffix="km" data-decimals="0">400km</div>
        <div style="font-size:0.75rem;color:var(--star-dim);font-family:var(--font-mono);letter-spacing:0.1em;text-transform:uppercase;margin-top:0.25rem;">Above Earth</div>
      </div>
    </div>
  </div>

  <!-- Scroll indicator -->
  <div style="position:absolute;bottom:2rem;left:50%;transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:0.5rem;animation:scrollBounce 2s infinite;" aria-hidden="true">
    <div style="font-family:var(--font-mono);font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--star-ghost);">Scroll to explore</div>
    <div style="width:1px;height:40px;background:linear-gradient(to bottom, var(--aurora-cyan), transparent);"></div>
  </div>
</section>

<style>
@keyframes scrollBounce {
  0%,100% { opacity: 0.4; transform: translateX(-50%) translateY(0); }
  50%      { opacity: 1;   transform: translateX(-50%) translateY(8px); }
}
</style>

<!-- ── SECTION 2: THE DREAM ── -->
<section class="story-section section" id="section-dream" aria-labelledby="dream-headline"
  style="background:linear-gradient(to bottom, transparent, rgba(26,16,96,0.15), transparent);">
  <div class="container">
    <div class="section-inner" style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;">
      <div class="reveal-left">
        <div class="eyebrow">The Dream</div>
        <h2 class="display-2 mb-4" id="dream-headline">
          Every <span class="gradient-text">Astronaut</span><br>Was Once A Child<br>Looking Up.
        </h2>
        <p style="font-size:1rem;color:var(--star-dim);line-height:1.9;margin-bottom:1.5rem;">
          Since Yuri Gagarin left Earth in 1961, only a few hundred humans have ever experienced
          the profound silence of space, the curvature of our planet, the vast darkness that
          surrounds us. That moment of transformation — <em>the overview effect</em> — will
          soon be yours.
        </p>
        <p style="font-size:1rem;color:var(--star-dim);line-height:1.9;">
          Cosmeet was built for the dreamers who refused to stop looking up.
          For the engineers, the artists, the wanderers — for anyone who ever asked
          <em>what is out there?</em>
        </p>
      </div>
      <div class="reveal-right" style="position:relative;">
        <!-- Visual: orbit diagram -->
        <div style="position:relative;height:360px;display:flex;align-items:center;justify-content:center;">
          <div style="width:200px;height:200px;border-radius:50%;
            background:radial-gradient(circle at 35% 35%, #1a6b3c, #1a5aa0, #04184a);
            box-shadow:0 0 40px rgba(0,100,255,0.3);
            position:relative;z-index:2;" aria-label="Earth illustration">
          </div>
          <!-- Orbit rings -->
          <div style="position:absolute;width:280px;height:280px;border-radius:50%;
            border:1px solid rgba(0,212,255,0.2);animation:orbitRotate 20s linear infinite;"></div>
          <div style="position:absolute;width:360px;height:160px;border-radius:50%;
            border:1px solid rgba(123,47,255,0.15);animation:orbitRotate 35s linear infinite reverse;"></div>
          <!-- Spacecraft dots on orbits -->
          <div style="position:absolute;width:280px;height:280px;border-radius:50%;
            animation:orbitRotate 20s linear infinite;">
            <div style="position:absolute;top:-5px;left:50%;transform:translateX(-50%);
              width:10px;height:10px;border-radius:50%;
              background:var(--aurora-cyan);box-shadow:0 0 15px var(--aurora-cyan);">
            </div>
          </div>
          <!-- Labels -->
          <div style="position:absolute;top:0.5rem;right:1rem;font-family:var(--font-mono);font-size:0.65rem;
            color:var(--aurora-cyan);letter-spacing:0.1em;">LEO · 400KM</div>
          <div style="position:absolute;bottom:1rem;left:1rem;font-family:var(--font-mono);font-size:0.65rem;
            color:var(--aurora-purple);letter-spacing:0.1em;">LUNAR · 384,000KM</div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
@keyframes orbitRotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

<!-- ── SECTION 3: THE MISSIONS ── -->
<section class="section" id="section-missions" aria-labelledby="missions-headline"
  style="position:relative;z-index:1;">
  <div class="container">
    <div class="text-center mb-8 reveal">
      <div class="eyebrow" style="justify-content:center;">Available Now</div>
      <h2 class="display-2 mb-3" id="missions-headline">
        Choose Your <span class="gradient-text">Mission</span>
      </h2>
      <p style="font-size:1rem;color:var(--star-dim);max-width:550px;margin:0 auto;">
        From orbital sunrise to lunar orbit to a Mars flyby — your next destination is waiting.
      </p>
    </div>

    <div class="mission-grid">
      <?php foreach ($featured as $i => $m): ?>
      <div class="mission-card reveal reveal-delay-<?= $i + 1 ?>" role="article">
        <div class="mission-card-visual">
          <!-- Dynamic SVG illustration based on destination -->
          <?php
          $dest = strtolower($m['destination']);
          if (str_contains($dest, 'mars')) {
            $bg = 'linear-gradient(135deg, #3d0f00, #7a2900, #4a1a00)';
            $emoji = '🔴';
          } elseif (str_contains($dest, 'lunar') || str_contains($dest, 'moon')) {
            $bg = 'linear-gradient(135deg, #1a1a2e, #2a2a4e, #0d0d20)';
            $emoji = '🌕';
          } elseif (str_contains($dest, 'station')) {
            $bg = 'linear-gradient(135deg, #001a3d, #003080, #001855)';
            $emoji = '🛸';
          } else {
            $bg = 'linear-gradient(135deg, #000a20, #001a4a, #000515)';
            $emoji = '🌍';
          }
          ?>
          <div style="width:100%;height:100%;background:<?= $bg ?>;
            display:flex;align-items:center;justify-content:center;
            font-size:4rem;position:relative;overflow:hidden;" aria-hidden="true">
            <div style="position:absolute;inset:0;background:radial-gradient(circle at 30% 30%, rgba(255,255,255,0.05), transparent 60%);"></div>
            <?= $emoji ?>
            <!-- Stars in card visual -->
            <div style="position:absolute;inset:0;overflow:hidden;" aria-hidden="true">
              <?php for($j=0;$j<20;$j++): ?>
              <div style="position:absolute;width:<?= rand(1,3) ?>px;height:<?= rand(1,3) ?>px;
                border-radius:50%;background:rgba(255,255,255,<?= number_format(rand(3,8)/10,1) ?>);
                top:<?= rand(5,95) ?>%;left:<?= rand(5,95) ?>%;"></div>
              <?php endfor; ?>
            </div>
          </div>
          <div class="mission-card-type"><?= htmlspecialchars(ucfirst($m['mission_type'])) ?></div>
          <div class="mission-card-seats">
            <?= $m['seats_available'] ?> seats left
          </div>
        </div>
        <div class="mission-card-body">
          <div class="mission-card-destination">⟶ <?= htmlspecialchars($m['destination']) ?></div>
          <h3 class="mission-card-title"><?= htmlspecialchars($m['title']) ?></h3>
          <div class="mission-card-meta">
            <span class="meta-item">
              <span>📅</span>
              <?= date('M d, Y', strtotime($m['launch_date'])) ?>
            </span>
            <span class="meta-item">
              <span>⏱</span>
              <?php
                $days = (int)$m['mission_duration_days'];
                echo $days . ' day' . ($days !== 1 ? 's' : '');
              ?>
            </span>
            <span class="meta-item">
              <span>⭐</span>
              <?= $m['safety_rating'] ?> safety
            </span>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;">
            <div class="mission-card-price">
              $<?= number_format($m['price_usd'], 0) ?>
              <span>/ seat</span>
            </div>
            <a href="<?= APP_URL ?>/missions/<?= htmlspecialchars($m['slug']) ?>"
               class="btn btn-outline btn-sm" aria-label="View <?= htmlspecialchars($m['title']) ?>">
              View Mission →
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-6 reveal">
      <a href="<?= APP_URL ?>/missions" class="btn btn-primary btn-lg">
        View All Missions →
      </a>
    </div>
  </div>
</section>

<!-- ── SECTION 4: THE EXPERIENCE ── -->
<section class="story-section section" id="section-experience"
  style="background:linear-gradient(to bottom, transparent, rgba(45,11,90,0.1), transparent);position:relative;z-index:1;"
  aria-labelledby="experience-headline">
  <div class="container">
    <div class="text-center mb-8 reveal">
      <div class="eyebrow" style="justify-content:center;">The Experience</div>
      <h2 class="display-2 mb-3" id="experience-headline">
        What It <span class="gradient-text">Actually Feels</span> Like
      </h2>
    </div>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;" class="reveal">
      <?php
      $phases = [
        ['🔧', 'Pre-Launch Training', 'Eight weeks of zero-gravity simulation, suit familiarization, and emergency protocols at our training facility.', 'cyan'],
        ['🚀', 'Launch Day', 'The engines ignite. 3G of acceleration compresses your body into the seat as Earth falls away in 90 seconds flat.', 'blue'],
        ['🌕', 'Orbital Operations', 'Floating weightless above Earth, watching 16 sunrises every 24 hours through crystal-clear observation windows.', 'purple'],
        ['🛸', 'Station Living', 'Private suites, gourmet cuisine, video calls home, and the quietest, most profound silence you\'ll ever experience.', 'gold'],
      ];
      foreach ($phases as $i => $phase):
        $delay = $i + 1;
      ?>
      <div class="glass-card reveal reveal-delay-<?= $delay ?>" style="padding:2rem;text-align:center;">
        <div style="font-size:3rem;margin-bottom:1.25rem;"><?= $phase[0] ?></div>
        <h3 style="font-family:var(--font-display);font-size:0.9rem;font-weight:600;margin-bottom:0.75rem;color:var(--aurora-<?= $phase[3] ?>);">
          <?= $phase[1] ?>
        </h3>
        <p style="font-size:0.85rem;color:var(--star-dim);line-height:1.7;"><?= $phase[2] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── SECTION 5: BECOME A TRAVELER ── -->
<section class="story-section section" id="section-cta"
  style="position:relative;z-index:1;overflow:hidden;"
  aria-labelledby="cta-headline">

  <!-- Background glow -->
  <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
    width:600px;height:600px;border-radius:50%;pointer-events:none;
    background:radial-gradient(circle, rgba(0,102,255,0.08) 0%, rgba(123,47,255,0.05) 50%, transparent 70%);"
    aria-hidden="true"></div>

  <div class="container text-center" style="position:relative;z-index:1;">
    <div class="reveal">
      <div class="eyebrow" style="justify-content:center;">Your Journey Starts Here</div>
      <h2 class="display-2 mb-4" id="cta-headline">
        The Universe Is<br>
        <span class="gradient-text">Waiting For You.</span>
      </h2>
      <p style="font-size:1.1rem;color:var(--star-dim);max-width:500px;margin:0 auto 3rem;line-height:1.9;">
        Join thousands of registered space travelers who have already reserved their seat
        on humanity's greatest adventure.
      </p>

      <div style="display:flex;gap:1.25rem;justify-content:center;flex-wrap:wrap;margin-bottom:3rem;">
        <a href="<?= APP_URL ?>/register" class="btn btn-glow btn-xl">
          🚀 Become A Space Traveler
        </a>
        <a href="<?= APP_URL ?>/readiness" class="btn btn-outline btn-xl">
          ✓ Check Your Readiness
        </a>
      </div>

      <!-- Features -->
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;max-width:750px;margin:0 auto;text-align:left;"
        class="reveal reveal-delay-2">
        <?php
        $features = [
          ['🛡️', 'Verified Safety', '9.8/10 average safety rating across all spacecraft'],
          ['💳', 'Flexible Payment', 'Reserve your seat with a small deposit today'],
          ['🌟', 'Space Passport', 'Your digital credentials for every mission'],
        ];
        foreach ($features as $f): ?>
        <div style="display:flex;gap:0.75rem;padding:1.25rem;border-radius:var(--radius);
          background:var(--glass-bg);border:1px solid var(--glass-border);">
          <div style="font-size:1.5rem;flex-shrink:0;"><?= $f[0] ?></div>
          <div>
            <div style="font-family:var(--font-display);font-size:0.85rem;font-weight:600;margin-bottom:0.25rem;"><?= $f[1] ?></div>
            <div style="font-size:0.8rem;color:var(--star-dim);"><?= $f[2] ?></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<script>
// Spawn hero particles
(function() {
  const container = document.getElementById('hero-particles');
  if (!container) return;
  container.style.cssText = 'position:absolute;inset:0;pointer-events:none;overflow:hidden;z-index:1;';
  for (let i = 0; i < 30; i++) {
    const p = document.createElement('div');
    p.className = 'particle';
    p.style.cssText = `
      left: ${Math.random()*100}%;
      bottom: ${Math.random()*30}%;
      --dx: ${(Math.random()-0.5)*60}px;
      animation-duration: ${3+Math.random()*5}s;
      animation-delay: ${Math.random()*5}s;
      width: ${1+Math.random()*2}px;
      height: ${1+Math.random()*2}px;
    `;
    container.appendChild(p);
  }
})();
</script>
