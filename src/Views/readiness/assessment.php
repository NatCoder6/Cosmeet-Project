<!-- ============================================================
     COSMEET — Space Traveler Readiness Assessment
     ============================================================ -->

<!-- Force reveal elements visible on this page — the loading overlay
     blocks IntersectionObserver from firing correctly, leaving content
     invisible after the overlay dismisses. -->
<style>
  .assessment-page .reveal,
  .assessment-page .reveal-left,
  .assessment-page .reveal-right {
    opacity: 1 !important;
    transform: none !important;
  }
</style>

<section class="section assessment-page" style="padding-top:7rem;">
  <div class="container" style="max-width:860px;">

    <!-- Header -->
    <div class="text-center mb-5">
      <div class="eyebrow">Mission Qualification System</div>
      <h1 class="display-2 mb-2">Space Traveler<br><span class="gradient-text">Readiness Assessment</span></h1>
      <p class="text-dim" style="max-width:580px;margin:0 auto;font-size:1.05rem;line-height:1.8;">
        Answer 12 questions across 4 domains. Our system will generate your personal Space Traveler Profile
        and mission readiness score.
      </p>
      <div style="display:flex;gap:1.5rem;justify-content:center;margin-top:1.5rem;flex-wrap:wrap;">
        <span class="badge badge-outline">⏱ ~5 minutes</span>
        <span class="badge badge-outline">🔒 Confidential</span>
        <span class="badge badge-outline">🏅 Score: 0–100</span>
      </div>
    </div>

    <!-- Assessment Form -->
    <form method="POST" action="<?= APP_URL ?>/readiness" id="readiness-form">
      <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= htmlspecialchars($csrf) ?>">
      <input type="hidden" name="q_physical"  id="score-physical"  value="0">
      <input type="hidden" name="q_psych"     id="score-psych"     value="0">
      <input type="hidden" name="q_adventure" id="score-adventure" value="0">
      <input type="hidden" name="q_knowledge" id="score-knowledge" value="0">

      <!-- Progress Bar -->
      <div class="assessment-progress glass p-3 rounded-lg mb-5">
        <div style="display:flex;justify-content:space-between;margin-bottom:0.5rem;" class="text-xs font-mono">
          <span class="text-dim">PROGRESS</span>
          <span id="progress-text" style="color:var(--aurora-cyan);">0 / 12 answered</span>
        </div>
        <div class="seat-bar" style="height:6px;">
          <div class="seat-bar-fill" id="progress-fill" style="width:0%;transition:width 0.4s ease;"></div>
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:0.75rem;" class="text-xs text-dim font-mono">
          <span>Physical</span><span>Psychological</span><span>Adventure</span><span>Knowledge</span>
        </div>
      </div>

      <!-- CATEGORY 1: PHYSICAL READINESS -->
      <div class="assessment-category glass p-4 rounded-lg mb-4" data-category="physical">
        <div class="category-header mb-3">
          <div class="category-icon">💪</div>
          <div>
            <h2 class="h4 mb-0">Physical Readiness</h2>
            <p class="text-xs text-dim">Evaluates your physical condition for spaceflight demands</p>
          </div>
        </div>

        <?php
          $physQuestions = [
            ['id' => 'p1', 'q' => 'How would you describe your current physical fitness level?',
             'opts' => ['Sedentary — minimal physical activity' => 1, 'Light activity once or twice a week' => 2, 'Regular exercise 3–4 times per week' => 4, 'Athlete-level training daily' => 6]],
            ['id' => 'p2', 'q' => 'Can you handle sustained physical exertion for 3+ hours?',
             'opts' => ['No, I tire easily' => 1, 'With difficulty' => 2, 'Yes, with occasional rest' => 4, 'Yes, comfortably' => 6]],
            ['id' => 'p3', 'q' => 'Do you have any medical conditions that could be affected by microgravity?',
             'opts' => ['Multiple serious conditions' => 1, 'Minor condition, well-managed' => 3, 'Cleared by medical professional' => 5, 'No conditions — excellent health' => 7]],
          ];
          foreach ($physQuestions as $i => $q): ?>
          <div class="question-block" data-answered="false" data-category="physical">
            <div class="question-text"><?= ($i+1) . '. ' . htmlspecialchars($q['q']) ?></div>
            <div class="question-options" role="group" aria-label="<?= htmlspecialchars($q['q']) ?>">
              <?php foreach ($q['opts'] as $label => $pts): ?>
                <label class="option-label">
                  <input type="radio" name="<?= $q['id'] ?>" value="<?= $pts ?>" style="display:none;">
                  <span class="option-text"><?= htmlspecialchars($label) ?></span>
                  <span class="option-points">+<?= $pts ?>pts</span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- CATEGORY 2: PSYCHOLOGICAL -->
      <div class="assessment-category glass p-4 rounded-lg mb-4" data-category="psych">
        <div class="category-header mb-3">
          <div class="category-icon">🧠</div>
          <div>
            <h2 class="h4 mb-0">Psychological Readiness</h2>
            <p class="text-xs text-dim">Assesses mental resilience in extreme environments</p>
          </div>
        </div>

        <?php
          $psychQuestions = [
            ['id' => 'ps1', 'q' => 'How do you respond to prolonged isolation and confinement?',
             'opts' => ['I struggle severely' => 1, 'I manage but find it very difficult' => 2, 'I adapt within days' => 4, 'I thrive in solitude' => 6]],
            ['id' => 'ps2', 'q' => 'When facing life-threatening situations, you typically:',
             'opts' => ['Panic and freeze' => 1, 'Feel strong fear but eventually act' => 3, 'Stay calm and assess options' => 5, 'Enter a focused, clear problem-solving state' => 7]],
            ['id' => 'ps3', 'q' => 'How would you handle being 400,000 km from Earth with no immediate return?',
             'opts' => ["I cannot imagine being OK with that" => 1, "I would be anxious but manage" => 3, "I would find it challenging but inspiring" => 5, 'It would be the greatest experience of my life' => 6]],
          ];
          foreach ($psychQuestions as $i => $q): ?>
          <div class="question-block" data-answered="false" data-category="psych">
            <div class="question-text"><?= ($i+1) . '. ' . htmlspecialchars($q['q']) ?></div>
            <div class="question-options" role="group">
              <?php foreach ($q['opts'] as $label => $pts): ?>
                <label class="option-label">
                  <input type="radio" name="<?= $q['id'] ?>" value="<?= $pts ?>" style="display:none;">
                  <span class="option-text"><?= htmlspecialchars($label) ?></span>
                  <span class="option-points">+<?= $pts ?>pts</span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- CATEGORY 3: ADVENTURE READINESS -->
      <div class="assessment-category glass p-4 rounded-lg mb-4" data-category="adventure">
        <div class="category-header mb-3">
          <div class="category-icon">⚡</div>
          <div>
            <h2 class="h4 mb-0">Adventure Readiness</h2>
            <p class="text-xs text-dim">Measures your drive and appetite for exploration</p>
          </div>
        </div>

        <?php
          $advQuestions = [
            ['id' => 'a1', 'q' => 'Have you experienced extreme adventure activities? (Skydiving, deep sea diving, mountaineering)',
             'opts' => ['Never — I prefer safe activities' => 1, 'Mild adventure occasionally' => 3, 'Regularly seek thrilling experiences' => 5, 'Extreme adventures are my lifestyle' => 7]],
            ['id' => 'a2', 'q' => 'How much risk are you willing to accept for a once-in-a-lifetime experience?',
             'opts' => ['Very little — safety first always' => 1, 'Minimal calculated risk only' => 2, 'Significant risk if well-prepared' => 4, 'The risk is part of the allure' => 6]],
            ['id' => 'a3', 'q' => 'If you knew the mission had a 2% failure probability, you would:',
             'opts' => ['Cancel — that is unacceptable' => 1, 'Hesitate significantly' => 2, 'Accept it as part of exploration' => 5, 'Still go without hesitation' => 6]],
          ];
          foreach ($advQuestions as $i => $q): ?>
          <div class="question-block" data-answered="false" data-category="adventure">
            <div class="question-text"><?= ($i+1) . '. ' . htmlspecialchars($q['q']) ?></div>
            <div class="question-options" role="group">
              <?php foreach ($q['opts'] as $label => $pts): ?>
                <label class="option-label">
                  <input type="radio" name="<?= $q['id'] ?>" value="<?= $pts ?>" style="display:none;">
                  <span class="option-text"><?= htmlspecialchars($label) ?></span>
                  <span class="option-points">+<?= $pts ?>pts</span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- CATEGORY 4: SPACE KNOWLEDGE -->
      <div class="assessment-category glass p-4 rounded-lg mb-4" data-category="knowledge">
        <div class="category-header mb-3">
          <div class="category-icon">🔭</div>
          <div>
            <h2 class="h4 mb-0">Space Knowledge</h2>
            <p class="text-xs text-dim">Tests your understanding of space and spaceflight</p>
          </div>
        </div>

        <?php
          $knoQuestions = [
            ['id' => 'k1', 'q' => 'How far is the International Space Station from Earth (approximate)?',
             'opts' => ['About 50 km' => 1, 'About 400 km' => 7, 'About 2,000 km' => 2, 'About 100,000 km' => 1]],
            ['id' => 'k2', 'q' => 'What is the primary challenge of weightlessness on the human body?',
             'opts' => ['Feeling dizzy' => 2, 'Muscle and bone mass loss' => 7, 'Inability to sleep' => 2, 'Hair growth acceleration' => 1]],
            ['id' => 'k3', 'q' => 'How much space training experience do you have?',
             'opts' => ['None — completely new to this' => 1, 'Self-study only (books, videos)' => 3, 'Formal simulation or training courses' => 5, 'Professional aerospace training' => 7]],
          ];
          foreach ($knoQuestions as $i => $q): ?>
          <div class="question-block" data-answered="false" data-category="knowledge">
            <div class="question-text"><?= ($i+1) . '. ' . htmlspecialchars($q['q']) ?></div>
            <div class="question-options" role="group">
              <?php foreach ($q['opts'] as $label => $pts): ?>
                <label class="option-label">
                  <input type="radio" name="<?= $q['id'] ?>" value="<?= $pts ?>" style="display:none;">
                  <span class="option-text"><?= htmlspecialchars($label) ?></span>
                  <span class="option-points">+<?= $pts ?>pts</span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Submit -->
      <div class="text-center mt-5">
        <div id="submit-warning" class="text-gold text-sm mb-2" style="display:none;">
          ⚠ Please answer all 12 questions before submitting.
        </div>
        <button type="submit" class="btn btn-glow btn-xl" id="readiness-submit" disabled style="opacity:0.5;">
          🏅 Generate My Space Profile
        </button>
        <p class="text-xs text-dim mt-2">Your results are saved to your Space Passport automatically.</p>
      </div>
    </form>

  </div>
</section>

<script>
(function() {
  const questions      = document.querySelectorAll('.question-block');
  const categoryFields = {
    physical:  document.getElementById('score-physical'),
    psych:     document.getElementById('score-psych'),
    adventure: document.getElementById('score-adventure'),
    knowledge: document.getElementById('score-knowledge'),
  };
  const progressText = document.getElementById('progress-text');
  const progressFill = document.getElementById('progress-fill');
  const submitBtn    = document.getElementById('readiness-submit');
  const submitWarn   = document.getElementById('submit-warning');
  const TOTAL        = questions.length;

  function recalculate() {
    const scores = { physical: 0, psych: 0, adventure: 0, knowledge: 0 };
    let answered = 0;

    questions.forEach(q => {
      const checked = q.querySelector('input[type=radio]:checked');
      if (checked) {
        answered++;
        q.dataset.answered = 'true';
        q.style.outline = '';
        const cat = q.dataset.category;
        if (scores[cat] !== undefined) scores[cat] += parseInt(checked.value, 10);
      }
    });

    Object.keys(scores).forEach(k => {
      scores[k] = Math.min(25, scores[k]);
      if (categoryFields[k]) categoryFields[k].value = scores[k];
    });

    if (progressText) progressText.textContent = answered + ' / ' + TOTAL + ' answered';
    if (progressFill) progressFill.style.width = Math.round((answered / TOTAL) * 100) + '%';

    const allDone = answered >= TOTAL;
    submitBtn.disabled     = !allDone;
    submitBtn.style.opacity = allDone ? '1' : '0.5';
    if (allDone && submitWarn) submitWarn.style.display = 'none';
  }

  document.querySelectorAll('.option-label').forEach(label => {
    label.addEventListener('click', () => {
      const group = label.closest('.question-options');
      group.querySelectorAll('.option-label').forEach(l => l.classList.remove('option-label--selected'));
      label.classList.add('option-label--selected');
      const radio = label.querySelector('input[type=radio]');
      if (radio) radio.checked = true;
      recalculate();
    });
  });

  document.getElementById('readiness-form').addEventListener('submit', function(e) {
    const unanswered = [...questions].filter(q => q.dataset.answered !== 'true');
    if (unanswered.length > 0) {
      e.preventDefault();
      if (submitWarn) submitWarn.style.display = 'block';
      unanswered[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
      unanswered.forEach(q => q.style.outline = '1px solid rgba(255,160,0,0.5)');
    }
  });
})();
</script>