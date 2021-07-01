<?php
// session_start();
require_once(__DIR__."/core/init.php");
// title of the page and meta desc
$pageTitle = 'register or login';
$metaDesc= 'field to register or to login';
$cssSep = 'reg_login.css';
// load the html-head and header 
require_once("layouts/header.php");
// include_once("register.php");
?>
<!-- site main content -->
  <div class="formContainer">
      <!--login form-->
    <section class="login">
        <h2>sign in</h2>
        <h3>to continue your journey through the woods</h3>
        <p class="login-message"></p>
        <form class="login-form" action="includes/login.php" method="POST">
            <label for="username">Enter your Username</label>
            <input type="text" name="username" id="username">
            <label for="password">Enter your password</label>
            <input type="password" name="password" id="password"><span><i id="togglePslogin" class="eye fas fa-eye-slash"></i></span>
            <input class="submitButton" type="submit" name="login" value="log in">
        </form>   
    </section>
        <h1 class="orH2">or</h1>
        <section class="reg">
            <!-- registration form -->
            <h2>register</h2>
            <h3>to secure your journey through the woods</h3>
            <p class="register-message"></p>
        <form class="register" action="includes/register.php" method="POST">
            <!-- firstname -->
            <label for="regFirstname">please enter your first name</label>
            <input type="text" name="Firstname" id="regFirstname">
            <!-- last name -->
            <label for="regLastname">please enter your last name</label>
            <input type="text" name="Lastname" id="regLastname">
            <!-- last name -->
            <label for="regUsername">please enter your username</label>
            <input type="text" name="Username" id="regUsername">
            <!-- email -->
            <label for="regEmail">please enter your e-mail adress</label>
            <input type="email" name="Email" id="regEmail">
            <!-- password -->
            <label for="regPass">please enter your password</label>
            <input type="password" name="Password" id="regPass"><span><i id="togglePsreg" class="eye fas fa-eye-slash"></i></span>
            <!-- checkbox for agb -->
            <input class="submitButton" type="submit" name="register" value="REGISTER">
        </form>    
        </section>
        <div class="test"></div>
</div>
<script>
$(document).ready(function(){
        // js script for register form 
    $('.login-form').on('submit',function(event){
        event.preventDefault();
        // console.log('trigger');
        // save the form with its attributes and data
        let that = $(this),
            url = that.attr('action'),
            type = that.attr('method'),
            data = {};
        // loop through the post array elements, wich have the name attribute 
        that.find('[name]').each(function(){
            let that = $(this),
                name = that.attr('name'),
                value = that.val();
            // push the elements in Data array to send 
            data[name] = value;
        });
        // console.table(data);
        $.ajax({
            url: url,
            type: type,
            data: data,
            dataType:'json',
        })
        .done(function(response){
            console.log(response);
            // console.log(userid);
            // console.log(typeof response);
            let userid = response.logindata;
            let errors = response.errors;
            // show errormessages 
            if(errors.length > 0){
                let errormessage = "";
                $('.errorMessage').remove();  
                for(error in errors){
                    errormessage += `<p class="errorMessage">${errors[error]}</p> `
                }
            $('.login-message').append(errormessage);  
            }else{
                // delete all errormessages, if everything is okay
                $('.errorMessage').remove();  
            }
            if(userid.length > 0){
                window.location.href = 'profile.php';
            }

        })
    });
        // js script for register form 
    $('.register').on('submit',function(event){
        event.preventDefault();
        // console.log('trigger');
        //save the form with its attributes and data
        let that = $(this),
            url = that.attr('action'),
            type = that.attr('method'),
            data = {};
        // loop through the post array elements, wich have the name attribute 
        that.find('[name]').each(function(){
            let that = $(this),
                name = that.attr('name'),
                value = that.val();
            // push the elements in Data array to send 
            data[name] = value;
        });
        // console.table(data);
        $.ajax({
            url: url,
            type: type,
            data: data,
            dataType: 'json',
        }).done(function(response){
            // console.log(response);
            let errors = response.errors;
            let success = response.success;
            // show error messages if got something
            if(errors.length > 0 ){
                    let errormessage = "";
                    $('.errorMessage').remove();  
                    for(error in errors){
                        errormessage += `<p class="errorMessage">${errors[error]}</p> `
                    }
                $('.register-message').append(errormessage);
            }else{
                $('.errorMessage').remove();
            }
             // if all inputs are good, save inputs in DB
            if(success.length > 0){
                let successmessage = `<p class="successMessage"> ${success[0]} </p>`;
                $('.register-message').append(successmessage);
            }else{
                $('.successMessage').remove();
            }
        });
    });
});

// toggle ps button to show and hide password field
const regPassField = document.querySelector('#regPass')
const loginPassField = document.querySelector('#password')
const toggleBtn = document.querySelector('#togglePsreg')
const toggleBtnLogin = document.querySelector('#togglePslogin')

toggleBtn.addEventListener('click', function(){
    if( regPassField.type ==="password"){
        regPassField.type ="text"
        toggleBtn.classList.remove('fa-eye-slash')
        toggleBtn.classList.add('fa-eye')
    }else{
        regPassField.type ="password"
        toggleBtn.classList.remove('fa-eye')
        toggleBtn.classList.add('fa-eye-slash')
    }
    
})
toggleBtnLogin.addEventListener('click', function(){
    if( loginPassField.type ==="password"){
        loginPassField.type ="text"
        toggleBtnLogin.classList.remove('fa-eye-slash')
        toggleBtnLogin.classList.add('fa-eye')
    }else{
        loginPassField.type ="password"
        toggleBtnLogin.classList.remove('fa-eye')
        toggleBtnLogin.classList.add('fa-eye-slash')
    }
    
})
</script>

<?php
// load the footer and html end
require_once("layouts/footer.php");

?>