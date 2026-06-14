/* ============================================================
   COSMEET — Main JavaScript
   Animations, Stars, Interactions, Scroll Effects
   ============================================================ */

'use strict';

// ── Star Field ──────────────────────────────────────────────
class StarField {
  constructor(canvas) {
    this.canvas = canvas;
    this.ctx = canvas.getContext('2d');
    this.stars = [];
    this.shootingStars = [];
    this.resize();
    this.init();
    window.addEventListener('resize', () => this.resize());
  }

  resize() {
    this.canvas.width  = window.innerWidth;
    this.canvas.height = window.innerHeight;
    if (this.stars.length) this.init();
  }

  init() {
    this.stars = [];
    const count = Math.floor((this.canvas.width * this.canvas.height) / 4000);
    for (let i = 0; i < count; i++) {
      this.stars.push({
        x:    Math.random() * this.canvas.width,
        y:    Math.random() * this.canvas.height,
        r:    Math.random() * 1.5 + 0.3,
        a:    Math.random(),
        da:   (Math.random() - 0.5) * 0.005,
        hue:  Math.random() > 0.9 ? 200 + Math.random() * 60 : 0,
        twinkle: Math.random() * Math.PI * 2,
      });
    }
  }

  spawnShootingStar() {
    if (Math.random() > 0.003) return;
    this.shootingStars.push({
      x:    Math.random() * this.canvas.width,
      y:    Math.random() * this.canvas.height * 0.5,
      len:  Math.random() * 150 + 80,
      speed: Math.random() * 8 + 4,
      a:    1,
      angle: Math.PI / 4 + Math.random() * 0.2,
    });
  }

  draw(t) {
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

    for (const s of this.stars) {
      s.twinkle += 0.02;
      const alpha = s.a + Math.sin(s.twinkle) * 0.3;
      const color = s.hue
        ? `hsla(${s.hue},80%,80%,${alpha})`
        : `rgba(220,230,255,${alpha})`;
      this.ctx.beginPath();
      this.ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
      this.ctx.fillStyle = color;
      this.ctx.fill();
    }

    this.spawnShootingStar();
    this.shootingStars = this.shootingStars.filter(ss => ss.a > 0);
    for (const ss of this.shootingStars) {
      const dx = Math.cos(ss.angle) * ss.len;
      const dy = Math.sin(ss.angle) * ss.len;
      const grad = this.ctx.createLinearGradient(ss.x, ss.y, ss.x - dx, ss.y - dy);
      grad.addColorStop(0, `rgba(0,212,255,${ss.a})`);
      grad.addColorStop(1, 'rgba(0,212,255,0)');
      this.ctx.strokeStyle = grad;
      this.ctx.lineWidth = 1.5;
      this.ctx.beginPath();
      this.ctx.moveTo(ss.x, ss.y);
      this.ctx.lineTo(ss.x - dx, ss.y - dy);
      this.ctx.stroke();
      ss.x += Math.cos(ss.angle) * ss.speed;
      ss.y += Math.sin(ss.angle) * ss.speed;
      ss.a -= 0.015;
    }
  }

  animate(t = 0) {
    this.draw(t);
    requestAnimationFrame(ts => this.animate(ts));
  }
}

// ── Cursor ───────────────────────────────────────────────────
class Cursor {
  constructor() {
    this.dot  = document.querySelector('.cursor-dot');
    this.ring = document.querySelector('.cursor-ring');
    if (!this.dot || !this.ring) return;
    this.mx = 0; this.my = 0;
    this.rx = 0; this.ry = 0;
    document.addEventListener('mousemove', e => {
      this.mx = e.clientX;
      this.my = e.clientY;
    });
    document.querySelectorAll('a, button, [data-cursor="pointer"]').forEach(el => {
      el.addEventListener('mouseenter', () => this.expand());
      el.addEventListener('mouseleave', () => this.contract());
    });
    this.animate();
  }

  expand() {
    this.ring.style.width  = '50px';
    this.ring.style.height = '50px';
    this.ring.style.borderColor = 'rgba(0,212,255,0.7)';
  }
  contract() {
    this.ring.style.width  = '30px';
    this.ring.style.height = '30px';
    this.ring.style.borderColor = 'rgba(0,212,255,0.4)';
  }

  animate() {
    this.rx += (this.mx - this.rx) * 0.12;
    this.ry += (this.my - this.ry) * 0.12;
    this.dot.style.left  = this.mx + 'px';
    this.dot.style.top   = this.my + 'px';
    this.ring.style.left = this.rx + 'px';
    this.ring.style.top  = this.ry + 'px';
    requestAnimationFrame(() => this.animate());
  }
}

// ── Scroll Reveal ────────────────────────────────────────────
class ScrollReveal {
  constructor() {
    this.els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    if (!this.els.length) return;
    this.io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
          this.io.unobserve(e.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    this.els.forEach(el => this.io.observe(el));
  }
}

// ── Nav Scroll Effect ────────────────────────────────────────
class NavScroll {
  constructor() {
    this.nav = document.querySelector('.nav');
    if (!this.nav) return;
    window.addEventListener('scroll', () => {
      this.nav.classList.toggle('scrolled', window.scrollY > 60);
    });
  }
}

// ── Parallax ─────────────────────────────────────────────────
class Parallax {
  constructor() {
    this.els = document.querySelectorAll('[data-parallax]');
    if (!this.els.length) return;
    window.addEventListener('scroll', () => this.update(), { passive: true });
  }

  update() {
    const scrollY = window.scrollY;
    this.els.forEach(el => {
      const speed = parseFloat(el.dataset.parallax) || 0.3;
      const rect  = el.getBoundingClientRect();
      const offset = (rect.top + scrollY - window.innerHeight / 2) * speed;
      el.style.transform = `translateY(${offset}px)`;
    });
  }
}

// ── Counter Animation ────────────────────────────────────────
class CounterAnimation {
  constructor() {
    this.els = document.querySelectorAll('[data-count]');
    if (!this.els.length) return;
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          this.animate(e.target);
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.5 });
    this.els.forEach(el => io.observe(el));
  }

  animate(el) {
    const target = parseFloat(el.dataset.count);
    const prefix = el.dataset.prefix || '';
    const suffix = el.dataset.suffix || '';
    const decimals = el.dataset.decimals || 0;
    const duration = 1800;
    let start = null;

    const step = ts => {
      if (!start) start = ts;
      const progress = Math.min((ts - start) / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 3);
      const val = target * ease;
      el.textContent = prefix + val.toFixed(decimals) + suffix;
      if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }
}

// ── Score Ring Animation ─────────────────────────────────────
class ScoreRing {
  constructor() {
    const ring = document.querySelector('.score-ring-fill');
    if (!ring) return;
    const score = parseInt(ring.dataset.score || 0);
    const r = parseFloat(ring.getAttribute('r'));
    const circ = 2 * Math.PI * r;
    ring.style.strokeDasharray = circ;
    ring.style.strokeDashoffset = circ;
    setTimeout(() => {
      const offset = circ * (1 - score / 100);
      ring.style.strokeDashoffset = offset;
    }, 400);
  }
}

// ── Readiness Assessment Interactive ─────────────────────────
class ReadinessAssessment {
  // The assessment view uses .option-label + hidden radio inputs (handled inline).
  // This class is a no-op placeholder so the DOMContentLoaded init call doesn't throw.
  constructor() {}
}

// ── Payment Form ──────────────────────────────────────────────
class PaymentForm {
  constructor() {
    const form = document.getElementById('payment-form');
    if (!form) return;
    // Card number formatting
    const cardNum = document.getElementById('card-number');
    if (cardNum) {
      cardNum.addEventListener('input', e => {
        let v = e.target.value.replace(/\D/g, '').substring(0, 16);
        v = v.replace(/(.{4})/g, '$1 ').trim();
        e.target.value = v;
      });
    }
    // Expiry
    const expiry = document.getElementById('card-expiry');
    if (expiry) {
      expiry.addEventListener('input', e => {
        let v = e.target.value.replace(/\D/g, '').substring(0, 4);
        if (v.length > 2) v = v.substring(0, 2) + '/' + v.substring(2);
        e.target.value = v;
      });
    }
    // CVV
    const cvv = document.getElementById('card-cvv');
    if (cvv) {
      cvv.addEventListener('input', e => {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
      });
    }
    // Submit simulate
    form.addEventListener('submit', e => {
      const btn = form.querySelector('[type="submit"]');
      if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="btn-loader"></span> Processing Mission Authorization...';
      }
    });
  }
}

// ── Flash Messages ────────────────────────────────────────────
class FlashMessages {
  constructor() {
    document.querySelectorAll('.flash').forEach(el => {
      el.addEventListener('click', () => el.remove());
      setTimeout(() => el.style.opacity = '0', 4500);
      setTimeout(() => el.remove(), 5000);
    });
  }
}

// ── Mobile Nav ────────────────────────────────────────────────
class MobileNav {
  constructor() {
    const toggle = document.querySelector('.nav-mobile-toggle');
    const links  = document.querySelector('.nav-links');
    const actions= document.querySelector('.nav-actions');
    if (!toggle) return;
    toggle.addEventListener('click', () => {
      links?.classList.toggle('open');
      actions?.classList.toggle('open');
      const bars = toggle.querySelectorAll('span');
      if (links?.classList.contains('open')) {
        bars[0].style.transform = 'translateY(7px) rotate(45deg)';
        bars[1].style.opacity   = '0';
        bars[2].style.transform = 'translateY(-7px) rotate(-45deg)';
      } else {
        bars.forEach(b => { b.style.transform = ''; b.style.opacity = ''; });
      }
    });
  }
}

// ── Section Progress Dots ─────────────────────────────────────
class SectionProgress {
  constructor() {
    const sections = document.querySelectorAll('.story-section');
    if (sections.length < 2) return;
    const container = document.createElement('div');
    container.className = 'section-dots';
    container.style.cssText = `
      position:fixed; right:2rem; top:50%; transform:translateY(-50%);
      display:flex; flex-direction:column; gap:10px; z-index:100;
    `;
    sections.forEach((_, i) => {
      const dot = document.createElement('div');
      dot.style.cssText = `
        width:6px; height:6px; border-radius:50%;
        background:rgba(0,212,255,0.3); border:1px solid rgba(0,212,255,0.4);
        transition:all 0.3s; cursor:pointer;
      `;
      dot.addEventListener('click', () => sections[i].scrollIntoView({ behavior: 'smooth' }));
      container.appendChild(dot);
    });
    document.body.appendChild(container);

    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        const i = Array.from(sections).indexOf(e.target);
        const dot = container.children[i];
        if (dot) {
          dot.style.background = e.isIntersecting ? 'var(--aurora-cyan)' : 'rgba(0,212,255,0.3)';
          dot.style.boxShadow  = e.isIntersecting ? '0 0 10px rgba(0,212,255,0.6)' : 'none';
          dot.style.transform  = e.isIntersecting ? 'scale(1.6)' : 'scale(1)';
        }
      });
    }, { threshold: 0.5 });
    sections.forEach(s => io.observe(s));
  }
}

// ── Init ──────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  // Loading screen
  const overlay = document.querySelector('.loading-overlay');
  if (overlay) {
    setTimeout(() => overlay.classList.add('hidden'), 2000);
  }

  // Star canvas
  const canvas = document.getElementById('star-canvas');
  if (canvas) {
    const sf = new StarField(canvas);
    sf.animate();
  }

  // Custom cursor (desktop only)
  if (window.innerWidth > 768 && !('ontouchstart' in window)) {
    new Cursor();
  }

  new NavScroll();
  new ScrollReveal();
  new Parallax();
  new CounterAnimation();
  new ScoreRing();
  new ReadinessAssessment();
  new PaymentForm();
  new FlashMessages();
  new MobileNav();
  new SectionProgress();

  // Smooth page transitions
  document.querySelectorAll('a[href^="/"]').forEach(link => {
    link.addEventListener('click', e => {
      if (e.metaKey || e.ctrlKey) return;
      const href = link.getAttribute('href');
      if (href === '#' || href.startsWith('/#')) return;
      // Add subtle fade on navigation
    });
  });
});

// ── Password Strength Meter ────────────────────────────────
(function initPasswordStrength() {
  const input = document.getElementById('password');
  const fill  = document.getElementById('strength-fill');
  const label = document.getElementById('strength-label');
  if (!input || !fill) return;

  input.addEventListener('input', () => {
    const v = input.value;
    let score = 0;
    if (v.length >= 8)  score++;
    if (v.length >= 12) score++;
    if (/[A-Z]/.test(v))  score++;
    if (/[0-9]/.test(v))  score++;
    if (/[^A-Za-z0-9]/.test(v)) score++;

    const levels = [
      { pct:  0, color: 'transparent',          text: '' },
      { pct: 20, color: '#ff4757',               text: 'Very Weak' },
      { pct: 40, color: 'var(--aurora-orange)',   text: 'Weak' },
      { pct: 60, color: 'var(--aurora-gold)',     text: 'Fair' },
      { pct: 80, color: 'var(--aurora-cyan)',     text: 'Strong' },
      { pct:100, color: 'var(--aurora-cyan)',     text: 'Very Strong' },
    ];
    const lvl = levels[score] || levels[0];
    fill.style.width    = lvl.pct + '%';
    fill.style.background = lvl.color;
    if (label) label.textContent = lvl.text;
  });

  // Toggle password visibility
  document.querySelectorAll('.toggle-password').forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.dataset.target;
      const targetInput = document.getElementById(targetId);
      if (!targetInput) return;
      const isHidden = targetInput.type === 'password';
      targetInput.type = isHidden ? 'text' : 'password';
      btn.textContent  = isHidden ? '🙈' : '👁';
    });
  });
})();

// ── Mission Card Background Parallax on hover ──────────────
(function initCardHoverTilt() {
  document.querySelectorAll('.mission-card').forEach(card => {
    card.addEventListener('mousemove', e => {
      const rect = card.getBoundingClientRect();
      const x = ((e.clientX - rect.left) / rect.width  - 0.5) * 12;
      const y = ((e.clientY - rect.top)  / rect.height - 0.5) * 12;
      card.style.transform = `translateY(-6px) rotateX(${-y}deg) rotateY(${x}deg)`;
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });
  });
})();

// ── Smooth Scroll for anchor links ────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const id = a.getAttribute('href').slice(1);
    const target = document.getElementById(id);
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

// ── Scroll-triggered Story Sections ─────────────────────
(function initStorySections() {
  const sections = document.querySelectorAll('.story-section');
  if (!sections.length) return;
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('story-active');
      }
    });
  }, { threshold: 0.3 });
  sections.forEach(s => io.observe(s));
})();

// ── Nebula Mouse Parallax ─────────────────────────────────
(function initNebulaParallax() {
  const nebula = document.querySelector('.nebula-bg');
  if (!nebula) return;
  let tX = 0, tY = 0, cX = 0, cY = 0;
  document.addEventListener('mousemove', e => {
    tX = (e.clientX / window.innerWidth  - 0.5) * 30;
    tY = (e.clientY / window.innerHeight - 0.5) * 30;
  });
  function animateNebula() {
    cX += (tX - cX) * 0.05;
    cY += (tY - cY) * 0.05;
    nebula.style.transform = `translate(${cX}px, ${cY}px)`;
    requestAnimationFrame(animateNebula);
  }
  animateNebula();
})();

// ── Floating Particles (hero) ─────────────────────────────
(function initParticles() {
  const container = document.getElementById('hero-particles');
  if (!container) return;
  const count = 40;
  for (let i = 0; i < count; i++) {
    const p = document.createElement('div');
    const size = Math.random() * 4 + 1;
    const colors = ['rgba(0,212,255,', 'rgba(123,47,255,', 'rgba(255,214,0,'];
    const color  = colors[Math.floor(Math.random() * colors.length)];
    const dur    = 6 + Math.random() * 10;
    const delay  = Math.random() * -15;
    p.style.cssText = `
      position:absolute;
      width:${size}px; height:${size}px;
      background:${color}${0.4 + Math.random() * 0.4});
      border-radius:50%;
      left:${Math.random() * 100}%;
      top:${Math.random() * 100}%;
      animation: floatParticle ${dur}s ${delay}s ease-in-out infinite;
      pointer-events:none;
    `;
    container.appendChild(p);
  }
})();

// ── Home Earth Rotation ────────────────────────────────────
(function initEarthRotation() {
  const earth = document.querySelector('.hero-earth');
  if (!earth) return;
  let deg = 0;
  setInterval(() => {
    deg = (deg + 0.05) % 360;
    earth.style.setProperty('--earth-rotation', deg + 'deg');
  }, 50);
})();

// ── Loading Screen Dismiss ─────────────────────────────────
(function dismissLoader() {
  const overlay = document.getElementById('loading-overlay');
  if (!overlay) return;
  const bar = overlay.querySelector('.loading-bar-fill');
  if (bar) {
    bar.style.transition = 'width 1.4s ease';
    bar.style.width = '100%';
  }
  setTimeout(() => {
    overlay.style.opacity = '0';
    overlay.style.transition = 'opacity 0.6s ease';
    setTimeout(() => { overlay.style.display = 'none'; }, 600);
  }, 1600);
})();

// ── Section entrance counter ──────────────────────────────
(function initSectionCounters() {
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      e.target.querySelectorAll('[data-count]').forEach(el => {
        const target   = parseFloat(el.dataset.count);
        const suffix   = el.dataset.suffix || '';
        const decimals = parseInt(el.dataset.decimals ?? 0);
        let start = null;
        const step = ts => {
          if (!start) start = ts;
          const p = Math.min((ts - start) / 1800, 1);
          const ease = 1 - Math.pow(1 - p, 3);
          el.textContent = (target * ease).toFixed(decimals) + suffix;
          if (p < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
      });
      io.unobserve(e.target);
    });
  }, { threshold: 0.4 });
  document.querySelectorAll('[data-count]').forEach(el => {
    const section = el.closest('section') || el;
    io.observe(section);
  });
})();
