<?php
/*Functions used by calendar moved to calendarfunctions to make more readable*/
//Conection details changed for privacy
$con = mysqli_connect(/*"localhost", "usernamehere", "password", "databasename"*/);

/****************User functions****************/

//Checks if username and password match
function validate($username, $password){
    global $con;
    $sql = "SELECT password FROM calendarUsers WHERE username LIKE '$username' AND password LIKE '$password'";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result)>0){
        return true;
    }
    else{
        return false;
    }
}

//Adds a user
function addUser($username, $password, $email){
    global $con;
    if(!userExists($username)){
        $sql = "INSERT INTO calendarUsers VALUES(null, '" . $username . "', '" . $password . "', '" . $email . "', 0)";
        mysqli_query($con, $sql);

        $sql = "ALTER TABLE rsvp ADD COLUMN $username BOOLEAN NOT NULL DEFAULT 0";
        mysqli_query($con, $sql);
        return true;
    }
    else{
        return false;
    }
}

//Checks if username already exists
function userExists($username){
    global $con;
    $sql = "SELECT * FROM calendarUsers WHERE username LIKE '" . $username . "'";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) >0){
        return true;
    }
    else{
        return false;
    }
}

//Transforms username into user id
function getUID($username){
    global $con;
    $sql = "SELECT * FROM calendarUsers WHERE username LIKE '$username'";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            return $row['ID'];
        }
    }
    else{
        return false;
    }
}

//Returns current user information
function fetchUser(){
    session_start();
    global $con;
    $sql ='SELECT * FROM calendarUsers WHERE username like "' . $_SESSION['username'] . '"';

    $result = mysqli_fetch_assoc(mysqli_query($con, $sql));
    return json_encode($result);
}

//Deletes current user account
function deleteAccount(){
    session_start();
    global $con;

    $sql = "ALTER TABLE rsvp DROP COLUMN " . $_SESSION['username'];
    mysqli_query($con, $sql);

    $sql = "DELETE FROM calendarEvents WHERE organizer = " . getUID($_SESSION['username']);
    mysqli_query($con, $sql);

    $sql = "DELETE FROM calendarUsers WHERE username LIKE '" . $_SESSION['username'] . "'";
    mysqli_query($con, $sql);
    session_unset();
    session_destroy();
}

//Changes account details
function editAccount($username, $password, $email){
    session_start();
    if(!userExists($username) || $username == $_SESSION['username']){
        global $con;
        $sql = "UPDATE calendarUsers SET username = '$username', password = '$password', email = '$email' WHERE username LIKE '" . $_SESSION['username'] . "'";
        mysqli_query($con, $sql);

        $sql = "ALTER TABLE rsvp CHANGE " . $_SESSION['username'] . " $username BINARY(1)";
        mysqli_query($con, $sql);
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        return true;
    }
    else{
        return false;
    }
}

/****************RSVP functions****************/

//RSVP's current user to an event
function rsvp($event){
    global $con;
    session_start();
    $username = $_SESSION['username'];
    $sql = "UPDATE rsvp SET $username = 1 WHERE Event LIKE '$event'";
    mysqli_query($con, $sql);

    return mysqli_error($con);
}

//Removes current user from RSVP
function unrsvp($event){
    global $con;
    session_start();
    $username = $_SESSION['username'];
    $sql = "UPDATE rsvp SET $username = 0 WHERE Event LIKE '$event'";
    mysqli_query($con, $sql);

    return mysqli_error($con);
}

//Returns all events user has RSVPed
function fetchRSVPEvents(){
    global $con;
    session_start();
    $sql = "SELECT * FROM rsvp WHERE " . $_SESSION['username'] . " = 1";
    $result = mysqli_query($con, $sql);

    $events = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($events, $row['Event']);
    }

    $eventString = "";

    if(count($events)>1){
        for($x=0; $x < count($events)-1; $x++){
            $eventString .= "'" . $events[$x] . "', ";
        }
    }
    $eventString .= "'" . $events[count($events)-1];

    $sql = "SELECT * FROM calendarEvents WHERE name IN ($eventString')";
    $result = mysqli_query($con, $sql);

    $array = [];
    for($x = 0; $x < mysqli_num_rows($result); $x++){
        $array[$x] = mysqli_fetch_assoc($result);
    }
    return json_encode($array);
}

/****************Event functions****************/

//Returns all events created by current user
function fetchEvents(){
    global $con;
    session_start();

    $sql = "SELECT * FROM calendarEvents WHERE organizer = " . getUID($_SESSION['username']);
    $result = mysqli_query($con, $sql);

    $array = [];
    for($x = 0; $x < mysqli_num_rows($result); $x++){
        $array[$x] = mysqli_fetch_assoc($result);
    }
    return json_encode($array);
}

//Changes event details
function saveEvent($id, $name, $desc, $date, $category){
    global $con;

    $oldName = fetchEventName($id);
    $sql = "UPDATE calendarEvents SET name = '$name', description = '$desc', date = '$date', category = '$category' WHERE ID = '$id'";
    mysqli_query($con, $sql);
    
    $sql = "UPDATE rsvp SET Event = '$name' WHERE Event LIKE '$oldName'";
    mysqli_query($con, $sql);
    return true;
}

//Deletes an event
function deleteEvent($eName){
    global $con;
    $sql = "DELETE FROM rsvp WHERE Event like '$eName'";

    mysqli_query($con, $sql);

    $sql = "DELETE FROM calendarEvents WHERE name like '$eName'";

    mysqli_query($con, $sql);
    return mysqli_error($con);
}

function fetchEventName($id){
    global $con;
    $sql = "SELECT * FROM calendarEvents WHERE ID = $id";
    $result = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($result);

    return $result['name'];
}
