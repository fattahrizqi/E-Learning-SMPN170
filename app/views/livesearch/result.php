<?php if (empty($data['user'])) { ?>
                  <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data</td>
                  </tr>
                  <?php } else { ?>
                    <?php foreach ($data['user'] as $akun) : ?>
                      <tr onclick="location.href='<?= BASEURL ?>dashboard'" style="cursor:pointer;">
                        <td><?= $akun['name'] ?></td>
                        <td><?= $akun['no_induk'] ?></td>
                        <td><?= $akun['role'] ?></td>
                        <td><?= $akun['position'] ?></td>
                        <td><?= $akun['gender'] ?></td>
                        <td><?= $akun['address'] ?></td>
                        <td><?= $akun['birth'] ?></td>
                      </tr>
                    <?php endforeach ?>
                <?php } ?>