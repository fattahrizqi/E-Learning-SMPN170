
      <div class="wrapper-form">
        <h1 class="title">Selamat Datang</h1>
        <form action="<?= BASEURL ?>login/authenticate" method="post">
          <input name="email" type="email" placeholder="Email address" required>
          <input name="password" type="password" placeholder="Password" required>
          <button type="submit">Login</button>
        </form>
        <div class="flash">
          <?php App\helpers\Flasher::flash() ?>
        </div>
        <p>Belum memiliki akun? <a href="<?= BASEURL ?>register">Daftar</a></p>
      </div>
    </div>
    
    <script src="../script/scriptSiswa.js"></script>
</body> 
</html>