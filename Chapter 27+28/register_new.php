<?php
 //modified by Melissa Flores
  // include function files for this application
  require_once('paper_fns.php');

  //create short variable names
  $email=$_POST['email_address'];
  $username=$_POST['userid'];
  $password=$_POST['password'];
  $password2=$_POST['password2'];
  // start session which may be needed later
  // start it now because it must go before headers
  session_start();
  try   {
    // check forms filled in
    if (!filled_out($_POST)) {
      throw new Exception('You have not filled the form out correctly - please go back and try again.');
    }

    // email address not valid
    if (!valid_email($email)) {
      throw new Exception('That is not a valid email address.  Please go back and try again.');
    }

    // passwords not the same
    if ($password != $password2) {
      throw new Exception('The passwords you entered do not match - please go back and try again.');
    }

    // check password length is ok
    // ok if username truncates, but passwords will get
    // munged if they are too long.
    if ((strlen($password) < 6) || (strlen($password) > 16)) {
      throw new Exception('Your password must be between 6 and 16 characters Please go back and try again.');
    }

    // attempt to register
    // this function can also throw an exception
    register($username, $email, $password);
    // register session variable
    $_SESSION['valid_user'] = $username;

    // provide link to members page
    do_html_header('Registration successful');
    echo 'Your registration was successful!';
    do_html_url('member.php', 'Go to members page');

   // end page
   do_html_footer();
  }
  catch (Exception $e) {
     do_html_header('Problem:');
     echo $e->getMessage();
     do_html_footer();
     exit;
  }
?>
