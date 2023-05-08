<nav class="sidebar">
            <div class="title">
                <div class="left">
                    <img src="<?= BASEURL ?>asset/house-fill.svg">
                    <h3>Kelas</h3>
                </div>
                <div class="close" onclick="hideSidebar()">
                    <img src="<?= BASEURL ?>asset/x-bold.svg">
                </div>
            </div>
            <div class="menu">
                <!-- if menu = 0 -->
                <!-- <div class="wrapper-emptyClass">
                    <p>Tidak ada kelas !</p>
                </div> -->
                <?php if ( empty($data['class']) ) { ?>
                    <div class="wrapper-emptyClass">
                        <p>Tidak ada kelas !</p>
                    </div>
                <?php } elseif ( !empty($data['class']) ) { ?>
                    <div class="wrapper-kelas">
                        <?php foreach ($data['class'] as $class) :?>
                            <a href="<?= BASEURL ?>class/dc/<?= $class['code'] ?>-<?= App\helpers\Unique::generate(12) ?>" class="kelas">
                                <div class="inisial"><?= $class['subject'][0]?></div>
                                <h3 class="title"><?= $class['subject'] ?> <?= $_SESSION['role'] === 'guru' ? '<span>' . $class['grade'] . '</span>' : '' ?></h3>
                            </a>
                        <?php endforeach ?>
                    </div>
                <?php } ?>
                <div class="akun">
                    <a href="<?= BASEURL ?>profil" class="profil">
                        <img src="<?= BASEURL ?>asset/user.svg" class="icon">
                        <h3><?= $data['user']['name'] ?></h3>
                    </a>
                    <form action="<?= BASEURL ?>login/l" method="post" class="logout">
                        <button type="submit" style="all:unset;display:flex;cursor:pointer;gap:1rem;">
                        <img src="<?= BASEURL ?>asset/sign-out.svg" class="icon">
                        <h3>Logout</h3>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="filter-background"></div>