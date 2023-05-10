        <div class="filter-background"></div>

        <div class="wrapper-modal">
            <div class="top">
                <h1>Import Data</h1>
                <img src="<?= BASEURL ?>asset/x.svg" onclick="hideModal()" class="close">
            </div>
            <div class="content">
                <form action="<?= BASEURL ?>files/import" method="post" enctype="multipart/form-data">
                    <input type="file" name="import_file" id="file">
                    
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>

        <div class="wrapper-modal1">
            <div class="top">
                <h1>Tambah Akun</h1>
                <img src="<?= BASEURL ?>asset/x.svg" onclick="hideSecondModal()" class="close">
            </div>
            <div class="content">
                <div class="wrapper-form">
                  <form action="<?= BASEURL ?>dashboard/uc" method="POST">
                    <input name="name" type="name" placeholder="Nama" required value="<?= isset($_SESSION['old']['name']) ? $_SESSION['old']['name'] : '' ?>" >
                    <?= isset($_SESSION['errors']['name']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['name'] . '</sup>' : '' ?>

                    <input name="noinduk" type="noinduk" placeholder="NIP/NISN" required value="<?= isset($_SESSION['old']['noinduk']) ? $_SESSION['old']['noinduk'] : '' ?>" >
                    <?= isset($_SESSION['errors']['noinduk']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['noinduk'] . '</sup>' : '' ?>

                    <input name="email" type="email" placeholder="Email address" required value="<?= isset($_SESSION['old']['email']) ? $_SESSION['old']['email'] : '' ?>" >
                    <?= isset($_SESSION['errors']['email']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['email'] . '</sup>' : '' ?>

                    <div class="kelas">
                        <img src="<?= BASEURL ?>asset/caret-down-fill.svg" class="caret"></img>
                        <select id="role" name="role">
                            <option hidden value="">Role</option>
                            <option value="siswa">Siswa</option>
                            <option value="guru">Guru</option>
                        </select>
                        <?= isset($_SESSION['errors']['role']) ? '<sup style="float:left;color:red;">' . $_SESSION['errors']['role'] . '</sup>' : '' ?>
                    </div>
                        
                    <button type="submit">Buat</button>
                  </form>
                </div>
            </div>
        </div>

        <!-- main -->
        <div class="wrapper-main">
          <div class="wrapper-table">
            <div class="top">
              <h1>Table Data Akun</h1>
              <div class="button-data">
                <button onclick="showModal()">Import Data</button>
                <button onclick="showSecondModal()">Buat Akun</button>
              </div>
            </div>

            <div class="main">
              <div class="flash">
                <?php App\helpers\Flasher::flash(); ?>
              </div>
              <div class="search">
                <form action="<?= BASEURL ?>dashboard/acs" id="search" method="post">
                  <label for="search">Search: </label>
                  <input type="text" name="keyword" id="search">
                  <button type="submit" id="submitBtn"></button>
                </form>
              </div>

              <table>
                <tr>
                  <th>Nama</th>
                  <th>No Induk / Status Pegawai</th>
                  <th>Role</th>
                  <th>Posisi</th>
                  <th>JK</th>
                  <th>Alamat</th>
                  <th>Tanggal Lahir</th>
                  <th>Aksi</th>
                </tr>
                <?php if (empty($data['user'])) { ?>
                  <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data</td>
                  </tr>
                  <?php } else { ?>
                    <?php foreach ($data['user'] as $akun) : ?>
                      <tr>
                        <td><?= $akun['name'] ?></td>
                        <td><?= $akun['no_induk'] ?></td>
                        <td><?= $akun['role'] ?></td>
                        <td><?= $akun['position'] ?></td>
                        <td><?= $akun['gender'] ?></td>
                        <td><?= $akun['address'] ?></td>
                        <td><?= $akun['birth'] ?></td>
                        <td>
                          <form action="<?= BASEURL ?>dashboard/du" method="post">
                          <input type="hidden" name="user_id" value="<?= $akun['id'] ?>">
                          <button onclick="return confirm('Hapus data?')" style="all:unset;background-color:#c53535;color:white;padding:5px 10px;cursor:pointer;width:4rem;margin-bottom:5px;" class="delete">DELETE</button>
                          </form>
                          <button onclick="location.href='<?= BASEURL ?>dashboard/ud/<?= $akun['id'] ?>-<?= \App\helpers\Unique::generate(3) ?>-<?= \App\helpers\Unique::generate(12) ?>'" style="all:unset;background-color:#17a2b8;cursor:pointer;color:white;padding:5px 10px;width:4rem">DETAIL</button>
                        </td>
                      </tr>
                    <?php endforeach ?>
                <?php } ?>
              </table>

              <div class="pagination">
                <?php if ($data['current_page'] > 1) : ?>
                  <a class="prev" href="<?= BASEURL . 'dashboard/ac/page-' . $data['current_page'] - 1 ?>">Previous</a>
                <?php endif ?>

                <?php for($i = $data['start_page']; $i <= $data['end_page']; $i++) : ?>
                  <?php if ($i == $data['current_page']) : ?>
                    <a href="#" class="page page<?= $i ?>" style="font-weight: 700;"><?= $i ?></a>
                  <?php else :?>
                    <a href="<?= BASEURL . 'dashboard/ac/page-' . $i ?>" class="page page<?= $i ?>"><?= $i ?></a>
                  <?php endif ?>
                <?php endfor ?>

                <?php if ($data['current_page'] < $data['total_page']) : ?>
                  <a class="next" href="<?= BASEURL . 'dashboard/ac/page-' . $data['current_page'] + 1 ?>">Next</a>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
    </div>
    
    <script src="<?= BASEURL ?>script/scriptSiswa.js"></script>
    
</body> 
</html>