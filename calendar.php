<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        table{
            width:80%;
            margin:auto;
        }
        td{
            height:125px;
            width:14.3%;
            vertical-align:top;
        }
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
        .Clubs{
            background-color:#1dab43;
            border-radius:7px;
            text-decoration:underline;
            padding:2px 2px 2px 5px;
            margin:2px;
        }
        .Workshops{
            background-color:#db0909;
            border-radius:7px;
            text-decoration:underline;
            padding:2px 2px 2px 5px;
            margin:2px;
        }
        .Festivals{
            background-color:#fc8312;
            border-radius:7px;
            text-decoration:underline;
            padding:2px 2px 2px 5px;
            margin:2px;
        }
        .Kids{
            background-color:#eb10d1;
            border-radius:7px;
            text-decoration:underline;
            padding:2px 2px 2px 5px;
            margin:2px;
        }
        .Arts{
            background-color:#8110eb;
            border-radius:7px;
            text-decoration:underline;
            padding:2px 2px 2px 5px;
            margin:2px;
        }
        .Sports{
            color:white;
            background-color:#102aeb;
            border-radius:7px;
            text-decoration:underline;
            padding:2px 2px 2px 5px;
            margin:2px;
        }
    </style>

<!--For moving beteen pages-->
    <form style = 'display:none;' id = 'logout' action='controller.php' method='post'>
        <input type = 'hidden' name = 'page' value = 'calendar'>
        <input type = 'hidden' name = 'command' id = 'command' value = 'logout'>
    </form>

    <!--Navigaion menu-->
    <h1 style = "text-align:center;">Community Calendar</h1>
    <div class = "dropdown" id="menu">
        <a  class = "" data-bs-toggle = "dropdown" style = "font-size:3em;"><i class="bi bi-list"></i></a>
        <ul class = 'dropdown-menu'>
            <li><a>Calendar</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id = 'myEventsButt'>My Events</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id = 'rsvpButt'>I'm Going</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id = 'accountButt'>Account</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a id = 'logoutButt'>Logout</a></li>
        </ul>
    </div>

    

    <!--Calendar-->
    <div class = "container">
        <?php
        include("calendarfunctions.php");
        $date = getDate();
        $date = date_create($date['year'] . '-' . $date['mon'] . '-1');
        echo createCalendar($date);
        ?>
    </div>

    <!--Catagory Filter-->
    <br>
    <div style = 'text-align:center'>
        <div class='form-check form-check-inline'>
            <input type = "checkbox" id ='clubsCheck' class = 'form-check-input' value='clubs' checked>
            <label class = 'form-check-label'>Clubs</label>
        </div>
        <div class='form-check form-check-inline'>
            <input type = "checkbox" id ='workCheck' class = 'form-check-input' value='work' checked>
            <label class = 'form-check-label'>Workshops</label>
        </div>
        <div class='form-check form-check-inline'>
            <input type = "checkbox" id ='festCheck' class = 'form-check-input' value='festivals' checked>
            <label class = 'form-check-label'>Festivals</label>
        </div>
        <div class='form-check form-check-inline'>
            <input type = "checkbox" id ='kidsCheck' class = 'form-check-input' value='kids' checked>
            <label class = 'form-check-label'>Kids</label>
        </div>
        <div class='form-check form-check-inline'>
            <input type = "checkbox" id ='artsCheck' class = 'form-check-input' value='arts' checked>
            <label class = 'form-check-label'>Arts</label>
        </div>
        <div class='form-check form-check-inline'>
            <input type = "checkbox" id ='sportsCheck' class = 'form-check-input' value='sports' checked>
            <label class = 'form-check-label'>Sports</label>
        </div>
    </div>

    <!--Button for adding event-->
    <a data-bs-toggle="modal" data-bs-target="#addModal" style = 'position:fixed; font-size:4em; left: 92%; bottom: 50px;'><i class="bi bi-plus"></i></a>

    <!--Modal for adding an event-->
    <div class = "modal" id = "addModal" role="dialog">
        <div class = "modal-dialog">
            <div class = "modal-content"><br>
                <h4 class = "modal-title" style = 'text-align:center;'>Add an Event</h4>
                <div class = "modal-body">

                <form id = 'addEventForm'>
                    <input type = 'hidden' name = 'page' value = 'calendar'>
                    <input type = 'hidden' name = 'command' value = 'addEvent'>
                    <label for='eName' class = 'form-label'>Event Name:</label>
                    <input type = 'text' name = 'eName' class='form-control' maxlength='50' required>

                    <label for='eDesc' class = 'form-label'>Description:</label>
                    <textarea name = 'eDesc' class='form-control' rows='5' maxlength='300' required></textarea>

                    <label for='eTime' class = 'form-label'>Time:</label>
                    <input type = 'datetime-local' name = 'eTime' class='form-control' style='width:50%;' required>

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
                <button type = "submit" class = "btn btn-primary" id = "subButton" style = "position:absolute; left:10px;" form = 'addEventForm'>Add Event</button>
                    <button type = "button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal for displaying event details-->
    <div class = 'modal' id ='eventDisplay'>
        <div class = "modal-dialog">
            <div class = "modal-content"><br>
            <h4 class = "modal-title" style = 'text-align:center;' id = 'eTitle'>Event Title</h4>
                <div class = 'modal-content'>
                    <br>
                    <label for = 'eventDesc' class = 'form-label' style = 'font-weight:bold;'>Description:</label>
                    <textarea name = 'eventDesc' id = 'eventDesc' type = 'text' rows ='5' style ="resize:none;" class = 'form-control' readonly></textarea>

                    <br>
                    <label for = 'eventTime' class = 'form-label' style = 'font-weight:bold;'>Time</label>
                    <input class = 'form-control' readonly id = 'eventTime' name = 'eventTime'></input>
                    <div class = "modal-footer">
                        <button type = "button" class="btn btn-default" id = 'rsvp'>RSVP</button>
                        <button type = "button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <script>
        //Add and event function
        $('#subButton').click(function(event){
            event.preventDefault();
            if(document.getElementById("addEventForm").checkValidity()){
                console.log($("#addEventForm").serialize());
                $.post('controller.php', String($("#addEventForm").serialize()), function(data, status){
                    alert(data);
                    location.reload();
                });
            }
        });

        //Display functionality to events
        $("#displayCal a").click(function(){
            $.post('controller.php', "page=calendar&command=getEvent&id=" + $(this).attr('data-name'), function(data){
                let array = JSON.parse(data);
                console.log(array);
                $("#eTitle").text(array['name']);
                $("#eventDesc").val(array['description']);
                $("#eventTime").val(array['date']);

                if(array['rsvp'] == 1){
                    $("#rsvp").html("RSVP <i class='bi bi-check'></i>");
                }
                else{
                    $("#rsvp").html("RSVP");
                }
            });
        });

        //RSVP on button click
        $("#rsvp").click(function(){
            $.post('controller.php', "page=calendar&command=addRSVP&eName=" + $("#eTitle").text(), function(){
                $("#rsvp").html("RSVP <i class='bi bi-check'></i>");
            });
        });

        //Menu navigation buttons
        $("#logoutButt").click(function(){
            $("#logout").submit();
        });
        $("#myEventsButt").click(function(){
            $("#command").val('events');
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

        //Filter boxes
        $("#clubsCheck").click(function(){
            if(this.checked){
                $(".Clubs").show();
            }
            else{
                $(".Clubs").hide();
            }
        });
        $("#sportsCheck").click(function(){
            if(this.checked){
                $(".Sports").show();
            }
            else{
                $(".Sports").hide();
            }
        });
        $("#artsCheck").click(function(){
            if(this.checked){
                $(".Arts").show();
            }
            else{
                $(".Arts").hide();
            }
        });
        $("#festCheck").click(function(){
            if(this.checked){
                $(".Festivals").show();
            }
            else{
                $(".Festivals").hide();
            }
        });
        $("#kidsCheck").click(function(){
            if(this.checked){
                $(".Kids").show();
            }
            else{
                $(".Kids").hide();
            }
        });

        //Unused
        function checkValidity(){
            let form = document.getElementById('addEventForm');
            let result = true;
            if(form['eName'].value == ''){
                this.
                result = false;
            }
            if(form['eDesc'].value == ''){
                result = false;
            }
            if(form['eTime'].value == ''){
                result = false;
            }
            return result;
        }
    </script>
</html>
<?php

?>