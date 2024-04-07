<!DOCTYPE html>
<html>
<head>
    <title>Blog Site</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="/Class Method/Style.css">
</head>
<body>
    <header>
        <h1 class="site-head">Blog Site</h1>
    </header>

    <nav>
        <ul>
            <li><a href="/Class Method/Index.php">Home</a></li>
            <?php if (Auth::isLoggedIn()) : ?>

                <li><a  href="/Class Method/Admin/">Admin</a></li>
                <li><a href="Log-out.php">Log out</a></li>
            <?php else : ?>

                <li><a href="Log-in.php">Log in</a></li>
            <?php endif; ?>

            <li><a href="/Class Method/Contact.php">Contact</a></li>
        </ul>
    </nav>
    <hr>
    <main>