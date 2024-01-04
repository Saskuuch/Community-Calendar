<?php
/*Calendar uses a lot of functions, so these where separated from modal.php to make it more readable*/ 
//Conection details changed for privacy
$con = mysqli_connect(/*"localhost", "usernamehere", "password", "databasename"*/);

//Creates calendar featured in calendar.php
function createCalendar($date){
    $months = ['January' => 31, 'February' => 28, 'March' => 31, 'April' => 30, 'May' => 31, 'June' => 30, 'July' => 31, 'August' => 31,
    'September' => 30, 'October' => 31, 'November' => 30, 'December' => 31];

    //Calendar headers
    $month = getDate($date->getTimestamp())['month'];
    $calendar = "<h2 style = 'text-align:center;'>$month</h2><table class ='table-bordered' id ='displayCal'><tr><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday
    </th><th>Saturday</th><th>Sunday</th></tr><tr>";

    //Weekdays up to first day in month (empty)
    for($index = 1; $index < getDate($date->getTimestamp())['wday']; $index++){
        $calendar .= "<td class = 'emptyDay'></td>";
    }

    //Calendar body
    $count = getDate($date->getTimestamp())['wday']-1;

    while(getDate($date->getTimestamp())['mday'] < $months[getDate($date->getTimestamp())['month']]){
        if($count % 7 != 0){
            $day = getDate($date->getTimestamp())['mday'];
            $calendar .= "<td class = 'calDay'>$day" . getEvents(date_format($date, 'Y-m-d')) . "</td>";
            $count++;
            date_add($date, date_interval_create_from_date_string('1 day'));
        }
        else{
            $day = getDate($date->getTimestamp())['mday'];
            $calendar .= "</tr><tr><td class = 'calDay'>$day" . getEvents(date_format($date, 'Y-m-d')) . "</td>";
            $count++;
            date_add($date, date_interval_create_from_date_string('1 day'));
        }
    }

    //Last day in month
    $day = getDate($date->getTimestamp())['mday'];
    $calendar .= "<td class = 'calDay'>$day" . getEvents(date_format($date, 'Y-m-d')) . "</td>";
    

    //Remaining days of week not part of month (empty)
    while($count % 7 != 6){
        $calendar .= "<td class = 'emptyDay'></td>";
        $count++;
    }
    
    $calendar .= "</tr></table>";
    return $calendar;
}

//Gets events' names and catagories on a specific day (used by createCalendar)
function getEvents($date){
    global $con;
    
    $sql = "SELECT * FROM calendarEvents WHERE date BETWEEN '$date 00:00:00' AND '$date 23:59:59'";
    $result = mysqli_query($con, $sql);
    $events ='';
    
    while($row = mysqli_fetch_assoc($result)){
        $events .= "<div class = '" . $row['category']. "'><a data-bs-toggle='modal' data-bs-target='#eventDisplay'"  . "data-name = '" . $row['ID'] . "'>" . $row['name'] . "</a></div>";
    }
    return $events;
}

//Adds an event
function addEvent($name, $desc, $date, $category){
    include("modal.php");
    global $con;
    session_start();

    $sql = "INSERT INTO calendarEvents VALUES(null, '$name', '$desc', '" . getUID($_SESSION['username']) . "', '$date', '$category')"; 
    mysqli_query($con, $sql);

    $sql = "INSERT INTO rsvp (Event) VALUES('$name')"; 
    mysqli_query($con, $sql);

    return mysqli_error($con);
}

//Gets event info based on its ID
function getEvent($id){
    global $con;

    $sql = "SELECT * FROM calendarEvents WHERE ID = $id";
    $result = mysqli_query($con, $sql);

    $back = mysqli_fetch_assoc($result);
    $back['rsvp'] = isRSVP($id);
    return $back;
}

//Checks current user has RSVPed an event
function isRSVP($eID){
    global $con;
    $sql = "SELECT * FROM calendarEvents WHERE ID = $eID";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $eName = $row['name'];

    session_start();
    $sql = "SELECT * FROM rsvp WHERE Event like '$eName'";
    $result = mysqli_query($con, $sql);

    return (mysqli_fetch_assoc($result))[$_SESSION['username']];
}
