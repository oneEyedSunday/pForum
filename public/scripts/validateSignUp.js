      function checkname(){
        var name = document.getElementById("UserName").value;
        if(name){
          $.ajax({
            type: 'post',
            url: 'helpers/checkdata.php',
            data:{
              user_name: name,
            },
            success: function(response){
              $(".name_status").html(response);
              if(response == "OK"){
                $("div.name_status").css({"display": "none"});
                return true;
              }else{
                $("div.name_status").css({"display": "block", "text-align":"center"});
                return false;
              }
            }
          });
        }else{
          $(".name_status").html("");
          return false;
        }
      } 

      function checkemail(){
        var email = document.getElementById("UserEmail").value;
        if(email){
          $.ajax({
            type: 'post',
            url: 'helpers/checkdata.php',
            data:{
              user_email : email,
            },
            success: function(response){
              $(".email_status").html(response);
              if(response == "OK"){
                $("div.email_status").css({"display":"none"});
                return true;
              }else{
                $("div.email_status").css({"display":"block", "text-align": "center"});
                return false;
              }
            }
          });
        }else{
          $(".email_status").html("");
          return false;
        }
      }
      function checkall(){
        var namehtml = document.getElementsByClassName("name_status")[0].innerHTML;
        var emailhtml = document.getElementsByClassName("email_status")[0].innerHTML;
        if((namehtml && emailhtml) == "OK"){
          return true;
        }else{
          return false;
        }
      }


      function checkpass(){
        var p = document.getElementById("password").value;
        if(document.getElementById("cpassword").value == p){
          $(".password_status").html("OK");
          $("div.password_status").css({"display": "none"});
          return true;
        }else{
          $(".password_status").html("Passwords don't match");
          $("div.password_status").css({"display":"block","text-align":"center"});
          return false;
        }
      }

      function checklen(){
        var p = document.getElementById("password").value;
        if( (p.length > 0) && (p.length < 6)){
          $(".password_length").html("Password must be greater than 5 xters");
          $("div.password_length").css({"display":"block","text-align":"center"});
          return false;
        }else{
          $(".password_length").html("OK");
          $("div.password_length").css({"display":"none"});
          return true;
        }
      }