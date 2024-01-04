<?php
//Landing control
$modal = "";
//Initial Landing
if(empty($_POST['page'])){
    $modal = "";
    include('signIn.php');
    exit();
}
//Signin Page
elseif($_POST['page'] == 'signIn'){
    if($_POST['command'] == 'signIn'){
        include("modal.php");
        
        if(validate($_POST['username'], $_POST['password'])){
            session_start();
            $_SESSION['username'] = $_POST['username'];
            include("calendar.php");
            exit();
        }
        else{
            $modal = "signIn";
            $signInMessage = "That username or password do not exist";
            include('signIn.php');
            exit();
        }
    }
    elseif($_POST['command']  == 'signUp'){
        include("modal.php");
        if(addUser($_POST['username'], $_POST['password'], $_POST['email'])){
            $modal = "signIn";
            $signInMessage = "Account Created Successfully!";
            include("signIn.php");
            exit();
        }
        else{
            $modal = "signUp";
            $signInMessage = "That username already exists";
            include('signIn.php');
            exit();
        }
    }
    else{
        include('signIn.php');
        $modal = "";
        exit();
    }
}
//Calendar Page
elseif($_POST['page'] == 'calendar'){
    if($_POST['command'] == 'addEvent'){
        include('calendarfunctions.php');
        echo addEvent($_POST['eName'], $_POST['eDesc'], $_POST['eTime'], $_POST['eCatatory']);
        echo('Event Added!');
        exit();
    }
    elseif($_POST['command'] == 'getEvent'){
        include('calendarfunctions.php');
        echo json_encode(getEvent($_POST['id']));
        exit();
    }
    elseif($_POST['command'] == 'addRSVP'){
        include('modal.php');
        rsvp($_POST['eName']);
        exit();
    }
    elseif($_POST['command'] == 'logout'){
        session_start();
        session_unset();
        session_destroy();
        include('signIn.php');
        exit();
    }
    elseif($_POST['command'] == 'events'){
        include('events.php');
        exit();
    }
    elseif($_POST['command'] == 'calendar'){
        include('calendar.php');
        exit();
    }
    elseif($_POST['command'] == 'account'){
        include('account.php');
        exit();
    }
    elseif($_POST['command'] == 'sendRsvp'){
        include('rsvp.php');
        exit();
    }
}
//Events page
elseif($_POST['page'] == 'myEvents'){
    if($_POST['command'] == 'fetchEvents'){
        include("modal.php");
        echo fetchEvents();
    }
    if($_POST['command'] == 'saveEvent'){
        include("modal.php");
        if(saveEvent($_POST['id'], $_POST['eName'], $_POST['eDesc'], $_POST['eTime'], $_POST['eCatatory'])){
            echo "Event Saved";
        }
        else{
            echo "There was an error saving your event";
        }
        exit();
    }
    elseif($_POST['command'] == 'deleteEvent'){
        include('modal.php');
        echo deleteEvent($_POST['eName']);
        exit();
    }
    elseif($_POST['command'] == 'logout'){
        session_start();
        session_unset();
        session_destroy();
        include('signIn.php');
        exit();
    }
    elseif($_POST['command'] == 'calendar'){
        include('calendar.php');
        exit();
    }
    elseif($_POST['command'] == 'events'){
        include('events.php');
        exit();
    }
    elseif($_POST['command'] == 'account'){
        include('account.php');
        exit();
    }
    elseif($_POST['command'] == 'sendRsvp'){
        include('rsvp.php');
        exit();
    }
}
//rsvp Page
elseif($_POST['page'] == 'rsvp'){
    if($_POST['command'] == 'logout'){
        session_start();
        session_unset();
        session_destroy();
        include('signIn.php');
        exit();
    }
    elseif($_POST['command'] == 'calendar'){
        include('calendar.php');
        exit();
    }
    elseif($_POST['command'] == 'events'){
        include('events.php');
        exit();
    }
    elseif($_POST['command'] == 'account'){
        include('account.php');
        exit();
    }
    elseif($_POST['command'] == 'sendRsvp'){
        include('rsvp.php');
        exit();
    }
    elseif($_POST['command'] == 'fetchEvents'){
        include('modal.php');
        echo fetchRSVPEvents();
        exit();
    }
    elseif($_POST['command'] == 'unrsvp'){
        include('modal.php');
        echo UnRSVP($_POST['id']);
        exit();
    }
}
//account page
elseif($_POST['page'] == 'account'){
    if($_POST['command'] == 'logout'){
        session_start();
        session_unset();
        session_destroy();
        include('signIn.php');
        exit();
    }
    elseif($_POST['command'] == 'calendar'){
        include('calendar.php');
        exit();
    }
    elseif($_POST['command'] == 'events'){
        include('events.php');
        exit();
    }
    elseif($_POST['command'] == 'account'){
        include('account.php');
        exit();
    }
    elseif($_POST['command'] == 'sendRsvp'){
        include('rsvp.php');
        exit();
    }
    elseif($_POST['command'] == 'fetchUser'){
        include('modal.php');
        echo fetchUser();
        exit();
    }
    elseif($_POST['command'] == 'deleteAccount'){
        include('modal.php');
        deleteAccount();        
        include("signIn.php");
        exit();
    }
    elseif($_POST['command'] == 'editAccount'){
        include('modal.php');
        echo editAccount($_POST['username'], $_POST['password'], $_POST['email']);
        exit();
    }
}
//If something breaks, go back to signin
else{
    include("signIn.php");
    exit();
}
?>