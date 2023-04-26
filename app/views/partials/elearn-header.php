<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning | <?= $data['title'] ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL ?>style/<?= $data['style'] ?>.css">
    <link rel="stylesheet" href="<?= BASEURL ?>style/flasher.css">
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div class="left">
                <img class="hamburger" src="<?= BASEURL ?>asset/list.svg" onclick="showSidebar()"></img>
                <?php if ($_SESSION['role'] === 'admin') { ?>
                    <a href="<?= BASEURL ?>dashboard/" class="title">Dashboard</a>
                <?php } else { ?>
                    <a href="<?= BASEURL ?>class/" class="title">SMPN 170</a>
                <?php } ?>
            </div>
            <?php if($_SESSION['role'] === 'siswa') { ?>
            <div onclick="showModal()" class="right">
                <h3>Gabung kelas</h3>
                <img src="<?= BASEURL ?>asset/plus.svg">
            </div>
            <?php } elseif ($_SESSION['role'] === 'guru') { ?>
            <div onclick="showModal()" class="right">
                <h3>Buat kelas</h3>
                <img src="../asset/plus.svg">
            </div>
            <?php } ?>
        </div>