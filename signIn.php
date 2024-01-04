<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
    .container{ 
        position:fixed; 
        background-color:white;
        border:black solid 2px;
        border-radius:15px;
        z-index: 3;
    }
    #inmodal{
        width:300px; 
        height:500px;
        top:calc(50% - 250px); 
        left:calc(50% - 150px);
    }
    #upmodal{
        width:300px; 
        height:600px;
        top:calc(50% - 300px); 
        left:calc(50% - 150px);
    }
    a:hover{
        cursor:pointer;
    }

</style> 
<!--Signup modal-->
    <div class = "container" id ="upmodal" style = "display:none;">
    <h2 style = "text-align:center;">Community Calendar Sign Up</h2>
        <form action = 'controller.php' class = "form" method = 'post' style = "padding: 30px;">
            <input type = "hidden" name = "page" value = "signIn">
            <input type = "hidden" name = "command" value = "signUp">
            <label for = "username">Username</label>
            <input type = "text" name = "username" id = "u1" class = "form-control" required placeholder = "Enter Username">
            <br><br>
            <label for = "email">Email Address:</label>
            <input type = "email" name = "email" class = "form-control" required placeholder = "example@test.com">
            <br><br>
            <label for = "password">Password</label>
            <input type = "password" name = "password" class = "form-control" required placeholder = "Enter Password">
            <label for = "password2">Re-enter Password</label>
            <input type = "password" name = "password2" class = "form-control" required placeholder = "Re-enter Password">

            <br>
            <a class = "link-primary" id = "signInButton"><p style = "text-align:center;">Already have an account?<br> Sign In!</p></a>

            <button type = "submit" class = "btn btn-primary" style = "position: absolute; bottom:30px; right:30px;">Sign Up</button>
        </form>
    </div>

    <!--Signin modal-->
    <div class = "container" id ="inmodal">
    <h2 style = "text-align:center;">Community Calendar Sign In</h2>
        <form action = 'controller.php' class = "form" method = 'post' style = "padding: 30px;">
            <input type = "hidden" name = "page" value = "signIn">
            <input type = "hidden" name = "command" value = "signIn">
            <label for = "username">Username</label>
            <input type = "text" name = "username" class = "form-control" required placeholder = "Enter Username">
            <br><br>
            <label for = "password">Password</label>
            <input type = "password" name = "password" class = "form-control" required placeholder = "Enter Password">

            <br>
            <a class = "link-primary" id = "signUpButton"><p style = "text-align:center;">Don't have an account?<br> Sign Up!</p></a>

            <button type = "submit" class = "btn btn-primary" style = "position: absolute; bottom:30px; right:30px;">Sign In</button>
        </form>
    </div>

    <script>
        //Handles which modal should be displayed
        <?php
        global $modal;
        if($modal == "signUp"){
            echo "displaySignUp();";
            echo "window.alert('" . $signInMessage . "');";
        }
        elseif($modal == "signIn"){
            echo "displaySignIn();";
            echo "window.alert('" . $signInMessage . "');";
        }
        ?>

        //For changing modals
        $("#signUpButton").click(displaySignUp);
        $("#signInButton").click(displaySignIn);

        function displaySignIn(){
            $("#inmodal").show();
            $("#upmodal").hide();
        }

        function displaySignUp(){
            $("#upmodal").show();
            $("#inmodal").hide();
        }
    </script>
</html>
