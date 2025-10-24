<html>
    <head>
        <title>::Data Registrasi::</title>
        <style type="text/css">
            body{
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background-size: cover;
                background-image: url("https://cdn.arstechnica.net/wp-content/uploads/2023/06/bliss-update-1440x960.jpg");
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
                padding: 20px;
            }
            .container{
                background-color: white;
                border: 3px solid grey;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                max-width: 600px;
                width: 100%;
            }
            h1{
                text-align: center;
                color: #333;
                margin-bottom: 30px;
                font-size: 28px;
            }
            .success-message{
                background-color: #d4edda;
                color: #155724;
                padding: 15px;
                margin-bottom: 20px;
                border: 1px solid #c3e6cb;
                border-radius: 5px;
                text-align: center;
                font-weight: bold;
            }
            table{
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td{
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th{
                background-color: #f8f9fa;
                font-weight: bold;
                color: #333;
                width: 30%;
            }
            td{
                color: #666;
            }
            .back-button{
                text-align: center;
                margin-top: 20px;
            }
            .back-button a{
                background-color: #007bff;
                color: white;
                padding: 12px 24px;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
                transition: background-color 0.3s;
            }
            .back-button a:hover{
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <?php 
            session_start();

            // Initialize registrations array in session
            if (!isset($_SESSION['registrations'])) {
                $_SESSION['registrations'] = [];
            }

            // Helper to sanitize strings for output
            function e($s) {
                return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
            }

            // Handle clear action
            if (isset($_POST['action']) && $_POST['action'] === 'clear') {
                $_SESSION['registrations'] = [];
            }

            // Handle form submission
            if (isset($_POST['submit'])) {
                $namaDepan = trim($_POST['namaDepan'] ?? '');
                $namaBelakang = trim($_POST['namaBelakang'] ?? '');
                $asalKota = trim($_POST['asalKota'] ?? '');
                $umur = trim($_POST['umur'] ?? '');

                // Basic validation: all fields present
                if ($namaDepan !== '' && $namaBelakang !== '' && $asalKota !== '' && $umur !== '') {
                    // Age validation: must be numeric and >= 10
                    if (!is_numeric($umur) || intval($umur) < 10) {
                        $success = false;
                        $ageError = true; // flag to show specific age error message
                    } else {
                        // Save registration (valid)
                        $_SESSION['registrations'][] = [
                            'namaDepan' => $namaDepan,
                            'namaBelakang' => $namaBelakang,
                            'asalKota' => $asalKota,
                            'umur' => $umur,
                        ];
                        $success = true;
                    }
                } else {
                    $success = false;
                    $missingData = true;
                }
            }
        ?>
        <div class="container">
            <h1>Data Registrasi User</h1>
            
            <?php if (isset($success) && $success): ?>
                <div class="success-message">Registrasi Berhasil!</div>
            <?php elseif (isset($success) && !$success): ?>
                <div style="text-align: center; color: #dc3545; padding: 20px;">
                    <h3>ummur kurang dari 10</h3>
                    <p>hanya boleh 10 keatas.</p>
                </div>
            <?php endif; ?>

            <!-- Table of registrations -->
            <?php if (!empty($_SESSION['registrations'])): ?>
                <table>
                    <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Umur</th>
                                <th>Asal Kota</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['registrations'] as $i => $r): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= e(($r['namaDepan'] ?? '') . ' ' . ($r['namaBelakang'] ?? '')) ?></td>
                                <td><?= e(($r['umur'] ?? '') . ' tahun') ?></td>
                                <td><?= e($r['asalKota']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="text-align: center; margin-top: 10px;">
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="action" value="clear">
                        <button type="submit" style="background:#dc3545;color:#fff;padding:8px 12px;border:none;border-radius:4px;">Clear All</button>
                    </form>
                </div>
            <?php else: ?>
                <div style="text-align: center; color: #777; padding: 20px;">
                    <h3>Belum ada registrasi</h3>
                    <p>Isi form registrasi untuk menambahkan data.</p>
                </div>
            <?php endif; ?>

            <div class="back-button">
                <a href="index.html">Kembali ke Form Registrasi</a>
            </div>
        </div>
        <?php 
            session_destroy();
        ?>
    </body>
</html>