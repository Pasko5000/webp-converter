<!DOCTYPE html>
<html>
<head>
	<title>Konwerter obrazów do WebP</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f5f5f5;
		}

		.container {
			margin: 50px auto;
			padding: 20px;
			max-width: 600px;
			background-color: #fff;
			border-radius: 5px;
			box-shadow: 0 0 10px rgba(0,0,0,0.2);
		}

		h1 {
			text-align: center;
			margin-bottom: 30px;
			color: #444;
		}

		form {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

        .icon {
			display: block;
			margin: 0 auto;
			max-width: 100%;
			height: auto;
			width: 100%;
			margin-top: 20px;
		}

		input[type=file] {
			margin-bottom: 20px;
			font-size: 16px;
			padding: 10px;
			border-radius: 5px;
			border: none;
			background-color: #f2f2f2;
			box-shadow: 0 0 10px rgba(0,0,0,0.1);
			width: 100%;
			box-sizing: border-box;
		}

		input[type=submit] {
			background-color: #4CAF50;
			color: white;
			padding: 10px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s ease;
			width: 100%;
			font-size: 16px;
			margin-top: 10px;
			box-sizing: border-box;
		}

		input[type=submit]:hover {
			background-color: #3e8e41;
		}

        a {
            all: unset;
            cursor: pointer;
        }
		a.download {
			display: block;
			background-color: #4CAF50;
			color: white;
			padding: 10px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			text-decoration: none;
			transition: background-color 0.3s ease;
			text-align: center;
			margin-top: 20px;
			font-size: 16px;
			box-sizing: border-box;
		}

		a:hover {
			background-color: #3e8e41;
		}
	</style>
</head>
<body>
    <div class="container">
		<a href="https://external.wulmarex.pl/konwersja/"><h1>Konwerter obrazów do WebP</h1></a>
        <form method="POST" enctype="multipart/form-data">
            <label for="image">Wybierz obraz:</label>
			<input type="file" name="image" id="image">
            <input type="submit" value="Wgraj i konwertuj do WebP">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES['image']['name']);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
            // Check if the uploaded file is an image
            if (!in_array($imageFileType, $allowed_extensions)) {
                echo 'Błąd: tylko pliki typu JPG, JPEG, PNG & GIF są dozwolone';
                exit;
            }
            // Move the uploaded file to the uploads directory
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                echo 'Błąd wgrywania pliku';
                exit;
            }
            // Convert the uploaded file to WebP format
            $webp_file = $target_dir . pathinfo($target_file, PATHINFO_FILENAME) . '.webp';
            $image = imagecreatefromstring(file_get_contents($target_file));
            if (!$image) {
                echo 'Błąd konwersji';
                exit;
            }
            if (!imagewebp($image, $webp_file)) {
                echo 'Błąd zapisu przekonwertowanego pliku';
                exit;
            }
            imagedestroy($image);
            // Show a link to the converted file
            echo '<a class="download" href="' . $webp_file . '" download><img class="icon" src="'.$webp_file.'" />Pobierz obraz WebP</a>';
        }
        ?>
    </div>

</body>
</html>