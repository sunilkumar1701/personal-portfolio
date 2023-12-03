<?php
  /

  // Replace contact@example.com with your real receiving email address
  $receiving_email_address = 'firstlandon17@gmail.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;

  if(!empty($name)||!empty($email)||!empty($subject)||!empty($message)){
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];
  $contact->message = $_POST['message'];

  $contact->smtp = array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'port' => 'contact_details'
  );
  $conn = new mysqli ($host,$username,$password,$port);
  if (mysqli_connect_error()){
    die('connect Error ('.mysqli_connect_errno().')'.sqli_connect_error());
  }
  else{
    $INSERT = "INSERT Into contact_details( name, email,	subject,	message ) values(?,?,?,?)";
    $stmt-> execute();
    $stmt->store_result();
    $rnum = $stmt->num_rows;
    if($rnum==0){
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->blind_param("ssss",$name, $email,	$subject,	$message);
      $stmt-> execute();
      echo"new record insterted sucessfully";
    }
    else{
      echo"something went wrong";
    }
    $stmt->close();
    $conn->close();
  }
}else{
  echo"All fields are required";
  die();
}

  $contact->add_message( $_POST['name'], 'From');
  $contact->add_message( $_POST['email'], 'Email');
  $contact->add_message( $_POST['message'], 'Message', 10);

  echo $contact->send();
?>
