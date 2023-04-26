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

                <!-- if menu = 1 -->
                <div class="wrapper-kelas">
                    <a href="#" class="kelas">
                        <div class="inisial">P</div>
                        <h3 class="title">Prakarya <?= $_SESSION['role'] === 'guru' ? '<span>7A</span>' : '' ?></h3>
                    </a>
                    <a href="#" class="kelas">
                        <div class="inisial">P</div>
                        <h3 class="title">Prakarya <?= $_SESSION['role'] === 'guru' ? '<span>7B</span>' : '' ?></h3>
                    </a>
                    <a href="#" class="kelas">
                        <div class="inisial">P</div>
                        <h3 class="title">Prakarya <?= $_SESSION['role'] === 'guru' ? '<span>7C</span>' : '' ?></h3>
                    </a>
                    <a href="#" class="kelas">
                        <div class="inisial">S</div>
                        <h3 class="title">Seni budaya <?= $_SESSION['role'] === 'guru' ? '<span>7A</span>' : '' ?></h3>
                    </a>
                    <a href="#" class="kelas">
                        <div class="inisial">S</div>
                        <h3 class="title">Seni budaya <?= $_SESSION['role'] === 'guru' ? '<span>7B</span>' : '' ?></h3>
                    </a>

                </div>
                <div class="akun">
                    <a href="#" class="profil">
                        <img src="<?= BASEURL ?>asset/user.svg" class="icon">
                        <h3>Nickymicko Ayub</h3>
                    </a>
                    <a href="<?= BASEURL ?>login/logout" class="logout">
                        <img src="<?= BASEURL ?>asset/sign-out.svg" class="icon">
                        <h3>Logout</h3>
                    </a>
                </div>
            </div>
        </nav>

        <div class="filter-background"></div>