# 🏨 Sistem Manajemen Reservasi Hotel

## 🧠 Brainstorming

### 📜 Deskripsi
Sistem manajemen reservasi hotel adalah proyek akhir dari mata kuliah Back-end Web Development yang memungkinkan pengelolaan pelanggan, kamar, dan reservasi dengan mudah dan efisien.

### ✨ Fitur
- 👥 **Manajemen Pelanggan**
  - **GET** `/api/customers`: Membaca data pelanggan
  - **POST** `/api/customers`: Menambahkan pelanggan baru
  - **PUT** `/api/customers`: Memperbarui data pelanggan
  - **DELETE** `/api/customers`: Menghapus data pelanggan

- 🛏️ **Manajemen Kamar**
  - **GET** `/api/rooms`: Membaca data kamar
  - **POST** `/api/rooms`: Menambahkan kamar baru
  - **PUT** `/api/rooms`: Memperbarui data kamar
  - **DELETE** `/api/rooms`: Menghapus data kamar

- 📅 **Manajemen Reservasi**
  - **GET** `/api/reservations/room-status`: Mengecek status kamar untuk reservasi
  - **GET** `/api/reservations`: Membaca data reservasi
  - **POST** `/api/reservations`: Menambahkan reservasi baru
  - **PUT** `/api/reservations`: Memperbarui data reservasi
  - **DELETE** `/api/reservations`: Menghapus data reservasi

## 🛠️ Skema Tech Stack
Berikut adalah beberapa kombinasi teknologi yang digunakan dalam mengembangkan sistem ini:

![skema_tech_stack](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/bbdc7094-38be-4d13-ade8-e58111bc457b)

### Penjelasan
Penjelasan singkat mengenai skema tech stack yang digunakan:
1. **User Interface**: Interaksi langsung dengan pengguna melalui web browser
2. **Apache Web Server**: Menangani permintaan dari browser dan meneruskannya ke REST API.
3. **REST API**: Interface antara front-end dan logika bisnis back-end, mengelola permintaan dari server web, melakukan operasi, dan mengembalikan respons.
4. **PHP**: Menjalankan logika bisnis sistem manajemen reservasi hotel, termasuk manipulasi data reservasi, validasi input pengguna, dan pemrosesan bisnis lainnya.
5. **MySQL**: Database untuk menyimpan semua data terkait sistem manajemen reservasi hotel.

## 🗂️ ERD

![erd_hotelreservation](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/6d27e87a-19da-4973-b91f-520fc76a5481)

ERD ini menunjukkan hubungan antara tiga tabel dalam sistem reservasi hotel:

1. **Customer (Pelanggan)**
    - `customer_id` (PK)
    - `name`, `email`, `phone_number`
2. **Reservation (Reservasi)**
    - `reservation_id` (PK)
    - `customer_id` (FK) - merujuk ke Customer
    - `room_id` (FK) - merujuk ke Room
    - `check_in_date`, `check_out_date`, `total_price`
3. **Room (Kamar)**
    - `room_id` (PK)
    - `room_type`, `price`

Relasi dalam ERD ini:

1. **Relasi Customer ke Reservation**
    - **One-to-Many**: Satu pelanggan bisa memiliki banyak reservasi. `customer_id` sebagai FK di tabel Reservation merujuk ke PK `customer_id` di tabel Customer.
2. **Relasi Room ke Reservation**
    - **One-to-Many**: Satu kamar bisa dipesan di banyak reservasi. `room_id` sebagai FK di tabel Reservation merujuk ke PK `room_id` di tabel Room.

### Kesimpulan
- Customer dapat memiliki banyak Reservation, tetapi setiap Reservation hanya terkait dengan satu Customer.
- Room dapat dipesan di banyak Reservation, tetapi setiap Reservation hanya terkait dengan satu Room.

## 🛠️ Petunjuk Pemasangan
Langkah-langkah untuk menginstal proyek ini secara lokal:
### 1. **Clone atau unduh repository:**
  ```bash
  git clone https://github.com/arkaadiana/hotel-reservation-backend.git
  ```

  ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/7e1d7046-ede2-4379-a3ac-0b77ac194910)
   Atau, unduh file ZIP dan ekstrak ke komputer kalian.

   Pastikan disimpannya pada lokasi seperti dibawah ini:

  ![location_folder](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/9a35684a-c08b-44d5-8bf4-006bffe42881)

### 2. **Buka Proyek di IDE:**
  - Buka proyek menggunakan IDE favorit kalian seperti Visual Studio Code.
### 3. **Aktifkan XAMPP:**
  - Pastikan XAMPP sudah berjalan dengan layanan Apache dan MySQL aktif.
  ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/a763ebf6-07e2-48ec-95bc-4c22d9550023)
### 4. **Impor Database**
  - Buka phpMyAdmin.
  - Impor file `db_hotelreservation.sql` atau jalankan query SQL dari file tersebut untuk membuat database dan tabel yang diperlukan.
  ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/2a5b06cb-c297-4af0-a365-59a194f16082)
### 5. **Konfigurasi File `.env`**
  - Atur file `.env` di direktori utama proyek dan sesuaikan konfigurasi database kalian:
  - Atau, bisa ikuti seperti saya ini:
    ```bash
    DB_HOST=localhost
    DB_NAME=hotelreservation 
    DB_USERNAME=root
    DB_PASSWORD=
    ```
### 6. **Instal Dependensi Composer**
  - Buka situs resmi Composer **[klik disini](https://getcomposer.org/download/)** dan unduh installer Composer sesuai OS kalian.
  - Jalankan installer yang sudah diunduh dan ikuti instruksi instalasi. Pada saat instalasi pastikan untuk mencentang opsi untuk menambahkan Composer ke PATH environment variable agar
Composer dapat dijalankan dari command line.
![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/10204908-942b-4bf0-bbeb-94bdd74b43d6)
  - Setelah instalasi selesai, buka terminal baru dan jalankan perintah berikut untuk memverifikasi instalasi:
    ```bash
    composer --version
    ```

### 7. **Instal PHPUnit untuk Unit Testing**
  - Setelah Composer terinstal, kalian bisa menjalankan perintah untuk menginstal PHPUnit diterminal proyeknya:
    ```bash
    composer require --dev phpunit/phpunit
    ```
    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/4eccbb48-090b-4476-8cab-93e7b8592611)
    *Catatan:* 
      - Jika versi PHP di platform kalian tidak memenuhi syarat minimum untuk versi PHPUnit terbaru, kalian bisa menginstal versi PHPUnit yang kompatibel dengan versi PHP kalian. 

      - Jika kalian menjalankan perintah `composer require --dev phpunit/phpunit` dan tetap mendapat peringatan bahwa versi PHP tidak memenuhi syarat untuk PHPUnit terbaru, Composer akan secara otomatis menginstal versi PHPUnit yang kompatibel dengan PHP kalian.

      - Jika memungkinkan, perbarui PHP kalian ke versi terbaru untuk mendapatkan kompatibilitas dengan PHPUnit versi terbaru.

  - Untuk memastikan apakah PHPUnit kalian sudah terinstall bisa ketikan perintah:
      ```bash
      vendor/bin/phpunit --version
      ```
  - Setelah menjalankan perintah untuk menginstal PHPUnit, struktur direktori proyeknya bertambah seperti berikut ini:

    ![PHPUnit](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/11b15d07-8476-4800-b90a-e7a1bbc0810e)

  Ini menunjukkan bahwa PHPUnit dan dependensinya telah terinstal dengan benar dalam proyek.

### 8. **Instal Postman untuk Uji API**
  -  Unduh Postman dari situs resminya **[klik disini](https://www.postman.com/downloads/)**
## 📁 Struktur Proyek
```bash
hotel-reservation-backend/
│
├── config/ 
│   ├── database.php
│   └── table.php
│
├── controllers/ 
│   ├── CustomersController.php
│   ├── ReservationsController.php
│   └── RoomsController.php
│
├── middleware/ 
│   └── Router.php
│
├── models/ 
│   ├── CustomersModel.php
│   ├── ReservationsModel.php
│   └── RoomsModel.php
│
├── services/ 
│   ├── CustomersService.php
│   ├── ReservationsService.php
│   └── RoomsService.php
│
├── tests/ 
│   ├── controllers/
│   │   ├── CustomersControllerTest.php
│   │   ├── ReservationsControllerTest.php
│   │   └── RoomsControllerTest.php
│   ├── models/
│   │   ├── CustomersModelTest.php
│   │   ├── ReservationsModelTest.php
│   │   └── RoomsModelTest.php
│   └── services/
│       ├── CustomersServiceTest.php
│       ├── ReservationsServiceTest.php
│       └── RoomsServiceTest.php
│
├── .env 
├── .htaccess 
├── app.php 
├── db_hotelreservation.sql 
├── LICENSE 
└── README.md 
```
## Struktur Tambahan yang Dibuat oleh Composer
```bash
├── vendor/
│   ├── bin/
│   ├── composer/
│   ├── myclabs/
│   ├── nikic/
│   ├── phar-io/
│   ├── phpunit/
│   ├── sebastian/
│   └── theseer/
│   └── autoload.php 
│
├── composer.json 
├── composer.lock 
```
### Penjelasan

### config/ 
- **database.php**: Berisi kelas `Database`, yang mengelola koneksi ke database dan membaca konfigurasi database dari file `.env`.
- **table.php**: Menyediakan pemetaan nama tabel untuk tabel-tabel yang digunakan dalam aplikasi.

### controllers/ 
- **CustomersController.php**: Menangani operasi terkait pelanggan seperti membaca, menambah, memperbarui, dan menghapus pelanggan.
- **ReservationsController.php**: Mengelola operasi terkait reservasi termasuk memeriksa status kamar, membaca, menambah, memperbarui, dan menghapus reservasi.
- **RoomsController.php**: Bertanggung jawab untuk operasi terkait kamar seperti membaca, menambah, memperbarui, dan menghapus kamar.

### middleware/ 
- **Router.php**: Menerapkan mekanisme routing sederhana untuk memetakan permintaan HTTP ke tindakan controller yang sesuai.

### models/ 
- **CustomersModel.php**: Berinteraksi dengan tabel pelanggan di database.
- **ReservationsModel.php**: Berinteraksi dengan tabel reservasi di database.
- **RoomsModel.php**: Berinteraksi dengan tabel kamar di database.

### services/ 
- **CustomersService.php**: Berisi logika bisnis untuk mengelola pelanggan.
- **ReservationsService.php**: Berisi logika bisnis untuk mengelola reservasi.
- **RoomsService.php**: Berisi logika bisnis untuk mengelola kamar.

### vendor/
- **bin/**: Berisi skrip-skrip yang dapat dieksekusi, biasanya dari dependensi.
- **composer/**: Berisi file-file yang diperlukan oleh Composer untuk mengelola dependensi.
- **myclabs/, nikic/, phar-io/, phpunit/, sebastian/, theseer/**: Direktori yang berisi berbagai dependensi proyek.
- **autoload.php**: File yang dihasilkan oleh Composer untuk autoloading kelas-kelas dari dependensi.

### tests/ 

#### controllers/
- **CustomersControllerTest.php**: Pengujian untuk `CustomersController`.
- **ReservationsControllerTest.php**: Pengujian untuk `ReservationsController`.
- **RoomsControllerTest.php**: Pengujian untuk `RoomsController`.

#### models/
- **CustomersModelTest.php**: Pengujian untuk `CustomersModel`.
- **ReservationsModelTest.php**: Pengujian untuk `ReservationsModel`.
- **RoomsModelTest.php**: Pengujian untuk `RoomsModel`.

#### services/
- **CustomersServiceTest.php**: Pengujian untuk `CustomersService`.
- **ReservationsServiceTest.php**: Pengujian untuk `ReservationsService`.
- **RoomsServiceTest.php**: Pengujian untuk `RoomsService`.

### File-File Utama 📑

- **.env**: File konfigurasi lingkungan yang berisi informasi sensitif seperti kredensial database.
- **.htaccess**: File konfigurasi Apache untuk pengaturan URL rewriting dan keamanan.
- **app.php**: Titik masuk utama untuk aplikasi.
- **composer.json**: Berisi konfigurasi untuk Composer, termasuk daftar dependensi proyek.
- **composer.lock**: Mengunci versi spesifik dari setiap dependensi yang digunakan.
- **db_hotelreservation.sql 🗄️**: File SQL untuk mengatur skema database.
- **LICENSE**: File lisensi untuk proyek ini.
- **README.md**: File readme yang berisi informasi tentang proyek ini.

## 🛠️ Cara Penggunaan

# **Uji API menggunakan Postman:**
Jika ingin alternatifnya, saya sudah menyiapkan file koleksi untuk uji Postmannya. [**klik disini**](https://drive.google.com/file/d/1RlzDRu3lMzFrXQfpfzMZBwJwEqcB2_P7/view?usp=sharing) *(impor ke Postman)*

  ### 1. Customer/Pelanggan
  - **Get All Customers**
    - URL: http://localhost/hotel-reservation-backend/api/customers
    - Method: GET
    - Description: Mengambil semua data pelanggan.

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/1a28b40b-d4db-4a08-88ee-d83c389234b9)

  - **Add Customer**
    - URL: http://localhost/hotel-reservation-backend/api/customers
    - Method: POST
    - Description: Menambahkan data pelanggan baru.
    - Body:
      ```bash
      {
        "name" : "Arka Adiana",
        "email" : "arkaadiana@gmail.com",
        "phone_number" : "0837743743483"
      }
      ```

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/0a87d072-4c20-4999-a161-e75b1028dff1)

  - **Update Customer**
    - URL: http://localhost/hotel-reservation-backend/api/customers
    - Method: PUT
    - Description: Memperbarui data pelanggan.
    - Body:
      ```bash
      {
          "customer_id": "1",
          "name": "Ketut Garing",
          "email": "ketutgaring@gmail.com",
          "phone_number": "0822334637437"
      }
      ```

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/effe4a93-08af-47c1-80a5-caa6b3a4b8ac)

  - **Delete Customer**
    - URL: http://localhost/hotel-reservation-backend/api/customers
    - Method: DELETE
    - Description: Menghapus data pelanggan.
    - Body:
      ```bash
      {
          "customer_id": "4",
      }
      ```

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/3acf67ff-fe37-4363-b149-bed8ed5300d3)

  ### 2. Room/Kamar
  - **Get All Rooms**
    - URL: http://localhost/hotel-reservation-backend/api/rooms
    - Method: GET
    - Description: Mengambil semua data kamar.

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/ceb9c717-574e-44d0-a064-4e3d19f7f0e2)

  - **Add Room**
    - URL: http://localhost/hotel-reservation-backend/api/rooms
    - Method: POST
    - Description: Menambahkan data kamar baru.
    - Body:
      ```bash
      {
          "room_type" : "Double",
          "price" : "80.00"
      }
      ```

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/2c05e97f-2ac6-45e3-bc66-17742bf98b96)

  - **Update Room**
    - URL: http://localhost/hotel-reservation-backend/api/rooms
    - Method: PUT
    - Description: Memperbarui data kamar.
    - Body:
      ```bash
      {
          "room_id" : "6",
          "room_type" : "Suite",
          "price" : "220.00"
      }
      ```

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/64fe546e-4539-41e7-aa19-f0d53d586423)

  - **Delete Room**
    - URL: http://localhost/hotel-reservation-backend/api/rooms
    - Method: DELETE
    - Description: Menghapus data kamar.
    - Body:
      ```bash
      {
          "room_id" : "5"
      }
      ```

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/2aa6b06f-38c2-4fa1-b358-2e73ffbf72e9)

  ### 3. Reservation/Reservasi
  - **Check Room Status**
    - URL: http://localhost/hotel-reservation-backend/api/reservations/room-status?room_id=2&check_in_date=2024-06-10 15:00:00&check_out_date=2024-06-15 12:00:00
    - Method: GET
    - Description: Memeriksa status ketersediaan kamar di reservasi.
    - Parameters:
      ```bash
      room_id: 2
      check_in_date: 2024-06-10 15:00:00
      check_out_date: 2024-06-15 12:00:00
      ```

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/acedd81a-98ad-494a-8ced-0e4cb84c8ac4)

  - **Get All Reservations**
    - URL: http://localhost/hotel-reservation-backend/api/reservations
    - Method: GET
    - Description: Mengambil semua data reservasi.

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/0ef87eeb-271c-4e01-b364-750e07c55ce5)

  - **Add Reservation**
    - URL: http://localhost/hotel-reservation-backend/api/reservations
    - Method: POST
    - Description: Menambahkan data reservasi baru.
    - Body:
      ```bash
      {
          "customer_id" : "6",
          "room_id" : "4",
          "check_in_datetime" : "2024-06-07 14:00:00",
          "check_out_datetime" : "2024-06-10 12:00:00",
          "total_price" : "210.00"
      }
      ```

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/f5c824db-2198-43a1-9a7e-efb8f5d61b6a)

  - **Update Reservation**
    - URL: http://localhost/hotel-reservation-backend/api/reservations
    - Method: PUT
    - Description: Memperbarui data reservation.
    - Body:
      ```bash
      {
          "reservation_id": "3",
          "customer_id": "3",
          "room_id": "3",
          "check_in_datetime": "2024-06-22 16:00:00",
          "check_out_datetime": "2024-06-28 10:00:00",
          "total_price": "900.00"
      }
      ```

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/af791d6d-ad32-4058-889b-dd21b2e1d911)

  - **Delete Reservation**
    - URL: http://localhost/hotel-reservation-backend/api/reservations
    - Method: DELETE
    - Description: Menghapus data reservation.
    - Body:
      ```bash
      {
          "reservation_id" : "3"
      }
      ```

    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/3c13a586-63cb-4de0-8f12-97f412fad9e0)

# **Unit Test menggunakan PHPUnit:**

  ### 1. Model
  - **CustomersModelTest.php**
    ```bash
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/models/CustomersModelTest.php
    ```
    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/e2c29fa3-ed64-4594-94e4-bac9fa45aaf5)

    - **testIsCustomerIdExists:** Menguji apakah metode isCustomerIdExists mengembalikan nilai benar jika ID pelanggan ada dalam database.
    - **testReadAllCustomers:** Memastikan metode readAllCustomers mengembalikan objek PDOStatement yang valid.
    - **testInsertCustomers:** Menyimulasikan penambahan data pelanggan baru dan memverifikasi keberhasilannya.
    - **testInsertCustomersDuplicateEmail:** Memeriksa penanganan kesalahan jika terdapat email pelanggan yang duplikat saat penyisipan.
    - **testInsertCustomersDuplicatePhoneNumber:** Menyimulasikan penanganan kesalahan jika terdapat nomor telepon pelanggan yang duplikat saat penyisipan.
    - **testUpdateCustomers:** Menguji apakah metode updateCustomers berhasil mengupdate data pelanggan.
    - **testUpdateCustomersDuplicateEmail:** Memeriksa penanganan kesalahan jika terdapat email yang duplikat saat mengupdate data pelanggan.
    - **testUpdateCustomersDuplicatePhoneNumber:** Menyimulasikan penanganan kesalahan jika terdapat nomor telepon yang duplikat saat mengupdate data pelanggan.
    - **testRemoveCustomers:** Menguji apakah metode removeCustomers berhasil menghapus data pelanggan.
    - **testRemoveCustomersForeignKeyConstraint:** Memastikan penanganan kesalahan jika ada upaya untuk menghapus pelanggan yang masih memiliki hubungan terkait (foreign key constraint).

  - **ReservationsModelTest.php**
    ```bash
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/models/ReservationsModelTest.php
    ```
    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/cbeeb07a-0bfa-4b99-8dc9-0fe320683c82)

    - **testIsReservationIdExists:** Menguji apakah metode isReservationIdExists mengembalikan nilai benar jika ID reservasi ada dalam database.
    - **testReadAllReservations:** Memastikan metode readAllReservations mengembalikan objek PDOStatement yang valid.
    - **testIsRoomBooked:** Memeriksa apakah metode isRoomBooked mengembalikan nilai benar jika kamar sudah dipesan pada rentang waktu tertentu.
    - **testInsertReservations:** Menyimulasikan penambahan data reservasi baru dan memverifikasi keberhasilannya.
    - **testUpdateReservations:** Menguji apakah metode updateReservations berhasil mengupdate data reservasi.
    - **testRemoveReservations:** Memastikan bahwa metode removeReservations berhasil menghapus data reservasi.

  - **RoomsModelTest.php**
    ```bash
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/models/RoomsModelTest.php
    ```
    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/a953eea0-2621-4f97-9abd-7cf3b52a9b99)

    - **testIsRoomIdExists:** Menguji apakah metode isRoomIdExists mengembalikan nilai benar jika ID kamar ada dalam database.
    - **testReadAllRooms:** Memastikan metode readAllRooms mengembalikan objek PDOStatement yang valid.
    - **testInsertRooms:** Menyimulasikan penambahan data kamar baru dan memverifikasi keberhasilannya.
    - **testUpdateRooms:** Menguji apakah metode updateRooms berhasil mengupdate data kamar.
    - **testRemoveRooms:** Memastikan bahwa metode removeRooms berhasil menghapus data kamar.
    - **testRemoveRoomsForeignKeyConstraint:** Memeriksa penanganan kesalahan jika ada upaya untuk menghapus kamar yang masih memiliki hubungan terkait (foreign key constraint).

  ### 2. Service
  - **CustomersServiceTest.php**
    ```bash
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/services/CustomersServiceTest.php
    ```
    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/a2951a1c-d55c-4f19-99b7-62478d14e9cb)

    - **testFetchAllCustomers:** Memastikan metode fetchAllCustomers mengembalikan daftar pelanggan yang benar.
    - **testAddCustomers:** Menyimulasikan penambahan pelanggan baru dan memverifikasi keberhasilannya.
    - **testUpdateCustomers:** Menguji apakah metode updateCustomers berhasil mengupdate data pelanggan jika ID pelanggan ada dalam database.
    - **testUpdateCustomersNotFound:** Memastikan metode updateCustomers mengembalikan pesan "Customer not found." jika ID pelanggan tidak ada dalam database.
    - **testDeleteCustomers:** Menguji apakah metode deleteCustomers berhasil menghapus data pelanggan jika ID pelanggan ada dalam database.
    - **testDeleteCustomersNotFound:** Memastikan metode deleteCustomers mengembalikan pesan "Customer not found." jika ID pelanggan tidak ada dalam database.

  - **ReservationsServiceTest.php**
    ```bash
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/services/ReservationsServiceTest.php
    ```
    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/79656efe-5831-47f3-9d21-a95623e703d4)

    - **testGetRoomStatusBooked:** Menguji fungsi untuk mendapatkan status kamar jika kamar sudah dipesan pada rentang waktu tertentu.
    - **testGetRoomStatusAvailable:** Menguji fungsi untuk mendapatkan status kamar jika kamar tersedia pada rentang waktu tertentu.
    - **testFetchAllReservations:** Menguji fungsi untuk mengambil semua data reservasi yang ada.
    - **testAddReservationsCustomerNotFound:** Menguji fungsi untuk menambahkan reservasi namun gagal karena tidak menemukan data customer.
    - **testAddReservationsRoomNotFound:** Menguji fungsi untuk menambahkan reservasi namun gagal karena tidak menemukan data kamar.
    - **testAddReservationsRoomBooked:** Menguji fungsi untuk menambahkan reservasi namun gagal karena kamar sudah dipesan pada rentang waktu tertentu.
    - **testAddReservationsSuccess:** Menguji fungsi untuk menambahkan reservasi dengan sukses.
    - **testUpdateReservationNotFound:** Menguji fungsi untuk memperbarui reservasi namun gagal karena reservasi tidak ditemukan.
    - **testUpdateReservationCustomerNotFound:** Menguji fungsi untuk memperbarui reservasi namun gagal karena tidak menemukan data customer.
    - **testUpdateReservationRoomNotFound:** Menguji fungsi untuk memperbarui reservasi namun gagal karena tidak menemukan data kamar.
    - **testUpdateReservationRoomBooked:** Menguji fungsi untuk memperbarui reservasi namun gagal karena kamar sudah dipesan pada rentang waktu tertentu.
    - **testUpdateReservationSuccess:** Menguji fungsi untuk memperbarui reservasi dengan sukses.
    - **testDeleteReservationsNotFound:** Menguji fungsi untuk menghapus reservasi namun gagal karena reservasi tidak ditemukan.
    - **testDeleteReservationsSuccess:** Menguji fungsi untuk menghapus reservasi dengan sukses.

  - **RoomsServiceTest.php**
    ```bash
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/services/RoomsServiceTest.php
    ```
    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/a650ea3d-9887-4f33-b06f-0e82ecb0f19d)

    - **testFetchAllRooms:** Memastikan metode fetchAllRooms mengembalikan daftar kamar yang benar.
    - **testAddRooms:** Menyimulasikan penambahan kamar baru dan memverifikasi keberhasilannya.
    - **testUpdateRooms:** Menguji apakah metode updateRooms berhasil mengupdate data kamar jika ID kamar ada dalam database.
    - **testUpdateRoomsNotFound:** Memastikan metode updateRooms mengembalikan pesan "Room not found." jika ID kamar tidak ada dalam database.
    - **testDeleteRooms:** Menguji apakah metode deleteRooms berhasil menghapus data kamar jika ID kamar ada dalam database.
    - **testDeleteRoomsNotFound:** Memastikan metode deleteRooms mengembalikan pesan "Room not found." jika ID kamar tidak ada dalam database.

  ### 3. Controller
  - **CustomersControllerTest.php**
    ```bash
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/controllers/CustomersControllerTest.php
    ```
    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/b617723f-c847-4087-8de3-b68f6a2959d1)

    - **testReadCustomers:** Memastikan metode readCustomers mengembalikan daftar pelanggan yang benar dalam format JSON.

  - **ReservationsControllerTest.php**
    ```bash
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/controllers/ReservationsControllerTest.php
    ```
    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/85a580e0-cbb3-42fd-82a6-8db05c9e4f37)

    - **testReadReservations:** Memastikan metode readReservations mengembalikan daftar reservasi yang benar dalam format JSON.

  - **RoomsControllerTest.php**
    ```bash
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/controllers/RoomsControllerTest.php
    ```
    ![image](https://github.com/arkaadiana/hotel-reservation-backend/assets/144679258/554f4300-d682-4361-b690-d7caa7062f44)

    - **testReadRooms:** Memastikan metode readRooms mengembalikan daftar kamar yang benar dalam format JSON.

## 💭 Refleksi Diri Terhadap Proyek Sistem Manajemen Reservasi Hotel
### Tantangan dan Kesulitan
1. **Unit Testing dan Integrasi**

   - **Tantangan:** Membuat dan menjalankan unit testing untuk memastikan setiap komponen sistem bekerja dengan baik dan saling terintegrasi. Kesulitan terutama muncul saat membuat unit test untuk kode yang menggunakan input dari php://input pada controller.
    - **Cara Mengatasi:** Menggunakan library PHPUnit untuk menulis dan menjalankan unit tests pada model, service, dan controller. Namun, untuk kode yang menggunakan php://input, saya masih belum sepenuhnya berhasil membuat unit test yang efektif. Saat ini, saya sedang mencari solusi terbaik dan mungkin akan membutuhkan bantuan dari komunitas atau mentor untuk mengatasi kendala ini.

2. **Manajemen Database**

    - **Tantangan:** Merancang database yang efisien dan memastikan integritas data.
    - **Cara Mengatasi:** Membuat Entity-Relationship Diagram (ERD) untuk memvisualisasikan hubungan antara entitas seperti pelanggan, kamar, dan reservasi. 

3. **Struktur Proyek dan Penggunaan Git**

    - **Tantangan:** Belum terbiasa membuat proyek yang terstruktur rapi dan mengimplementasikan sistem kontrol versi menggunakan Git.
    - **Cara Mengatasi:** Mempelajari best practices dalam penyusunan struktur proyek yang baik, termasuk pemisahan kode berdasarkan fungsinya (controller, model, service). Menggunakan Git untuk version control, dengan memanfaatkan branch untuk fitur yang berbeda dan melakukan commit secara teratur dengan pesan yang jelas. 

### Pelajaran yang Dipetik
 1. **Workflow yang Terstruktur:** Saya jadi merubah kebiasaan saya yang sebelumnya workflow saya tidak jelas jadi lebih terstruktur dan ada tujuannya.
 2. **Struktur Proyek:** Saya jadi terbiasa membuat proyek yang terstruktur rapi dan bagaimana cara menerapkan MVC dengan baik.
 3. **Unit Testing:** Saya jadi tahu cara melakukan unit test walaupun saya masih menggunakan library PHPUnit untuk pengujiannya.
 4. **Penggunaan GitHub:** Saya jadi terbiasa menggunakan GitHub untuk version control dan kolaborasi.
 5. **Dokumentasi Proyek:** Saya jadi bisa membuat dokumentasi mengenai proyek ini dengan lebih baik.

### Kesimpulan
Pengembangan sistem manajemen reservasi hotel memberikan pengalaman yang berharga dalam mengelola proyek perangkat lunak yang kompleks. Melalui berbagai tantangan yang saya hadapi dan cara mengatasinya, saya belajar tentang pentingnya perencanaan yang matang, pengujian yang menyeluruh,  dan dokumentasi yang jelas. Proyek ini tidak hanya meningkatkan keterampilan teknis saya, tetapi juga kemampuan dalam menyelesaikan masalah secara efektif.

Terima kasih untuk semuanya, semoga dokumentasi ini dapat menjadi panduan yang berguna bagi pengembang lain yang ingin belajar dan mengembangkan sistem serupa. ***"Arka Adiana"***