<?php
    $pageTitle = "Admin";
    include 'header.php';

    if(!isset($_SESSION['admin'])) {
      header("HTTP/1.0 403 Forbidden");
      echo ("You do not have access to this page.");
      exit();
    }

    include_once("config.php");

    if ($_GET['id']) {
        $id = $_GET['id'];

        if ($_POST) {
            echo 'Book updated.';

            $newTitle            = stripslashes(mysql_real_escape_string($_POST['title']));
            $newAuthor           = stripslashes(mysql_real_escape_string($_POST['author']));
            $newGenre            = stripslashes(mysql_real_escape_string($_POST['genre']));
            $newDescription      = stripslashes(mysql_real_escape_string($_POST['description']));
            $newPrice            = stripslashes(mysql_real_escape_string($_POST['price']));

            $newImageLocation = strtolower($newTitle);
            $newImageLocation = str_replace(' ', '_', $newImageLocation);

            $fileName = $newImageLocation;
            $newDownloadLocation = 'uploads/books/'.$fileName.'.pdf';
            $newImageLocation = 'uploads/images/'.$fileName.'.jpg';

            $newTitle = filter_var($newTitle,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $newAuthor = filter_var($newAuthor,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $newGenre = filter_var($newGenre,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $newDescription = filter_var($newDescription,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $newPrice = filter_var($newPrice,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $newImageLocation = filter_var($newImageLocation,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $newDownloadLocation = filter_var($newDownloadLocation,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

            mysql_query("UPDATE books SET Title='".$newTitle."',
                                        Author='".$newAuthor."',
                                        Genre='".$newGenre."',
                                        Description='".$newDescription."',
                                        ImageURL='".$newImageLocation."',
                                        DownloadURL='".$newDownloadLocation."',
                                        Price='".$newPrice."' WHERE B_Id='".$id."'");

        }

        $result = mysql_query("SELECT * FROM books WHERE B_Id=".$id);
        $row = mysql_fetch_assoc($result);

        $title = $row['Title'];
        $author = $row['Author'];
        $genre = $row['Genre'];
        $description = $row['Description'];
        $price = $row['Price'];
    } else {
        echo "error";
    }

    mysql_close($con);
?>

<h2>Administrator - Edit Book</h2>
<form enctype="multipart/form-data" id="edit-book-form" action="" method="post">
    <table id="edit-book-list" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Author</th>
          <th>Genre</th>
          <th>Description</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php
            echo '<td>'.$id.'</td>
                <td><input type="text" name="title" id="title" value="'.$title.'"></td>
                <td><input type="text" name="author" id="author" value="'.$author.'"></td>
                <td><input type="text" name="genre" id="genre" value="'.$genre.'"></td>
                <td><input type="text" name="description" id="description" value="'.$description.'"></td>
                <td><input type="text" name="price" id="price" value="'.$price.'"></td>';
          ?>
        </tr>
      </tbody>
    </table>
    <div class="row add-book">
      <button class="btn btn-large btn-success" type="submit" href="edit-book.php" class="btn">Edit Book</button>
    </div>
</form>

<?php include 'footer.php'; ?>