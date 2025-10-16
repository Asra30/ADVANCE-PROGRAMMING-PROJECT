// Minimal client-side validation and UX enhancements
document.addEventListener('DOMContentLoaded', function() {
  var form = document.getElementById('taskForm');
  var input = document.getElementById('task');
  form.addEventListener('submit', function(e) {
    if (!input.value.trim()) {
      e.preventDefault();
      alert('Description cannot be empty.');
      input.focus();
    }
  });

  // Auto-hide success alert after 4 seconds with fade out
  var alertEl = document.querySelector('.alert.alert-info');
  if (alertEl) {
    setTimeout(function() {
      alertEl.style.transition = 'opacity 0.6s ease';
      alertEl.style.opacity = '0';
      setTimeout(function() { if (alertEl.parentNode) alertEl.parentNode.removeChild(alertEl); }, 700);
    }, 4000);
  }
});
