<?php
    $pageTitle = "Register";
    include 'header.php';
?>

<div class="row">
  <div id="alert" class="alert alert-success hide">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> You have registered.
  </div>
  <form id="register-user" class="well span6 form-horizontal">
    <h2>Register</h2>
    <div class="control-group">
        <label class="control-label" for="firstName">First Name</label>
        <div class="controls">
          <input type="text" id="firstName" maxlength="25" name="firstName" class="required" placeholder="First Name">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="surname">Surname</label>
        <div class="controls">
          <input type="text" id="surname" maxlength="25" name="surname" class="required" placeholder="Surname">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="email">Email</label>
        <div class="controls">
          <input type="text" id="email" maxlength="25" name="email" class="required" placeholder="Email">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputPassword">Password</label>
        <div class="controls">
          <input type="password" id="inputPassword" name="password" class="required" placeholder="Password">
        </div>
    </div>

    <div class="control-group">
      <div class="controls">
          <button type="submit" class="btn">Register</button>
      </div>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>