<?php

    /*
        - - - SETTING UP THE PATIENTS TABLE
    */
    //Retrieving data from patients of current doctor.
    $stmt = $link->prepare("SELECT FullName, FatherName, AMKA, DoB, TelephoneNum, EnterDate, DischargeDate, PatientID FROM patientdata WHERE DocName = (?)");
    $stmt->bind_param("s", $_SESSION['DOC_NAME']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($FullName, $FatherName, $AMKA, $DoB, $TelephoneNum, $EnterDate, $DischargeDate, $PatientID);
    
    //Creating patient table.
    $table = "  <form name=\"PatientDetails\" method=\"post\" action=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "\">
                <table>
                <tr>
                    <th>Name</th>
                    <th>Father's Name</th>
                    <th>AMKA</th>
                    <th>Date of Birth</th>
                    <th>Tel. Number</th>
                    <th>Entrance Date</th>
                    <th>Discharge Date</th>
                    <th>Details</th>
                </tr>";

    //Filling it up.
    $patientIdArray = array();
    $i = 0;
    while($stmt->fetch()){
        $table .= "<tr><td>" . htmlspecialchars($FullName) . "</td>";
        $table .= "<td>" . htmlspecialchars($FatherName) . "</td>";
        $table .= "<td>" . htmlspecialchars($AMKA) . "</td>";
        $table .= "<td>" . htmlspecialchars($DoB) . "</td>";
        $table .= "<td>" . htmlspecialchars($TelephoneNum) . "</td>";
        $table .= "<td>" . htmlspecialchars($EnterDate) . "</td>";
        $table .= "<td>" . htmlspecialchars($DischargeDate) . "</td>";
        $table .= "<td><div class=\"d-grid gap-2\">
                    <button type=\"submit\" class=\"btn btn-primary\" name=\"DetailsButton" . $PatientID . "\"
                    >+</button></div></td>"; 
        $patientIdArray[$i] = $PatientID;
        $i++;
    }
    $table .= "</table></form>";
    $stmt->close();

    //Used for ending loops.
    $endLoop = false;
    //Used to create the details field.
    $opDetails = $exDetails = $prDetails = "";

    //Collecting patient's details.
    for($j = 0; $j < $i && !$endLoop; $j++){
        $postButton = "DetailsButton" . $patientIdArray[$j];
        if(isset($_POST[$postButton])){

            //Retrieving  operation details about the patient.
            $stmt2 = $link->prepare("SELECT operationDetails, `date` FROM operations WHERE patientID = (?)");
            $stmt2->bind_param("i", $patientIdArray[$j]);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($patOperations, $opDate);
            while($stmt2->fetch()){
                $opDetails .= "[" . htmlspecialchars($opDate) . "] " . htmlspecialchars($patOperations);
                $opDetails .= "<br>";
            }
            $stmt2->close();

            //Retrieving examination details about the patient.
            $stmt2 = $link->prepare("SELECT examinationDetails, `date` FROM examinations WHERE patientID = (?)");
            $stmt2->bind_param("i", $patientIdArray[$j]);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($patExaminations, $exDate);
            while($stmt2->fetch()){
                $exDetails .= "[" . htmlspecialchars($exDate) . "] " . htmlspecialchars($patExaminations);
                $exDetails .= "<br>";
            }
            $stmt2->close();

            //Retrieving prescription details about the patient.
            $stmt2 = $link->prepare("SELECT prescriptionDetails, `date` FROM prescriptions WHERE patientID = (?)");
            $stmt2->bind_param("i", $patientIdArray[$j]);
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result($patPrescriptions, $prDate);
            while($stmt2->fetch()){
                $prDetails .= "[" . htmlspecialchars($prDate) . "] " . htmlspecialchars($patPrescriptions);
                $prDetails .= "<br>";
            }
            $stmt2->close();
            
            $endLoop = true;

        }
    }
    
    //Setting up the details field.
    $detailsField = "<div class=\"DetailsWrap\"  style=\"white-space: nowrap;\">
                        <div class=\"ButtonsWrap\">
                            <button class=\"btn btn-secondary\" id=\"Btn1\" onclick=\"showContentt(1)\" name=\"Operations\" style=\"white-space: nowrap;\" onclick=\"\">Operations</buttton>
                            <button class=\"btn btn-secondary\" id=\"Btn2\" onclick=\"showContentt(2)\"name=\"Examinations\" style=\"white-space: nowrap;\" onclick=\"\">Examinations</buttton>
                            <button class=\"btn btn-secondary\" id=\"Btn3\" onclick=\"showContentt(3)\"name=\"Prescriptions\" style=\"white-space: nowrap;\" onclick=\"\">Prescriptions</buttton>
                        </div>
                            <div class=\"FieldWrap\">
                                <p id=\"Content1\" hidden>" . $opDetails . "</p>
                                <p id=\"Content2\" hidden>" . $exDetails . "</p>
                                <p id=\"Content3\" hidden>" . $prDetails . "</p>
                            </div>
                    </div>";

?>