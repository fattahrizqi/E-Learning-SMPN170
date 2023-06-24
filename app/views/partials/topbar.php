<?php if ($data['topbar'] == 1) :?>
        <div class="topbar">
            <div class="left">
                <img class="hamburger" src="<?= BASEURL ?>asset/list.svg" onclick="showSidebar()"></img>
                <?php if ($_SESSION['role'] === 'admin') { ?>
                    <a href="<?= BASEURL ?>dashboard/" class="title">Dashboard</a>
                <?php } else { ?>
                    <a href="<?= BASEURL ?>class/" class="title">SMPN 170</a>
                <?php } ?>
            </div>
            <?php if($_SESSION['role'] === 'siswa' && $data['title'] !== 'Profil') { ?>
            <div onclick="showModal()" class="right">
                <h3>Gabung kelas</h3>
                <img src="<?= BASEURL ?>asset/plus.svg">
            </div>
            <?php } elseif ($_SESSION['role'] === 'guru' && $data['title'] !== 'Profil') { ?>
            <div onclick="showModal()" class="right">
                <h3>Buat kelas</h3>
                <img src="<?= BASEURL ?>asset/plus.svg">
            </div>
            <?php } ?>
        </div>
<?php elseif ($data['topbar'] == 2) : ?>
        <div class="topbar">
            <div class="left">
                <img class="hamburger" src="<?= BASEURL ?>asset/list.svg" onclick="showSidebar()"></img>
                <a href="<?= BASEURL ?>class" class="title">SMPN 170</a>
            </div>
            <div class="right">
                <a href="<?= BASEURL ?>class/dc/<?= $data['class_code'] ?>-<?= App\helpers\Unique::generate(12) ?>" class="<?= $data['title'] === 'Forum' || $data['title'] === 'Post' ? 'active' : '' ?>">Forum</a>
                <?php if ($_SESSION['role'] == 'guru') { ?> 
                    <a href="<?= BASEURL ?>class/ln/<?= $data['class_code'] ?>-<?= App\helpers\Unique::generate(12) ?>" class="<?= $data['title'] === 'Mark' ? 'active' : '' ?>">Lembar nilai</a>
                    <a href="<?= BASEURL ?>class/rc/<?= $data['class_code'] ?>-<?= App\helpers\Unique::generate(12) ?>" class="<?= $data['title'] === 'Recap' ? 'active' : '' ?>">Rekap Nilai</a>
                <?php } ?>
            </div>
        </div>
<?php endif ?>