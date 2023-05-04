<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?> | SMPN 170</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL ?>style/<?= $data['style'] ?>.css">
    <link rel="stylesheet" href="<?= BASEURL ?>style/flasher.css">
</head>
<body>
    <div class="topbar">
          <a href="<?= BASEURL ?>" class="left">
              <img class="logo" src="<?= BASEURL ?>asset/logo 170.png"></img>
              <h3 class="title">SMPN 170</h3>
          </a>
          <div class="right">
              <a href="<?= BASEURL ?>" <?php if($data['title'] === 'Home'){ echo "class='active'"; } ?>>Beranda</a>
              <a href="<?= BASEURL ?>about" <?php if($data['title'] === 'Profil'){ echo "class='active'"; } ?>>Profil</a>
              <?php if (!isset($_SESSION['user_id'])) : ?>
                <a href="<?= BASEURL ?>login" <?php if($data['title'] === 'Login' || $data['title'] === 'Register'){ echo "class='active'"; } ?>>Masuk/Daftar</a>
            <?php else : ?>
                <a href="<?= BASEURL ?>class" >E-Learning</a>
            <?php endif ?>
          </div>
    </div>
    <div class="container">