$(document).ready(function() {

  $("#register-user").validate({
    rules: {
        firstName: "required",
        surname: "required",
        email: {
            required: true,
            email: true
        },
        password: {
            required: true,
            minlength: 5
        }
    },
    messages: {
        firstName: "Please enter your firstname",
        surname: "Please enter your lastname",
        password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
        },
        email: "Please enter a valid email address"
    },
    submitHandler: function(form) {
      $.post(
       'register-user.php',
        $("#register-user").serialize(),
        function(data){
            if(data == "success") {
              $('#register-user').fadeOut();
              $('#alert').fadeIn();
              $('#alert').after("<p>Login using the form above.</p><p><a href='books.php' class='btn btn-primary btn-large'>See Book Collection &raquo;</a></p>");
            } else {
              $('#alert').after("<p>"+data+"</p>");
            }
        }
      );
      return false;
    }
  });

  $("#submit-book").validate({
    rules: {
        title: "required",
        author: "required",
        description: "required",
        price: {
            required: true,
            min: 0,
            number: true
        }
    },
    messages: {
        title: "Please enter a title",
        author: "Please enter an author",
        price: {
            required: "Please provide a price",
            min: "Can't be lower than 0",
            number: "Must be a number"
        },
        description: "Please enter a description"
    },
    submitHandler: function(form) {
      $.post(
       'process-book.php',
        $("#submit-book").serialize(),
        function(data){
            if(data == "success") {
              $('#alert').fadeIn();
              populateAdminBooks();
              $('#addBook').modal('hide');
            }
        }
      );
      return false;
    }
  });

  $("#submit-review").validate({
    rules: {
        review: "required"
    },
    messages: {
        review: "Please enter a review"
    },
    submitHandler: function(form) {
      $.post(
       'process-review.php',
        $("#submit-review").serialize(),
        function(data){
            if(data == "success") {
              $('#alert').fadeIn();
              populateReviews();
              $("#addreviewButton").hide();
              $('#addReview').modal('hide');
            }
        }
      );
      return false;
    }
  });

  $("#edit-book-form").validate({
    rules: {
        title: "required",
        author: "required",
        genre: "required",
        description: "required",
        price: {
            required: true,
            min: 0,
            number: true
        }
    },
    messages: {
        title: "Please enter a title",
        author: "Please enter an author",
        genre: "Please enter an genre",
        price: {
            required: "Please provide a price",
            min: "Can't be lower than 0",
            number: "Must be a number"
        },
        description: "Please enter a description"
    },
    submitHandler: function(form) {
      form.submit();
    }
  });

  if ($("#admin-book-list").length>0) {
    populateAdminBooks();
  }

  if ($("#books-list").length>0) {
    populateBooks();
  }

  if ($(".book-previews").length>0) {
    populateHomeBooks();
  }

  if ($(".reviews-list").length>0) {
    populateReviews();
  }

  function populateHomeBooks() {
    $(".book-previews").empty();
    $.ajax({
      url: 'list-books.php',
      data: "",

      dataType: 'json',
      success: function(data) {

        for(var i=0; i<3; i++) {
          var imageURL = data[i]['ImageURL'];
          var id = data[i]['B_Id'];
          var title = data[i]['Title'];
          var description = data[i]['Description'];
          var price = '£'+data[i]['Price'];

          $(".book-previews").append("<div class='span4 clearfix'><h2>"+title+"</h2><img src='"+ imageURL+"' alt='"+ title +"' class='img-polaroid pull-left' /><p>"+description+"</p><p><strong>"+price+"</strong></p><p><a class='btn' href='book.php?id="+ id +"'>More details</a></p></div>");
        }
      }
    });
  }

  function populateBooks() {
    $("#books-list tbody").empty();
    $.ajax({
      url: 'list-books.php',
      data: "",

      dataType: 'json',
      success: function(data) {

        $.each(data, function(index, element) {
          var imageURL = element['ImageURL'];
          var id = element['B_Id'];
          var title = element['Title'];
          var author = element['Author'];
          var genre = element['Genre'];
          var description = element['Description'];
          var price = '£'+element['Price'];

          $("#books-list tbody").append("<tr><td><img src='"+ imageURL+"' alt='"+ title +"' /></td><td>"+ title +"</td><td>"+ author +"</td><td>"+ genre +"</td><td>"+ description +"</td><td>"+ price +"</td><td><a class='btn btn-small btn-info' href='book.php?id="+ id +"'>Read More</a></td></tr>");
        });
      }
    });
  }

  function populateReviews() {
    $(".reviews-list tbody").empty();
    var id = $(".reviews-list").attr("id");
    $.ajax({
      url: 'list-reviews.php?id='+id,
      data: "",

      dataType: 'json',
      success: function(data) {

        $.each(data, function(index, element) {
          var reviewId = element['R_Id'];
          var name = element['Name'];
          var review = element['Review'];
          var rating = element['Rating'];

          $(".reviews-list tbody").append("<tr><td>"+name+"</td><td>"+review+"</td><td>"+rating+"</td></tr>");
        });
      }
    });
  }

  function populateAdminBooks() {
    $("#admin-book-list tbody").empty();
    $.ajax({
      url: 'list-books.php',
      data: "",

      dataType: 'json',
      success: function(data) {

        $.each(data, function(index, element) {
          var imageURL = element['ImageURL'];
          var id = element['B_Id'];
          var title = element['Title'];
          var author = element['Author'];
          var genre = element['Genre'];
          var description = element['Description'];
          var price = element['Price'];
          var downloadURL = element['DownloadURL'];
          $("#admin-book-list tbody").append("<tr><td><img src='"+ imageURL+"' alt='"+ title +"' /><td>"+ id +"</td><td>"+ title +"</td><td>"+ author +"</td><td>"+ genre +"</td><td>"+ description +"</td><td>"+ downloadURL +"</td><td>"+ price +"</td></td><td><a href='edit-book.php?id="+id+"' class='btn btn-small btn-info'>Edit</a></td><td><button href='"+id+"' id='deleteButton' class='btn btn-small btn-danger'>Delete</button></td></tr>");
        });

        $("#deleteButton").click(function(){
          var id = $(this).attr("href");
          console.log(id);
          $('#delete-modal').modal('toggle');
          $('#delete-button').attr('href', "process-book.php?delete="+id);
        });
      }
    });
  }

});