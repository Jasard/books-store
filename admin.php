<?php
    $pageTitle = "Admin";
    include 'header.php';

    if(!isset($_SESSION['admin'])) {
      header("HTTP/1.0 403 Forbidden");
      echo ("You do not have access to this page.");
      exit();
    }
?>

<h2>Administrator</h2>
<div id="alert" class="alert alert-success hide">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Success!</strong> Book has been added to database.
</div>
<div class="row add-book">
  <button class="btn btn-large btn-success" href="#addBook" role="button" class="btn" data-toggle="modal">Add New Book</button>
</div>
<table id="admin-book-list" class="table table-striped table-hover">
  <thead>
    <tr>
      <th></th>
      <th>ID</th>
      <th>Title</th>
      <th>Author</th>
      <th>Genre</th>
      <th>Description</th>
      <th>Download Location</th>
      <th>Price</th>
      <th></th>
    </tr>
  </thead>

  <tbody></tbody>
</table>

<div id="addBook" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Book</h3>
  </div>
  <form enctype="multipart/form-data" id="submit-book" class="well form-horizontal" action="" method="post">
    <div class="modal-body">

        <div class="control-group">
            <label class="control-label" for="title">Title</label>
            <div class="controls">
              <input type="text" name="title" maxlength="50" id="title" placeholder="Title">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="author">Author</label>
            <div class="controls">
              <input type="text" name="author" maxlength="50" id="author" placeholder="Author">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="genre">Genre</label>
            <div class="controls">
              <select id="genre" name="genre">
                <option>Adventure</option>
                <option>Biography</option>
                <option>Computing & Internet</option>
                <option>Crime, Thriller & Mystery</option>
                <option>History</option>
                <option>Horror</option>
                <option>Romance</option>
                <option>Science Fiction & Fantasy</option>
              </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="price">Description</label>
            <div class="controls">
              <input type="text" name="description" maxlength="500" id="description" placeholder="Description">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="price">Price</label>
            <div class="controls">
              <input class="span2" type="text" name="price" id="price" placeholder="Price">
            </div>
        </div>
    </div>

    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <input type="submit" value="Add Book" class="btn btn-primary">
    </div>
  </form>
</div>

<div id="delete-modal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Delete</h3>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to delete this entry?</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn">Cancel</a>
    <a id="delete-button" href="#" class="btn btn-primary">Delete</a>
  </div>
</div>

<?php include 'footer.php'; ?>