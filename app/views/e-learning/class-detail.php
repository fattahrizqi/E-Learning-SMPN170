
        <div class="filter-background"></div>
        
        <div class="wrapper-modal">
          <h3>Anda yakin ingin menghapus forum?</h3>
          <div class="button">
            <button class="yes">Hapus</button>
            <button class="no">Tidak</button>
          </div>
        </div>

        <div class="flash" style="bottom:0;position:absolute;margin-left:10px;margin-bottom:10px;">
                <?php App\helpers\Flasher::flash() ?>
        </div>

        <div class="wrapper-main">
          <div class="banner">
            <img src="<?= BASEURL ?>asset/banner.png" alt="">
          </div>

          <div class="main">
            <div class="daftar-tugas">
                <?= $_SESSION['role'] == 'guru' ? '<h1>Code: ' . $data['detail_class']['code'] . '</h1>' : '' ?>
                <br>
              <h1>Daftar Tugas</h1>
              <h3>Kelas <?= $data['detail_class']['subject'] ?></h3>
              <ul class="wrapper-tugas">
                <?php $i = 1; ?>
                <?php foreach ($data['post'] as $post) : ?>
                    <?php if ($post['categories'] === 'tugas') : ?>
                      <li onclick="scrollHere('<?= $i ?>')" class="tugas"><?= $post['title'] ?></li>
                    <?php $i++ ?>
                    <?php elseif ($i < 1) : ?>
                      <li class="tugas">Tidak ada tugas</li>
                    <?php endif ?>
                <?php endforeach ?>
                <?php if ($i <= 1) : ?>
                  <li class="tugas">Tidak ada tugas</li>
                <?php endif ?> 
              </ul>
            </div>
            <div class="wrapper-forum">
              <div class="title">
                <h1><?= $data['detail_class']['subject'] ?></h1>
                <h3><?= $data['detail_class']['name'] ?></h3>
              </div>
              
              <div class="wyswyg" style="min-height: 600px;">
                <form action="<?= BASEURL ?>class/ps" method="post" enctype="multipart/form-data">
                  <input type="text" name="title" id="title" placeholder="title">
                  <input type="hidden" name="class_id" value="<?= $data['detail_class']['id'] ?>">
                  <input type="file" name="attachment" id="attachment" placeholder="file">
                  <input type="file" name="attachment2" id="attachment2" placeholder="file2">
                  <?php if($_SESSION['role'] === 'guru') : ?>
                    <select name="categories" id="categories">
                      <option value="" hidden>Kategori</option>
                      <option value="default">Default</option>
                      <option value="tugas">Tugas</option>
                    </select>
                  <?php endif ?>
                  <textarea name="description" id="editor">
                      <p>Ketik deskripsi...</p>
                  </textarea>
                  <div class="button">
                    <button class="yes" type="submit">Post</button>
                  </div>
                </form>
              </div>

              <div class="forums">
                    <?php $i = 1; ?>
                    <?php $timeFormat = new App\helpers\Time() ?>
                    <?php foreach ($data['post'] as $post) : ?>
                        <div class="forum <?= $i ?>">
                        <div class="content">
                            <h3><?= $post['title'] ?></h3>
                            <p>Posted <?= $post['created_at'] = $timeFormat->friendlyTime($post['created_at']) ?> by <?= $post['name'] ?></p>
                        </div>
                        <div class="button">
                            <?php if($_SESSION['user_id'] === $data['detail_class']['teacher']) : ?>
                              <?php if($post['categories'] === 'tugas') : ?>
                                <button class="detail" onclick="location.href='<?= BASEURL ?>class/ln/<?= $data['detail_class']['code'] ?>-<?= $post['slug'] ?>'" >Lihat Tugas Siswa</button>
                              <?php else : ?>
                                <button class="detail" onclick="location.href='<?= BASEURL ?>class/dt/<?= $data['detail_class']['code'] ?>-<?= $post['slug'] ?>'" >Lihat Detail</button>
                              <?php endif ?>
                            <?php else : ?>
                              <button class="detail" onclick="location.href='<?= BASEURL ?>class/dt/<?= $data['detail_class']['code'] ?>-<?= $post['slug'] ?>'" >Lihat Detail</button>
                            <?php endif ?>
                            <?php if($_SESSION['role'] === 'guru' || $post['author'] == $_SESSION['user_id']) : ?>
                                <button onclick="showModal()" class="delete"><img src="<?= BASEURL ?>asset/trash-fill.svg" srcset=""></button>
                            <?php endif ?>
                        </div>
                        </div>
                        <?php $i++ ?>
                    <?php endforeach ?>
                
              </div>
            </div>
          </div>
        </div>

        
    </div>

    <script src="<?= BASEURL ?>script/scriptSiswa.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

</body> 
</html>