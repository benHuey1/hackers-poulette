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
			echo '<p class=receive-message >Name '. $verifyValue .' is valid!</p>';
			return true;
		} else {
			echo '<p class=error-message >Enter your '.$verifyValue.' !</p>';
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
			echo '<p class=error-message >Error: Invalid email address!</p>';
			return false;
		} else {
			echo '<p class=receive-message >Email '. $inputEmail .' is valid!</p>';
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
					move_uploaded_file($_FILES['file']['tmp_name'], 'upload/' . basename($_FILES['file']['name']));
					echo '<p class=receive-message >Envoi effectué !</p>';
					$inputFile = $_FILES['file']['name'];
					return true;
				} else {
					echo '<p class=error-message >Error: Not an accepted file type!</p>';
					return false;
				}
			} else {
				echo '<p class=error-message >Error: File size is too large!</p>';
				return false;
			}
		} else {
			echo '<p class=error-message >Error: File not upload failed!</p>';
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
			echo '<p class=error-message >Textarea input must be at least 2 characters long.!</p>';
			return false;
		}
		echo '<p class=receive-message >Description '. $inputDescription .'is valid!</p>';
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
				echo '<p class=receive-message >Mail envoyé avec succès.</p>';
			} else {
			echo "<p class=error-message >Un problème est survenu lors de l'envoi du mail.</p>";
			}
				// exit();
		} else {
			echo "Error: " . $stmt->errorInfo()[2];
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
	<link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
	<!-- <link rel="" href="./traitement.php"> -->

		<!-- <script> function onClick(e) {
			e.preventDefault();
			grecaptcha.enterprise.ready(async () => {
			const token = await grecaptcha.enterprise.execute('6LdDorImAAAAAIZe-1yCOisnnypIT1AqgVKaaYr-', {action: 'POST'});
			// IMPORTANT: The 'token' that results from execute is an encrypted response sent by
			// reCAPTCHA Enterprise to the end user's browser.
			// This token must be validated by creating an assessment.
			// See https://cloud.google.com/recaptcha-enterprise/docs/create-assessment
			});
		}
		function onSubmit(token) {
			document.getElementById("demo-form").submit();
		} </script> -->
	<style>
		.receive-message{
			color: #00FF00;
		}
		.error-message{
			color: #FF0000;
		}
		form {
			display: flex;
			flex-direction: column;
		}
		#submit {
			width: 10%;	
		}
	</style>
</head>
<body>
<!-- <body style="background-color:#1c87c9;"> -->
	<h2>Hackers Poulette ™ </h2>
	<h1>Contact Support</h1>
	<form action="verify.php" method="post" enctype="multipart/form-data">
		<div>
			<label for="name">Name</label>
			<input type="text" name="name" value="" maxlength="255">
			<?php 
			inputValue($inputName); 
			?>
		</div>
		<div>
			<label for="firstname">Firstname</label>
			<input type="text" name="firstname" value="" maxlength="255">
			<?php 
			inputValue($inputFirstname); 
			?>
		</div>
		<div>
			<label for="email">Email</label>
			<input type="email" name="email" value="" maxlength="255">
			<?php 
			sanitizeEmail($inputEmail); 
			?>
		</div>
		<div>
			<label for="file">File</label>
			<!-- <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> -->
            <input type="file" name="file" id="">
			<?php 
			inputFile ($inputFile) ;
			?>
		</div>
		<div>
			<label for="description">Description</label>
			<textarea type="text" name="description" value="" maxlength="1000"></textarea>
			<?php 
				sanitizeTextarea($inputDescription); 
			?>
		</div>
		<!-- <input type="hidden" id="recaptchaResponse" name="recaptcha-response"> -->

		<button type="submit" name="button" id="submit">Envoyer</button>
		
		<!-- <script src="https://www.google.com/recaptcha/api.js?render=6LdDorImAAAAAIZe-1yCOisnnypIT1AqgVKaaYr-"></script> -->


		<!-- <button type="submit" name="button" id="submit" class="g-recaptcha" 
        data-sitekey="reCAPTCHA_site_key" 
        data-callback='onSubmit' 
        data-action='submit'>Envoyer</button>
	</form> -->
	<!-- <script>
			grecaptcha.enterprise.ready(async () => {
				const token = await grecaptcha.enterprise.execute('6LdDorImAAAAAIZe-1yCOisnnypIT1AqgVKaaYr-', {action: 'homepage'});
				// IMPORTANT: The 'token' that results from execute is an encrypted response sent by
				// reCAPTCHA Enterprise to the end user's browser.
				// This token must be validated by creating an assessment.
				// See https://cloud.google.com/recaptcha-enterprise/docs/create-assessment
			});
		</script> -->
		<!-- <script>
		grecaptcha.ready(function() {
			grecaptcha.execute('6LdDorImAAAAAIZe-1yCOisnnypIT1AqgVKaaYr-', {action: 'homepage'}).then(function(token) {
				document.getElementById('recaptchaResponse').value = token
			});
		});
		</script>	 -->
		<!-- <script defer src="https://www.google.com/recaptcha/enterprise.js?render=6Lcct7wmAAAAAMRMm5aOa3CT18U_9VMPGeCeqKPW"></script> -->
		<!-- <script>
			function onSubmit(token) {
				document.getElementById("demo-form").submit();
			}
 		</script>
		<script src="https://www.google.com/recaptcha/api.js"></script> -->
</body>
</html>

<?php



?>