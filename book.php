<?php
    $pageTitle = "Book Title";
    include 'header.php';

    if (isset($_GET['id'])) {
      $id = $_GET['id'];

      include_once("config.php");

      $result = mysql_query("SELECT * FROM books WHERE B_Id=".$id);
      $row = mysql_fetch_assoc($result);

      if (empty($row)) {
        echo 'Error: Book not found!';
        include 'footer.php';
        exit();
      }

      $title = $row['Title'];
      $author = $row['Author'];
      $description = $row['Description'];
      $price = $row['Price'];
      $reviewed = true;
      $purchased = false;
      $session = false;

      if(isset($_SESSION['email'])) {
        $u_id = $_SESSION['U_Id'];
        $session = true;

        $result = mysql_query("SELECT * FROM reviews WHERE U_Id=".$u_id." and B_Id=".$id);
        $row = mysql_fetch_assoc($result);
        if (!empty($row)) {
          $reviewed = true;
        } else {
          $reviewed = false;
        }

        $result = mysql_query("SELECT * FROM sales WHERE U_Id=".$u_id." and B_Id=".$id);
        $row = mysql_fetch_assoc($result);
        if (!empty($row)) {
          $purchased = true;
        } else {
          $purchased = false;
        }
      }

      $imageLocation = strtolower($title);
      $imageLocation = str_replace(' ', '_', $imageLocation);

      mysql_close($con);

    } else {
      echo 'Error: Book not found!';
      include 'footer.php';
      exit();
    }
?>

<ul class="breadcrumb">
  <li>
    <a href="index.php">Home</a>
    <span class="divider">/</span>
  </li>
  <li>
    <a href="books.php">Books</a>
    <span class="divider">/</span>
  </li>
  <li>
    <a href="#"><?php echo $title ?></a>
  </li>
</ul>

<div class="row">
  <h1><?php echo $title ?></h1>
  <img src="uploads/images/<?php echo $imageLocation ?>.jpg" alt="Harry Potter" class="span3 img-polaroid" width="200px">
  <dl class="dl-horizontal span8">
    <dt>Title</dt>
      <dd><?php echo $title ?></dd>
    <dt>Author</dt>
      <dd><?php echo $author ?></dd>
    <dt>Description</dt>
      <dd><?php echo $description ?></dd>
    <dt>Price</dt>
      <dd>£<?php echo $price ?></dd>
  </dl>
</div>

<div class="row">
  <h2>Reviews</h2>
  <div id="alert" class="alert alert-success hide">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> Review has been added.
  </div>
  <?php
    if($purchased) {
      echo '<div class="row add-book">
        <a class="btn btn-large btn-success" href="download.php?bid='.$id.'" role="button" class="btn">Download Book</a>
      </div>';
    } else if (!$purchased && $session) {
      echo '<div class="row add-book">
        <a class="btn btn-large btn-success" href="digitalcart.php?id='. $id .'" role="button" class="btn">Buy Book</a>
      </div>';
    }
    if($reviewed == false) {
      echo '<div id="addreviewButton" class="row add-book">
        <button class="btn btn-large btn-success" href="#addReview" role="button" class="btn" data-toggle="modal">Add Review</button>
      </div>';
    }
  ?>

  <table id="<?php echo $id ?>" class="reviews-list table table-striped">
    <thead>
      <tr>
        <th>Reviewer</th>
        <th>Review</th>
        <th>Rating</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>

<div id="addReview" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Review</h3>
  </div>
  <form enctype="multipart/form-data" id="submit-review" class="well form-horizontal" action="" method="post">
    <div class="modal-body">

        <div class="control-group">
            <label class="control-label" for="review">Review Text</label>
            <div class="controls">
              <textarea type="text" name="review" maxlength="250" id="review" placeholder="Review Text" rows="5"></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="rating">Rating</label>
            <div class="controls">
              <select id="rating" name="rating">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
        </div>
        <input type="hidden" name="b_Id" value="<?php echo $id ?>">
        <input type="hidden" name="name" value="<?php echo $_SESSION['name']?>">
        <input type="hidden" name="u_Id" value="<?php echo $_SESSION['U_Id']?>">
    </div>

    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <input type="submit" value="Add Review" class="btn btn-primary">
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>