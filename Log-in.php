<?php

require 'Includes/Init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = require 'Includes/Db.php';
    
    if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {
        
        Auth::login();
        Url::redirect('/../Class Method/Index.php');

    } else {
        
        $error = "login incorrect";

    }
}

?>
<?php require 'Includes/header.php'; ?>

<h2>Login</h2>

<?php if (! empty($error)) : ?>
    <p><?= $error ?></p>
<?php endif; ?>

<form method="post">

    <div>
        <label for="username">Username</label>
        <input name="username" id="username">
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>
    <br>
    <button>Log in</button>

</form>

<?php require 'Includes/footer.php'; ?>
