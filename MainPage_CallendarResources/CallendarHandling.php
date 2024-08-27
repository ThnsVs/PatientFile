<?php 

    /*
        HANDLING THE CALLENDAR
    */
    $Callendar = "";
    //Getting the first day of the current month.
    $firstDay = date('01.' . $_SESSION['Clndr_Month'] . '.' . $_SESSION['Clndr_Year']);
    //echo $firstDay;
    //Getting what day of the week the first day of this month was.
    $firstDayNum = date('w', strtotime($firstDay));
    //0 = Sunday, so we turn it to 7.
    if($firstDayNum == 0)
        $firstDayNum = 7;
    //echo $firstDayNum;
    $dayNum = 1;

    //Beginning the table of the callendar.
    $Callendar .= "
                        <table>
                            <th><button type=\"submit\" class=\"ButtonFill KeyButton\" value=\"Prev\" name=\"Callendar\"><</button></th>
                            <th colspan=\"5\">" . $_SESSION['Clndr_Month'] . ",   " . $_SESSION['Clndr_Year'] . "</th>
                            <th><button type=\"submit\" class=\"ButtonFill KeyButton\" value=\"Next\" name=\"Callendar\">></button></th>
                            <tr>
                                <th class=\"clndrWidth\">Monday</th>
                                <th class=\"clndrWidth\">Tuesday</th>
                                <th class=\"clndrWidth\">Wednesday</th>
                                <th class=\"clndrWidth\">Thursday</th>
                                <th class=\"clndrWidth\">Friday</th>
                                <th class=\"clndrWidth\">Saturday</th>
                                <th class=\"clndrWidth\">Sunday</th>
                            </tr>";



    //Editing the first row of the callendar.
    for($j = 1; $j < 8; $j++){
        if($j < $firstDayNum)
            $Callendar .= "<th class=\"clndrWidth\">-</th>";
        else{
            /*  
                Since the array has been sorted, and we are ascending the days of the month, if we find a day in which the doctor
                has an appointment, we make the button of the day a different color and we remove that day from the $datesArray.
            */
            if($dayNum == $datesArray[0]){
                array_splice($datesArray, 0, 1);
                //Every button has a value of it's date. $dayNum helps pass through the days of the month.
                $Callendar .= "<th class=\"clndrWidth\"><button type=\"submit\" class=\"ButtonFill ActiveDateButton\" value=\"" . $_SESSION['Clndr_Year'] . "-" . $_SESSION['Clndr_Month'] . "-" . 
                                $dayNum . "\" name=\"Callendar\">" . $dayNum . "</th>";
            }
            else{
                $Callendar .= "<th class=\"clndrWidth\"><button type=\"submit\" class=\"ButtonFill InactiveDateButton\" value=\"" . $_SESSION['Clndr_Year'] . "-" . $_SESSION['Clndr_Month'] . "-" . 
                                $dayNum . "\" name=\"Callendar\">" . $dayNum . "</th>";
            }
            $dayNum++;
        }
    }
    $Callendar .= "</tr>";


    //Editing the rest of the callendar.
    while($dayNum <= $monthDays){

        $Callendar .= "<tr>";
        for($j = 0; $j < 7 ; $j++){
            if($dayNum <= $monthDays){

                if($dayNum == $datesArray[0]){
                    array_splice($datesArray, 0, 1);
                    $Callendar .= "<th class=\"clndrWidth\"><button type=\"submit\" class=\"ButtonFill ActiveDateButton\" value=\"" . $_SESSION['Clndr_Year'] . "-" . $_SESSION['Clndr_Month'] . "-" . 
                                    $dayNum . "\" name=\"Callendar\">" . $dayNum . "</th>";
                }
                else{
                    $Callendar .= "<th class=\"clndrWidth\"><button type=\"submit\" class=\"ButtonFill InactiveDateButton\" value=\"" . $_SESSION['Clndr_Year'] . "-" . $_SESSION['Clndr_Month'] . "-" . 
                                    $dayNum . "\" name=\"Callendar\">" . $dayNum . "</th>";
                }
                $dayNum++;
            }
            else{
                $Callendar .= "<th class=\"clndrWidth\">-</th>";
            }
        }

        $Callendar .= "</tr>";
    }

    $Callendar .= "</tr> 
        </table>
        </form>";


    

?>