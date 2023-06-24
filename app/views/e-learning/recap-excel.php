<?php 

    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=rekap-nilai-".$data['detail_class']['subject']."-".$data['detail_class']['grade'].".xls");

?>

  <table class="content-table">
    <thead>
      <tr>
        <th>Nama</th>
        <?php $total_assignment = 0 ?>
        <?php foreach ($data['post'] as $post) : ?>
          <?php if ($post['categories'] === 'tugas') : ?>
              <?php $total_assignment++ ?>
              <th><?= $post['title'] ?></th>
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
          <td><?= number_format($sum, 2) ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>