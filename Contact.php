<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'Vendor/PHPMailer-master/src/Exception.php';
    require 'Vendor/PHPMailer-master/src/PHPMailer.php';
    require 'Vendor/PHPMailer-master/src/SMTP.php';


    require 'Includes/Init.php';

    $email = '';
    $subject = '';
    $message = '';
    $sent = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $errors = [];

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Please enter a valid email addaress';
        }

        if ($subject == '') {
            $errors[] = 'Please enter a subject';
        }

        if ($message == '') {
            $errors[] = 'Please enter a message';
        }

        if (empty($errors)) {

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = SMTP_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = SMTP_USER;
                $mail->Password = SMTP_PASS;
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
            
                $mail->setFrom('sender@example.com');
                $mail->addAddress('recipient@example.com');
                $mail->addReplyTo($email);
                $mail->Subject = $subject;
                $mail->Body = $message;
            
                $mail->send();
            
                $sent = true;

            } catch (Exception $e) {

                $errors[] = $mail->ErrorInfo;
            }
        }
    }
?>

<?php require 'Includes/header.php'; ?>

<h2>Contact</h2>

<?php if ($sent) : ?>
    <p>Message sent.</p>
<?php else: ?>

    <?php if (! empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" id="formContact">
        <div>
            <label for="email">Your Email: </label><br>
            <input type="email" name="email" id="email" placeholder="Sender's email"
            value="<?= htmlspecialchars($email) ?>">
        </div>

        <div>
            <label for="subject">Subject: </label><br>
            <input type="text" name="subject" id="subject" placeholder="Subject"
            value="<?= htmlspecialchars($subject) ?>">
        </div>

        <div>
            <label for="message">Message: </label><br>
            <textarea name="message" id="message" placeholder="Your message" rows="5"><?=
            htmlspecialchars($message) ?></textarea>
        </div>
        <br><br>
        <button>Send</button>
    </form>

<?php endif; ?>

<?php require 'Includes/footer.php'; ?>