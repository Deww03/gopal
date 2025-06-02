<!DOCTYPE html>
<html>
<head>
	<title>Login - Bude Ari</title>
    <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
</head>
<body>
  <div class="cont">
  <form id="login_kasir" action="login_kasir.php" class="mb-3" method="post">
    <div class="form sign-in">
      <br>
      <h2>Login Kasir</h2>
      <br>
      <br>
      <label>
        <span>Nama</span>
        <input type="text" name="nama_kasir" required>
      </label>
      <label>
        <span>Password</span>
        <input type="password" name="password_kasir" required>
      </label>
      <br>
      <button class="submit" type="submit">Masuk</button>
    </div>
    </form>

    <div class="sub-cont">
      <div class="img">
        <div class="img-text m-up">
          <br>
          <h1>Pemilik?</h1>
          <p>Tekan tombol dibawah ini</p>
        </div>
        <div class="img-text m-in">
          <br>
          <h1>Kasir?</h1>
          <p>Tekan tombol dibawah ini</p>
        </div>
        <br>
        <div class="img-btn">
          <span class="m-up">Pemilik</span>
          <span class="m-in">Kasir</span>
        </div>
      </div>
    <form id="login_pemilik" action="login_pemilik.php" class="mb-3" method="post">      
      <div class="form sign-up">
        <br>
        <h2>Login Pemilik</h2>
        <br>
        <br>
        <label>
          <span>Nama</span>
          <input type="text" name="nama_pemilik" required>
        </label>
        <label>
          <span>Password</span>
          <input type="password" name="password_pemilik" required>
        </label>
        <br>
        <button type="submit" class="submit">Masuk</button>
      </div>
    </form>  
    </div>
  </div>

  <!-- Toast untuk Login Gagal -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="loginToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-danger text-white">
      <strong class="me-auto">Login Gagal</strong>
      <small>Baru saja</small>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Nama atau password yang kamu masukkan salah.
    </div>
  </div>
</div>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const alert = urlParams.get('alert');
    if (alert === 'gagal') {
      const toastEl = document.getElementById('loginToast');
      const toast = new bootstrap.Toast(toastEl);
      toast.show();
    }
  });
</script>


<script type="text/javascript" src="script.js"></script>
<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>