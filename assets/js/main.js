//fromWhere: 
//register
//answerPosting
//questionPosting

function loadMoreQuestions(page, length) {
  "use strict";
      $.ajax({
        url: "/question/get_by_page",
        context: document.body,
        type: 'POST',
        dataType: 'json',
        data: {'page' : page, 'length' : length},
        success: function(result) {
          if (result['status'] == 'success') {
            $('#questionsList').append(result['questions']);
            $('#pageFetchAllowed').text('1');
          } else {
            $('#pageEndReached').text('1');
            $('#questionsList').append('<h3><strong>There are no more questions to load</strong></h3>');
          }
        },
        error: function(result) {
          alert(result);
        }
    });
}

window.onload = function() {
  $(window).on('scroll', function(){
      if( $(window).scrollTop() / ($(document).height() - $(window).height()) > 0.9) {
          
          var pageEnd = $('#pageEndReached').text();
          var allowed = $('#pageFetchAllowed').text();
          
          $('#pageFetchAllowed').text('0');
          if (allowed == 1 && pageEnd == 0) {
            var page = parseInt($('#pageIndicator').text(),10);
            loadMoreQuestions(page + 1, 10);
            $('#pageIndicator').text(page + 1);
          }
      }
  });
}

function loginSignUpButtonClick(fromWhere) {
    "use strict";
      $.ajax({ 
        url: "/auth/forms/getForms",
        context: document.body,
        type: 'POST',
        dataType: 'json',
          success: function(result) {

          if(result) {
            $('#registerFormSave').html(result['registerForm']);
            $('#loginFormSave').html(result['loginForm']);

            $('#registerFormSave').attr('style','display:block');
            $('.Reglayer-bg').attr('style','display:block');

              $('#registerSubmitButton').on('click', function() {
                  registerButtonClick(fromWhere);
              });

              $('#loginSubmitButton').on('click', function() {
                  loginButtonClick(fromWhere);
              });

        } else {
            alert("error");
          }
        }
    });
}

function displayLoginForm() {
  "use strict";
  $('#loginFormSave').attr('style','display:block');
  $('#registerFormSave').attr('style','display:none');
}


function reload() {
  "use strict";
  location.reload(true);
}

function loginAfterRegister(fromWhere, email, password) {
  "use strict";

  if (fromWhere == 'register') {
    loginUser(email, password, reload);
  } else if (fromWhere == 'answerPosting') {
    loginUser(email, password, postAnswerToDb);
  } else if (fromWhere == 'questionPosting') {
    loginUser(email, password, postQuestionToDb);
  } else {
    console.log('fromWhere has a different value');
  }
}

function displayRegisterForm() {
  "use strict";
  $('#loginFormSave').attr('style','display:none');
  $('#registerFormSave').attr('style','display:block');
}

function checkValue(elem) {
  "use strict";
  return elem.length != 0;
}

function isValidEmail(email) {
  "use strict";
  var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
  return pattern.test(email);
}

function loginUser(email, password, call) {
  "use strict";

  $.ajax({
        url : "/auth/login/process",
        type : "POST",
        dataType : "json",
        data : {"email" : email, "password" : password},
        success : function(data) {
          
          if (data['status'] == 'failure') {
            $('#loginStatus').text(data['message']);
          } else {
            $('#uid').text(data['uid']);
            console.log('uid', data['uid']);
            call();
          }
        },
        error : function(data) {
            alert(data);
        }
  });
}

function postUserToDb(user, fromWhere, loginAfterReg) {
  "use strict";
  $.ajax({
        url : "/auth/register/process",
        type : "POST",
        dataType : "json",
        data : {"first_name" : user[0],  "last_name" : user[1],
                "email" : user[2], "password" : user[3]},
        success : function(data) {
          var status = data['status'];

          if (status == 'failure') {
            $('#registerStatus').text(data['message']);
          } else {
            $('#uid').text(data['uid']);
            loginAfterReg(fromWhere, user[2], user[3]);
          }
        },
        error : function(data) {
            alert(data);
        }
    });
}


function registerButtonClick(fromWhere) {
  "use strict";

  var firstName = $.trim($('#registerFirstNameField').val());
  var lastName = $.trim($('#registerLastNameField').val());
  var email = $.trim($('#registerEmailField').val());
  var password = $.trim($('#registerPasswordField').val());

  var errorFields = new Array();

  if (!checkValue(firstName)) errorFields.push('First Name');
  if (!checkValue(email) || !isValidEmail(email)) errorFields.push('E-mail');
  if (!checkValue(password) || password.length < 6) errorFields.push('Password');

  var error = errorFields.join(', ');

  if (errorFields.length == 1) error += ' is not valid';
  if (errorFields.length > 1) error += ' are not valid';

  $('#registerStatus').text('');

  if (errorFields.length != 0) {
    $('#registerStatus').text(error);
  } else {
    var user = [firstName, lastName, email, password];
    postUserToDb(user, fromWhere, loginAfterRegister);
  }
}


function loginButtonClick(fromWhere) {
  "use strict";

  var email = $.trim($('#loginEmailField').val());
  var password = $.trim($('#loginPasswordField').val());

  var errorFields = new Array();

  if (!checkValue(email) || !isValidEmail(email)) errorFields.push('E-mail');
  if (!checkValue(password) || password.length < 6) errorFields.push('Password');

  var error = errorFields.join(', ');

  if (errorFields.length == 1) error += ' is not valid';
  if (errorFields.length > 1) error += ' are not valid';

  $('#loginStatus').text('');

  if (errorFields.length != 0) {
    $('#loginStatus').text(error);
  } else {

    if (fromWhere == 'register') {
      loginUser(email, password, reload)
    } else if (fromWhere == 'answerPosting'){
      loginUser(email, password, postAnswerToDb);
    } else if (fromWhere == 'questionPosting') {
      loginUser(email, password, postQuestionToDb);
    }
  }
}


function logoutButtonClick() {
 "use strict";
  $.ajax({
        url : "/auth/SessionController/logout",
        type : "POST",
        success: function(data) {
          location.reload(true);
        }
    }); 
}

function cancelAnswerButton() {
  "use strict";
  $('#answerArea').val('');
}


function postAnswerToDb() {
  "use strict";

  var uid = parseInt($('#uid').text(), 10);
  var text = $.trim($('#answerArea').val());
  var qid = parseInt($('#qid').text(), 10);

  if (uid <= 0) {
    return;
  }

  if (text.length == 0) {
    $('#answerAreaStatus').text('Answer is empty');
    return;
  }

  $.ajax({ 
        url: "/answer/answer/add",
        context: document.body,
        type: 'POST',
        dataType: 'json',
        data : {"uid" : uid, "qid" : qid, "text" : text}, 
        success: function(result) {
          location.reload(true);
        }
    });  
}

function submitAnswerButton() {
  "use strict";
  
  var uid = parseInt($('#uid').text(), 10);  
  var text = $.trim($('#answerArea').val());

  if (text.length == 0) {
    $('#answerAreaStatus').text('Answer is empty');
    return;
  }

  $('#answerAreaStatus').text(' ');
    
  if (uid > 0) {
    postAnswerToDb();
  } else {
    loginSignUpButtonClick('answerPosting');   
  }
}

function closeRegLayer() {
  "use strict";
  $('#loginFormSave').attr('style','display:none');
  $('#registerFormSave').attr('style','display:none');
  $('.Reglayer-bg').attr('style','display:none'); 
}

function displayQuestionContainer() {
  "use strict";
  $('#askQuestionContainer').slideToggle();
}

function postQuestionToDb() {
  "use strict";

  var title = $.trim($('#questionTitle').val());
  var uid = parseInt($('#uid').text(), 10);
  var description = $('#questionDescription').val();
    
  if (uid <= 0) {
    return;
  }

  if (title.length == 0) {
    $('#questionStatusField').text('Title cannot be empty');
    return;
  }

  $.ajax({
    url: "/question/add",
    context: document.body,
    type: 'POST',
    dataType: 'json',
    data: {'title' : title, 'ownerId': uid, 'description' : description},
    success: function(result) {
      window.location = "/question/detail/" + result['qid'];
    },
    error: function(result) {
      alert(result);
    }
  });
}

function postQuestionButtonClick() {
  "use strict";

  var uid = parseInt($('#uid').text(), 10);
  var title = $.trim($('#questionTitle').val());

  if (title.length == 0) {
    $('#questionStatusField').text('Title cannot be empty');
    return;
  }

  $('#questionStatusField').text(' ');
   
  if (uid > 0) {
    postQuestionToDb();
  } else {
    loginSignUpButtonClick('questionPosting');   
  }
}