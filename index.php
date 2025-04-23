<!DOCTYPE html>
<html>
<head>
	<title>Login - Gopal</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
</head>
<body>
  <div class="cont">
  <form id="formAuthentication" action="login_admin.php" class="mb-3" method="post">
    <div class="form sign-in">
      <br>
      <h2>Login Admin</h2>
      <br>
      <br>
      <label>
        <span>Nama</span>
        <input type="text" name="nama_admin" required>
      </label>
      <label>
        <span>Password</span>
        <input type="password" name="password_admin" required>
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
          <h1>Admin?</h1>
          <p>Tekan tombol dibawah ini</p>
        </div>
        <br>
        <div class="img-btn">
          <span class="m-up">Pemilik</span>
          <span class="m-in">Admin</span>
        </div>
      </div>
      <div class="form sign-up">
        <br>
        <h2>Login Pemilik</h2>
        <br>
        <br>
        <label>
          <span>Nama</span>
          <input type="text">
        </label>
        <label>
          <span>Password</span>
          <input type="password">
        </label>
        <br>
        <button type="button" class="submit">Masuk</button>
      </div>
    </div>
  </div>
<script type="text/javascript" src="script.js"></script>
</body>
</html>