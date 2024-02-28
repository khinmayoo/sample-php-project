<?php
    if(!isLoggedIn()) {
        header('location: /login');
        exit();
    }
    $user_id = $_SESSION['user']['id'];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($_POST["action"] ?? '' === "DELETE") {
            $id = $_POST['id'];
            $delete_query = sprintf("DELETE FROM `todos` WHERE id = %d AND user_id=%d", 
                mysqli_real_escape_string($conn, $id),
                mysqli_real_escape_string($conn, $user_id)
            );

            $result = mysqli_query($conn, $delete_query);
        } else {
            $body = $_POST['body'];

            $insert = sprintf("INSERT INTO `todos` (`body`, `user_id`) VALUES ('%s', %d)",
                mysqli_real_escape_string($conn, $body),
                mysqli_real_escape_string($conn, $user_id)
            );

            $result = mysqli_query($conn, $insert);
        }
    }

    $query_string = sprintf("SELECT * FROM todos WHERE user_id = %d ORDER BY id DESC",
        mysqli_real_escape_string($conn, $user_id)
    );

    $result = mysqli_query($conn, $query_string);

?>
<?php require(BASE_PATH . "/view/header.view.php");?>
<?php require(BASE_PATH . "/view/nav.view.php");?>
<div>
    <form action="/todos/" method="POST">
        <input type="text" name="body" />
        <button name="add-todo-btn" type="submit">Add</button>
    </form>
</div>
<div>
    <?php while($row = mysqli_fetch_assoc($result)) : ?>
        <div>
            <?= htmlentities($row['body']) ?>
            <form action="/todos/" method="POST">
                <input type="hidden" name="id" value=<?= $row['id'] ?> />
                <input type="hidden" name="action" value="DELETE"/>
                <button>Delete</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>
<?php require(BASE_PATH . "/view/footer.view.php");?>