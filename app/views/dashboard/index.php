        <div class="filter-background"></div>

        <div class="flash" style="bottom:0;position:absolute;margin-left:10px;margin-bottom:10px;">
            <?php App\helpers\Flasher::flash() ?>
        </div>
        <!-- main -->
        <div class="wrapper-main">
          <!-- grid -->
          <div class="card-top siswa">
            <p>AKUN PESERTA DIDIK LAKI-LAKI</p>
            <h3><?= count($data['L']) ?></h3>
          </div>
          <div class="card-top siswi">
            <p>AKUN PESERTA DIDIK PEREMPUAN</p>
            <h3><?= count($data['P']) ?></h3>
          </div>
          <div class="card-top pendidik">
            <p>TENAGA PENDIDIK</p>
            <h3><?= count($data['teacher']) ?></h3>
          </div>
          <div class="card-top administrasi">
            <p>TENAGA ADMINISTRASI</p>
            <h3><?= count($data['admin']) ?></h3>
          </div>
          <div class="main">
            <h3>E-Learning System</h3>
            <div class="img">
              <img src="<?= BASEURL ?>asset/logo 170.png">
            </div>
            <h3>SMPN 170 Jakarta | Akreditasi: A</h3>
          </div>
          <div class="konfigurasi">
            <h3>Konfigurasi Sistem</h3>
            <form action="">
              <label for="tahun">Tahun Ajaran </label>
              <div class="tahun">
                  <img src="<?= BASEURL ?>asset/caret-down-fill.svg" class="caret"></img>
                  <select id="tahun" name="tahun">
                      <option value="23">2022/2023</option>
                      <option value="22">2021/2022</option>
                      <option value="21">2020/2021</option>
                  </select>
              </div>
              <label for="nama">Nama Sistem </label>
              <input type="text" id="nama" value="E-Learning SMPN 170">
              
              <button>Proses</button>
          </form>
          </div>
        </div>
    </div>
    
    <script src="<?= BASEURL ?>script/scriptSiswa.js"></script>
</body> 
</html>