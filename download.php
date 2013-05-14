<?php
    $pageTitle = "Book Title";
    include 'header.php';

    if (!isset($_GET['bid']) && !isset($_GET['key']) && !isset($_SESSION['did'])){
        echo 'Error: Please contact support.';
        include 'footer.php';
        exit();
    }

    include_once("config.php");

    if (!isset($_GET['key'])) {
        $sId = $_SESSION['U_Id'];
        $gBid = $_GET['bid'];

        if(!isset($_GET['bid'])) {
            echo 'Error: Please contact support.';
            include 'footer.php';
            exit();
        }

        $sql="SELECT * FROM sales WHERE U_Id='".$sId."' and B_Id='".$gBid."' LIMIT 1;";
        $result=mysql_fetch_assoc(mysql_query($sql));

        if (!empty($result)) {
            $sql="SELECT * FROM books WHERE B_Id='".$gBid."' LIMIT 1;";
            $result=mysql_fetch_assoc(mysql_query($sql));

            $downloadURL = $result['DownloadURL'];
            $title = $result['Title'];

            if (file_exists($downloadURL)) {
                header("Content-Length: " . filesize ( $downloadURL ) );
                header("Content-type: application/octet-stream");
                header("Content-disposition: attachment; filename=".basename($downloadURL));
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                ob_clean();
                flush();

                readfile($downloadURL);
            } else {
                echo 'Error: Please contact support.';
                include 'footer.php';
                exit();
            }

        } else {
            echo 'Error: Please contact support.';
        }

    } else {
        $bid = $_GET['bid'];
        $sKey = $_SESSION['did'];
        $sId = $_SESSION['U_Id'];

        $idLength = strlen($sId);

        $gDid = $_GET['key'];
        $gDidLength = strlen($gDid);
        $gIdLength = $gDidLength - $idLength;
        $gKey = substr($gDid, 0, -$idLength);
        $gId = substr($gDid, $gIdLength);

        if ($sId == $gId && $sKey == $gKey) {
            $sql="SELECT * FROM sales WHERE U_Id='".$sId."' and B_Id='".$bid."' LIMIT 1;";
            $result=mysql_fetch_assoc(mysql_query($sql));

            if (empty($result)) {
                mysql_query("INSERT INTO sales (U_Id, B_Id) VALUES('".$sId."', '".$bid."')");
            }

        } else {
            echo 'Error: Please contact support.';
        }

        $sql="SELECT * FROM books WHERE B_Id='".$bid."' LIMIT 1;";
        $result=mysql_fetch_assoc(mysql_query($sql));

        $downloadURL = $result['DownloadURL'];
        $title = $result['Title'];

        if (file_exists($downloadURL)) {
            header("Content-Length: " . filesize ( $downloadURL ) );
            header("Content-type: application/octet-stream");
            header("Content-disposition: attachment; filename=".basename($downloadURL));
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            ob_clean();
            flush();

            readfile($downloadURL);
        } else {
            echo 'Error: Please contact support.';
            include 'footer.php';
            exit();
        }
    }

    mysql_close($con);
    include 'footer.php';
?>