<?php

try {
	// Connect to MySQL using PDO
	$bdd = new PDO('mysql:host=localhost;dbname=id20933598_hackers_poulette;charset=utf8', 'id20933598_hacker', 'No@ccess0');

	// Define variables to hold input values
	$inputName = '';
	$inputFirstname = '';
	$inputEmail = '';
	$inputFile = '';
	$inputDescription = '';

	// Define function to validate input values
	function inputValue($verifyValue) {
		if (isset($_POST[$verifyValue]) && !empty($_POST[$verifyValue])) {
			$inputValueTrim = trim($_POST[$verifyValue]);
			$verifyValue = htmlspecialchars($inputValueTrim);
// 			echo '<p class=receive-message >Name '. $verifyValue .' is valid!</p>';
			return true;
		} else {
// 			echo '<p class=error-message >Enter your name !</p>';
			return false;
		}
	}

	// Define function to validate email input
	function sanitizeEmail($inputEmail) {
		$inputEmail = $_POST['email'];
		// Remove leading and trailing whitespace
		$inputEmail = trim($inputEmail);
	  
		// Sanitize the input
		$inputEmail = filter_var($inputEmail, FILTER_SANITIZE_EMAIL);
	  
		// Validate the input
		if (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
// 			echo '<p class=error-message >Error: Invalid email address!</p>';
			return false;
		} else {
// 			echo '<p class=receive-message >Email '. $inputEmail .' is valid!</p>';
			return true;
		}
	  }

	// Define function to validate file input
	function inputFile ($inputFile) {
		if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
			if ($_FILES['file']['size'] <= 2000000) {
				$fileInfo = pathinfo($_FILES['file']['name']);
				$extension = $fileInfo['extension'];
				$allowedExtensions = array('jpg', 'png', 'gif');
				if (in_array($extension, $allowedExtensions)) {
				// 	move_uploaded_file($_FILES['file']['tmp_name'], 'upload/' . basename($_FILES['file']['name']));
				// 	echo '<p class=receive-message >Envoi effectué !</p>';
					$inputFile = $_FILES['file']['name'];
					return true;
				} else {
				// 	echo '<p class=error-message >Error: Not an accepted file type!</p>';
					return false;
				}
			} else {
				// echo '<p class=error-message >Error: File size is too large!</p>';
				return false;
			}
		} else {
// 			echo '<p class=error-message >Error: File not upload failed!</p>';
			return false;
		}
	}

	// Define function to sanitize textarea input
	function sanitizeTextarea(&$inputDescription) {
		$inputDescription = $_POST['description'];
		// Remove leading and trailing whitespace
		$inputDescription = trim($inputDescription);
		// Remove HTML and PHP tags
		$inputDescription = strip_tags($inputDescription);
		// Replace special characters with HTML entities
		$inputDescription = htmlspecialchars($inputDescription, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		// Validate the input
		if (strlen($inputDescription) < 2) {
// 			echo '<p class=error-message >Textarea input must be at least 2 characters long.!</p>';
			return false;
		}
// 		echo '<p class=receive-message >Description '. $inputDescription .'is valid!</p>';
		return true;
	}

	// Validate input values and assign to variables
	if (inputValue('name') && inputValue('firstname') && sanitizeEmail('email') && inputFile('file') && sanitizeTextarea($inputDescription)) {
		$inputName = $_POST['name'];
		$inputFirstname = $_POST['firstname'];
		$inputEmail = $_POST['email'];
		$inputFile = $_FILES['file']['name'];
		$inputDescription = $_POST['description'];

		// Prepare SQL statement to insert data into table
		$stmt = $bdd->prepare('INSERT INTO hackers_poulette (name, firstname, email, file, description) VALUES (:name, :firstname, :email, :file, :description)');

		// Bind input values to SQL statement
		$stmt->bindParam(':name', $inputName, PDO::PARAM_STR);
		$stmt->bindParam(':firstname', $inputFirstname, PDO::PARAM_STR);
		$stmt->bindParam(':email', $inputEmail, PDO::PARAM_STR);
		$stmt->bindParam(':file', $inputFile, PDO::PARAM_STR);
		$stmt->bindParam(':description', $inputDescription, PDO::PARAM_STR);

		// Execute SQL statement and handle errors
		if ($stmt->execute()) {
		    
			$to=$inputEmail;
			$subject="Hackers Poulette - Form sent successfully";
			$message="
				Hello, your form has been sent successfully!

				Greatings,
				
				Hackers Poulette
			";
			$header="From: hackers-poulette-contact@yopmail.com
			";
			// $entetes.="Cc: ";
			// $header.="Content-Type: text/html; charset=iso-8859-1";
			if(mail($to, $subject, $message, $header)) {
				// echo '<p class=receive-message >Mail envoyé avec succès.</p>';
			} else {
// 			echo "<p class=error-message >Un problème est survenu lors de l'envoi du mail.</p>";
			}
                header('Location: success.php');
				exit();
		} else {
// 			echo "Error: " . $stmt->errorInfo()[2];
		}
	}
} catch(Exception $e) {
	// Handle errors
	die('Erreur : '.$e->getMessage());
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Hacking poulette</title>
	<link rel="stylesheet" href="./style.css" media="screen" title="no title" charset="utf-8">
	<script>
	    function successCallback () {
	        debugger;
	    }
	    function onLoadCallBack() {
	        grecaptcha.render('divRecaptcha', {
	            sitekey:'6LdAN70mAAAAAHJx0J616dL3hGnoL9LzuCfHkNGj',
	            callback: successCallback,
	        })
	    }
	</script>
	<script src="https://www.google.com/recaptcha/api.js?onload=onLoadCallBack&render=explicit"async defer></script>
	<style>
	</style>
</head>
<body>
	<h2>Hackers Poulette ™ </h2>
	<h1>Contact Support</h1>
	<form action="" method="post" enctype="multipart/form-data">
		<div id="divName" class="text_input">
			<label for="name">Name</label>
			<input type="text" name="name" value="" maxlength="255">
			<?php 
			inputValue($inputName); 
			?>
		</div>
		<span id="error_divName"></span>
		<div id="divFirstname" class="text_input">
			<label for="firstname">Firstname</label>
			<input type="text" name="firstname" value="" maxlength="255">
			<?php 
			inputValue($inputFirstname); 
			?>
		</div>
		<span id="error_divFirstname"></span>
		<div id="divEmail" class="text_input">
			<label for="email">Email</label>
			<input type="email" name="email" value="" maxlength="255">
			<?php 
			sanitizeEmail($inputEmail); 
			?>
		</div>
		<span id="error_divEmail"></span>
		<div id="divFile" class="text_input">
			<label for="file">File</label>
            <input type="file" name="file" id="">
			<?php 
			inputFile ($inputFile) ;
			?>
		</div>
		<span id="error_divFile"></span>
		<div id="divDescription" class="text_input">
			<label for="description">Description</label>
			<textarea type="text" name="description" value="" maxlength="1000"></textarea>
			<?php 
				sanitizeTextarea($inputDescription); 
			?>
		</div>
		<span id="error_divDescription"></span>
            <div class="g-recaptcha" id="divRecaptcha"></div>
		 <button type="submit" name="button" id="submit">Envoyer</button>
	</form>
	
	<script>
        function disableButton() {
          document.getElementById('submit').disabled = true;
        }
    </script>
    
		 <script> function onClick(e) {
			e.preventDefault();
			grecaptcha.enterprise.ready(async () => {
			const token = await grecaptcha.enterprise.execute('6LdAN70mAAAAAHJx0J616dL3hGnoL9LzuCfHkNGj
', {action: 'POST'});
			// IMPORTANT: The 'token' that results from execute is an encrypted response sent by
			// reCAPTCHA Enterprise to the end user's browser.
			// This token must be validated by creating an assessment.
			// See https://cloud.google.com/recaptcha-enterprise/docs/create-assessment
			});
		}
		function onSubmit(token) {
			document.getElementById("demo-form").submit();
		} </script>
</body>
</html>