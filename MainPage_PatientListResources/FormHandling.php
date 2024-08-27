<?php

    /*
        - - - HANDLING THE PATIENT ENTRY FORM - - -
    */
    $FormErrorMsg = "";
    if(isset($_POST['PatientEntryForm'])){

        //Checking if the given AMKA already exists.
        $stmt = $link->prepare("SELECT AMKA FROM patientdata WHERE AMKA = (?)");
        $stmt->bind_param("i", $_POST['Pat_AMKA']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($returnAMKAs);

        $AMKAExists = false;
        if($stmt->fetch() && !$AMKAExists){
            $FormErrorMsg = "The AMKA you input already exists.";
            $AMKAExists = true;
        }

        $stmt->close();

        //If the AMKA does not exist, we proceed with submitting the new patient to the DB.
        if(!$AMKAExists){
            
            $stmt = $link->prepare("INSERT INTO patientdata (FullName, FatherName, AMKA, EnterDate, DoB, TelephoneNum, DocName)
                                    VALUES ((?), (?), (?), (?), (?), (?), (?))");
            $stmt->bind_param("ssissis", $_POST['Pat_FullName'], $_POST['Pat_FatherName'], $_POST['Pat_AMKA'], $_POST['Pat_EnterDate'],
                                                $_POST['Pat_DateOfBirth'], $_POST['Pat_TelephoneNumber'], $_SESSION['DOC_NAME']);
            $stmt->execute();
            $stmt->close();
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    /*
        - - - HANDLING THE PATIENT DETAILS ENTRY FORM - - -
    */
    else if(isset($_POST['PatientDetailsForm'])){

        //Checking if the user input a valid AMKA.
        $stmt = $link->prepare("SELECT AMKA FROM patientdata WHERE AMKA = (?)");
        $stmt->bind_param("i", $_POST['Det_AMKA']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($returnAMKAs);

        $AMKAExists = false;
        if($stmt->fetch() && !$AMKAExists)
            $AMKAExists = true;

        $stmt->close();

        if($AMKAExists){
            //Submitting new data to Operations table.
            if($_POST['DetailsCategory'] == "Operation"){
                
                //Inserting the given date and details about operation, as well as the logged in Doctor, and the patientID corresponding
                //to the patient's AMKA given.
                $stmt = $link->prepare("INSERT INTO operations (`date`, operationDetails, OperationDoc, patientID)
                                        VALUES ((?), (?), (?), 
                                        (SELECT PatientID FROM patientdata WHERE AMKA=(?))
                                        );");
                $stmt->bind_param("sssi", $_POST['Det_EnterDate'], $_POST['Det_Details'], $_SESSION['DOC_NAME'], $_POST['Det_AMKA']);
                $stmt->execute();
                $stmt->close();

            }
            else if($_POST['DetailsCategory'] == "Examination"){
                
                //Inserting the given date and details about examination, as well as the logged in Doctor, and the patientID corresponding
                //to the patient's AMKA given.
                $stmt = $link->prepare("INSERT INTO examinations (`date`, examinationDetails, examinationDoc, patientID)
                                        VALUES ((?), (?), (?), 
                                        (SELECT PatientID FROM patientdata WHERE AMKA=(?))
                                        );");
                $stmt->bind_param("sssi", $_POST['Det_EnterDate'], $_POST['Det_Details'], $_SESSION['DOC_NAME'], $_POST['Det_AMKA']);
                $stmt->execute();
                $stmt->close();

            }
            else if($_POST['DetailsCategory'] == "Prescription"){

                //Inserting the given date and details about operation, as well as the logged in Doctor, and the patientID corresponding
                //to the patient's AMKA given.
                $stmt = $link->prepare("INSERT INTO prescriptions (`date`, prescriptionDetails, prescriptionDoc, patientID)
                                        VALUES ((?), (?), (?), 
                                        (SELECT PatientID FROM patientdata WHERE AMKA=(?))
                                        );");
                $stmt->bind_param("sssi", $_POST['Det_EnterDate'], $_POST['Det_Details'], $_SESSION['DOC_NAME'], $_POST['Det_AMKA']);
                $stmt->execute();
                $stmt->close();

            }
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    /*
        - - - HANDLING THE PATIENT EDIT FORM - - -
    */
    else if(isset($_POST['PatientEditForm'])){

        //Checking to see if the given AMKA exists.
        $stmt = $link->prepare("SELECT AMKA FROM patientdata WHERE AMKA = (?)");
        $stmt->bind_param("i", $_POST['Ed_OldAMKA']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($returnAMKAs);

        $AMKAExists = false;
        if($stmt->fetch())
            $AMKAExists = true;

        $stmt->close();

        //Editing the selecting patient's data.
        $stmt = $link->prepare("UPDATE patientdata 
                                SET FullName = (?),
                                    FatherName = (?),
                                    AMKA = (?),
                                    DoB = (?),
                                    EnterDate = (?),
                                    DischargeDate = (?),
                                    TelephoneNum = (?)
                                WHERE AMKA = (?);");

        $stmt->bind_param("ssisssii", $_POST['Ed_FullName'], $_POST['Ed_FatherName'], $_POST['Ed_AMKA'], $_POST['Ed_DateOfBirth'], 
                                    $_POST['Ed_EntranceDate'], $_POST['Ed_DischargeDate'], $_POST['Ed_TelephoneNumber'], $_POST['Ed_OldAMKA']);
        $stmt->execute();
        $stmt->close();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    /*
        - - - LOGGING OUT - - -
    */
    else if(isset($_POST['LogOut'])){
        session_destroy();
        header('Location: Log_In.php');
        die();
    }

?>