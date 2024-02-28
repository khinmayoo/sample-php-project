<?php
require('database.php');

if (isLoggedIn()) {
    header('location: /');
    exit();
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ((strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) &&
        strlen($password) > 0 && strlen($confirm_password) > 0 &&
        $password === $confirm_password
    ) {
        $query = sprintf(
            "SELECT * FROM users WHERE email = '%s'",
            mysqli_real_escape_string($conn, $email)
        );

        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if (!empty($row)) {
                $errors['duplicate'] = "Email already exists.";
            } else {
                $query = sprintf(
                    "INSERT INTO `users` (`username`, `email`, `password`) VALUES ('%s', '%s', '%s')",
                    mysqli_real_escape_string($conn, $username),
                    mysqli_real_escape_string($conn, $email),
                    mysqli_real_escape_string($conn, password_hash($password, PASSWORD_BCRYPT)),
                );
                $result = mysqli_query($conn, $query);
            }
        } else {
            $errors['body'] = "Errors when select the data.";
        }
    } else {
        $errors['body'] = "Enter valid email and password.";
    }
}
?>
<?php view('header.view.php'); ?>
<?php view('nav.view.php'); ?>

<form action="/register" method="POST">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" id="username" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="email" required>
        <span class="text-danger"><?= $errors['duplicate'] ?? '' ?></span>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password" required>
    </div>
    <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirm Password</label>
        <input type="password" name="confirm-password" class="form-control" id="confirmPassword" required>
    </div>
    <?php if (!empty($errors)) : ?>
        <div><?= $errors['body'] ?? '' ?></div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php view('footer.view.php'); ?>