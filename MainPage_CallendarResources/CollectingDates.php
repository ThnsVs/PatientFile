<?php

    /*
        COLLECTING THE DATES THE USER HAS OPERATIONS/EXAMINATIONS
    */
    //Getting the dates of the operations the doctor has this current month.
    $stmt = $link->prepare("SELECT `date` FROM operations 
                                WHERE operationDoc=(?)
                                AND (`date` BETWEEN (?) AND (?));");
    //Start and end of current month date strings.
    $startDate = $_SESSION['Clndr_Year'] . '-' . $_SESSION['Clndr_Month'] . '-' . '00';
    $endDate = $_SESSION['Clndr_Year'] . '-' . $_SESSION['Clndr_Month'] . '-' . $monthDays;

    $stmt->bind_param("sss", $_SESSION['DOC_NAME'], $startDate, $endDate);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($dates);

    $i = 0;
    $datesArray = [];
    //Creating substrings that will be used for checking which days of the month the doctor has appointments.
    while($stmt->fetch()){
        $datesArray[$i] = substr($dates, -2);
        $i++;
    }
    $stmt->close();
    //Removing duplicate dates.
    $datesArray = array_unique($datesArray);
    sort($datesArray);


    //Getting the dates of the examinations the doctor has this current month.
    $stmt = $link->prepare("SELECT `date` FROM examinations 
                                WHERE examinationDoc=(?)
                                AND (`date` BETWEEN (?) AND (?));");

    $stmt->bind_param('sss', $_SESSION['DOC_NAME'], $startDate, $endDate);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($dates);

    //Creating substrings that will be used for checking which days of the month the doctor has appointments.
    while($stmt->fetch()){
        $datesArray[$i] = substr($dates, -2);
        $i++;
    }
    //Removing duplicate dates.
    $datesArray = array_unique($datesArray);
    sort($datesArray);

?>