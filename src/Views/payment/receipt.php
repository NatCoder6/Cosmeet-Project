<!-- ============================================================
     COSMEET — Mission Confirmed / Receipt
     ============================================================ -->
<section class="section" style="padding-top:8rem;">
  <div class="container" style="max-width:780px;">

    <!-- Success Celebration -->
    <div class="text-center mb-6 reveal" id="launch-celebrate">
      <div class="launch-success-icon" aria-hidden="true">🚀</div>
      <h1 class="display-2 mb-2">
        Mission <span class="gradient-text">Confirmed!</span>
      </h1>
      <p class="text-dim" style="font-size:1.1rem;max-width:500px;margin:0 auto;">
        Your seat aboard <strong style="color:var(--star-bright);"><?= htmlspecialchars($payment['spacecraft_name']) ?></strong>
        is secured. Prepare for the journey of a lifetime.
      </p>
    </div>

    <!-- Booking steps complete -->
    <div class="booking-steps reveal mb-5">
      <div class="step step--done"><div class="step-num">✓</div><div class="step-label">Review</div></div>
      <div class="step-connector step-connector--done"></div>
      <div class="step step--done"><div class="step-num">✓</div><div class="step-label">Payment</div></div>
      <div class="step-connector step-connector--done"></div>
      <div class="step step--done step--active"><div class="step-num">✓</div><div class="step-label">Confirmed</div></div>
    </div>

    <!-- Receipt Card (printable) -->
    <div class="receipt-card glass p-5 rounded-lg reveal reveal-delay-1" id="receipt-printable">

      <!-- Receipt Header -->
      <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.07);padding-bottom:1.5rem;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
        <div>
          <div class="nav-logo" style="font-size:1.2rem;margin-bottom:0.25rem;">🚀 COSMEET</div>
          <div class="text-xs font-mono text-dim">Space Travel Receipt</div>
        </div>
        <div style="text-align:right;">
          <div class="text-xs font-mono text-dim">Transaction ID</div>
          <div class="font-mono" style="color:var(--aurora-cyan);font-size:0.85rem;">
            <?= htmlspecialchars($payment['transaction_id']) ?>
          </div>
          <div class="text-xs font-mono text-dim mt-1">
            <?= date('d M Y, H:i UTC', strtotime($payment['paid_at'])) ?>
          </div>
        </div>
      </div>

      <!-- Traveler + Mission -->
      <div class="grid-2 mb-4" style="gap:2rem;">
        <div>
          <div class="text-xs font-mono text-dim mb-2" style="letter-spacing:0.1em;text-transform:uppercase;">Traveler</div>
          <div style="font-size:1.1rem;font-weight:600;"><?= htmlspecialchars($payment['first_name'] . ' ' . $payment['last_name']) ?></div>
          <div class="text-sm text-dim"><?= htmlspecialchars($payment['email']) ?></div>
          <div class="text-xs font-mono mt-2" style="color:var(--aurora-cyan);">
            <?= htmlspecialchars($payment['reservation_code']) ?>
          </div>
        </div>
        <div>
          <div class="text-xs font-mono text-dim mb-2" style="letter-spacing:0.1em;text-transform:uppercase;">Mission</div>
          <div style="font-size:1.1rem;font-weight:600;"><?= htmlspecialchars($payment['mission_title']) ?></div>
          <div class="text-sm text-dim"><?= htmlspecialchars($payment['destination']) ?></div>
          <div class="text-xs font-mono mt-2">
            Launch: <strong><?= date('d M Y', strtotime($payment['launch_date'])) ?></strong>
          </div>
        </div>
      </div>

      <div style="display:flex;justify-content:space-between;align-items:center;background:rgba(0,230,190,0.05);border:1px solid rgba(0,230,190,0.15);border-radius:var(--radius);padding:1.25rem;margin-bottom:1.5rem;">
        <div>
          <div class="text-xs font-mono text-dim">Amount Paid</div>
          <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;">
            $<?= number_format($payment['amount_usd'], 2) ?>
          </div>
        </div>
        <div class="badge" style="background:rgba(0,230,190,0.15);color:var(--aurora-cyan);border:1px solid var(--aurora-cyan);font-size:0.9rem;padding:0.5rem 1rem;">
          ✓ PAYMENT CONFIRMED
        </div>
      </div>

      <!-- What's Next -->
      <div class="mb-4">
        <div class="text-xs font-mono text-dim mb-3" style="letter-spacing:0.1em;text-transform:uppercase;">
          Next Steps
        </div>
        <div style="display:flex;flex-direction:column;gap:0.75rem;">
          <div style="display:flex;gap:0.75rem;align-items:flex-start;">
            <span style="color:var(--aurora-cyan);font-size:1rem;">01</span>
            <div>
              <div class="text-sm" style="font-weight:600;">Check Your Dashboard</div>
              <div class="text-xs text-dim">Your Space Passport and Journey Timeline have been updated.</div>
            </div>
          </div>
          <div style="display:flex;gap:0.75rem;align-items:flex-start;">
            <span style="color:var(--aurora-purple);font-size:1rem;">02</span>
            <div>
              <div class="text-sm" style="font-weight:600;">Complete Readiness Assessment</div>
              <div class="text-xs text-dim">Get your Space Traveler profile and personalized preparation plan.</div>
            </div>
          </div>
          <div style="display:flex;gap:0.75rem;align-items:flex-start;">
            <span style="color:var(--aurora-gold);font-size:1rem;">03</span>
            <div>
              <div class="text-sm" style="font-weight:600;">Pre-Flight Briefing</div>
              <div class="text-xs text-dim">You'll receive a briefing pack 30 days before launch at your registered email.</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Receipt footer -->
      <div style="border-top:1px solid rgba(255,255,255,0.06);padding-top:1rem;text-align:center;" class="text-xs text-dim font-mono">
        This is an official Cosmeet mission confirmation document.<br>
        Retain for your records. Reference: <?= htmlspecialchars($payment['transaction_id']) ?>
      </div>
    </div>

    <!-- Action Buttons -->
    <div style="display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;margin-top:2rem;" class="reveal reveal-delay-2">
      <a href="<?= APP_URL ?>/dashboard" class="btn btn-glow btn-lg">
        🛸 Open My Dashboard
      </a>
      <a href="<?= APP_URL ?>/readiness" class="btn btn-primary btn-lg">
        🏅 Take Readiness Assessment
      </a>
      <button onclick="window.print()" class="btn btn-ghost btn-lg">
        🖨 Print Receipt
      </button>
      <a href="<?= APP_URL ?>/missions" class="btn btn-ghost btn-lg">
        Browse More Missions
      </a>
    </div>

  </div>
</section>

<script>
// Launch confetti celebration
(function() {
  const colors = ['#00e6be','#8b3fff','#ffa000','#ffffff','#00d4ff'];
  const container = document.getElementById('launch-celebrate');
  for (let i = 0; i < 80; i++) {
    setTimeout(() => {
      const el = document.createElement('div');
      el.style.cssText = `
        position:fixed;pointer-events:none;z-index:9999;
        left:${Math.random()*100}vw;top:-10px;
        width:${4+Math.random()*6}px;height:${4+Math.random()*6}px;
        background:${colors[Math.floor(Math.random()*colors.length)]};
        border-radius:${Math.random() > 0.5 ? '50%' : '0'};
        animation:confettiFall ${1.5+Math.random()*2}s linear forwards;
      `;
      document.body.appendChild(el);
      el.addEventListener('animationend', () => el.remove());
    }, i * 30);
  }
})();
</script>

<style>
@keyframes confettiFall {
  0%   { transform: translateY(0) rotate(0deg); opacity:1; }
  100% { transform: translateY(100vh) rotate(720deg); opacity:0; }
}
.launch-success-icon {
  font-size: 5rem;
  display: inline-block;
  animation: rocketLaunch 1s ease-out forwards;
  margin-bottom: 1.5rem;
}
@keyframes rocketLaunch {
  0%   { transform: translateY(30px) scale(0.5); opacity:0; }
  60%  { transform: translateY(-20px) scale(1.2); }
  100% { transform: translateY(0) scale(1); opacity:1; }
}
@media print {
  body > *:not(.receipt-card), nav, .booking-steps, .btn { display:none !important; }
  .receipt-card { box-shadow:none !important; border:1px solid #ccc !important; color:#000 !important; }
}
</style>
