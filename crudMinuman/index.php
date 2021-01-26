<?php session_start(); ?>
<html>
<head>
	<title>Homepage</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="header">
		Welcome!
	</div>
	<?php
	if(isset($_SESSION['valid'])) {			
		include("koneksi.php");					
		$result = mysqli_query($mysqli, "SELECT * FROM login");
	?>
				
		Welcome <?php echo $_SESSION['name'] ?> ! <a href='logout.php'>Logout</a><br/>
		<br/>
		<?php if($_SESSION['role'] == 1) { ?>
			<a href='view.php'>Lihat dan tambah produk</a>
			<br/>
			<a href='transaksi.php'>Transaksi</a>
			<br/>
			
		<?php }else{ ?>
			<a href='view.php'> Produk</a>
			<br/>
			<a href='transaksi.php'>Transaksi</a>
		<?php } ?>
		<br/><br/>
	<?php	
	} else {
		echo "Harap login dahulu<br/><br/>";
		echo "<a href='login.php'>Login</a>";
	}
	?>
	<div id="footer">
		
	</div>
</body>
</html>
