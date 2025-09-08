tokogametokogametokogame-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Apr 2025 pada 14.34
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokogame`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(4) NOT NULL,
  `nama_admin` varchar(200) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `foto_admin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`, `foto_admin`) VALUES
(1, 'M. Diki Fahriza', 'admin', 'admin', 'admin.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `game`
--

CREATE TABLE `game` (
  `id_game` int(4) NOT NULL,
  `nama_game` varchar(200) NOT NULL,
  `id_kategori` int(4) NOT NULL,
  `deskripsi` varchar(1000) NOT NULL,
  `harga` varchar(15) NOT NULL,
  `foto_game` varchar(100) NOT NULL,
  `beli` varchar(15) NOT NULL,
  `view` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `game`
--

INSERT INTO `game` (`id_game`, `nama_game`, `id_kategori`, `deskripsi`, `harga`, `foto_game`, `beli`, `view`) VALUES
(1, 'Call of Duty: Warzone 2.0', 1, 'Call of Duty: Warzone 2.0 adalah permainan battle royale yang menghadirkan pengalaman bertempur di medan perang modern dengan grafis realistis dan gameplay dinamis. Pertempuran seru dengan berbagai mode dan taktik yang seru menanti Anda!\r\n\r\nFitur Utama:\r\nMode Battle Royale dengan 150 pemain\r\nGrafis yang realistis dan dunia terbuka yang luas\r\nFitur cross-platform untuk bermain dengan teman-teman di berbagai platform\r\nBanyak senjata dan gadget canggih untuk digunakan', '20000', 'img1.jpg', '10', '28'),
(2, 'Counter-Strike: Global Offensive (CS:GO)', 2, 'Counter-Strike: Global Offensive (CS:GO) adalah salah satu game FPS (First-Person Shooter) yang paling populer di dunia, yang menekankan pada permainan tim dan taktik. Pemain dibagi menjadi dua tim, yaitu teroris dan kontra-teroris, yang bertempur untuk menyelesaikan misi tertentu seperti penanaman bom atau penyelamatan sandera. CS:GO terkenal dengan gameplay yang kompetitif, sistem ekonomi dalam permainan, dan tingkat skill yang tinggi. Dengan berbagai mode permainan, termasuk matchmaking kompetitif dan mode kasual, CS:GO menawarkan pengalaman yang sangat adiktif dan menantang.\r\n\r\nFitur Utama:\r\nGameplay berbasis tim yang intens\r\nBerbagai mode permainan, termasuk kompetitif dan kasual\r\nSistem ekonomi dalam permainan yang mendalam\r\nDukungan untuk esports dengan turnamen global', '50000', 'img2.jpg', '0', '4'),
(3, 'Warframe', 2, 'Warframe adalah game aksi online gratis yang memungkinkan pemain untuk berperan sebagai anggota Tenno, pejuang kuno yang terbangun dari tidur panjang untuk melawan berbagai faksi musuh di seluruh galaksi. Dengan gaya bermain yang cepat dan dinamis, pemain dapat berlari, melompat, dan melakukan aksi keren menggunakan armormu yang disebut Warframe. Warframe menonjol dengan sistem pertempuran yang fluid, berbagai senjata, serta mode permainan kooperatif yang seru. Dengan banyak konten yang diperbarui secara berkala, Warframe selalu menawarkan tantangan baru untuk para pemainnya.', '12000', 'img3.jpg', '0', '0'),
(4, 'Fortnite', 3, 'Fortnite adalah permainan battle royale yang sangat populer dengan elemen bangunan unik. Pemain bertempur untuk menjadi yang terakhir bertahan hidup di sebuah pulau yang semakin menyusut, namun dengan tambahan kemampuan untuk membangun struktur seperti dinding, tangga, dan benteng. Fortnite juga dikenal dengan mode permainan kreatif dan cerita yang terus berkembang, dengan pembaruan reguler yang menambah tantangan dan event baru. Dengan grafis kartun yang ramah dan gameplay yang seru, Fortnite menarik pemain dari berbagai kalangan usia.', '159.000', 'img4.jpg', '1', '6'),
(5, 'Need for Speed (NFS)', 1, 'Need for Speed (NFS) adalah salah satu seri game balapan paling ikonik yang menawarkan pengalaman balapan jalanan dengan mobil-mobil keren dan kecepatan tinggi. Game ini menampilkan aksi balapan penuh ketegangan, serta berbagai mode permainan seperti balapan melawan waktu, pengejaran polisi, dan mode multiplayer. Dengan berbagai mobil yang dapat dikustomisasi, serta trek yang penuh tantangan, NFS selalu memberikan pengalaman balapan yang seru dan mendebarkan. Setiap game dalam seri NFS menawarkan fitur dan grafis yang semakin meningkat, menjadikannya pilihan utama bagi para penggemar balapan.', '12000', 'img5.jpg', '3', '7'),
(15, 'The Witcher 3: Wild Hunt', 2, 'Dalam game ini, pemain menjadi Geralt of Rivia, seorang pemburu monster profesional yang terjebak dalam konflik besar yang melibatkan kerajaan, makhluk mitologi, dan takdirnya sendiri. Pemain dapat menjelajahi dunia terbuka yang luas dengan berbagai quest menarik, berinteraksi dengan karakter yang memiliki kepribadian mendalam, dan menghadapi keputusan moral sulit yang berdampak pada cerita. Kombinasi sistem pertarungan yang kompleks dan elemen RPG menjadikan game ini salah satu yang terbaik di zamannya.', '300000', '6791472113ce8_the-witcher-3-wild-hunt-nextgen.png', '1', '1'),
(16, 'Elden Ring', 3, 'Sebagai penerus spiritual dari seri Dark Souls, Elden Ring menawarkan dunia terbuka yang luas dengan berbagai lokasi menarik untuk dijelajahi, dari kastil megah hingga reruntuhan kuno. Pemain harus menghadapi musuh-musuh yang tangguh dengan gaya bertarung yang memerlukan keterampilan dan strategi. Narasi mendalam yang ditulis oleh George R.R. Martin memberikan dimensi baru pada mitologi game ini, menciptakan pengalaman yang imersif dan epik.', '800000', '67914777c11fe_images.jpeg', '1', '1'),
(17, 'Cyberpunk 2077', 2, 'Cyberpunk 2077 adalah game dunia terbuka futuristik yang berpusat di Night City, kota metropolis yang dipenuhi teknologi canggih dan kriminalitas. Pemain berperan sebagai V, seorang tentara bayaran yang mengejar keabadian melalui teknologi misterius. Game ini menawarkan kebebasan tinggi dalam membangun karakter, memilih jalur cerita, dan mengeksplorasi berbagai aspek kota dengan grafis yang memukau.', '600000', '679147c7c99a9_social-thumbnail-en-ddcf4d23.jpg', '1', '1'),
(18, 'Red Dead Redemption 2', 10, 'Game ini adalah epik barat yang menempatkan pemain dalam peran Arthur Morgan, seorang penjahat di akhir era Wild West. Pemain dapat menikmati dunia terbuka yang hidup dengan detail luar biasa, dari hutan lebat hingga kota kecil. Ceritanya menggambarkan perjuangan moral Arthur dalam memilih kesetiaan pada geng atau jalan hidup yang lebih bermakna.', '700000', '6791484182b27_images (1).jpeg', '0', '1'),
(19, 'Grand Theft Auto V', 2, 'GTA V adalah game dunia terbuka yang menawarkan tiga protagonis dengan latar cerita unik: Michael, seorang mantan pencuri; Franklin, seorang pemuda yang bercita-cita tinggi; dan Trevor, seorang maniak dengan misi pribadinya. Pemain dapat beralih antara ketiganya untuk melakukan misi yang penuh aksi, humor gelap, dan eksplorasi kota Los Santos yang penuh dengan aktivitas.', '300000', '6791489226677_gta-v-130923c.jpg', '0', '0'),
(20, 'Minecraft', 11, 'Minecraft memungkinkan pemain untuk mengeksplorasi, membangun, dan bertahan hidup di dunia blok yang tidak terbatas. Dengan mode kreatif dan survival, pemain dapat mengasah kreativitas mereka dengan membangun struktur megah atau menghadapi berbagai tantangan untuk bertahan hidup. Game ini sangat populer berkat komunitas yang aktif, modifikasi, dan kebebasan tanpa batas yang ditawarkannya.', '400000', '6791494c8815b_maxresdefault.jpg', '1', '4'),
(21, 'dadadad', 1, '0', '212', '67914f4da8d9a_gta-v-130923c.jpg', '1', '3'),
(22, 'sas', 1, '0', '11', '67914ff516b79_gta-v-130923c.jpg', '', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(4) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Racing'),
(2, 'Action'),
(3, 'Role Playing Game'),
(5, 'MultiPlayer'),
(6, 'Fighting'),
(7, 'First Person Shooter'),
(8, 'Third Person Shooter'),
(9, 'Real Time Strategy'),
(10, 'Adventure'),
(11, 'Simulasi'),
(12, 'Sport');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id_game`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `game`
--
ALTER TABLE `game`
  MODIFY `id_game` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
