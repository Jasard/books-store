<?php
    session_start();
    if (empty($_POST)){
        header("location:index.php");
        exit();
    }

    include_once("config.php");

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        mysql_query("DELETE FROM books WHERE B_Id=".$id);
        mysql_close($con);
        header("location:admin.php");
    } else {

        // if($_FILES['imageloc']['name']) {
        //     //if no errors...
        //     if(!$_FILES['imageloc']['error']) {
        //         //now is the time to modify the future file name and validate the file
        //         $new_file_name = strtolower($_FILES['imageloc']['tmp_name']); //rename file
        //         if($_FILES['imageloc']['size'] > (20480000)) {
        //             $valid_file = false;
        //             $message = 'Oops!  Your file\'s size is to large.';
        //         } else {
        //             move it to where we want it to be
        //             $filename = $_FILES['imageloc']['name'];

        //             move_uploaded_file($_FILES['imageloc']['tmp_name'], 'uploads/images/test.png');
        //             $message = 'Congratulations!  Your file was accepted.';
        //         // }
        //     }
        //     //if there is an error...
        //     else {
        //         //set that to be the returned message
        //         $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['imageloc']['error'];
        //     }
        // }

        $title            = stripslashes(mysql_real_escape_string($_POST['title']));
        $author           = stripslashes(mysql_real_escape_string($_POST['author']));
        $genre            = stripslashes(mysql_real_escape_string($_POST['genre']));
        $description      = stripslashes(mysql_real_escape_string($_POST['description']));
        $price            = stripslashes(mysql_real_escape_string($_POST['price']));

        if (isset($title) && strlen($title)>0 &&
            isset($author) && strlen($author)>0 &&
            isset($genre) && strlen($genre)>0 &&
            isset($description) && strlen($description)>0 &&
            isset($price) && strlen($price)>0
        ) {
            $imageLocation = strtolower($title);
            $imageLocation = str_replace(' ', '_', $imageLocation);

            $fileName = $imageLocation;
            $downloadLocation = 'uploads/books/'.$fileName.'.pdf';
            $imageLocation = 'uploads/images/'.$fileName.'.jpg';

            $title = filter_var($title,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $author = filter_var($author,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $genre = filter_var($genre,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $description = filter_var($description,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $price = filter_var($price,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $imageLocation = filter_var($imageLocation,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            mysql_query("INSERT INTO books (Title, Author, Genre, Description, Price, ImageURL, DownloadURL) VALUES('".$title."', '".$author."', '".$genre."', '".$description."', '".$price."', '".$imageLocation."', '".$downloadLocation."')");
            echo "success";
        }
    }
    mysql_close($con);
?>