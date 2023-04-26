

        <?php if ($_SESSION['role'] === 'siswa') { ?>
        <div class="wrapper-modal">
            <div class="top">
                <h1>Kode Kelas</h1>
                <img src="<?= BASEURL ?>asset/x.svg" onclick="hideModal()" class="close">
            </div>
            <div class="content">
                <h3>Mintalah kode kelas kepada guru, lalu masukan di sini!</h3>
                <input type="text" placeholder="31XXXXXX">
                <p>*Gunakan kode kelas yang terdiri dari 6-8 huruf atau angka, tanpa spasi atau simbol</p>
            </div>
        </div>
        <?php } elseif ($_SESSION['role'] === 'guru') { ?>
        <div class="wrapper-modal">
            <div class="top">
                <h1>Buat Kelas</h1>
                <img src="<?= BASEURL ?>asset/x.svg" onclick="hideModal()" class="close">
            </div>
            <div class="content">
                <form action="">
                    <div class="mapel">
                        <img src="<?= BASEURL ?>asset/caret-down-fill.svg" class="caret"></img>
                        <select id="mapel" name="mapel">
                            <option hidden>Mata pelajaran</option>
                            <option value="matematika">Matematika</option>
                            <option value="ipa">IPA</option>
                            <option value="ips">IPS</option>
                            <option value="bahasa">Bahasa indonesia</option>
                            <option value="inggris">Bahasa inggris</option>
                            <option value="pjok">PJOK</option>
                            <option value="ppkn">PPKN</option>
                            <option value="islam">Agama islam</option>
                            <option value="kristen">Agama kristen</option>
                            <option value="prakarya">Prakarya</option>
                            <option value="senibudaya">Seni budaya</option>
                        </select>
                    </div>
                    <div class="kelas">
                        <img src="<?= BASEURL ?>asset/caret-down-fill.svg" class="caret"></img>
                        <select id="kelas" name="kelas">
                            <option hidden>Kelas</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="abjad">
                        <img src="<?= BASEURL ?>asset/caret-down-fill.svg" class="caret"></img>
                        <select id="abjad" name="abjad">
                            <option hidden>Abjad kelas</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                            <option value="e">E</option>
                            <option value="f">F</option>
                            <option value="g">G</option>
                        </select>
                    </div>
                    
                    <button>Buat</button>
                </form>
            </div>
        </div>
        <?php } ?>

        <!-- if class = 0 -->
        <!-- <div class="wrapper-emptyCard">
            <img src="../>asset/cart is empty.png">
            <h3>Kamu belum bergabung dengan kelas apapun.</br>Kontak gurumu untuk mendapatkan kode referensi</h3>
            <button onclick="showModal()">Gabung +</button>
        </div> -->

        <!-- if class = 1 -->
        <div class="flash" style="bottom:0;position:absolute;margin-left:10px;margin-bottom:10px;">
            <?php App\helpers\Flasher::flash() ?>
        </div>
        <div class="wrapper-cards">
            <div onclick="location.href='detailClassSiswa.html'" class="card">
                <div class="image">
                    <img src="<?= BASEURL ?>asset/mtk.png">
                </div>
                <div class="content">
                    <?= $_SESSION['role'] === 'guru' ? '<h3 class="kelas">7A</h3>' : '' ?>
                    <h1 class="mapel">MTK</h1>
                    <p class="creator">Abdul Mahfud </p>
                </div>
            </div>
            <div onclick="location.href='detailClassSiswa.html'" class="card">
                <div class="image">
                    <img src="<?= BASEURL ?>asset/mtk.png">
                </div>
                <div class="content">
                    <h1 class="mapel">Bahasa Indonesia</h1>
                    <p class="creator">Abdul Mahfud </p>
                </div>
            </div>
            <div onclick="location.href='detailClassSiswa.html'" class="card">
                <div class="image">
                    <img src="<?= BASEURL ?>asset/mtk.png">
                </div>
                <div class="content">
                    <h1 class="mapel">MTK</h1>
                    <p class="creator">Abdul Mahfud </p>
                </div>
            </div>
            <div onclick="location.href='detailClassSiswa.html'" class="card">
                <div class="image">
                    <img src="<?= BASEURL ?>asset/mtk.png">
                </div>
                <div class="content">
                    <h1 class="mapel">Bahasa Indonesia</h1>
                    <p class="creator">Abdul Mahfud </p>
                </div>
            </div>
            <div onclick="location.href='detailClassSiswa.html'" class="card">
                <div class="image">
                    <img src="<?= BASEURL ?>asset/mtk.png">
                </div>
                <div class="content">
                    <h1 class="mapel">MTK</h1>
                    <p class="creator">Abdul Mahfud </p>
                </div>
            </div>
            <div onclick="location.href='detailClassSiswa.html'" class="card">
                <div class="image">
                    <img src="<?= BASEURL ?>asset/mtk.png">
                </div>
                <div class="content">
                    <h1 class="mapel">MTK</h1>
                    <p class="creator">Abdul Mahfud </p>
                </div>
            </div>
            <div onclick="location.href='detailClassSiswa.html'" class="card">
                <div class="image">
                    <img src="<?= BASEURL ?>asset/mtk.png">
                </div>
                <div class="content">
                    <h1 class="mapel">MTK</h1>
                    <p class="creator">Abdul Mahfud </p>
                </div>
            </div>
            <div onclick="location.href='detailClassSiswa.html'" class="card">
                <div class="image">
                    <img src="<?= BASEURL ?>asset/mtk.png">
                </div>
                <div class="content">
                    <h1 class="mapel">MTK</h1>
                    <p class="creator">Abdul Mahfud </p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="<?= BASEURL ?>script/scriptSiswa.js"></script>
</body> 
</html>