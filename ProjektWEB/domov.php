<?php
    include_once('Partials\header.php');
    include_once('Partials\db_connection.php'); // Include your database connection file here

    // Create
    if(isset($_POST['create'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $sql = "INSERT INTO articles (title, content) VALUES ('$title', '$content')";
        mysqli_query($conn, $sql);
    }

    // Read
    $sql = "SELECT * FROM articles";
    $result = mysqli_query($conn, $sql);

    // Update
    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $sql = "UPDATE articles SET title='$title', content='$content' WHERE id=$id";
        mysqli_query($conn, $sql);
    }

    // Delete
    if(isset($_POST['delete'])){
        $id = $_POST['id'];
        $sql = "DELETE FROM articles WHERE id=$id";
        mysqli_query($conn, $sql);
    }
?>
<link rel="stylesheet" href="CSS/domov.css">
<main>
    <!-- Display articles here -->
    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <h2><?php echo $row['title']; ?></h2>
        <p><?php echo $row['content']; ?></p>
    <?php endwhile; ?>
</main>
<?php
    include_once('Partials\footer.php');
?>