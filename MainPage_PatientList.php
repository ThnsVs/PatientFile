<?php

    //Handling errors.
    require_once('GeneralResources/ErrorHandling_Config.php');
    //Beginning our session.
    require_once('GeneralResources/Session_config.php');

    //Checking to see if someone entered the page without logging in.
    if(!isset($_SESSION['ID'])){
        header('Location: Log_In.php');
        die();
    }
    
    //Connecting to the patientfile DB.
    require_once("GeneralResources/connPatientFile.php");
    
    //Handling page's forms.
    require_once("MainPage_PatientListResources/FormHandling.php");
    //Handling the patients' table.
    require_once("MainPage_PatientListResources/PatientTableDisplay.php");

    $link->close();

?>

<!DOCTYPE HTML>
<html lang="en">
    <head>

        <title>Login Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="MainPage_PatientListResources/MainPage_PatientList1.css">
        <script src="MainPage_PatientListResources/MainPage_PatientList1.js"></script>

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

        <div class="container w-100 h-100 pt-1 ">
            <div class="row">
                <div class="col-8">
                    <!-- Patient List -->
                    <?php echo $table;?>    
                </div>
                <div class="col-3">    
                    <!-- Patient details field -->     
                    <?php echo $detailsField;?>
                </div>
            </div>

            <div class="row">
                <div class="col-7">
                    
                    <!--Patient Entry Button -->
                    <div class="buttonWrapper">
                        <button type="button" id="PatientEntryButton" class="btn btn-success" onclick="showForm(1);">New Patient</button>
                        <button type="button" id="PatientDetailsEntryButton"  class="btn btn-success" onclick="showForm(2);">Patient Details</button>
                        <button type="button" id="PatientDetailsEntryButton"  class="btn btn-success" onclick="showForm(3);">Edit Patient's File</button>
                    </div>
                    <p class="warning"><?php echo htmlspecialchars($FormErrorMsg);?></p>

                </div>
            </div>

            <div class="row">
                <div class="col-12">

                    <!-- PATIENT ENTRY FORM -->
                    <div id="PatEntDiv" class="FormWrapper">
                        <form id="PatientEntryForm" name="PatientEntryForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                            <div class="mb-3">
                                <label for="Pat_FullName" class="form-label">Patient's full name</label>
                                <input type="text" class="form-control" id="Pat_FullName" name="Pat_FullName" required>
                            </div>
                            <div class="mb-3">
                                <label for="Pat_FatherName" class="form-label">Patient's Father's name</label>
                                <input type="text" class="form-control" id="Pat_FatherName" name="Pat_FatherName" required>
                            </div>
                            <div class="mb-3">
                                <label for="Pat_AMKA" class="form-label">Patient's AMKA</label>
                                <input type="number" class="form-control" id="Pat_AMKA" name="Pat_AMKA" required>
                            </div>
                            <div class="mb-3">
                                <label for="Pat_EnterDate" class="form-label">Entrance Date</label>
                                <input type="date" class="form-control" id="Pat_EnterDate" name="Pat_EnterDate" required>
                            </div> 
                            <div class="mb-3">
                                <label for="Pat_DateOfBirth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="Pat_DateOfBirth" name="Pat_DateOfBirth" required>
                            </div>
                            <div class="mb-3">
                                <label for="Pat_TelephoneNumber" class="form-label">Telephone Number</label>
                                <input type="number" class="form-control" id="Pat_TelephoneNumber" name="Pat_TelephoneNumber" required>
                            </div>
                            <button type="submit" name="PatientEntryForm" id="PatientEntryForm" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                    <!-- PATIENT DETAILS ENTRY FORM -->
                    <div id="PatDetDiv" class="FormWrapper">
                        <form id="PatientDetailsForm" name="PatientDetailsForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                            <div class="mb-3">
                                <label for="Det_AMKA" class="form-label">Patient's AMKA</label>
                                <input type="number" class="form-control" id="Det_AMKA" name="Det_AMKA" required>
                            </div>
                            <div class="mb-3">
                                <label for="DetailsCategory" class="form-label">Details Category</label>
                                <select name="DetailsCategory" class="form-select">
                                    <option value="Operation">Operation</option>
                                    <option value="Examination">Examination</option>
                                    <option value="Prescription">Prescription</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Det_EnterDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="Det_EnterDate" name="Det_EnterDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="Det_Details" class="form-label">Details</label>
                                <textarea class="form-control" id="Det_Details" rows="3" name="Det_Details" required></textarea>
                            </div>
                            <button type="submit" name="PatientDetailsForm" id="PatientDetailsForm" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                    <!-- EDIT PATIENT FORM -->
                    <div id="PatEdDiv" class="FormWrapper">
                        <form id="PatientEditForm" name="PatientEditForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                            <div class="mb-3">
                                <label for="Ed_OldAMKA" class="form-label">Old Patient's AMKA</label>
                                <input type="number" class="form-control" id="Ed_OldAMKA" name="Ed_OldAMKA" required>
                            </div>
                            <div class="mb-3">
                                <label for="Ed_FullName" class="form-label">New Patient's full name</label>
                                <input type="text" class="form-control" id="Ed_FullName" name="Ed_FullName" required>
                            </div>
                            <div class="mb-3">
                                <label for="Ed_FatherName" class="form-label">New Patient's Father's name</label>
                                <input type="text" class="form-control" id="Ed_FatherName" name="Ed_FatherName" required>
                            </div>
                            <div class="mb-3">
                                <label for="Ed_AMKA" class="form-label">New Patient's AMKA</label>
                                <input type="number" class="form-control" id="Ed_AMKA" name="Ed_AMKA" required>
                            </div>
                            <div class="mb-3">
                                <label for="Ed_DateOfBirth\" class="form-label">New Date of Birth</label>
                                <input type="date" class="form-control" id="Ed_DateOfBirth" name="Ed_DateOfBirth" required>
                            </div>
                            <div class="mb-3">
                                <label for="Ed_EntranceDate" class="form-label">New Entrance Date</label>
                                <input type="date" class="form-control" id="Ed_EntranceDate" name="Ed_EntranceDate" required>
                            </div> 
                            <div class="mb-3">
                                <label for="Ed_DischargeDate" class="form-label">Discharge Date</label>
                                <input type="date" class="form-control" id="Ed_DischargeDate" name="Ed_DischargeDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="Ed_Telephone Number" class="form-label">New Telephone Number</label>
                                <input type="number" class="form-control" id="Ed_Telephone Number" name="Ed_Telephone Number" required>
                            </div>
                            <button type="submit" name="PatientEditForm" id="PatientEditForm" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>









    </body>
</html>