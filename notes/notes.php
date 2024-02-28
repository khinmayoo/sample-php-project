<?php
    $select_query = "SELECT title, notes.id AS note_id, body, users.id AS user_id, username FROM notes LEFT JOIN users ON notes.user_id = users.id";
    $results = mysqli_query($conn, $select_query);
?>
<?php view("header.view.php", [
    "title" => "Notes"
]);?>
<?php view("nav.view.php");?>
<h1>Notes</h1>
<div>
    <?php while($row = mysqli_fetch_assoc($results)) : ?>
        <h3><a href="/note?id=<?=$row["note_id"]?>"><?= $row["title"] ?></a></h3>
        <p>
            Author - <a href="/author?id=<?= $row['user_id']?>"><?= $row["username"] ?? "Unknown" ?></a>
        </p>
        <p>
            <?= substr(htmlentities($row["body"]), 0, 200) . '...' ?>
        </p>
    <?php endwhile; ?>
</div>
<?php view("footer.view.php");?>
