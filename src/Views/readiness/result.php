<!-- ============================================================
     COSMEET — Readiness Result
     ============================================================ -->
<section class="section" style="padding-top:7rem;">
  <div class="container" style="max-width:820px;">

    <!-- Profile Reveal -->
    <div class="text-center mb-6 reveal" id="result-hero">
      <div class="readiness-score-ring" aria-label="Readiness score: <?= $total ?> out of 100">
        <svg viewBox="0 0 160 160" width="160" height="160" style="overflow:visible;">
          <circle cx="80" cy="80" r="68" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="12"/>
          <circle cx="80" cy="80" r="68" fill="none"
                  stroke="<?= $total >= 75 ? 'var(--aurora-cyan)' : ($total >= 50 ? 'var(--aurora-purple)' : 'var(--aurora-gold)') ?>"
                  stroke-width="12" stroke-linecap="round"
                  stroke-dasharray="<?= round(427.3 * $total / 100) ?> 427.3"
                  transform="rotate(-90 80 80)"
                  style="transition:stroke-dasharray 1.5s ease;"/>
          <text x="80" y="72" text-anchor="middle" fill="white"
                style="font-family:var(--font-display);font-size:2.2rem;font-weight:800;"><?= $total ?></text>
          <text x="80" y="95" text-anchor="middle" fill="rgba(255,255,255,0.4)"
                style="font-family:var(--font-mono);font-size:0.65rem;letter-spacing:0.15em;">OUT OF 100</text>
        </svg>
      </div>

      <h1 class="display-2 mt-4 mb-2">
        You Are a<br><span class="gradient-text"><?= htmlspecialchars($profile) ?></span>
      </h1>
      <p class="text-dim" style="max-width:560px;margin:0 auto;font-size:1.05rem;line-height:1.8;">
        <?= htmlspecialchars($feedback) ?>
      </p>
    </div>

    <!-- Score Breakdown -->
    <div class="glass p-5 rounded-lg mb-5 reveal">
      <h2 class="h4 mb-4" style="color:var(--aurora-cyan);">Score Breakdown</h2>
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:2rem;">
        <?php
          $cats = [
            ['💪', 'Physical',      $scores['physical'],   'var(--aurora-cyan)'],
            ['🧠', 'Psychological', $scores['psych'],      'var(--aurora-purple)'],
            ['⚡', 'Adventure',     $scores['adventure'],  'var(--aurora-gold)'],
            ['🔭', 'Knowledge',     $scores['knowledge'],  'var(--aurora-cyan)'],
          ];
          foreach ($cats as [$icon, $label, $score, $color]):
            $pct = round(($score / 25) * 100);
        ?>
          <div style="text-align:center;">
            <div style="font-size:2rem;margin-bottom:0.5rem;"><?= $icon ?></div>
            <div class="text-sm" style="font-weight:600;margin-bottom:0.25rem;"><?= $label ?></div>
            <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;color:<?= $color ?>;">
              <?= $score ?><span style="font-size:1rem;color:rgba(255,255,255,0.3);">/25</span>
            </div>
            <div class="seat-bar" style="height:6px;margin-top:0.5rem;">
              <div class="seat-bar-fill" style="width:<?= $pct ?>%;background:<?= $color ?>;"></div>
            </div>
            <div class="text-xs text-dim mt-1"><?= $pct ?>%</div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Profile Meaning -->
    <div class="glass p-5 rounded-lg mb-5 reveal reveal-delay-1">
      <h2 class="h4 mb-3">What Your Profile Means</h2>
      <?php
        $profiles = [
          'Interplanetary Pioneer' => [
            'desc' => "You represent humanity's vanguard explorers. Your physical, psychological, and intellectual preparation places you among the top 5% of all assessed candidates. You don't just dream of space — you are ready for it.",
            'missions' => ['Mars Transit', 'Deep Space Expedition', 'Lunar Landing'],
            'color' => 'var(--aurora-gold)',
            'icon' => '🌟',
          ],
          'Orbital Commander' => [
            'desc' => "Exceptional readiness across all domains. You have the resilience, curiosity, and physical capability for complex missions beyond Earth orbit. A few refinements will push you to elite status.",
            'missions' => ['Lunar Orbit', 'Space Station Extended Stay', 'Orbital Expedition'],
            'color' => 'var(--aurora-cyan)',
            'icon' => '🛸',
          ],
          'Space Explorer' => [
            'desc' => "You have a solid foundation for space travel. Your adventurous spirit and genuine curiosity make you a natural candidate for introductory orbital missions. Consistent preparation will rapidly advance your profile.",
            'missions' => ['Low Earth Orbit', 'Orbital Tourism', 'ISS Visit'],
            'color' => 'var(--aurora-purple)',
            'icon' => '🚀',
          ],
          'Lunar Voyager' => [
            'desc' => "You're on the journey and making real progress. Several of your domain scores show genuine potential. A structured preparation program will help you reach the next level of readiness.",
            'missions' => ['Suborbital Flight', 'Earth Observation', 'Edge of Space'],
            'color' => 'var(--aurora-purple)',
            'icon' => '🌙',
          ],
          'Aspiring Traveler' => [
            'desc' => "Every astronaut started exactly where you are — with a dream. Your profile shows areas to develop, and we have programs specifically designed to prepare aspirational travelers like you for the real thing.",
            'missions' => ['Zero-G Experience', 'Balloon Ascent', 'Simulation Training'],
            'color' => 'var(--aurora-gold)',
            'icon' => '🌍',
          ],
          'Earth Dreamer' => [
            'desc' => "The dream is the beginning of every journey. Your assessment shows there's work to be done across several areas, but we believe in the power of commitment. Start your preparation program today.",
            'missions' => ['Virtual Reality Mission', 'Ground Training', 'Astronaut Workshop'],
            'color' => 'rgba(255,255,255,0.4)',
            'icon' => '⭐',
          ],
        ];
        $pd = $profiles[$profile] ?? $profiles['Earth Dreamer'];
      ?>
      <div style="display:flex;gap:1rem;align-items:flex-start;">
        <div style="font-size:2.5rem;"><?= $pd['icon'] ?></div>
        <div>
          <p style="line-height:1.8;color:rgba(255,255,255,0.8);margin-bottom:1rem;">
            <?= htmlspecialchars($pd['desc']) ?>
          </p>
          <div class="text-xs font-mono text-dim mb-2" style="letter-spacing:0.1em;text-transform:uppercase;">Recommended Missions</div>
          <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
            <?php foreach ($pd['missions'] as $m): ?>
              <span class="badge" style="background:<?= $pd['color'] ?>1a;color:<?= $pd['color'] ?>;border:1px solid <?= $pd['color'] ?>40;">
                <?= htmlspecialchars($m) ?>
              </span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Call to Action -->
    <div style="display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;" class="reveal reveal-delay-2">
      <a href="<?= APP_URL ?>/missions" class="btn btn-glow btn-lg">🚀 Book a Mission Now</a>
      <a href="<?= APP_URL ?>/dashboard" class="btn btn-primary btn-lg">🛸 View My Passport</a>
      <a href="<?= APP_URL ?>/readiness" class="btn btn-ghost btn-lg">Retake Assessment</a>
    </div>

  </div>
</section>
