<?php


error_reporting(-1);
ini_set('display_errors', 'on');

include 'includes/filter-wrapper.php';



$possible_priorities = array(
	'eng' => 'English'
	, 'norm' => 'French'
	, 'high' => 'Spanish'
);


$errors = array();
$display_thanks = false;

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$message = filter_input(INPUT_POST,'message', FILTER_SANITIZE_STRING);
$terms = filter_input(INPUT_POST, 'terms', FILTER_SANITIZE_STRING);
$language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_STRING);
$ty = filter_input(INPUT_POST, 'ty', FILTER_SANITIZE_STRING);


var_dump($name);

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check to see if the form has been submitted before validating
	if (empty($name)) {
		$errors['name'] = true;
	}
	
	if (mb_strlen($username) > 25) { 
		$errors['username'] = true;
	}
	
	if (empty($password)) {
		$errors['password'] = true;
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = true;
	}
	
	if (mb_strlen($message) < 25) { 
		$errors['message'] = false;
	}
	
	if ($terms !== "") { 
	$errors['terms'] = true;
	}
	
	if (!array_key_exists($language, $possible_priorities)) {
		$errors['language'] = true;
	}
	
	if (empty($errors)) {
    $display_thanks = true;
    mail($email, 'Thanks for registering', 'Thanks for registering', "From: Chho0005@algonquincollege.com>\r\n");
  }
}

$thanks = "Thank you for using our mail form";

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Contact Form</title>
	<link href="css/general.css" rel="stylesheet">
</head>
<body>


<?php if ($display_thanks) : ?>

	<strong>Thanks!</strong>
    
<?php else : ?>

	<form method="post" action="index.php">
		<div>
			<label for="name">Name<?php if (isset($errors['name'])) : ?> <strong> Please fill in Name</strong><?php endif; ?></label>
			<input id="name" name="name" value="<?php echo $name; ?>" required>
		</div>
        <div>
			<label for="username">Username<?php if (isset($errors['username'])) : ?> <strong> Maximum of 25 characters</strong><?php endif; ?></label>
			<input id="username" name="username" value="<?php echo $username; ?>" required>
		</div>
        	
        <div>
      		<label for="password">Password<?php if (isset($errors['password'])) : ?> <strong>Please Enter a Password</strong><?php endif; ?></label>
			<input type="password" id="password" name="password" value="<?php echo $password; ?>" required>
        </div>

		<div>
			<label for="email">E-mail Address<?php if (isset($errors['email'])) : ?> <strong> Please enter an email addresss</strong><?php endif; ?></label>
			<input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
		</div>
		       
        <fieldset>
		<legend>Preferred languages</legend>
		<?php if (isset($errors['language'])) : ?><strong>Select a language</strong><?php endif; ?>
		<?php foreach ($possible_priorities as $key => $value) : ?>
			<label for="<?php echo $key; ?>"><?php echo $value; ?></label>
            <input type="radio" name="language" id="<?php echo $key; ?>"  value="<?php echo $key; ?>"<?php if ($key == $language) { echo 'checked'; } ?>>
		<?php endforeach; ?>
		</fieldset>
  
		<div>
			<label for="message">Notes<?php if (isset($errors['message'])) : ?> <strong>must be at least 25 characters</strong><?php endif; ?></label>
			<textarea id="message" name="message" required><?php echo $message; ?></textarea>
		</div>

		    <div>
    	<input type="checkbox" id="terms" name="terms" <?php if (!empty($terms)) { echo 'checked'; } ?>
        <label for="terms"> Please accept before continuing</label>
        <?php if (isset($errors['terms'])) :?><strong>You must comply!</strong><?php endif; ?>
    </div>
    
		<div>
			<button type="submit" value="Send Message">Send Message</button>
			<?php if (isset($error['ty'])) : ?> <strong> thank you for sending a message</strong><?php endif; ?></label>
			<input id="ty" name="ty" value="">
		</div>

		<?php if (isset($_REQUEST['email'])){
            $subject = "You are Registered!";
            $from = "chho005@algonquinlive.com";
            $message = "You have received this mail because you have registered with:";
            $header = "Linda Chhor" . $from;
            mail($email, $subject, $message, $header);
            echo "Please check your mailbox.";
        }
        ?>

<?php endif; ?>

</body>
</html>











