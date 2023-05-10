English

# Note: Read it in Word Wrap

# E-Learning SMPN 170, build in Native PHP MVC architecture, using .htaccess rewriteEngine for URL rule

    ## Native PHP MVC (Model-View-Controller) application is a web application architecture that separates an application into three main components: the model, the view, and the controller.

        ### The model is responsible for managing data and providing it to the view. It is the component that interacts with the database and retrieves or stores data.

        ### The view is responsible for rendering the data provided by the model. It is the component that the user interacts with and sees on the screen.

        ### The controller is responsible for receiving and processing user input, calling the appropriate model and view components, and returning the appropriate response to the user.

    ## In a native PHP MVC application, the controller is implemented using PHP scripts, which listen to requests made by users and determine how to handle them. The model is implemented using PHP classes, which interact with the database and provide the data to the controller. The view is implemented using PHP templates, which generate the HTML code that is sent to the user's web browser.

    ## By using the MVC architecture, native PHP MVC applications are easier to maintain, test, and scale. The separation of concerns between the model, view, and controller components makes it easier to modify and update the application without affecting other components. Additionally, the use of PHP classes and templates promotes code reusability, reducing the time and effort needed to develop new features or fix bugs.

    ## Overall, using Native PHP MVC can result in more maintainable, scalable, and testable web applications, with a more efficient development process.

--------------------------------------------------------------------------------------------------------------

# Manual Book

    ## Make your local database in PhpMyAdmin etc. with dbname db_e-learning_smpn170, then import the table with sql file that available in App\database\

    ## Access App\config\config.php for set your own configuration, like its BASEURL (ex: i store this app in xampp\htdocs, then i should write the baseurl 'http://localhost/E-Learning-SMPN170/' which it represent where the app stored, and the name of its app folder) and all database configuration (such as dbname, host, user, password)

    ## Read the short documentation in the source code (if you need)

--------------------------------------------------------------------------------------------------------------

# App\helpers explanation

    ## It's helpers program that useful on specific purpose

    ## helpers component build separately from the main code for reusability code

    ## App\helpers list:

        ### Flasher : for set and return a flash message as user action feedback
        ### Handler : (for now) build for handle HTTP $_FILES request before store into repo and db
        ### Request : as HTTP Request Method validator, usually this helpers use when the method is just only for POST method
        ### Time : function to convert database timestamp into user-friendly time
        ### Unique : useful static method to generate unique code
        ### Validator : as a form input validator

--------------------------------------------------------------------------------------------------------------

# App\middlewares explanation

    ## It's program for authorizing user's role

    ## as a E-Learning App, role that's in list :

        ### Student : Joining class by unique code that sended by teacher, submit a class work and get mark from teacher. Can start post but as discussion post, and edit profil. For this role, it can be registered in sign up page

        ### Teacher : Create a class, set a class work, and set students mark, and edit profil. For this role, it just can be registered by admin in account centre

        ### Admin : Manage user account (create account for teacher or students, and create user by importing csv or xlsx file) with default username: admin@admin.com, pass: adminweb


==============================================================================================================
==============================================================================================================


Bahasa Indonesia

# Catatan: Bacalah dengan fitur Word Wrap diaktifkan

# E-Learning SMPN 170, dibangun dengan arsitektur Native PHP MVC, menggunakan .htaccess rewriteEngine untuk aturan URL

    ## Aplikasi Native PHP MVC (Model-View-Controller) adalah arsitektur aplikasi web yang memisahkan aplikasi menjadi tiga komponen utama: model, view, dan controller.

        ### Model bertanggung jawab untuk mengelola data dan menyediakannya ke tampilan. Ini adalah komponen yang berinteraksi dengan database dan mengambil atau menyimpan data.

        ### View bertanggung jawab untuk merender data yang disediakan oleh model. Ini adalah komponen yang digunakan oleh pengguna dan terlihat di layar.

        ### Controller bertanggung jawab untuk menerima dan memproses masukan pengguna, memanggil model dan tampilan yang sesuai, dan mengembalikan respons yang tepat kepada pengguna.

    ## Pada aplikasi Native PHP MVC, controller diimplementasikan menggunakan skrip PHP, yang menghandle request yang dibuat oleh pengguna dan menentukan cara menanganinya. Model diimplementasikan menggunakan kelas-kelas PHP, yang berinteraksi dengan database dan mengembalikan data ke controller. View diimplementasikan menggunakan templating PHP, yang menghasilkan kode HTML yang dikirim ke client-side web.

    ## Dengan menggunakan arsitektur MVC, aplikasi Native PHP MVC lebih mudah untuk di-maintenance, testing, dan dikembangkan. Pemisahan responsibility antara komponen model, view, dan controller membuatnya lebih mudah untuk memodifikasi dan memperbarui aplikasi tanpa memengaruhi komponen lainnya. Selain itu, penggunaan kelas-kelas dan templating PHP dengan prinsip reuseabilitas kode, mengurangi waktu dan usaha yang dibutuhkan untuk mengembangkan fitur baru atau memperbaiki bug.

    ## Secara keseluruhan, penggunaan Native PHP MVC dapat menghasilkan aplikasi web yang lebih mudah dipelihara, dapat dikembangkan dengan skala lebih besar, dan dapat diuji, dengan proses pengembangan yang lebih efisien.

--------------------------------------------------------------------------------------------------------------

# Panduan Manual

    ## Buatlah database lokal Anda di PhpMyAdmin atau sejenisnya dengan dbname db_e-learning_smpn170, kemudian impor tabel dengan file sql yang tersedia di App\database\

    ## Akses App\config\config.php untuk mengatur konfigurasi anda sendiri, seperti BASEURL (misalnya, jika saya menyimpan aplikasi ini di xampp\htdocs, maka saya harus menulis baseurl 'http://localhost/E-Learning-SMPN170/' yang mewakili di mana aplikasi disimpan, dan nama folder aplikasinya) serta semua konfigurasi database (seperti dbname, host, user, password)

    ## Bacalah dokumentasi singkat di kode sumber (jika diperlukan)

--------------------------------------------------------------------------------------------------------------

# Penjelasan App\helpers

    ## Ini adalah program helpers yang berguna untuk tujuan tertentu

    ## Komponen helpers dibangun secara terpisah dari kode utama untuk reuseabilitas kode

    ## Daftar class pada App\helpers:

        ### Flasher: untuk mengatur dan mengembalikan pesan kilat sebagai umpan balik tindakan pengguna.
        ### Handler: (untuk saat ini) dibangun untuk menangani permintaan HTTP $_FILES sebelum disimpan ke repo dan db.
        ### Request: sebagai validator Metode Permintaan HTTP, biasanya pembantu ini digunakan saat metode hanya untuk metode POST saja.
        ### Time: fungsi untuk mengkonversi timestamp database menjadi waktu yang ramah pengguna.
        ### Unique: metode statis yang berguna untuk menghasilkan kode unik.
        ### Validator: sebagai validator input formulir.

--------------------------------------------------------------------------------------------------------------

# Penjelasan App\middlewares

    ## Ini adalah program untuk mengotorisasi peran pengguna.

    ## Sebagai Aplikasi E-Learning, peran yang ada dalam daftar:

        ### Siswa: Bergabung dengan kelas menggunakan kode unik yang dikirimkan oleh guru, mengirimkan tugas kelas dan mendapatkan penilaian dari guru. Dapat memulai pos tetapi hanya sebagai pos diskusi, dan mengedit profil. Untuk peran ini, dapat mendaftar di halaman sign up.

        ### Guru: Membuat kelas, menetapkan tugas kelas, dan menetapkan penilaian siswa, serta mengedit profil. Untuk peran ini, hanya dapat didaftarkan oleh admin di pusat akun.

        ### Admin: Mengelola akun pengguna (membuat akun untuk guru atau siswa, dan membuat pengguna dengan mengimpor file csv atau xlsx) dengan username default: admin@admin.com, pass: adminweb
