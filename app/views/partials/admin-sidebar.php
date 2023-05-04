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
                    <a href="<?= BASEURL ?>dashboard" class="kelas">
                        <div class="inisial">D</div>
                        <h3 class="title">Dashboard</h3>
                    </a>
                    <a href="<?= BASEURL ?>dashboard/ac/" class="kelas">
                        <div class="inisial">D</div>
                        <h3 class="title">Data Akun</h3>
                    </a>
                    <!-- <a href="#" class="kelas">
                        <div class="inisial">D</div>
                        <h3 class="title">Data Kelas</h3>
                    </a>
                    <a href="#" class="kelas">
                        <div class="inisial">R</div>
                        <h3 class="title">Role</h3>
                    </a> -->

                </div>
                <div class="akun">
                    <a href="#" class="profil">
                        <img src="<?= BASEURL ?>asset/user.svg" class="icon">
                        <h3>Admin</h3>
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