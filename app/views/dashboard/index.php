
        <nav class="sidebar">
            <div class="title">
                <div class="left">
                    <img src="<?= BASEURL ?>asset/house-fill.svg">
                    <h3>Kelas</h3>
                </div>
                <div class="close" onclick="hideSidebar()">
                    <img src="<?= BASEURL ?>asset/x-bold.svg">
                </div>
            </div>
            <div class="menu">
                <div class="wrapper-kelas">
                    <a href="#" class="kelas">
                        <div class="inisial">D</div>
                        <h3 class="title">Dashboard</h3>
                    </a>
                    <a href="dataAkunAdmin.html" class="kelas">
                        <div class="inisial">D</div>
                        <h3 class="title">Data Akun</h3>
                    </a>
                    <a href="#" class="kelas">
                        <div class="inisial">D</div>
                        <h3 class="title">Data Kelas</h3>
                    </a>
                    <a href="#" class="kelas">
                        <div class="inisial">R</div>
                        <h3 class="title">Role</h3>
                    </a>

                </div>
                <div class="akun">
                    <a href="#" class="profil">
                        <img src="<?= BASEURL ?>asset/user.svg" class="icon">
                        <h3>Admin</h3>
                    </a>
                    <a href="#" class="logout">
                        <img src="<?= BASEURL ?>asset/sign-out.svg" class="icon">
                        <h3>Logout</h3>
                    </a>
                </div>
            </div>
        </nav>

        <div class="filter-background"></div>

        <!-- main -->
        <div class="wrapper-main">
          <!-- grid -->
          <div class="card-top siswa">
            <p>PESERTA DIDIK LAKI-LAKI</p>
            <h3>330</h3>
          </div>
          <div class="card-top siswi">
            <p>PESERTA DIDIK PEREMPUAN</p>
            <h3>366</h3>
          </div>
          <div class="card-top pendidik">
            <p>TENAGA PENDIDIK</p>
            <h3>33</h3>
          </div>
          <div class="card-top administrasi">
            <p>TENAGA ADMINISTRASI</p>
            <h3>10</h3>
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