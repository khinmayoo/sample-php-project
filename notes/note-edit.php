<?php
    if(!isLoggedIn()) {
        header('location: /notes/');
        exit();
    }

    $user_id = $_SESSION['user']['id'];
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $body = $_POST['body'];
        
        if (strlen($title) > 0 && strlen($body) > 0) {
            $update_query = sprintf("UPDATE notes SET `title`= '%s', `body` = '%s' WHERE id=%d AND user_id=%d",
                mysqli_real_escape_string($conn, $title),
                mysqli_real_escape_string($conn, $body),
                mysqli_real_escape_string($conn, $_GET['id']),
                mysqli_real_escape_string($conn, $user_id)
            );
            
            $result = mysqli_query($conn, $update_query);
            if (!$result) {
                $errors['body'] = "Error occurred.";
            } else {
                $message = "Note has been updated.";
            }
        } else {
            $errors['body'] = "No valid inputs.";
        }
    }

    if (isset($_GET['id'])) {
        $note_id = $_GET['id'];
        //dd($note_id);
        $select_query = sprintf("SELECT * FROM notes where user_id = %d AND id = %d",
            mysqli_real_escape_string($conn, $user_id),
            mysqli_real_escape_string($conn, $note_id)
        );
        
        $result = mysqli_query($conn, $select_query);
        $row = mysqli_fetch_assoc($result);
    } else {
        $row = null;
    }
?>

<?php view('header.view.php'); ?>
<?php view('nav.view.php'); ?>
<?= $message ?? '' ?>
<?php if ($row) : ?>
    <form action="/note/edit?id=<?= $note_id ?>" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" id="title" required value="<?= $row['title'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Body</label>
            <textarea name="body" class="form-control" id="body" required><?= $row['body'] ?></textarea>
        </div>
        <?php if (!empty($errors)) : ?>
            <div><?= $errors['body'] ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
<?php else : ?>
    Not Found
<?php endif; ?>

<?php view('footer.view.php'); ?>