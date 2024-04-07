<?php

require '../Includes/Init.php';
Auth::requireLogin();
$conn = require '../Includes/DB.php';

if (isset($_GET['id'])) {

    $article = Article::getByID($conn, $_GET['id']);

    if ( ! $article) {
        die("article not found");
    }

} else {
    die("id not supplied, article not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (empty($_FILES)) {
            throw new Exception('Invalid upload');
        }

        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file uploaded');
                break;
            case UPLOAD_ERR_INI_SIZE:
                throw new Exception('File too large (from the server setting)');
                break;
            dafault:
                throw new Exception('An error occured');
        }

        if ($_FILES['file']['size'] > 1000000) {
            throw new Exception('File is too large');
        }

        $mime_types = ['image/gif', 'image/png', 'image/jpeg', 'image/jpg'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if (! in_array($mime_type, $mime_types)) {
            throw new Exception('Invalid file type');
        }

        $pathinfo = pathinfo($_FILES['file']['name']);

        $base = $pathinfo['filename'];
        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);

        $base = mb_substr($base, 0, 200);

        $filename = $base . "." . $pathinfo['extension'];
        $destination = "../Uploads/$filename";
        
        $i = 1;

        while (file_exists($destination)) {
            $filename = $base . "-$i." . $pathinfo['extension'];
            $destination = "../Uploads/$filename";

            $i++;
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {

            $previous_image = $article->image_file;

            if ($article->setImageFile($conn, $filename)) {

                if ($previous_image) {
                    unlink("../Uploads/$previous_image");
                }

                URL::redirect("/../Class Method/Admin/Edit-article-image.php?id={$article->id}");
            }

        } else {
            throw new Exception('Unable to move upload file');
        }

    }   catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>
<?php require '../Includes/header.php'; ?>

<h2>Edit article image</h2>

<?php if ($article->image_file) : ?>
    <img src="/../Class Method/Uploads/<?= $article->image_file; ?>" width="200px">
    <a class="delete" href="Delete-article-image.php?id=<?= $article->id; ?>">Delete</a>
<?php endif; ?>

<?php if (isset($error)) : ?>
    <p><?= $error ?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <div>
        <label for="file">Image File:</label>
        <input type="file" name="file" id="file">
    </div><br>
    <button>Upload</button>
</form>

<?php require '../Includes/footer.php'; ?>
