
      <div class="wrapper-form">
        <h1 class="title">Selamat Datang</h1>
        <form action="<?= BASEURL ?>login/authenticate" method="post">
          <input name="email" type="text" placeholder="Name or Email address" required>
          <input name="password" type="password" placeholder="Password" required>
          <button type="submit">Login</button>
        </form>
        <div class="flash">
          <?php App\helpers\Flasher::flash() ?>
        </div>
        <p>Belum memiliki akun? <a href="<?= BASEURL ?>register">Daftar</a></p>
      </div>
    </div>
    
    <script src="script/scriptHome.js"></script>
</body> 
</html>