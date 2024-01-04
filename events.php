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
    <h1 style='text-align:center;'>My Events</h1>

    <!--Used for navigation-->
    <form style = 'display:none;' id = 'logout' action='controller.php' method='post'>
        <input type = 'hidden' name = 'page' value = 'myEvents'>
        <input type = 'hidden' name = 'command' id = 'command' value = 'logout'>
    </form>

    <!--Navigation menu-->
    <div class = "dropdown" id="menu">
        <a  class = "" data-bs-toggle = "dropdown" style = "font-size:3em;"><i class="bi bi-list"></i></a>
        <ul class = 'dropdown-menu'>
            <li><a id = 'calendar'>Calendar</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id = 'myEventsButt'>My Events</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id='rsvpButt'>I'm Going</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id='accountButt'>Account</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id = 'logoutButt'>Logout</a></li>
        </ul>
    </div>

    <!--Events-->
    <div id = 'events' class = 'container'>
    </div>

    <!--Edit event modal-->
    <div class = "modal" id = "addModal" role="dialog">
        <div class = "modal-dialog">
            <div class = "modal-content"><br>
                <h4 class = "modal-title" style = 'text-align:center;'>Edit an Event</h4>
                <div class = "modal-body">
                    <form id = 'addEventForm'>
                        <input type = 'hidden' name = 'page' value = 'myEvents'>
                        <input type = 'hidden' name = 'command' id='command2' value = 'saveEvent'>
                        <input type = 'hidden' name = 'id' id = 'id' value = 'saveEvent'>
                        <label for='eName' class = 'form-label'>Event Name:</label>
                        <input type = 'text' name = 'eName' id = 'eName' class='form-control' maxlength='50' required>

                        <label for='eDesc' class = 'form-label'>Description:</label>
                        <textarea name = 'eDesc' class='form-control' rows='5' maxlength='300' required></textarea>

                        <label for='eTime' class = 'form-label'>Time:</label>
                        <input type = 'datetime-local' name = 'eTime' id ='eTime' class='form-control' style='width:50%;' required>

                        <label for='eCatagory' class = 'form-label'>Catagory:</label>
                        <select name = 'eCatatory' class='form-select' style = 'width:50%;' required>
                            <option value = 'Clubs'>Clubs</option>
                            <option value = 'Workshops'>Workshops</option>
                            <option value = 'Festivals'>Festivals</option>
                            <option value = 'Kids'>Kids</option>
                            <option value = 'Arts'>Arts</option>
                            <option value = 'Sports'>Sports</option>
                        </select>
                    </form>
                </div>
                <div class = "modal-footer">
                    <button type = "submit" class = "btn btn-primary" id = "subButton" style = "position:absolute; left:10px;" form = 'addEventForm'>Save Event</button>
                    <button type = "button" class = "btn btn-danger" id = "deleteButton" style = "position:absolute; left:150px;" form = 'addEventForm'>Delete Event</button>
                    <button type = "button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        //Fetches user's events and displays as table
        $.post('controller.php', "page=myEvents&command=fetchEvents", function(data){
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
                table += "<td><a class = 'btn btn-primary' data-bs-toggle='modal' data-bs-target='#addModal' data-rowid = '" + events[x]['ID'] + "'>Edit</a></td>";
                table +="</tr>";
            }
            table += "</table>";

            $("#events").html(table);

                //Adds functionality to all buttons attatched to events
                $("#eventTable td a").click(function(){
                $.post('controller.php', "page=calendar&command=getEvent&id=" + $(this).attr('data-rowid'), function(data){
                    let array = JSON.parse(data);
                
                    console.log(array);
                    $("#id").val(array['ID']);
                    $("#eName").val(array['name']);
                    $("#addEventForm textarea").val(array['description']);
                    $("#eTime").val(array['date']);
                    $("#addEventForm select").val(array['category']);
                });
            });
        });

        //Saves edited event
        $("#subButton").click(function(){
            event.preventDefault();
            if(document.getElementById("addEventForm").checkValidity()){
                console.log($("#addEventForm").serialize());
                $.post('controller.php', String($("#addEventForm").serialize()), function(data, status){
                    alert(data);
                    location.reload();
                });
            }
        });

        //Deletes Event
        $("#deleteButton").click(function(){
            if(document.getElementById("addEventForm").checkValidity()){
                if(confirm("Delete Event?")){
                    $("#command2").val("deleteEvent");
                    console.log($("#addEventForm").serialize());
                    $.post('controller.php', String($("#addEventForm").serialize()), function(data, status){
                        // alert(data);
                        location.reload();
                    });
                }
            }
        });

        //Navigation Functions
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
</html>

