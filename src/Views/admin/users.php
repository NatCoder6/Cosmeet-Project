<!-- ============================================================
     COSMEET — Admin: Users
     ============================================================ -->
<section class="section" style="padding-top:7rem;">
  <div class="container">

    <div class="reveal mb-5" style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;">
      <div>
        <div class="eyebrow" style="color:var(--aurora-gold);">⭐ Admin</div>
        <h1 class="display-3">Registered <span class="gradient-text">Travelers</span></h1>
        <p class="text-dim">Page <?= $page ?> · <?= count($users) ?> users shown</p>
      </div>
      <a href="<?= APP_URL ?>/admin" class="btn btn-ghost btn-sm">← Dashboard</a>
    </div>

    <div class="glass p-4 rounded-lg reveal">
      <?php if (empty($users)): ?>
        <p class="text-dim text-center py-5">No users registered yet.</p>
      <?php else: ?>
        <div style="overflow-x:auto;">
          <table class="admin-table" style="width:100%;">
            <thead>
              <tr>
                <th>Traveler</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $u):
                $roleColor = $u['role'] === 'admin' ? 'var(--aurora-gold)' : 'var(--aurora-cyan)';
                $statusColor = $u['status'] === 'active' ? 'var(--aurora-cyan)' : '#ff4757';
              ?>
                <tr>
                  <td>
                    <div style="display:flex;align-items:center;gap:0.75rem;">
                      <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--aurora-cyan),var(--aurora-purple));display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:0.75rem;font-weight:700;flex-shrink:0;">
                        <?= strtoupper(substr($u['first_name'],0,1).substr($u['last_name'],0,1)) ?>
                      </div>
                      <div>
                        <div class="text-sm" style="font-weight:600;">
                          <?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?>
                        </div>
                        <div class="font-mono text-xs text-dim">ID: <?= $u['id'] ?></div>
                      </div>
                    </div>
                  </td>
                  <td class="text-sm text-dim"><?= htmlspecialchars($u['email']) ?></td>
                  <td>
                    <span class="badge" style="background:<?= $roleColor ?>1a;color:<?= $roleColor ?>;border:1px solid <?= $roleColor ?>30;text-transform:capitalize;">
                      <?= htmlspecialchars($u['role']) ?>
                    </span>
                  </td>
                  <td>
                    <span style="display:inline-flex;align-items:center;gap:0.3rem;font-size:0.75rem;font-family:var(--font-mono);">
                      <span style="width:6px;height:6px;border-radius:50%;background:<?= $statusColor ?>;display:inline-block;"></span>
                      <span style="color:<?= $statusColor ?>;"><?= ucfirst($u['status']) ?></span>
                    </span>
                  </td>
                  <td class="font-mono text-xs text-dim">
                    <?= date('d M Y', strtotime($u['created_at'])) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <nav class="text-center mt-4">
          <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="btn btn-ghost btn-sm">← Previous</a>
          <?php endif; ?>
          <span class="text-dim font-mono text-sm" style="padding:0 1rem;">Page <?= $page ?></span>
          <?php if (count($users) >= 20): ?>
            <a href="?page=<?= $page + 1 ?>" class="btn btn-ghost btn-sm">Next →</a>
          <?php endif; ?>
        </nav>
      <?php endif; ?>
    </div>

  </div>
</section>
