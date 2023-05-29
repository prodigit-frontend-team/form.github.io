

<?php
if (isset($_POST['email'])) {
    $email_to = "chakribabu.epixelweb@gmail.com";
    $email_subject = "Summarized propose of the email";

    // Errors to show if there is a problem in form fields.
    function died($error)
    {
        echo "We are sorry that we can't proceed with your request due to error(s).<br />";
        echo "Below is the error(s) list:<br /><br />";
        echo $error . "<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        echo '<script>alert("We are sorry that we can\'t proceed with your request due to error(s).");';
        echo 'window.location.href = "home.php";</script>';
        die();
    }

    // Validation expected data exists
    if (
        !isset($_POST['name']) ||
        
        !isset($_POST['email']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['country']) ||
        !isset($_POST['comments'])
    ) {
        died('We are sorry to proceed with your request due to errors within form entries');
    }

    $name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['telephone'];
    $country = $_POST['country']; // not required
    $comments = $_POST['comments']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if (!preg_match($email_exp, $email_from)) {
        $error_message .= 'You entered an invalid email<br />';
    }
    
    $string_exp = "/^[A-Za-z .'-]+$/";
    if (!preg_match($string_exp, $name)) {
        $error_message .= 'Invalid first name<br />';
    }
   
    if (strlen($comments) < 2) {
        $error_message .= 'Invalid comments<br />';
    }
    if (strlen($error_message) > 0) {
        died($error_message);
    }

    $email_message = "Form details below.\n\n";
    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email_from) . "\n";
    $email_message .= "Telephone: " . clean_string($telephone) . "\n";
    $email_message .= "Country: " . clean_string($country) . "\n";
    $email_message .= "Comments: " . clean_string($comments) . "\n";

    // Create email headers
    $headers = 'From: ' . $email_from . "\r\n" .
        'Reply-To: ' . $email_from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if (@mail($email_to, $email_subject, $email_message, $headers)) {
        echo '<script>alert("Thank you for contacting us. We will be in touch with you very soon.");';
        echo 'window.location.href = "https://iseeoverseas.com/";</script>';
        exit();
    } else {
        echo '<script>alert("There was an error sending your message. Please try again later.");';
        echo 'window.location.href = "https://iseeoverseas.com/";</script>';
        exit();
    }
}
?>
