# elemes_OLP

Test PHP Backend dev

a. tech spec:

    - Framework : laravel versi 9.32.0
    - database : mysql
    - package: default laravel dan untuk auth nya saya menggunakan laravel/sanctum yang juga sudah ter install bersamaan dengan penginstallan laravel nya. serta untuk manage role dan permissions saya gunakan package spatie/laravel.
    - PHP version 8.1.9 (cli) (built: Aug  4 2022 15:12:55) (NTS)
    - Semua API URL ada di postman.collection yang ada di folder /docs.
    - route api ada di file routes/api.php.
    - migration ada di folder /database/migrations/.
    - model ada di app/Models/.

b. Cara Setup dan menjalankan di local Environment:

    - clone repository ini.
    - jika sudah ter download, masuk ke folder project nya.
    - lalu buka terminal atau command prompt dan jalankan perintah "Composer Install" dan tunggu hingga proses selesai.
    - jalankan perintah "Composer update" dan tunggu hingga proses selesai.
    - lalu copy file /.env.example dan rename menjadi /.env
    - lalu setting database nya di file /.env silahkan ubah settingan nya seperti ini:
    	DB_CONNECTION=mysql
    	DB_HOST=127.0.0.1 (ip server database mysql)
    	DB_PORT=3306
    	DB_DATABASE=elemes_olp (nama database)
    	DB_USERNAME=root (disesuaikan dengan user mysql di masing masing)
    	DB_PASSWORD= (disesuaikan dengan password user mysql di masing masing)
    - untuk isi DB_DATABASE menyesuaikan dengan nama database yang di buat.
    - untuk host, port username dan password menyesuaikan dengan settingan masing masing.
    - jika setting database telah selesai, maka kita pergi lagi ke terminal.
    - lalu jalankan perintah "php artisan migrate --seed" untuk menjalankan migrasi database dan seeder untuk membuat user.
    - jika semua telah selesai saatnya menjalankan perintah "php artisan serve" di terminal.
    - lalu coba test menggunakan Postman, jangan lupa import dulu postmancolection nya yang ada di folder /docs.
    - Login menggunakan username dan password yang telah di sediakan atau bisa juga register baru dan akan otomatis mendapat role "User"

c. Login Cridential:

    -   Username: user
        Password: 12345678
        Permission: Register, Get Category Course, Get Popular Category Course, Get Course, Get Detail Course, Search Course serta Sort Course based on: Lowest price, Highest price, dan Free
    -   Username: admin
        Password: 12345678
        Permission: CRUD Course, CRUD Category, Delete User (soft delete), Get Simple Statistics meliputi : menampilkan jumlah total user, total course, serta total course yang memiliki harga free
    -   Username: superadmin
        Password: 12345678
        Permission: semua akses
