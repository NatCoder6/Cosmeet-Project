<!-- ============================================================
     COSMEET — Payment Checkout
     ============================================================ -->
<section class="section" style="padding-top:8rem;">
  <div class="container" style="max-width:760px;">

    <!-- Steps -->
    <div class="booking-steps reveal mb-5">
      <div class="step step--done">
        <div class="step-num">✓</div>
        <div class="step-label">Review</div>
      </div>
      <div class="step-connector step-connector--done"></div>
      <div class="step step--active">
        <div class="step-num">2</div>
        <div class="step-label">Payment</div>
      </div>
      <div class="step-connector"></div>
      <div class="step">
        <div class="step-num">3</div>
        <div class="step-label">Confirmed</div>
      </div>
    </div>

    <!-- Order Summary -->
    <div class="glass p-4 rounded-lg mb-4 reveal">
      <h2 class="text-xs font-mono text-dim mb-3" style="letter-spacing:0.1em;text-transform:uppercase;">Order Summary</h2>
      <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <div>
          <div class="h4 mb-0"><?= htmlspecialchars($reservation['mission_title']) ?></div>
          <div class="text-xs font-mono text-dim">
            <?= htmlspecialchars($reservation['spacecraft_name']) ?>
            &nbsp;·&nbsp; Launch: <?= date('d M Y', strtotime($reservation['launch_date'])) ?>
          </div>
          <div class="text-xs font-mono mt-1" style="color:var(--aurora-cyan);">
            REF: <?= htmlspecialchars($reservation['reservation_code']) ?>
          </div>
        </div>
        <div style="text-align:right;">
          <div style="font-family:var(--font-display);font-size:2rem;font-weight:800;">
            $<?= number_format($reservation['price_usd'], 2) ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Form -->
    <div class="glass p-5 rounded-lg reveal reveal-delay-1">
      <h1 class="h3 mb-1">Secure Payment</h1>
      <p class="text-dim mb-4 text-sm">This is a simulation. No real payment will be processed.</p>

      <form method="POST" action="<?= APP_URL ?>/payment/process" id="payment-form">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= htmlspecialchars($csrf) ?>">
        <input type="hidden" name="reservation_code" value="<?= htmlspecialchars($reservation['reservation_code']) ?>">

        <!-- Payment method selector -->
        <div class="payment-methods mb-4">
          <label class="payment-method-option payment-method-option--active" data-method="card">
            <input type="radio" name="payment_method" value="card" checked style="display:none;">
            <span>💳 Credit Card</span>
          </label>
          <label class="payment-method-option" data-method="crypto">
            <input type="radio" name="payment_method" value="crypto" style="display:none;">
            <span>₿ Crypto</span>
          </label>
          <label class="payment-method-option" data-method="wire">
            <input type="radio" name="payment_method" value="wire" style="display:none;">
            <span>🏦 Wire Transfer</span>
          </label>
        </div>

        <!-- Card Details Panel -->
        <div id="panel-card">
          <div class="form-group">
            <label class="form-label">Cardholder Name</label>
            <input class="form-input" type="text" name="cardholder"
                   value="<?= htmlspecialchars($reservation['first_name'] . ' ' . $reservation['last_name']) ?>"
                   placeholder="Neil A. Armstrong" autocomplete="cc-name">
          </div>

          <!-- Card number with live card preview -->
          <div class="credit-card-preview glass mb-4" id="card-preview" aria-hidden="true">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
              <div style="font-size:1.5rem;">💎</div>
              <div class="text-xs font-mono" style="color:rgba(255,255,255,0.5);">COSMEET TRAVEL</div>
            </div>
            <div class="card-number-display font-mono" id="card-number-display" style="font-size:1.2rem;letter-spacing:0.2em;margin-top:1.5rem;">
              •••• •••• •••• ••••
            </div>
            <div style="display:flex;justify-content:space-between;margin-top:1rem;">
              <div>
                <div class="text-xs" style="color:rgba(255,255,255,0.4);">CARDHOLDER</div>
                <div class="font-mono text-xs" id="card-name-display">
                  <?= htmlspecialchars($reservation['first_name'] . ' ' . $reservation['last_name']) ?>
                </div>
              </div>
              <div>
                <div class="text-xs" style="color:rgba(255,255,255,0.4);">EXPIRES</div>
                <div class="font-mono text-xs" id="card-expiry-display">MM/YY</div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="card_number">Card Number</label>
            <input class="form-input font-mono" type="text" id="card_number" name="card_number"
                   placeholder="0000 0000 0000 0000" maxlength="19" autocomplete="cc-number"
                   inputmode="numeric">
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="card_expiry">Expiry Date</label>
              <input class="form-input font-mono" type="text" id="card_expiry" name="card_expiry"
                     placeholder="MM/YY" maxlength="5" autocomplete="cc-exp" inputmode="numeric">
            </div>
            <div class="form-group">
              <label class="form-label" for="card_cvv">CVV</label>
              <input class="form-input font-mono" type="text" id="card_cvv" name="card_cvv"
                     placeholder="•••" maxlength="4" autocomplete="cc-csc" inputmode="numeric">
            </div>
          </div>
        </div>

        <!-- Crypto panel (hidden by default) -->
        <div id="panel-crypto" style="display:none;">
          <div class="glass p-4 rounded text-center" style="border:1px solid rgba(255,160,0,0.2);">
            <div style="font-size:2rem;margin-bottom:0.5rem;">₿</div>
            <p class="text-sm text-dim">Send exactly <strong style="color:var(--aurora-gold);">0.00847 BTC</strong> to:</p>
            <div class="font-mono text-xs mt-2" style="color:var(--aurora-cyan);word-break:break-all;">
              bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh
            </div>
            <p class="text-xs text-dim mt-2">(Simulated — no real transaction needed)</p>
          </div>
        </div>

        <!-- Wire panel -->
        <div id="panel-wire" style="display:none;">
          <div class="glass p-4 rounded" style="border:1px solid rgba(139,63,255,0.2);">
            <div class="text-sm" style="display:flex;flex-direction:column;gap:0.5rem;">
              <div><span class="text-dim">Bank:</span> Cosmeet International Bank</div>
              <div><span class="text-dim">Account:</span> 2026-COSM-7749-0001</div>
              <div><span class="text-dim">SWIFT:</span> COSMETXXXX</div>
              <div><span class="text-dim">Reference:</span>
                <strong class="font-mono"><?= htmlspecialchars($reservation['reservation_code']) ?></strong>
              </div>
            </div>
            <p class="text-xs text-dim mt-2">(Simulated — no real wire needed)</p>
          </div>
        </div>

        <!-- Total -->
        <div class="price-breakdown glass p-3 rounded mt-4 mb-4" style="border:1px solid rgba(255,255,255,0.06);">
          <div style="display:flex;justify-content:space-between;" class="text-sm mb-2">
            <span>Seat reservation</span><span>$<?= number_format($reservation['price_usd'], 2) ?></span>
          </div>
          <div style="display:flex;justify-content:space-between;" class="text-sm text-dim mb-2">
            <span>Processing fee (3%)</span><span>$<?= number_format($reservation['price_usd'] * 0.03, 2) ?></span>
          </div>
          <div style="border-top:1px solid rgba(255,255,255,0.08);padding-top:0.75rem;margin-top:0.5rem;display:flex;justify-content:space-between;">
            <strong>Total Charged</strong>
            <strong style="font-family:var(--font-display);font-size:1.25rem;color:var(--aurora-cyan);">
              $<?= number_format($reservation['price_usd'] * 1.03, 2) ?>
            </strong>
          </div>
        </div>

        <button type="submit" class="btn btn-glow w-full btn-xl" id="pay-btn">
          <span class="pay-btn-text">🔒 Complete Mission Payment</span>
          <span class="pay-btn-loading" style="display:none;">⏳ Processing…</span>
        </button>

        <p class="text-xs text-dim text-center mt-3">
          🔐 256-bit SSL encrypted &nbsp;·&nbsp; PCI DSS compliant simulation &nbsp;·&nbsp; No real charges made
        </p>
      </form>
    </div>

  </div>
</section>

<script>
// Payment method toggle
document.querySelectorAll('.payment-method-option').forEach(opt => {
  opt.addEventListener('click', () => {
    document.querySelectorAll('.payment-method-option').forEach(o => o.classList.remove('payment-method-option--active'));
    opt.classList.add('payment-method-option--active');
    opt.querySelector('input').checked = true;
    const method = opt.dataset.method;
    document.getElementById('panel-card').style.display   = method === 'card'   ? '' : 'none';
    document.getElementById('panel-crypto').style.display = method === 'crypto' ? '' : 'none';
    document.getElementById('panel-wire').style.display   = method === 'wire'   ? '' : 'none';
  });
});

// Live card number formatting
const cardInput = document.getElementById('card_number');
cardInput?.addEventListener('input', () => {
  let v = cardInput.value.replace(/\D/g,'').substring(0,16);
  cardInput.value = v.replace(/(.{4})/g,'$1 ').trim();
  document.getElementById('card-number-display').textContent =
    (v.padEnd(16,'•')).replace(/(.{4})/g,'$1 ').trim().replace(/[0-9]/g, (c, i) => i < v.length ? c : '•');
});

document.getElementById('card_expiry')?.addEventListener('input', e => {
  let v = e.target.value.replace(/\D/g,'');
  if (v.length >= 3) v = v.slice(0,2) + '/' + v.slice(2,4);
  e.target.value = v;
  document.getElementById('card-expiry-display').textContent = e.target.value || 'MM/YY';
});

document.querySelector('[name=cardholder]')?.addEventListener('input', e => {
  document.getElementById('card-name-display').textContent = e.target.value || 'CARDHOLDER';
});

// Payment button loading state
document.getElementById('payment-form')?.addEventListener('submit', () => {
  document.querySelector('.pay-btn-text').style.display = 'none';
  document.querySelector('.pay-btn-loading').style.display = '';
  document.getElementById('pay-btn').disabled = true;
});
</script>
