<?php

    /*
        HANDLING CALLENDAR INTERACTIONS.
    */
    $appointmentsTable = "";

    if(isset($_POST['Callendar'])){

        //If the user chose to see the next month:
        if($_POST['Callendar'] == "Next"){
            if($_SESSION['Clndr_Month'] < 12)
                $_SESSION['Clndr_Month']++;
            else{
                $_SESSION['Clndr_Month'] = 1;
                $_SESSION['Clndr_Year']++;
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }//If the user chose to see the previous month:
        else if($_POST['Callendar'] == "Prev"){
            echo $_POST['Callendar'];
            if($_SESSION['Clndr_Month'] > 1)
                $_SESSION['Clndr_Month']--;
            else{
                $_SESSION['Clndr_Month'] = 12;
                $_SESSION['Clndr_Year']--;
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }//If the user clicked anything else on the callendar.
        else{

            //Reading which date button the user clicked on.
            $dateSelected = $_POST['Callendar'];

            //Handling the appointments table.
            $appointmentsTable = "<table class=\"AppntmtTbl\">
                                    <tr> 
                                        <th class=\"AppRow\">Date</th>
                                        <th class=\"AppRow\">Appointment</th>
                                        <th class=\"AppRow\">Details</th>
                                        <th class=\"AppRow\">Patient's Name</th>
                                        <th class=\"AppRow\">AMKA</th>
                                    </tr>";
            
            //Requesting to know the date, details, the patient's full name and the patient's AMKA about the day's appointment.
            $stmt = $link->prepare('SELECT operations.date, operations.operationDetails, patientdata.FullName, patientdata.AMKA
                                        FROM operations
                                        LEFT JOIN patientdata ON operations.patientID=patientdata.PatientID
                                        WHERE operations.date = (?) AND operations.operationDoc=(?);');
            $stmt->bind_param('ss', $dateSelected, $_SESSION['DOC_NAME']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($opDate, $opDetails, $opFullName, $opAMKA);

            while($stmt->fetch()){
                $appointmentsTable .=  "<tr> 
                                            <td class=\"AppRowDate\">[" . htmlspecialchars($opDate) . "]</td>
                                            <td class=\"AppRowOper\">Operation</td>
                                            <td class=\"AppRowDetails\">" . htmlspecialchars($opDetails) . "</td>
                                            <td class=\"AppRowFullName\">" . htmlspecialchars($opFullName) . "</td>
                                            <td class=\"AppRowAMKA\">" . htmlspecialchars($opAMKA) .  "</td>
                                        </tr>";
            }
            $stmt->close();


            //Requesting to know the date, details, the patient's full name and the patient's AMKA about the day's appointment.
            $stmt = $link->prepare('SELECT examinations.date, examinations.examinationDetails, patientdata.FullName, patientdata.AMKA
                                        FROM examinations
                                        LEFT JOIN patientdata ON examinations.patientID=patientdata.PatientID
                                        WHERE examinations.date = (?) AND examinations.examinationDoc=(?);');
            $stmt->bind_param('ss', $dateSelected,  $_SESSION['DOC_NAME']);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($opDate, $opDetails, $opFullName, $opAMKA);

            while($stmt->fetch()){
            $appointmentsTable .=  "<tr> 
                            <td class=\"AppRowDate\">[" . htmlspecialchars($opDate) . "]</td>
                            <td class=\"AppRowOper\">Examination</td>
                            <td class=\"AppRowDetails\">" . htmlspecialchars($opDetails) . "</td>
                            <td class=\"AppRowFullName\">" . htmlspecialchars($opFullName) . "</td>
                            <td class=\"AppRowAMKA\">" . htmlspecialchars($opAMKA) .  "</td>
                        </tr>";
            }
            $appointmentsTable .= "</table>";

        }
    }

?>