
        <div class="filter-background"></div>

        
          <?php if ($_SESSION['role'] === 'guru') :?>
            <div class="wrapper-modal">
                <div class="top">
                    <h1>Tugas siswa</h1>
                    <img src="<?= BASEURL ?>asset/x.svg" onclick="hideModal()" class="close">
                </div>
                <div class="content">
                    <div class="wrapper-tugas">
                      <?php if(!empty($data['user_assignment']['dirname'] && !empty($data['user_assignment']['filename']))) : ?>
                        <form action="<?= BASEURL ?>files/export" method="post">
                          <button type="submit" name="file" value="<?= $data['user_assignment']['dirname'] ?>"><?= $data['user_assignment']['filename'] ?></button>
                        </form>
                      <?php else : ?>
                        <a href="#">not setted</a>
                      <?php endif ?>
                    </div>
                    <form class="form-input" method="post" action="<?= BASEURL ?>class/mark">
                      <input type="number" name="mark" max="100" placeholder="Masukan nilai" value="<?= $data['user_assignment']['mark'] != 0 ? $data['user_assignment']['mark'] : '' ?>">
                      <input type="text" name="teacher_note" placeholder="Tulis catatan">
                      <input type="hidden" name="user_id" value="<?= $data['user_assignment']['user_id'] ?>">
                      <input type="hidden" name="post_id" value="<?= $data['detail_post']['id'] ?>">
                      <button type="submit">Kirim</button>
                    </form>
                </div>
            </div>
          <?php elseif($_SESSION['role'] === 'siswa') : ?>
              <div class="wrapper-modal">
                  <div class="top">
                      <h1>Upload tugas</h1>
                      <img src="<?= BASEURL ?>asset/x.svg" onclick="hideModal()" class="close">
                  </div>
                  <div class="content">
                      <form action="<?= BASEURL ?>class/sbtgs" method="post" enctype="multipart/form-data">
                        <?php if(!empty($data['user_assignment']['dirname'])) : ?>
                          <p>Sudah mengumpulkan tugas!</p>
                          <?php else : ?>
                            <input type="file" id="files" name="assignment" required>
                            <input type="hidden" name="post_id" value="<?= $data['user_assignment']['post_id'] ?>">
                            <button type="submit">Submit</button>
                          <?php endif ?>
                      </form>
                  </div>
              </div>
          <?php endif ?>

        <div class="wrapper-modal1"></div>

        <div class="flash" style="bottom:0;position:absolute;margin-left:10px;margin-bottom:10px;">
          <?php App\helpers\Flasher::flash() ?>
        </div>

        <div class="wrapper-main">
        <?php if($data['detail_post']['categories'] === 'tugas') : ?>
          <div class="card">
            <h1 class="title"><?= $data['user_assignment']['name'] ?></h1>
            <?php if (!empty($data['user_assignment']['dirname']) && !empty($data['user_assignment']['mark'])) : ?>
              <h5 style="color:green;font-weight:400">Dinilai</h5>
            <?php elseif (!empty($data['user_assignment']['dirname']) && empty($data['user_assignment']['mark'])) : ?>
              <h5 style="color:gray;font-weight:400">Belum dinilai</h5>
            <?php elseif (empty($data['user_assignment']['dirname']) && empty($data['user_assignment']['mark'])) : ?>
              <h5 style="color:gray;font-weight:400">Belum mengumpulkan</h5>
            <?php endif ?>
            <h3 class="nilai"><?= !empty($data['user_assignment']['mark']) ? $data['user_assignment']['mark'] : '-' ?>/100</h3>
            <div class="note">
              Note Pengajar:
              <p><?= !empty($data['user_assignment']['teacher_note']) ? $data['user_assignment']['teacher_note'] : '' ?></p>
            </div>
          </div>
        <?php endif ?>

        <div class="main">
            <div class="title">
              <h1><?= $data['detail_post']['title'] ?></h1>
              <p><?= $data['detail_post']['created_at'] ?></p>
            </div>
            <div class="content">
              <div class="desc"><?= htmlspecialchars_decode($data['detail_post']['description']) ?></div>
              <div class="file">
                <?php foreach ($data['files'] as $file) : ?>
                  <form action="<?= BASEURL ?>files/export" method="post">
                    <button type="submit" name="file" value="<?= $file['dirname'] ?>"><?= $file['filename'] ?></button>
                  </form>
                <?php endforeach ?>
              </div>
            </div>
            <?php if ($data['detail_post']['categories'] === 'tugas') : ?>
              <?php if ($_SESSION['role'] === 'guru') : ?>
                <button onclick="showModal()">Lihat tugas</button>
              <?php elseif ($_SESSION['role'] === 'siswa') : ?>
                <button onclick="showModal()">Submit tugas</button>
              <?php endif ?>
            <?php endif ?>
          </div>
        </div>

        
    </div>
    
    <script src="<?= BASEURL ?>script/scriptSiswa.js"></script>
</body> 
</html>