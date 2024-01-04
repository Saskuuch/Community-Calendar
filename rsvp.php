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
    <h1 style='text-align:center;'>RSVP</h1>

    <!--For navigation-->
    <form style = 'display:none;' id = 'logout' action='controller.php' method='post'>
        <input type = 'hidden' name = 'page' value = 'myEvents'>
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
            <li><a id = "rsvpButt">I'm Going</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id='accountButt'>Account</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id = 'logoutButt'>Logout</a></li>
        </ul>
    </div>

    <!--Events-->
    <div id = 'events' class = 'container'>
    </div>

<script>
    //Creates and populates events
    $.post('controller.php', "page=rsvp&command=fetchEvents", function(data){
        if(data != ""){
            let events = JSON.parse(data);
            let table = "<table class = 'table table-striped' id='eventTable'>";
            table += "<tr>";
            for(y in events[0]){
                if(y != 'organizer' && y != 'ID'){
                        table += "<th>" + y + "</th>";
                    }
                }
                table += "<th></th></tr>";
            for(x = 0; x<events.length; x++){
                table += "<tr>";
                for(y in events[x]){
                    if(y != 'organizer' && y != 'ID'){
                        table += "<td>" + events[x][y] + "</td>";
                    }
                }
                table += "<td><a class = 'btn btn-primary' data-rowid = '" + events[x]['name'] + "'>UnRSVP</a></td>";
                table +="</tr>";
            }
            table += "</table>";

            $("#events").html(table);

                $("#eventTable td a").click(function(){
                    if(confirm("Remove RSVP?")){
                    $.post('controller.php', "page=rsvp&command=unrsvp&id=" + $(this).attr('data-rowid'), function(data){
                        location.reload();
                    });
                }
            });
        }
    });

    //Functions for navigation
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
    $("#accountButt").click(function(){
        $("#command").val('account');
        $("#logout").submit();
    });
    $("#rsvpButt").click(function(){
        $("#command").val('sendRsvp');
        $("#logout").submit();
    });
    </script>
</html