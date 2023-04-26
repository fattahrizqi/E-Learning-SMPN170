
<div class="wrapper-form">
        <h1 class="title">Daftar</h1>
        <form action="<?= BASEURL ?>register/store" method="POST">
          <input name="name" type="name" placeholder="Nama" required value="<?= isset($_SESSION['old']['name']) ? $_SESSION['old']['name'] : '' ?>" >
          <?= isset($_SESSION['errors']['name']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['name'] . '</sup>' : '' ?>

          <input name="noinduk" type="noinduk" placeholder="NIP/NIK/NISN" required value="<?= isset($_SESSION['old']['noinduk']) ? $_SESSION['old']['noinduk'] : '' ?>" >
          <?= isset($_SESSION['errors']['noinduk']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['noinduk'] . '</sup>' : '' ?>

          <input name="email" type="email" placeholder="Email address" required value="<?= isset($_SESSION['old']['email']) ? $_SESSION['old']['email'] : '' ?>" >
          <?= isset($_SESSION['errors']['email']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['email'] . '</sup>' : '' ?>

          <input name="password" type="password" placeholder="Password" required  >
          <?= isset($_SESSION['errors']['password']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['password'] . '</sup>' : '' ?>

          <input name="confirm" type="password" placeholder="Confirm password" required >
          <?= isset($_SESSION['errors']['confirm']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['confirm'] . '</sup>' : '' ?>

          <button type="submit">Sign in</button>
        </form>
        <div class="flash">
            <?php App\helpers\Flasher::flash(); ?>
        </div>
        <p>Sudah memiliki akun? <a href="<?= BASEURL ?>login">Masuk</a></p>
      </div>
    </div>
    
    <script src="../script/scriptSiswa.js"></script>
</body> 
</html>