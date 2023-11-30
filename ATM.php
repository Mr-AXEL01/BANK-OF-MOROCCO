<?php
@include "DataBase.php";


// Handle Delete action
if (isset($_POST['deleteATM']) && isset($_POST['delete'])) {
    $id = $_POST['delete'];
    // Delete associated records in the 'atm' table
    $deleteATM = "DELETE FROM atm WHERE atmid = $id";
    if ($conn->query($deleteATM) !== TRUE) {
        echo "Error deleting ATM: " . $conn->error;
    }
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
            <h1 class="text-[50px] h-[10%]  text-center text-black">ATM</h1>
            <a href="addATM.php" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-600 rounded">Add ATM</a>

        </div>
        <?php
        // Check if the 'submit' and 'bankid' are set, indicating that the form is submitted
        if (isset($_POST['submit']) && isset($_POST['bankid'])) {
            $bankid = $conn->real_escape_string($_POST['bankid']);

            // Fetch bank details based on the bankid
            $bank_sql = "SELECT * FROM bank WHERE bankid = '$bankid'";
            $bank_result = $conn->query($bank_sql);

            if ($bank_result->num_rows > 0) {
                $bank_row = $bank_result->fetch_assoc();
                echo "<div class ='flex w-[100%]  justify-center h-[60px] border-[2px] border-black border-solid items-center text-black'>";
                echo "<img class='border-[2px] border-black  border-solid w-[15%] h-[100%] flex items-center  justify-center' src='{$bank_row['logo']}' > ";
                echo "<p class='border-[2px] border-white border-solid w-[85%] h-[100%] flex items-center  justify-center'>Bank : {$bank_row["name"]}</p>";
                echo "</div>";
            }

            // Fetch data based on the selected bankid for 'agency'
            $sql = "SELECT * FROM atm WHERE bankid = '$bankid'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="leading-9 h-[90%] w-[100%] text-center text-black">';
                echo '<thead>
                        <tr>
                            <th class="border-[2px] border-black border-solid w-[20%]">ID</th>
                            <th class="border-[2px] border-black border-solid w-[20%]">Adress</th>
                            <th class="border-[2px] border-black border-solid w-[20%]">Bank Id</th>
                            <th class="border-[2px] border-black border-solid w-[20%]">Edit</th>
                            <th class="border-[2px] border-black border-solid w-[20%]">Delete</th>
                          
                          
                        </tr>
                    </thead>';
                while ($row = $result->fetch_assoc()) {

                    echo "<tr>
                            <td class='border-[2px] border-black border-solid w-[15%]'>" . $row["atmId"] . " </td>
                            <td class='border-[2px] border-black border-solid w-[15%]'> " . $row["adress"] . "</td>
                            <td class='border-[2px] border-black border-solid w-[15%]'>" . $row["bankId"] . "</td>
                           
                            <td class='border-[2px] border-black border-solid w-[15%]'>
                            <form action='addATM.php' method='post'class='height-[100%] cursor-pointer width-[100%] hover:bg-black bg-white hover:text-white text-black'>
                            <input type='hidden' name='operation' value='" . $row["atmId"] . "'>
                            <input type='hidden' name='atmid' value='" . $row["atmId"] . "'>
                            <input type='submit'  name='editing' value='Edit'>
                        </form>
                        
                            </td>
                       
                          
                           <td class='border-[2px] border-black border-solid w-[15%]'>
                                <form action='ATM.php' method='post' class='height-[100%] cursor-pointer width-[100%] hover:bg-black bg-white hover:text-white text-black'>
                                    <input type='hidden' name='delete' value='" . $row["atmId"] . "'>
                                    <input type='submit'  name='deleteATM' value='Delete'>
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
            $sqlATM = "SELECT * FROM atm";
            $result2 = $conn->query($sqlATM);

            if ($result2->num_rows > 0) {
                echo '<table class="leading-9  w-[100%] text-center h-[7vh] items-start text-black">';
                echo '<thead>
                <tr>
                <th class="border-[2px] border-black border-solid w-[15%]">ID</th>
                <th class="border-[2px] border-black border-solid w-[15%]">Adress</th>
                <th class="border-[2px] border-black border-solid w-[15%]">Bank Id</th>
                <th class="border-[2px] border-black border-solid w-[15%]">Edit</th>
                <th class="border-[2px] border-black border-solid w-[15%]">Delete</th>
      
            </tr>
                    </thead>';
                while ($row = $result2->fetch_assoc()) {

                    echo "<tr>
                    <td class='border-[2px] border-black border-solid w-[15%]'>" . $row["atmId"] . " </td>
                    <td class='border-[2px] border-black border-solid w-[15%]'> " . $row["adress"] . "</td>
                    <td class='border-[2px] border-black border-solid w-[15%]'>" . $row["bankId"] . "</td>


                            
                            <td class='border-[2px] border-black border-solid w-[15%]'>
                            <form action='addATM.php' method='post' class = 'h-[5vh]  cursor-pointer width-[150px] hover:bg-blue-700 bg-blue-500 hover:text-white text-black>
                            <input type='hidden' name='operation' value='" . $row["atmId"] . "'>
                            <input type='hidden' name='atmid' value='" . $row["atmId"] . "'>
                            <input type='submit'  name='editing' value='Edit'>
                        </form>
                        
                            </td>
                            <td class='border-[2px] border-black border-solid w-[15%]'>
                            <form action='ATM.php' method='post' class = 'h-[5vh]  cursor-pointer width-[150px] hover:bg-red-700 bg-red-500 hover:text-white text-black>
                                <input type='hidden' name='delete' value='" . $row["atmId"] . "'>
                                <input type='submit'  name='deleteATM' value='Delete'>
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