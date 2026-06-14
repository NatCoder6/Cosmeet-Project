<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Cosmeet — Book your seat on humanity's next great journey. Space travel reservations for the bold.">
  <meta name="theme-color" content="#000005">
  <title><?= htmlspecialchars($title ?? 'Cosmeet — Space Travel') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="<?= APP_URL ?>/css/cosmeet.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🚀</text></svg>">
</head>
<body>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loading-overlay">
  <div class="loading-logo">COSMEET</div>
  <div style="font-family:var(--font-mono);font-size:0.65rem;letter-spacing:0.3em;color:var(--star-dim);text-transform:uppercase;">Initializing Mission Control</div>
  <div class="loading-bar"><div class="loading-bar-fill"></div></div>
</div>

<!-- Nebula Background -->
<div class="nebula-bg"></div>

<!-- Star Canvas -->
<canvas id="star-canvas" aria-hidden="true"></canvas>

<!-- Custom Cursor -->
<div class="cursor-dot" aria-hidden="true"></div>
<div class="cursor-ring" aria-hidden="true"></div>

<!-- Navigation -->
<nav class="nav" role="navigation" aria-label="Main navigation">
  <a href="<?= APP_URL ?>/" class="nav-logo" aria-label="Cosmeet Home">
    <div class="logo-icon" aria-hidden="true">🚀</div>
    COSMEET
  </a>

  <ul class="nav-links" role="list">
    <li><a href="<?= APP_URL ?>/">Home</a></li>
    <li><a href="<?= APP_URL ?>/missions">Missions</a></li>
    <?php if (\Cosmeet\Core\Auth::check()): ?>
      <li><a href="<?= APP_URL ?>/dashboard">Dashboard</a></li>
      <li><a href="<?= APP_URL ?>/my-reservations">Reservations</a></li>
      <li><a href="<?= APP_URL ?>/readiness">Readiness</a></li>
      <?php if (\Cosmeet\Core\Auth::isAdmin()): ?>
        <li><a href="<?= APP_URL ?>/admin" style="color:var(--aurora-gold)">⭐ Admin</a></li>
      <?php endif; ?>
    <?php endif; ?>
  </ul>

  <div class="nav-actions">
    <?php if (\Cosmeet\Core\Auth::check()): ?>
      <span style="font-size:0.8rem;color:var(--star-dim);font-family:var(--font-mono);">
        <?= htmlspecialchars(\Cosmeet\Core\Auth::user()['name']) ?>
      </span>
      <a href="<?= APP_URL ?>/logout" class="btn btn-ghost btn-sm">Logout</a>
    <?php else: ?>
      <a href="<?= APP_URL ?>/login" class="btn btn-ghost btn-sm">Login</a>
      <a href="<?= APP_URL ?>/register" class="btn btn-primary btn-sm">Join Cosmeet</a>
    <?php endif; ?>
  </div>

  <button class="nav-mobile-toggle" aria-label="Toggle menu" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- Flash Message -->
<?php if (!empty($flash)): ?>
  <div class="flash flash-<?= htmlspecialchars($flash['type']) ?>" role="alert" aria-live="polite">
    <?= $flash['type'] === 'success' ? '✓' : '⚠' ?>
    <?= htmlspecialchars($flash['message']) ?>
  </div>
<?php endif; ?>

<!-- Main Content -->
<main id="main-content">
