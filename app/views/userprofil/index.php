          <div class="wrapper-modal">
            <div class="top">
                <h1>Tambah Akun</h1>
                <img src="<?= BASEURL ?>asset/x.svg" onclick="hideModal()" class="close">
            </div>
            <div class="content">
                <div class="wrapper-form">
                  <form action="<?= BASEURL ?>profil/ep" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="old_pic" value="<?= $data['profil']['profpic'] ?>">
                    <input type="hidden" name="user_id" value="<?= $data['profil']['user_id'] ?>">

                    <label for="profpic">Foto Profil</label>
                    <input type="file" name="profpic" id="profpic">

                    <input name="noinduk" type="text" placeholder="NIP/NISN/STATUS KEPEGAWAIAN" required value="<?= isset($_SESSION['old']['noinduk']) ? $_SESSION['old']['noinduk'] : $data['profil']['no_induk'] ?>" >
                    <?= isset($_SESSION['errors']['noinduk']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['noinduk'] . '</sup>' : '' ?>

                    <input name="position" type="text" placeholder="Kelas/Posisi" required value="<?= isset($_SESSION['old']['position']) ? $_SESSION['old']['position'] : $data['profil']['position'] ?>" >
                    <?= isset($_SESSION['errors']['position']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['position'] . '</sup>' : '' ?>


                    <div class="kelas">
                      <img src="<?= BASEURL ?>asset/caret-down-fill.svg" class="caret"></img>
                        <select id="religion" name="religion">
                            <option hidden>Agama</option>
                            <option value="Islam" <?= $data['profil']['religion'] === 'Islam' ? 'selected' : '' ?>>Islam</option>
                            <option value="Protestan" <?= $data['profil']['religion'] === 'Protestan' ? 'selected' : '' ?>>Protestan</option>
                            <option value="Katolik" <?= $data['profil']['religion'] === 'Katolik' ? 'selected' : '' ?>>Katolik</option>
                            <option value="Hindu" <?= $data['profil']['religion'] === 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                            <option value="Buddha" <?= $data['profil']['religion'] === 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                            <option value="Konghucu" <?= $data['profil']['religion'] === 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                        </select>
                    </div>
                    <?= isset($_SESSION['errors']['religion']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['religion'] . '</sup>' : '' ?>

                    <div class="kelas">
                      <img src="<?= BASEURL ?>asset/caret-down-fill.svg" class="caret"></img>
                        <select id="gender" name="gender">
                            <option hidden>Jenis Kelamin</option>
                            <option value="L" <?= $data['profil']['gender'] === 'L' ? 'selected' : '' ?>>Laki-Laki</option>
                            <option value="P" <?= $data['profil']['gender'] === 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <?= isset($_SESSION['errors']['gender']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['gender'] . '</sup>' : '' ?>

                    <input name="birth_place" type="text" placeholder="Tempat Lahir (ex: Jakarta)" required value="<?= isset($_SESSION['old']['birth_place']) ? $_SESSION['old']['birth_place'] : $data['profil']['birth_place'] ?>" >
                    <?= isset($_SESSION['errors']['birth_place']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['birth_place'] . '</sup>' : '' ?>

                    <input name="address" type="text" placeholder="Alamat" required value="<?= isset($_SESSION['old']['address']) ? $_SESSION['old']['address'] : $data['profil']['address'] ?>" >
                    <?= isset($_SESSION['errors']['address']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['address'] . '</sup>' : '' ?>

                    <label for="birth">Tanggal lahir</label>
                    <input id="birth" name="birth" type="date" placeholder="Tanggal Lahir" required value="<?= isset($_SESSION['old']['birth']) ? $_SESSION['old']['birth'] : $data['profil']['birth'] ?>" >
                    <?= isset($_SESSION['errors']['birth']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['birth'] . '</sup>' : '' ?>
                        
                    <button type="submit">Sunting</button>
                  </form>
                </div>
            </div>
        </div>
        
        <div class="wrapper-modal1">
            <div class="top">
                  <h1>Ubah password</h1>
                  <img src="<?= BASEURL ?>asset/x.svg" onclick="hideSecondModal()" class="close">
            </div>
            <div class="content">
                <div class="wrapper-form">
                  <form action="<?= BASEURL ?>profil/ucp" method="POST">
                    <input type="hidden" name="user_id" value="<?= $data['profil']['user_id'] ?>">

                    <input name="old_pass" type="password" placeholder="Password lama" required>

                    <input name="new_pass" type="password" placeholder="Password baru" required >

                    <input name="confirm_pass" type="password" placeholder="Konfirmasi password" required >
                        
                    <button type="submit">Sunting</button>
                  </form>
                </div>
            </div>
        </div>

        <div class="filter-background"></div>

        <div class="flash" style="bottom:0;position:absolute;margin-left:10px;margin-bottom:10px;">
            <?php App\helpers\Flasher::flash() ?>
        </div>

        <div class="wrapper-main">
          <div class="card">
            <div class="text">
              <div class="top">
                <h1 class="nama"><?= $data['profil']['name'] ?></h1>
                <?php if ($data['profil']['user_id'] == $_SESSION['user_id'] || $_SESSION['role'] === 'admin') : ?>
                  <button class="sunting" onclick="showModal()">sunting profil</button>
                  <button class="sunting" style="color:red;" onclick="showSecondModal()">ubah password</button>
                <?php endif ?>
              </div>

              <div class="bottom">
                <p class="nisn"><?= $data['profil']['no_induk'] != null ? $data['profil']['no_induk'] : '-' ?></p>
                <p class="kelas"><span>Kelas/Posisi:</span> <?= $data['profil']['position'] != null ? $data['profil']['position'] : '-' ?></p>
                <p class="agama"><span>Agama:</span> <?= $data['profil']['religion'] != null ? $data['profil']['religion'] : '-' ?></p>
                <p class="jk"><span>Jenis Kelamin:</span> <?= $data['profil']['gender'] != null ? $data['profil']['gender'] : '-' ?></p>
                <p class="ttl"><span>TTL:</span> <?= $data['profil']['birth_place'] != null ? $data['profil']['birth_place'] . ',' : '- ,' ?> <?= $data['profil']['birth'] ?></p>
                <p class="alamat"><span>Alamat:</span> <?= $data['profil']['address'] != null ? $data['profil']['address'] : '-' ?></p>
              </div>
            </div>
            <div class="img">
              <img src="<?= BASEURL ?>asset/<?= $data['profil']['profpic'] ?>" alt="profpic">
            </div>

            <!-- bg -->
            <div class="bg-img">
              <img src="<?= BASEURL ?>asset/logo 170.png">
            </div>
          </div>
        </div>

        <script src="<?= BASEURL ?>script/scriptSiswa.js"></script>

  </body>
</html>