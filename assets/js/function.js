/******************************************************* Function Scripts ****************************************** */
// Contact us 
$('#submitcontactus').on('submit', function (e) {
  e.preventDefault();
  var form = new FormData(this);
  $.ajax({
    url: "ETWeb/baseapi/Api.php/setcontactus",
    method: "POST",
    cache: false,
    contentType: false,
    processData: false,
    data: form,
    success: function (data) {
      var obj = JSON.parse(data);
      if (obj.response == true && typeof obj.message !== 'undefined') {
        sweetalert("Submitted", obj.message, "success", "OK", "");
        $('#submitbooking')[0].reset(); // Reset the form
      } else {
        sweetalert("Invalid", obj.message, "error", "OK", "");
      }
    }
  })
})


// Order 
$('#setorder').on('submit', function (e) {
  e.preventDefault();
  var form = new FormData(this);
  $.ajax({
    url: "ETWeb/baseapi/Api.php/setorder",
    method: "POST",
    cache: false,
    contentType: false,
    processData: false,
    data: form,
    success: function (data) {
      var obj = JSON.parse(data);
      if (obj.response == true && typeof obj.message !== 'undefined') {
        sweetalert("Submitted", obj.message, "success", "OK", "");
        $('#setorder')[0].reset(); // Reset the form
        $("#exampleModal").modal('hide');
      } else {
        sweetalert("Invalid", obj.message, "error", "OK", "");
      }
    }
  });
  return false;
});


// Booking 
$('#submitbooking').on('submit', function (e) {
  e.preventDefault();
  var form = new FormData(this);
  $.ajax({
    url: "ETWeb/baseapi/Api.php/setbook",
    method: "POST",
    cache: false,
    contentType: false,
    processData: false,
    data: form,
    success: function (data) {
      var obj = JSON.parse(data);
      if (obj.response == true && typeof obj.message !== 'undefined') {
        sweetalert("Submitted", obj.message, "success", "OK", "");
        $('#submitbooking')[0].reset(); // Reset the form
      } else {
        sweetalert("Invalid", obj.message, "error", "OK", "");
      }
    }
  });
  return false;
});


// Send OTP
$('#otpregistration').on('submit', function (e) {
  e.preventDefault();
  var form = new FormData(this);
  // get the value of the mobile input in the first form
  var mobileValue = $('#mobile').val();
  // set the value of the mobile input in the second form to the value entered in the first form
  $('#otpverification #mobile').val(mobileValue);
  $.ajax({
    url: "ETWeb/baseapi/Api.php/setuserlogin",
    method: "POST",
    cache: false,
    contentType: false,
    processData: false,
    data: form,
    success: function (data) {
      var obj = JSON.parse(data);
      if (obj.response == true && typeof obj.message !== 'undefined') {
        sweetalert("Submitted", obj.message, "success", "OK", "");
        document.getElementById("otpregistration").style.display = "none";
        document.getElementById("otpverification").style.display = "block";
      } else {
        sweetalert("Invalid", obj.message, "error", "OK", "");
      }
    }
  })
});


// Verify OTP
$('#otpverification').on('submit', function (e) {
  e.preventDefault();
  var form = new FormData(this);
  $.ajax({
    url: "ETWeb/baseapi/Api.php/userlogin",
    method: "POST",
    cache: false,
    contentType: false,
    processData: false,
    data: form,
    success: function (data) {
      var obj = JSON.parse(data);
      if (obj.response == true && typeof obj.message !== 'undefined') {
        sweetalert("Submitted", obj.message, "success", "OK", "reload");
        $('#submitbooking')[0].reset(); // Reset the form
      } else {
        sweetalert("Invalid", obj.message, "error", "OK", "");
      }
    }
  })
})


// Logout
$('#logouthandler').on('click', function (e) {
  $.ajax({
    url: "ETWeb/baseapi/Api.php/userlogout",
    method: "POST",
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      var obj = JSON.parse(data);
      if (obj.response == true && typeof obj.message !== 'undefined') {
        location.reload();
      } else {
        sweetalert("Invalid", obj.message, "error", "OK", "");
      }
    }
  })
})