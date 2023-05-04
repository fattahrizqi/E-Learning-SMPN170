        <div class="filter-background"></div>

        <div class="wrapper-modal">
            <div class="top">
                <h1>Kode Kelas</h1>
                <img src="<?= BASEURL ?>asset/x.svg" onclick="hideModal()" class="close">
            </div>
            <div class="content">
                <h3>Mintalah kode kelas kepada guru, lalu masukan di sini!</h3>
                <input type="text" placeholder="31XXXXXX">
                <p>*Gunakan kode kelas yang terdiri dari 6-8 huruf atau angka, tanpa spasi atau simbol</p>
            </div>
        </div>

        <div class="wrapper-main">
          <div class="daftar-tugas">
            <div class="title">
              <h1>Daftar Tugas</h1>
            </div>
            <div class="wrapper-tugas">
            <?php

            use App\helpers\Unique;

            foreach ($data['post'] as $post) : ?>
                <?php if ($post['categories'] === 'tugas') : ?>
                    <a href="<?= BASEURL ?>class/ln/<?= $data['detail_class']['code'] . '-' . $post['slug'] ?>" class="tugas"><?= $post['title'] ?></a>
                <?php endif ?>
            <?php endforeach ?>
            </div>
          </div>

          <div class="main">
            <div class="title">
              <h1>Lembar Jawaban Siswa</h1>
              <div class="wrapper-filter">
                <form action="">
                  <div class="filter">
                      <img src="<?= BASEURL ?>asset/caret-down-fill.svg" class="caret"></img>
                      <select id="filter" name="filter">
                          <option hidden>Filter</option>
                          <option value="belumDikerjakan">Belum dikerjakan</option>
                          <option value="belumDinilai">Belum dinilai</option>
                          <option value="sudahDinilai">Sudah dinilai</option>
                      </select>
                  </div>
                  
              </form>
              </div>
            </div>

            <div class="wrapper-cards">

              <?php foreach ($data['post_assignment'] as $assignment) : ?>
                <div class="card" onclick="location.href='<?= BASEURL ?>class/dt/<?= $data['detail_class']['code'] ?>-<?= $assignment['slug'] . '-' . $assignment['user_id'] . '-' . \App\helpers\Unique::generate(3) ?>'">
                <div class="top">
                  <h3><?= $assignment['name'] ?></h3>
                  <button><img src="<?= BASEURL ?>asset/dots-three-outline-vertical-fill - black.svg"></button>
                </div>

                <div class="content">
                  <div class="file">
                    <a href="#"><?= !empty($assignment['filename']) ? $assignment['filename'] : 'not setted' ?></a>
                  </div>
                <?php if (!empty($assignment['dirname']) && !empty($assignment['mark'])) : ?>
                    <p class="status" style="color:green;">Dinilai</p>
                <?php elseif (!empty($assignment['dirname']) && empty($assignment['mark'])) : ?>
                    <p class="status">Belum dinilai</p>
                <?php elseif (empty($assignment['dirname']) && empty($assignment['mark'])) : ?>
                    <p class="status" style="color:red;">Belum mengumpulkan</p>
                <?php endif ?>
                </div>
              </div>
            <?php endforeach ?>
              
            </div>
          </div>
        </div>

        
    </div>
    
    <script src="<?= BASEURL ?>script/scriptSiswa.js"></script>
</body> 
</html>