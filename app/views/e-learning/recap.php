
  <div class="filter-background"></div>

  <div class="wrapper-modal">
      <div class="top">
          <h1>Kode Kelas</h1>
          <img src="../asset/x.svg" onclick="hideModal()" class="close">
      </div>
      <div class="content">
          <h3>Mintalah kode kelas kepada guru, lalu masukan di sini!</h3>
          <input type="text" placeholder="31XXXXXX">
          <p>*Gunakan kode kelas yang terdiri dari 6-8 huruf atau angka, tanpa spasi atau simbol</p>
      </div>
  </div>

  <div class="wrapper-main">
    <div class="pdf-header"x>
      <h2>Rekapitulasi Nilai - Kelas <?= $data['detail_class']['subject'] . ' ' . $data['detail_class']['grade'] ?></h2>
      <h3>Guru: <?= $data['detail_class']['name'] ?></h3>
    </div>
    <div class="button-export">
      <button onclick="location.href='<?= BASEURL ?>class/rcxls/<?= $data['detail_class']['code'] ?>'">Export as Excell</button>
      <button onclick="window.print();return false;">Export as PDF</button>
    </div>
    <table class="content-table">
      <thead>
        <tr>
          <th>Nama</th>
          <?php $total_assignment = 0 ?>
          <?php foreach ($data['post'] as $post) : ?>
            <?php if ($post['categories'] === 'tugas') : ?>
                <?php $total_assignment++ ?>
                <th onclick="location.href='<?= BASEURL ?>class/ln/<?= $data['detail_class']['code'] . '-' . $post['slug'] ?>'" class="tugas"><?= $post['title'] ?></th>
            <?php endif ?>
          <?php endforeach ?>
          <th>Nilai Rerata Siswa (<?= $total_assignment ?> tugas)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['students'] as $student) : ?>
          <tr>
            <td><?= $student['name'] ?></td>
            <?php $average = null; $total_post = count($student['mark']); $sum = null?>
            <?php foreach ($student['mark'] as $row) : ?>
              <?php 
                $average += $row['mark'];
                $sum = $average / $total_post;
              ?>
              <td><?= $row['mark'] ?></td>
            <?php endforeach ?>
            <td><?= number_format($sum, 2, '.', ' ') ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
  
</div>
</body>
</html>