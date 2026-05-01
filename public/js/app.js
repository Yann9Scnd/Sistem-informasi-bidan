/* ============================================================
   PMB BIDAN KLINIK — app.js
   Global JavaScript: dropdown, sidebar, toast, stepper, modal
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  // ─── DROPDOWN ────────────────────────────────────────────────
  const avatarBtn     = document.getElementById('avatarBtn');
  const dropdownMenu  = document.getElementById('dropdownMenu');

  if (avatarBtn && dropdownMenu) {
    avatarBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      dropdownMenu.classList.toggle('show');
    });

    document.addEventListener('click', function () {
      dropdownMenu.classList.remove('show');
    });
  }

  // ─── SIDEBAR TOGGLE (MOBILE) ─────────────────────────────────
  const menuToggleBtn = document.getElementById('menuToggleBtn');
  const sidebar       = document.getElementById('sidebar');
  const overlay       = document.getElementById('sidebarOverlay');

  if (menuToggleBtn && sidebar) {
    menuToggleBtn.addEventListener('click', function () {
      sidebar.classList.toggle('open');
      if (overlay) overlay.classList.toggle('show');
    });
  }
  if (overlay) {
    overlay.addEventListener('click', function () {
      sidebar.classList.remove('open');
      overlay.classList.remove('show');
    });
  }

  // ─── ANAMNESA SUBMENU ─────────────────────────────────────────
  window.toggleAnamnesa = function (btn) {
    const menu  = document.getElementById('anamnesa-menu');
    const arrow = document.getElementById('anamnesa-arrow');
    if (menu) {
      menu.classList.toggle('open');
      if (arrow) arrow.style.transform = menu.classList.contains('open') ? 'rotate(180deg)' : '';
    }
  };

  // ─── LOADING BUTTON ───────────────────────────────────────────
  document.querySelectorAll('form').forEach(function (form) {
    form.addEventListener('submit', function () {
      const btn = form.querySelector('button[type="submit"].btn-loading-on-submit');
      if (btn) {
        btn.classList.add('loading');
        btn.disabled = true;
      }
    });
  });

  // ─── SESSION TOAST (dirender dari Blade via data-attribute) ──
  const toastEl = document.getElementById('sessionToast');
  if (toastEl) {
    const msg  = toastEl.dataset.message;
    const type = toastEl.dataset.type || 'success';
    if (msg) showToast(msg, type);
  }

});

// ─── TOAST SYSTEM ─────────────────────────────────────────────
window.showToast = function (msg, type) {
  type = type || 'success';
  const container = document.getElementById('toastContainer');
  if (!container) return;

  const toast = document.createElement('div');
  toast.className = 'toast' + (type === 'error' ? ' toast-err' : '');

  const icon = type === 'error'
    ? '<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke-linecap="round" stroke-width="2"/></svg>'
    : '<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';

  toast.innerHTML = icon + msg;
  container.appendChild(toast);
  setTimeout(function () { if (toast.parentNode) toast.remove(); }, 3200);
};

// ─── MODAL ────────────────────────────────────────────────────
window.openModal = function (id) {
  const m = document.getElementById(id);
  if (m) m.classList.add('show');
};

window.closeModal = function (id) {
  const target = id ? document.getElementById(id) : document.querySelector('.modal-overlay.show');
  if (target) target.classList.remove('show');
};

// Close on overlay click
document.addEventListener('click', function (e) {
  if (e.target.classList.contains('modal-overlay')) {
    e.target.classList.remove('show');
  }
});

// ─── DELETE MODAL HELPER ──────────────────────────────────────
window.openDeleteModal = function (name, action) {
  const nameEl = document.getElementById('deletePatientName');
  const form   = document.getElementById('deleteForm');
  if (nameEl) nameEl.textContent = name;
  if (form && action) form.action = action;
  openModal('deleteModal');
};

// ─── TABS ─────────────────────────────────────────────────────
window.switchTab = function (btn, tabId) {
  document.querySelectorAll('.tab-btn').forEach(function (b) { b.classList.remove('active'); });
  document.querySelectorAll('.tab-content').forEach(function (t) { t.classList.remove('active'); });
  btn.classList.add('active');
  const tab = document.getElementById(tabId);
  if (tab) tab.classList.add('active');
};

window.nextTab = function () {
  const active = document.querySelector('.tab-btn.active');
  if (!active) return;
  const next = active.nextElementSibling;
  if (next && next.classList.contains('tab-btn')) next.click();
};

window.prevTab = function () {
  const active = document.querySelector('.tab-btn.active');
  if (!active) return;
  const prev = active.previousElementSibling;
  if (prev && prev.classList.contains('tab-btn')) prev.click();
};

// ─── LOGIN PAGE HELPERS ───────────────────────────────────────
window.togglePassword = function () {
  const input = document.getElementById('passwordInput');
  const icon  = document.getElementById('eyeIcon');
  if (!input) return;

  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
  }
};

window.handleLoginSubmit = function (e, btn) {
  btn.classList.add('loading');
  btn.disabled = true;
  // Form akan submit normal ke Laravel
};

// ─── COPY ALAMAT (pasien create) ─────────────────────────────
window.copyAlamatKTP = function (checkbox) {
  if (!checkbox.checked) return;
  const tinggal = document.getElementById('alamat_tinggal');
  const ktp     = document.getElementById('alamat_ktp');
  if (tinggal && ktp) {
    ktp.value = tinggal.value;
    showToast('Alamat KTP diisi sama dengan alamat tinggal ✅');
  }
};