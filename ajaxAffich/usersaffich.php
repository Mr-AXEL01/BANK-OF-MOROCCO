
<?php

@include "../DataBase.php";



$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

            // Check if the 'submit' and 'bankid' are set, indicating that the form is submitted
            if (isset($_POST['users']) && isset($_POST['agencyId'])) {
                $agencyid = $conn->real_escape_string($_POST['agencyId']);


                // Fetch bank details based on the bankid
                $agency_sql = "SELECT * FROM agency WHERE agencyid = '$agencyid'";
                $agency_result = $conn->query($agency_sql);

                if ($agency_result->num_rows > 0) {
                    $agency_row = $agency_result->fetch_assoc();
                    echo "<div class ='flex w-[100%]  justify-center h-[60px] border-[2px] border-white border-solid items-center text-black'>";

                    echo "<p class='border-[2px] border-white border-solid w-[50%] h-[100%] flex items-center  justify-center'>Agence : {$agency_row["agencyname"]}</p>";
                    echo "</div>";
                }

                // Fetch data based on the selected bankid for 'agency'
                $sql = "SELECT users.userid, users.firstName, users.familyName, users.username, agency.agencyid
                FROM users
                INNER JOIN adress ON users.userid = adress.userid
                INNER JOIN agency ON adress.agencyid = agency.agencyid
                WHERE agency.agencyid = '$agencyid' AND users.username LIKE '%$searchTerm%' ORDER BY username ASC";
        




                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<table  class="leading-9 h-[90%] w-[100%] text-center text-black">';
                    echo '<thead>
                            <tr>
                                <th class="border-[2px] border-black border-solid w-[15%]">User Name</th>
                                <th class="border-[2px] border-black border-solid w-[15%]">First Name</th>
                                <th class="border-[2px] border-black border-solid w-[15%]">Family Name</th>
                            
                                <th class="border-[2px] border-black border-solid w-[15%]">Editing</th>
                                <th class="border-[2px] border-black border-solid w-[15%]">Deleting</th>
                                <th class="border-[2px] border-black border-solid w-[15%]">Accounts</th>
                            </tr>
                        </thead>';
                    while ($row = $result->fetch_assoc()) {

                        echo "<tr> 
                                <td class='border-[2px] border-black border-solid w-[15%]'>" . $row["username"] . " </td>
                                <td class='border-[2px] border-black border-solid w-[15%]'> " . $row["firstName"] . "</td>
                                <td class='border-[2px] border-black border-solid w-[15%]'>" . $row["familyName"] . "</td>
                            
                                
                        
                        
                            
                            <td class='border-[2px] border-black border-solid '>
                                <form action='registre.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-blue-700 bg-blue-500 hover:text-white text-white '>
                                <input type='hidden' name='operation' value='" . $row["userid"] . "'>
                                <input type='hidden' name='userid' value='" . $row["userid"] . "'>
                                <input type='submit'  name='editing' value='Edit'>
                            </form>
                            
        
                            
                                </td>
                            <td class='border-[2px] border-black border-solid '>
                            <form action='users.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-red-700 bg-red-500 hover:text-white text-white '>
                            <input type='hidden' name='userid' value='" . $row["userid"] . "'>
                            <input type='submit'  name='deleteuser' value='Delete'>
                        </form>
                        
                                </td>
                                <td class='border-[2px] border-black border-solid '>
                                <form action='agences.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-gray-900 bg-black hover:text-white text-white '>
                                    <input type='hidden' name='userid' value='" . $row["userid"] . "'>
                                    <input type='submit'  name='submit' value='Show'>
                                </form>
                            </td> 
                            </tr>";
                    }
                    echo '</table>';
                } else {
                    echo "<p class='text-center'>0 results</p>";
                }
            } else {
            
            
                $sqlATM = "SELECT * FROM users WHERE username LIKE '%$searchTerm%' ORDER BY username ASC";
                $result2 = $conn->query($sqlATM);

                if ($result2->num_rows > 0) {
                    echo '
                    <table class="leading-9  w-[100%] text-center h-[7vh] items-start text-black" >';
                    echo '<thead>
                    <tr>
                    <th class="border-[2px] border-black border-solid w-[15%]">User Name</th>
                    <th class="border-[2px] border-black border-solid w-[15%]">First Name</th>
                    <th class="border-[2px] border-black border-solid w-[15%]">Family Name</th>
                
                    <th class="border-[2px] border-black border-solid w-[15%]">Editing</th>
                    <th class="border-[2px] border-black border-solid w-[15%]">Deleting</th>
                    <th class="border-[2px] border-black border-solid w-[15%]">Accounts</th>
                </tr>
                        </thead>';
                    while ($row = $result2->fetch_assoc()) {

                        echo "<tr>
                        <td class='border-[2px] border-black border-solid '>" . $row["username"] . " </td>
                        <td class='border-[2px] border-black border-solid '> " . $row["firstName"] . "</td>
                        <td class='border-[2px] border-black border-solid '>" . $row["familyName"] . "</td>


                        
                                <td class='border-[2px] border-black border-solid '>
                                <form action='registre.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-blue-700 bg-blue-500 hover:text-white text-white '>
                                <input type='hidden' name='operation' value='" . $row["userId"] . "'>
                                <input type='hidden' name='userid' value='" . $row["userId"] . "'>
                                <input type='submit'  name='editing' value='Edit'>
                            </form>

                                </td>
                                <td class='border-[2px] border-black border-solid '>
                                <form action='users.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-red-700 bg-red-500 hover:text-white text-white '>
                                <input type='hidden' name='userId' value='" . $row["userId"] . "'>
                                <input type='submit'  name='deleteuser' value='Delete'>
                            </form>
                            
                            </td>
                            <td class='border-[2px] border-black border-solid '>
                            <form action='ajaxAffich/accountaffich.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-gray-900 bg-black hover:text-white text-white '>

                                <input type='hidden' name='userid' value='" . $row["userId"] . "'>
                                <input type='submit' name='submit'  value='Show'>
                                </form>

                                </td>
                            </tr>";
                    }
                    echo '</table>
                    ';
                } else {
                    echo "<p class='text-center'>0 results</p>";
                }
            }
            $conn->close();
            ?>
            