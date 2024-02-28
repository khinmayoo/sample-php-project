<?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $select_query = sprintf("SELECT title, notes.id as note_id, username, body, user_id " . 
            "FROM notes LEFT JOIN users ON notes.user_id = users.id WHERE notes.id = %d",
            mysqli_real_escape_string($conn, $id)
        );

        $results = mysqli_query($conn, $select_query);
        $count = mysqli_num_rows($results);
    } else {
        echo "Not found";
        return;
    }
    
?>
<?php 
    view("header.view.php", [
        "title" => "Notes"
    ]);
?>
<?php view("nav.view.php");?>
<h1>Notes</h1>
<div>
    <?php if ($count > 0) : ?>
    <?php while($row = mysqli_fetch_assoc($results)) : ?>
        <h3><a href="/note?id=<?=$row["note_id"]?>"><?= $row["title"] ?></a></h3>
        <p>Author - <?= $row["username"] ?? "Unknown" ?></p>
        <p>
            <?= htmlentities($row["body"]) ?>
        </p>
        <p>
            <?php if (isLoggedIn() && $_SESSION['user']['id'] === $row['user_id']) : ?>
                <a href="/note/edit?id=<?= $row['note_id'] ?>">Edit<a/> | Delete
            <?php endif; ?>
        </p>
    <?php endwhile; ?>
    <?php else: ?>
        <h4>404 not found.</h4>
    <?php endif; ?>
</div>
<?php view("footer.view.php");?>
