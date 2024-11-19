# SIMPLE REST API CODEIGNITER 3

Simple REST API dengan CodeIgniter 3

1. Membuat database dan import menggunakan phpMyAdmin (http://localhost/phpmyadmin/)

- Buat database baru

  ```
  codeigniter-restserver
  ```

- Klik SQL

```
-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 04, 2019 at 01:36 PM
-- Server version: 5.6.33
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codeigniter-restserver`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nrp` char(9) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `jurusan` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nrp`, `nama`, `email`, `jurusan`) VALUES
(1, '12345678', 'Muhammad Andre Syahli', 'mandresyahliii16@gmail.com', 'Teknik Informatika'),
(2, '23456789', 'Muhammad Dwi A Farel', 'farel@gmail.com', 'Sistem Informasi'),
(3, '34567890', 'Example', 'example@gmail.com', 'Teknik Informatika');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

```

- Klik GO

3. Buat file bernama .htaccess untuk menghilangkan index.php

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

4. Buka file di folder config -> database.php, perhatikan pada bagian hostname, username, password, database samakan dengan komputer Anda masing - masing

```
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'database' => 'codeigniter-restserver',
```

5. Buka file di folder config -> config.php

```
$config['base_url'] = 'http://localhost/simple-rest-api-codeigniter-3/';

$config['index_page'] = '';
```

6. Buka file di folder config -> autoload.php tambahkan

```
$autoload['libraries'] = array('database', 'form_validation);

$autoload['helper'] = array('url');
```

7. Jangan lupa aktifkan web server Anda
8. Jalankan POSTMAN / INSOMNIA buat request (GET POST PUT DELETE)

```
http://localhost/simple-rest-api-codeigniter-3/api/mahasiswa
```
