/**
 * Pemu Health — theme-toggle.js
 * CRITICAL: Inlined in <head> before first paint to prevent flash of wrong theme.
 * Reads localStorage 'pemu-theme' = 'light' | 'dark' | 'system'
 */
(function () {
  'use strict';

  function applyTheme(preference) {
    var html = document.documentElement;
    var systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    var isDark = preference === 'dark' || (preference === 'system' && systemDark);
    html.classList.toggle('dark', isDark);
    html.classList.toggle('light', !isDark);
    // Keep data attribute for CSS targeting
    html.setAttribute('data-theme', isDark ? 'dark' : 'light');
  }

  // Apply on first paint
  var saved = localStorage.getItem('pemu-theme') || 'system';
  applyTheme(saved);

  // Watch for OS-level changes when in system mode
  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
    if ((localStorage.getItem('pemu-theme') || 'system') === 'system') {
      applyTheme('system');
    }
  });

  // Public API used by Alpine.js components
  window.pemuSetTheme = function (preference) {
    localStorage.setItem('pemu-theme', preference);
    applyTheme(preference);
  };
})();
