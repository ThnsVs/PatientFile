<?php

    //Beginning our session.
    require_once('GeneralResources/Session_config.php');
    //Handling errors.
    require_once('GeneralResources/ErrorHandling_Config.php');


    //Checking to see if someone entered the page without logging in.
    if(!isset($_SESSION['ID'])){
        header('Location: Log_In.php');
        die();
    }

    //Connecting to the patientfile DB.
    require_once('GeneralResources/connPatientFile.php');

    //Logging out.
    if(isset($_POST['LogOut'])){
        session_destroy();
        header('Location: Log_In.php');
        die();
    }

    //Getting the current month and year the callendar is displaying.
    if(!isset($_SESSION['Clndr_Month']))
        $_SESSION['Clndr_Month'] = date('m', strtotime(date('d.m.y')));
    
    if(!isset($_SESSION['Clndr_Year']))
        $_SESSION['Clndr_Year'] = 2000 + date('y', strtotime(date('d.m.y')));
    

    //Finding out how many days the current month has.
    //Arrays that hold which months have 31 and 30 days.
    $month31 = [1, 3, 5, 7, 8, 10, 12];
    $month30 = [4, 6, 9, 11];

    //Holding how many days the month we are working with has.
    $monthDays = 0;   

    //Checking to see if the month has 31 days.
    for($i = 0; $i < count($month31) && ($monthDays == 0); $i++){
        if($_SESSION['Clndr_Month'] == $month31[$i]){
            $monthDays = 31;
        }
    }
    //If we haven't found what month we have is, we check to see if the month has 30 days.
    if(($monthDays == 0)){
        for($i = 0; $i < count($month30) && ($monthDays == 0); $i++){
            if($_SESSION['Clndr_Month'] == $month30[$i]){
                $monthDays = 30;
            }
        }
    }
    //If we still haven't found our month, it's february, and we check to see if it has 28 or 29 days.
    if(($monthDays == 0)){
        if(($_SESSION['Clndr_Year'] % 4) == 0){
            $monthDays = 29;
        }
        else if(($_SESSION['Clndr_Year'] % 4) != 0){ 
            $monthDays = 28;
        }
    }

    //Collecting date information.
    require_once('MainPage_CallendarResources/CollectingDates.php');
    
    //Handling the Callendar form's interactions.
    require_once('MainPage_CallendarResources/CallendarInteractions.php');

    //Handling the display of the callendar on the page.
    require_once('MainPage_CallendarResources/CallendarHandling.php');

    $link->close();

?>



<!DOCTYPE HTML>
<html lang="en">
    <head>

        <title>Login Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="MainPage_CallendarResources/MainPage_Callendar5.css">
        <script src="MainPage_CallendarResources/MainPage_Callendar1.js"></script>

    </head>

    <body>

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="MainPage_PatientList.php">Patient List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="MainPage_Callendar.php">Callendar</a>
                </li>
                </ul>
            </div>
            <div  class="navbarNav1">
                <form class="form-inline" id="LogOut" name="LogOut" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit" name="LogOut">Log Out</button>
                </form>
            </div>
        </nav>

        <h3>Logged in as: <?php echo htmlspecialchars($_SESSION['DOC_NAME']);?></h3>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="CalDiv">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" name="Callendar">
                        <?php echo $Callendar; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="CalDiv">
                        <?php echo $appointmentsTable;?>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $a;?>

    </body>

</html>