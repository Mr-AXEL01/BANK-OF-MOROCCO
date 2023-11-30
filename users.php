<?php
@include "DataBase.php";



if (isset($_POST['deleteuser']) && isset($_POST['userId'])) {
    $id = $_POST['userId'];


   
    
    $deletetransaction = "DELETE FROM transaction WHERE accountId IN (SELECT accountId FROM account WHERE userId = $id)";
    $conn->query($deletetransaction);
    


    $deleteaaccount = "DELETE FROM account WHERE userId = $id";
    $conn->query($deleteaaccount);
    // Delete associated records in the 'agency' table
    $deleterole = "DELETE FROM roleofuser WHERE userId = $id";
    $conn->query($deleterole);

    $deleteadress = "DELETE FROM adress WHERE userId = $id";
    $conn->query($deleteadress);

    // Delete the record from the 'bank' table
    $deleteuser = "DELETE FROM users WHERE userId = $id";
    $conn->query($deleteuser);
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags and stylesheets go here -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Gestionaire Bancaire</title>
    <style>
        header {
            filter: drop-shadow(4px 4px 5px rgba(255, 255, 255));
            border: 1px white solid;
        }
    </style>
</head>

<body>
    <section class="min-h-[95vh] w-[100vw] bg-gray-100 bg-cover">
    <header class="header sticky w-[100%] top-0 bg-white shadow-md flex items-center justify-between px-8 py-02 z-50 mb-[10vh]	">
            <!-- logo -->
            <a href="" class = "flex items-center font-bold	gap-[7px]">
                <img src="images/cihlogo.png" alt="" class="md:h-[50px] md:w-[140px] h-[35px] w-[90px]">
                ADMIN
            </a>
            <!-- navigation -->
            <nav class="nav font-semibold w-[100%] text-lg">
                <ul class="flex items-center w-[100%] justify-center  ">
                  
                    <li class="p-4 border-b-2 border-blue-500 border-opacity-0 hover:border-opacity-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <select name="clients" id="selectOption" class="outline-none rounded">
                    <option class="font-semibold text-lg" value="Banks">Locations</option>

                        <option class="font-semibold text-lg" value="Banks">Banks</option>
                        <option class="font-semibold text-lg" value="agency">agency</option>
                        <option class="font-semibold text-lg" value="ATM">ATM</option>
                    </select>
                </li>
            
                <li class="p-4 border-b-2 border-blue-500 border-opacity-0 hover:border-opacity-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <select name="clients" id="selectOptions1" class="outline-none rounded">
                    <option class="font-semibold text-lg" value="client">Operations</option>

                        <option class="font-semibold text-lg" value="client">Users</option>
                        <option class="font-semibold text-lg" value="accounts">accounts</option>
                        <option class="font-semibold text-lg" value="transactions">transactions</option>
                    </select>
                    </li>
                    <li class="p-4 border-b-2 border-blue-500 border-opacity-0 hover:border-opacity-100 hover:text-blue-500 duration-200 cursor-pointer">
                    <a href="index.php" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-600 rounded">Log Out</a>
                    </li>
                </ul>
            </nav>
            <!-- buttons --->
         
        </header>


        <div class="flex justify-evenly items-center mb-[50px]">
            <h1 class="text-[50px] h-[10%]  text-center text-black">USERS</h1>
            <a href="registre.php" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-600 rounded">Add USERS</a>

        </div>
        <?php
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
            WHERE agency.agencyid = '$agencyid'";




            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="leading-9 h-[90%] w-[100%] text-center text-black">';
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
            // Handle the case when 'submit' and 'bankid' are not set (initial page load)
            // Fetch data for 'compts' table
            $sqlATM = "SELECT * FROM users";
            $result2 = $conn->query($sqlATM);

            if ($result2->num_rows > 0) {
                echo '<table class="leading-9  w-[100%] text-center h-[7vh] items-start text-black">';
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
                        <form action='Accounts.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-gray-900 bg-black hover:text-white text-white '>

                            <input type='hidden' name='userid' value='" . $row["userId"] . "'>
                            <input type='submit' name='submit'  value='Show'>
                            </form>

                            </td>
                        </tr>";
                }
                echo '</table>';
            } else {
                echo "<p class='text-center'>0 results</p>";
            }
        }
        $conn->close();
        ?>
    </section>

    <footer class="text-center h-[5vh] text-white bg-black flex items-center justify-center">
        <h2>Copyright © 2030 Hashtag Developer. All Rights Reserved</h2>
    </footer>
    <script src="navbar.js">

    </script>

</body>

</html>