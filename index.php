<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Instruksi Kerja Nomor 1 CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <title>Hitung Biaya Parkir Mall</title>
</head>
<body>
    <div class="container border">        
        <!-- Instruksi Kerja Nomor 2. -->
        <!-- Menampilkan logo Mall -->
        <h2 class="mt-4"><img src="img/logo.png" width="40" height="40" class="mb-4"> Hitung Biaya Parkir Mall</h2>
        <br>
        <form action="index.php" method="post" id="formPerhitungan">
            <div class="row">
                <!-- Masukan data plat nomor kendaraan. Tipe data text. -->
                <div class="col-lg-2"><label for="nama">Plat Nomor Kendaraan:</label></div>
                <div class="col-lg-2"><input type="text" id="plat" name="plat"></div>
            </div>

            <div class="row">
                <!-- Masukan pilihan jenis kendaraan. -->
                <div class="col-lg-2"><label for="tipe">Jenis Kendaraan:</label></div>
                <div class="col-lg-2">
                    <!-- Instruksi Kerja Nomor 3, 4, dan 5 -->
                    <?php 
					// Membuat data jenis kendaraan dalam bentuk array
                    $jenis_kendaraan = [
                        "Truk", "Motor", "Mobil"
                    ];                    
                    // Menyortir data array secara ascending berdasarkan nilai dengan fugsi asort
                    asort($jenis_kendaraan);

					// Membuat perulangan foreach jenis kendaraan dengan tipe input radio button
                    foreach ($jenis_kendaraan as $jenis) {
                        echo '<input type="radio" name="kendaraan" value="'.$jenis.'"> '.$jenis.'<br>';
                    }
                    ?>
                
                </div>
            </div>

            <div class="row">
                <!-- Masukan Jam Masuk Kendaraan -->
                <div class="col-lg-2"><label for="nomor">Jam Masuk [jam]:</label></div>
                <div class="col-lg-2">
                    <select class="form-select"  id="masuk" name="masuk">
                    <option>- Jam Masuk -</option>
                    
                    <!-- Instruksi Kerja Nomor 6 -->
                    <?php
					// Melakukan perulangan for dengan variable i untuk memasukkan jam keluar pada parkir mall
                    for ($i = 1; $i <= 24; $i++) {
                        echo '<option value="'.$i.'">jam '.$i.'</option>';
                    }
                    ?>

                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Masukan Jam Keluar Kendaraan. -->
                <div class="col-lg-2"><label for="nomor">Jam Keluar [jam]:</label></div>
                <div class="col-lg-2">
                    <select class="form-select"  id="keluar" name="keluar">
                    <option>- Jam Keluar -</option>
                    
                    <!-- Instruksi Kerja Nomor 6 -->
                    <?php
					// Melakukan perulangan for dengan variable i untuk memasukkan jam keluar pada parkir mall
                    for ($i = 1; $i <= 24; $i++) {
                        echo '<option value="'.$i.'">jam '.$i.'</option>';
                    }
                    ?>

                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Masukan pilihan Member. -->
                <div class="col-lg-2"><label for="tipe">Keanggotaan:</label></div>
                <div class="col-lg-2" style="margin-left:20px;">
                    <input type='radio' class="form-check-input" name='member' value='Member'> Member <br>
                    <input type='radio' class="form-check-input" name='member' value='Non-Member'> Non Member <br>
                </div>
            </div>

            <div class="row">
                <!-- Tombol Submit -->
                <div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formPerhitungan" value="hitung" name="hitung">Hitung</button></div>
                <div class="col-lg-2"></div>        
            </div>
        </form>
    </div>

    <?php

    if(isset($_POST['hitung'])) {
        // Instruksi Kerja Nomor 7 (hitung durasi)
        $jam_masuk = $_POST['masuk'];
        $jam_keluar = $_POST['keluar'];
        $durasi = $jam_keluar - $jam_masuk;

        // Instruksi Kerja Nomor 8 (fungsi)
        function hitung_parkir($durasi, $kendaraan){
            // Instruksi Kerja Nomor 9 (kontrol percabangan)
			// Membuat variable biaya dengan nilai 0 dengan maksud biaya itu dimulai dari angka 0
            $biaya = 0;
			// Pengkondisian untuk memilih jenis kendaraan sesuai harga dan durasi parkir yang ada di mall
            if ($kendaraan == 'Mobil') {
                $biaya = 5000 + ($durasi - 1) * 3000;
            } elseif ($kendaraan == 'Motor') {
                $biaya = 2000 + ($durasi - 1) * 1000;
            } elseif ($kendaraan == 'Truk') {
                $biaya = 6000 * $durasi;
            }

            // Tuliskan baris komentar untuk menjelaskan fungsi tersebut
            return $biaya;
        }

        // Instruksi Kerja Nomor 10 ($biaya_parkir)
        $biaya_parkir = hitung_parkir($durasi, $_POST['kendaraan']);

	        // Instruksi Kerja Nomor 11 (hitung diskon dan simpan hasil akhir setelah diskon pada variabel $biaya_akhir)
        $biaya_akhir = $biaya_parkir;
		// Jika member memiliki kartu member maka mendapat diskon sebesar 10% dan disini terdapat perhitungan diskon dengan metode if
        if ($_POST['member'] == 'Member') {
            $diskon = 0.1;
            $biaya_akhir = $biaya_parkir * (1 - $diskon);
        }

        $dataParkir = array(
            'plat' => $_POST['plat'],
            'kendaraan' => $_POST['kendaraan'],
            'masuk' => $_POST['masuk'],
            'keluar' => $_POST['keluar'],
            'durasi' => $durasi,
            'member' => $_POST['member'],
            'biaya_parkir' => $biaya_parkir,
            'biaya_akhir' => $biaya_akhir,
        );

        // Instruksi Kerja Nomor 12 (menyimpan ke json)

		// Memanggil data json
        $berkas = "data/data.json";
		// Encode data json dengan JSON_PRETTY_PRINT agar pada saat menyimpan ke dalam data json menjadi rapih
        $dataJson = json_encode($dataParkir, JSON_PRETTY_PRINT);
		// Menginput data dari php ke dalam json
        file_put_contents($berkas, $dataJson);
		// Memanggil isi yang ada di dalam data json pada variable berkas
        $dataJson = file_get_contents($berkas);
		// Decode data atau mengembalikan ke dalam nilai json
        $dataParkir = json_decode($dataJson, true);

        //	Menampilkan data parkir kendaraan.
        //  KODE DI BAWAH INI TIDAK PERLU DIMODIFIKASI!!!
        echo "
        <br/>
        <div class='container'>
        <div class='row'>
        <!-- Menampilkan Plat Nomor Kendaraan. -->
        <div class='col-lg-2'>Plat Nomor Kendaraan:</div>
        <div class='col-lg-2'>".$dataParkir['plat']."</div>
        </div>
        <div class='row'>
        <!-- Menampilkan Jenis Kendaraan. -->
        <div class='col-lg-2'>Jenis Kendaraan:</div>
        <div class='col-lg-2'>".$dataParkir['kendaraan']."</div>
        </div>
        <div class='row'>
        <!-- Menampilkan Durasi Parkir. -->
        <div class='col-lg-2'>Tempo Parkir:</div>
        <div class='col-lg-2'>".$dataParkir['durasi']." jam</div>
        </div>
        <div class='row'>
        <!-- Menampilkan Jenis Keanggotaan. -->
        <div class='col-lg-2'>Keanggotaan:</div>
        <div class='col-lg-2'>".$dataParkir['member']." </div>
        </div>
        <div class='row'>
        <!-- Menampilkan Total Biaya Parkir. -->
        <div class='col-lg-2'>Total Biaya Parkir:</div>
        <div class='col-lg-2'>Rp".number_format($biaya_akhir, 0, ".", ".").",-</div>
        </div>

        </div>
        ";
    }
    ?>

</body>
</html>
