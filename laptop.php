
<?php
// Parent Class: Laptop
class Laptop {
    public $merk;
    public $ram;
    public $penyimpanan;

    public function __construct($merk, $ram, $penyimpanan) {
        $this->merk = $merk;
        $this->ram = $ram;
        $this->penyimpanan = $penyimpanan;
    }

    public function getInfoLaptop() {
        return "Merk: {$this->merk}, RAM: {$this->ram}, Penyimpanan: {$this->penyimpanan}";
    }
}

// Child Class: LaptopGaming
class LaptopGaming extends Laptop {
    public $jenisVGA;

    public function __construct($merk, $ram, $penyimpanan, $jenisVGA) {
        parent::__construct($merk, $ram, $penyimpanan);
        $this->jenisVGA = $jenisVGA;
    }

    // Override Method
    public function getInfoLaptop() {
        return parent::getInfoLaptop() .
        ", VGA: {$this->jenisVGA}";
    }
}

// Child Class: LaptopKantor
class LaptopKantor extends Laptop {
    public $jenisProsesor;

    public function __construct($merk, $ram, $penyimpanan, $jenisProsesor) {
        parent::__construct($merk, $ram, $penyimpanan);
        $this->jenisProsesor = $jenisProsesor;
    }

    // Override Method
    public function getInfoLaptop() {
        return parent::getInfoLaptop() .
        ", Prosesor: {$this->jenisProsesor}";
    }
}

// Inisialisasi
$laptop_obj = null;
$jenis_selected = $_POST['jenis'] ?? 'LaptopGaming';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $merk = htmlspecialchars($_POST['merk']);
    $ram = htmlspecialchars($_POST['ram']);
    $penyimpanan = htmlspecialchars($_POST['penyimpanan']);

    if ($jenis_selected === 'LaptopGaming') {

        $vga = htmlspecialchars($_POST['vga']);

        $laptop_obj = new LaptopGaming(
            $merk, $ram, $penyimpanan, $vga
        );

    } elseif ($jenis_selected === 'LaptopKantor') {

        $prosesor = htmlspecialchars($_POST['prosesor']);

        $laptop_obj = new LaptopKantor(
            $merk, $ram, $penyimpanan, $prosesor
        );
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klasifikasi Laptop</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #101827;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            max-width: 900px;
            width: 100%;
        }

        .card {
            background: #1e293b;
            padding: 25px;
            border-radius: 15px;
        }

        h2 {
            color: #60a5fa;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 7px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border-radius: 8px;
            border: none;
            background: #334155;
            color: white;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 20px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .info {
            margin-top: 20px;
            padding: 15px;
            background: #334155;
            border-radius: 8px;
        }

        @media(max-width: 650px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Form Laptop -->
    <div class="card">
        <h2>Klasifikasi Laptop</h2>
        <p>Penerapan OOP Inheritance pada Laptop</p>

        <form method="POST">

            <label>Merk Laptop</label>
            <input type="text" name="merk"
                placeholder="Contoh: ASUS"
                value="<?= htmlspecialchars($_POST['merk'] ?? '') ?>"
                required>

            <label>RAM</label>
            <select name="ram">
                <option value="4 GB">4 GB</option>
                <option value="8 GB">8 GB</option>
                <option value="16 GB">16 GB</option>
                <option value="32 GB">32 GB</option>
            </select>

            <label>Penyimpanan</label>
            <select name="penyimpanan">
                <option value="256 GB SSD">256 GB SSD</option>
                <option value="512 GB SSD">512 GB SSD</option>
                <option value="1 TB SSD">1 TB SSD</option>
                <option value="1 TB HDD">1 TB HDD</option>
            </select>

            <label>Jenis Laptop</label>
            <select name="jenis" id="jenis" onchange="toggleFields()">

                <option value="LaptopGaming"
                    <?= $jenis_selected === 'LaptopGaming' ? 'selected' : '' ?>>
                    Laptop Gaming
                </option>

                <option value="LaptopKantor"
                    <?= $jenis_selected === 'LaptopKantor' ? 'selected' : '' ?>>
                    Laptop Kantor
                </option>

            </select>

            <!-- Input Laptop Gaming -->
            <div id="fields-gaming">

                <label>Jenis VGA</label>
                <select name="vga">
                    <option value="NVIDIA RTX">NVIDIA RTX</option>
                    <option value="NVIDIA GTX">NVIDIA GTX</option>
                    <option value="AMD Radeon">AMD Radeon</option>
                </select>

            </div>

            <!-- Input Laptop Kantor -->
            <div id="fields-kantor">

                <label>Jenis Prosesor</label>
                <select name="prosesor">
                    <option value="Intel Core i3">Intel Core i3</option>
                    <option value="Intel Core i5">Intel Core i5</option>
                    <option value="Intel Core i7">Intel Core i7</option>
                    <option value="AMD Ryzen 5">AMD Ryzen 5</option>
                    <option value="AMD Ryzen 7">AMD Ryzen 7</option>
                </select>

            </div>

            <button type="submit">
                Tampilkan Detail Laptop
            </button>

        </form>
    </div>

    <!-- Detail Laptop -->
    <div class="card">
        <h2>Detail Laptop</h2>

        <?php if ($laptop_obj !== null): ?>

            <div class="info">

                <h3><?= htmlspecialchars(get_class($laptop_obj)) ?></h3>

                <p>Merk:
                    <?= htmlspecialchars($laptop_obj->merk) ?>
                </p>

                <p>RAM:
                    <?= htmlspecialchars($laptop_obj->ram) ?>
                </p>

                <p>Penyimpanan:
                    <?= htmlspecialchars($laptop_obj->penyimpanan) ?>
                </p>

                <?php if ($laptop_obj instanceof LaptopGaming): ?>

                    <p>Jenis VGA:
                        <?= htmlspecialchars($laptop_obj->jenisVGA) ?>
                    </p>

                <?php elseif ($laptop_obj instanceof LaptopKantor): ?>

                    <p>Jenis Prosesor:
                        <?= htmlspecialchars($laptop_obj->jenisProsesor) ?>
                    </p>

                <?php endif; ?>

                <hr>

                <p><b>Info Method:</b></p>

                <p>
                    <?= htmlspecialchars($laptop_obj->getInfoLaptop()) ?>
                </p>

            </div>

        <?php else: ?>

            <h3>💻 Data Laptop Kosong</h3>

            <p>Pilih jenis laptop dan isi form untuk melihat detail laptop.</p>

        <?php endif; ?>

    </div>

</div>

<script>
function toggleFields() {

    let jenis = document.getElementById("jenis").value;

    let gaming = document.getElementById("fields-gaming");
    let kantor = document.getElementById("fields-kantor");

    gaming.style.display =
        jenis === "LaptopGaming" ? "block" : "none";

    kantor.style.display =
        jenis === "LaptopKantor" ? "block" : "none";

    gaming.querySelector("select").disabled =
        jenis !== "LaptopGaming";

    kantor.querySelector("select").disabled =
        jenis !== "LaptopKantor";
}

toggleFields();
</script>

</body>
</html>
