<script>
  (() => {
    'use strict';

    window.addEventListener('load', () => {
      const forms = document.querySelectorAll('form');

      forms.forEach(form => {
        form.classList.add('needs-validation');
        form.setAttribute('novalidate', true);

        form.addEventListener('submit', event => {
          const requiredInputs = form.querySelectorAll('[required]');
          let valid = true;

          requiredInputs.forEach(input => {
            if (!input.value.trim()) {
              valid = false;
              input.classList.add('is-invalid');
              let feedback = input.nextElementSibling;

              if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.textContent = 'Silahkan isi terlebih dahulu';
                input.after(feedback);
              } else {
                feedback.textContent = 'Silahkan isi terlebih dahulu';
              }
            } else {
              input.classList.remove('is-invalid');
              input.classList.add('is-valid');
            }
          });

          if (!valid) {
            event.preventDefault();
            event.stopPropagation();
          }

          form.classList.add('was-validated');
        });
      });
    });
  })();
</script>

<script>
document.getElementById('searchInput').addEventListener('keypress', function (e) {
  if (e.key === 'Enter') {
    var search = this.value.trim();
    if (search !== '') {
      window.location.href = "?search=" + encodeURIComponent(search);
    }
  }
});
</script>



<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Dibuat oleh <a href="#" target="_blank">Adam Kurniawan</a>.</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2025. All rights reserved.</span>
    </div>
</footer>