<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Membuat Barcode Generator Dengan PHP</title>
	<link href="style.css" rel="stylesheet">
</head>

<body>
	<h3>Membuat Barcode Generator Dengan PHP</h3>
	<p>
	<form method="post" action="">
		<fieldset>
			<p>
				<label for="kode">Masukkan Kode Barcode</label>
				<input type="text" name="kode" id="kode" minlength="4" maxlength="20" required value="<?php $val = isset($_POST['generate']) ? $_POST['kode'] : "";
																										echo $val; ?>">
			</p>
			<p>
				<input type="submit" name="generate" id="btn_submit" value="Generate Code">
			</p>
		</fieldset>
	</form>
	</p>
	<p>
		<?php
		if (isset($_POST['generate'])) {
			/*create folder*/
			$tempdir = "img-barcode/";
			if (!file_exists($tempdir))
				mkdir($tempdir, 0755);
			$target_path = $tempdir . $_POST['kode'] . ".png";

			/*using server online
		$protocol=stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
		$fileImage=$protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/php-barcode/barcode.php?text=" . $_POST['kode_barang'] . "&codetype=code128&print=true&size=55";
		*/
			/*using server localhost*/
			$fileImage = "http://localhost" . dirname($_SERVER['PHP_SELF']) . "/barcode.php?text=" . $_POST['kode'] . "&codetype=code128&print=true&size=40";

			/*get content from url*/
			$content = file_get_contents($fileImage);

			/*save file */
			file_put_contents($target_path, $content);

			echo "
		<p class='result'>Result :</p>
		<p><img src='barcode.php?text=" . $_POST['kode'] . "&codetype=code39&print=true&size=40' /></p>
		<p><a href='lat_dua.php?file=$target_path'>Print Image (10 pcs) </a></p>
		";
		}
		?>
</body>

</html>