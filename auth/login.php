<?php
    if (isLoggedIn()) {
        header('location: /');
        exit();
    }
    $errors = [];
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ((strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) &&
            strlen($password) > 0
        ) {
            $query_select = sprintf("SELECT * FROM users WHERE email = '%s' LIMIT 1",
                mysqli_real_escape_string($conn, $email)
            );
            $result = mysqli_query($conn, $query_select);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $user = [
                    'id' => $row['id'],
                    'email' => $row['email']
                ];
                if (password_verify($password, $row['password'])) {
                    login($user);
                    header('location: /');
                    exit();
                } else {
                    $errors['body'] = "Email or password incorrect.";
                }
            }
        } else {
            $errors['body'] = "Enter valid email and password.";
        }
    }
?>
<?php view('header.view.php'); ?>
<?php view('nav.view.php'); ?>
<form action="/login<?= $url_query ?? ''?>" method="POST">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-1">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class=mb-3>
        <?php if (!empty($errors)) : ?>
            <span class="text-danger"><?= $errors['body'] ?></span>
        <?php endif; ?>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
<?php view('footer.view.php'); ?>