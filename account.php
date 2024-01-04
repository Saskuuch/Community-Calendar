<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
    #menu{
            position:fixed;
            right:30px;
            top:30px;
        }
    li{
            text-align:center;
        }
    a:hover{
            cursor:pointer;
        }
    a{
            color:black;
        }
</style>


<br><br>

<!--Navigation form-->
    <form style = 'display:none;' id = 'logout' action='controller.php' method='post'>
        <input type = 'hidden' name = 'page' value = 'account'>
        <input type = 'hidden' name = 'command' id = 'command' value = 'logout'>
    </form>

    <!--Navigation Menu-->
    <div class = "dropdown" id="menu">
        <a  class = "" data-bs-toggle = "dropdown" style = "font-size:3em;"><i class="bi bi-list"></i></a>
        <ul class = 'dropdown-menu'>
            <li><a id = 'calendar'>Calendar</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id = 'myEventsButt'>My Events</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id='rsvpButt'>I'm Going</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a>Account</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id = 'logoutButt'>Logout</a></li>
        </ul>
    </div>

    <!--Modal for editing account details-->
    <div class = "container" id ="upmodal" style = "">
    <h2 style = "text-align:center;">My Account</h2>
        <form action = 'controller.php' class = "form" id = 'accountForm' method = 'post' style = "padding: 30px;">
            <input type = "hidden" name = "page" value = "account">
            <input type = "hidden" name = "command" value = "editAccount">
            <label for = "username">Username</label>
            <input type = "text" name = "username" id = "u1" class = "form-control" required placeholder = "Enter Username">
            <br><br>
            <label for = "email">Email Address:</label>
            <input type = "email" name = "email" id='email' class = "form-control" required placeholder = "example@test.com">
            <br><br>
            <label for = "password">Password</label>
            <input type = "password" name = "password" id='password1' class = "form-control" required placeholder = "Enter Password">
            <label for = "password2">Re-enter Password</label>
            <input type = "password" name = "password2" id='password2' class = "form-control" required placeholder = "Re-enter Password">

            <br>
            
            <button type = 'button' class = "btn btn-danger" id="deleteButt" style = "position: absolute; bottom:30px; right:30px;">Delete Account</button>
            <button type = "submit" class = "btn btn-primary" id = 'subButt' style = "position: absolute; bottom:30px; left:30px;">Save Account Settings</button>
        </form>
    </div>


    <script>
        //Navigation functions
        $("#logoutButt").click(function(){
            $("#logout").submit();
        });
        $("#myEventsButt").click(function(){
            $("#command").val('events');
            $("#logout").submit();
        });
        $("#calendar").click(function(){
            $("#command").val('calendar');
            $("#logout").submit();
        });
        $("#rsvpButt").click(function(){
            $("#command").val('sendRsvp');
            $("#logout").submit();
        });

        //To populate user information
        $.post('controller.php', "page=account&command=fetchUser", function(data){
            data = JSON.parse(data);
            $("#u1").val(data['username']);
            $("#email").val(data['email']);
            $("#password1").val(data['password']);
            $("#password2").val(data['password']);
        });

        //Saves changes to account
        $("#subButt").click(function(event){
            event.preventDefault();

            if(document.getElementById("accountForm").checkValidity()){
                $.post('controller.php', $("#accountForm").serialize(), function(data){
                    if(data){
                        alert("Account Saved Successfully");
                        location.reload();
                    }
                    else{
                        alert("Account not saved successfully");
                    }
                });
            }
        });

        //Deletes account
        $("#deleteButt").click(function(){
            if(confirm("Are you sure you want to delete your account?")){
                $("#command").val('deleteAccount');
                $("#logout").submit();
            }
        });   
</script>
</html>

