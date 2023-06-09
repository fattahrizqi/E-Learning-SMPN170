

        <?php if ($_SESSION['role'] === 'siswa') { ?>
        <div class="wrapper-modal">
            <div class="top">
                <h1>Kode Kelas</h1>
                <img src="<?= BASEURL ?>asset/x.svg" onclick="hideModal()" class="close">
            </div>
            <div class="content">
                <form action="<?= BASEURL ?>class/jc/" method="post" id="modalForm">
                    <h3>Mintalah kode kelas kepada guru, lalu masukan di sini!</h3>
                    <input type="text" name="code" placeholder="31XXXXXX">
                    <p>*Gunakan kode kelas yang terdiri dari 6-8 huruf atau angka, tanpa spasi atau simbol</p>
                    <button type="submit" id="modalSubmit"></button>
                </form>
            </div>
        </div>
        <?php } elseif ($_SESSION['role'] === 'guru') { ?>
        <div class="wrapper-modal">
            <div class="top">
                <h1>Buat Kelas</h1>
                <img src="<?= BASEURL ?>asset/x.svg" onclick="hideModal()" class="close">
            </div>
            <div class="content">
                <form action="<?= BASEURL ?>class/c" method="post">
                    <div class="mapel">
                        <img src="<?= BASEURL ?>asset/caret-down-fill.svg" class="caret"></img>
                        <select id="mapel" name="subject">
                            <option hidden>Mata pelajaran</option>
                            <option value="MTK">Matematika</option>
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                            <option value="Bahasa Indonesia">Bahasa indonesia</option>
                            <option value="Bahasa Inggris">Bahasa inggris</option>
                            <option value="PJOK">PJOK</option>
                            <option value="PPKN">PPKN</option>
                            <option value="PAI">Agama islam</option>
                            <option value="PAK">Agama kristen</option>
                            <option value="Prakarya">Prakarya</option>
                            <option value="Seni Budaya">Seni budaya</option>
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
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                        </select>
                    </div>
                    
                    <button type="submit">Buat</button>
                </form>
            </div>
        </div>
        <?php } ?>

        <div class="wrapper-modal1"></div>

        <div class="flash" style="bottom:0;position:absolute;margin-left:10px;margin-bottom:10px;">
            <?php App\helpers\Flasher::flash() ?>
        </div>
        <?php if ( empty($data['class']) ) { ?>
            <div class="wrapper-emptyCard">
                <img src="<?= BASEURL ?>asset/homeImg2.svg">
                <?php if ($_SESSION['role'] === 'siswa') { ?>
                    <h3>Kamu belum bergabung dengan kelas apapun.</br>Kontak gurumu untuk mendapatkan kode referensi</h3>
                    <button onclick="showModal()">Gabung +</button>
                <?php } else { ?>
                    <h3>Oops, anda belum membuat kelas apapun.</br>Silahkan buat kelas dan invite siswa siswi untuk masuk. </h3>
                    <button onclick="showModal()">Buat kelas +</button>
                <?php } ?>
            </div>
        <?php } elseif ( !empty($data['class']) ) { ?>
            <div class="wrapper-cards">
                <?php foreach ($data['class'] as $class) : ?>
                    <div onclick="location.href='<?= BASEURL ?>class/dc/<?= $class['code'] ?>-<?= App\helpers\Unique::generate(12) ?>'" class="card">
                        <div class="image">
                            <img src="<?= BASEURL ?>asset/<?= $class['pict'] ?>">
                        </div>
                        <div class="content">
                            <?= $_SESSION['role'] === 'guru' ? '<h3 class="kelas">'. $class['grade'] .'</h3>' : '' ?>
                            <h1 class="mapel"><?= $class['subject'] ?></h1>
                            <p class="creator"><?= $class['name'] ?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php } ?>
    </div>
    
    <script src="<?= BASEURL ?>script/scriptSiswa.js"></script>
</body> 
</html>