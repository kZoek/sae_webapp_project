<?php
require_once("core/init.php");
// echo $_SESSION['status'];
// title of the page and meta desc
$pageTitle = 'profile';
$metaDesc = 'landing page';
$cssSep = 'profile.css';
// load the html-head and header 
require_once("layouts/header.php");
// if the session id from login is activ, show the profile
if($_SESSION['userId']){
    $id=  $_SESSION['userId'];
    /**
     * fetchSingle and fetchAll awaits 2 parameters
     * @param $query -> query wich should be executed
     * @param $params -> array, with parameters for prepared statements
     */
    $user = $content->fetchSingle("SELECT * FROM `users` WHERE id = :id",['id'=> $id]);
?>
<!-- site main content -->
<h2 class="smTitle">Welcome back Player!</h2>
    <section class="about">
        <!-- infos about the player -->
        <div class="profileinfos">
            <!-- container for personal infos -->
            <div class="card">
                <h3>personal informations</h3>
                <span class="card-title"> first name </span>
                <p><?=$user['first_name']?></p> 
                <span class="card-title"> last name </span>
                <p><?=$user['last_name']?></p>
            </div>
            <!-- container for ingame infos -->
            <div class="card">
                <h3>ingame informations</h3>
                <span class="card-title"> username </span>
                <p><?=$user['username']?></p>
                <span class="card-title"> Score </span>
                <p><?=$user['score']?></p>
            </div>
            <!-- container for contact infos -->
            <div class="card">       
                <h3>contact informations</h3>
                <span class="card-title"> Email address </span>
                <p><?=$user['email']?></p>
            </div>
        </div>
        <form class="edit-profile hiddenmenu" action="includes/edit_profile.php" method="POST">
            <div class="card">
                <h3>personal informations</h3>
                <span class="card-title"> first name </span>
                <label class="card-title" for="firstname"><input type="text" name="firstname" value="<?=$user['first_name']?>"></label>
                <span class="card-title"> last name </span>
                <label class="card-title" for="lastname"><input type="text" name="lastname"value="<?=$user['last_name']?>"></label> 
            </div>
            <div class="card">
                <h3>ingame informations</h3>
                <span class="card-title"> username </span>
                <label for="username"><input type="text" name="username" value="<?=$user['username']?>"></label>
            </div>
            <div class="card">       
                <h3>contact informations</h3>
                <span class="card-title"> Email address </span>
                <label for="email"><input type="email" name="email" value="<?=$user['email']?>"></label>
            </div>
            <div class="card">       
                <h3>change password</h3>
                <span class="card-title"> enter old password: </span>
                <label for="oldpassword"><input type="password" name="oldpassword"></label>
                <span class="card-title"> enter new password: </span>
                <label for="new password"><input type="password" name="new_password"></label>
            </div>
            <p class="profile-messages"></p>
            <input id="saveProfile" class="submitButton" type="submit" value="save changes">
        </form>
        <button class="editButton"> <i class="fas fa-user-edit"></i></button>
    </section>

    <script>
        $(document).ready(function(){
            // variables for html-elements
            const button = $('.editButton');
            const editForm = $('.edit-profile');
            const showInfos = $('.profileinfos');
            // toggle class for elements, on click
            $(button).click(function(){
                // console.log('yay');
                $(editForm).toggleClass('hiddenmenu');
                $(showInfos).toggleClass('hiddenmenu');
                $(button).toggleClass('hiddenmenu');
            })
            // send data from form to backend with ajax
            $('.edit-profile').on('submit',function(e){
                e.preventDefault();
                // console.log('yay');
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
                // ajax function to get response from backend
                $.ajax({
                    url: url,
                    type: type,
                    data: data,
                    dataType:'json',
                }).done(function(response){
                    // console.log(response);
                    let errors = response.errors;
                    let success = response.success;
                    // console.log(response.errors)
                    // console.log(response.success)
                    // if there are errors, show these
                    if(errors.length > 0 ){
                        let errormessage = "";
                        $('.errorMessage').remove();  
                        for(error in errors){
                            errormessage += `<p class="errorMessage">${errors[error]}</p> `
                        }
                        $('.profile-messages').append(errormessage);
                    }else{
                        $('.errorMessage').remove();
                    }
                    // if all inputs are good, save changes in DB and reload page
                    if(success.length > 0){
                        let successmessage = `<p class="successMessage"> ${success[0]} </p>`;
                        $('.profile-messages').append(successmessage);
                        location.reload(10);
                    }else{
                        $('.successMessage').remove();
                    }
                });
            })

         
        })
    </script>
<?php
} else{ 
    // if the userid from session is not valid or active, go to login page
header('location: register_login.php');
}
// load the footer and html end
require_once("layouts/footer.php");
?>