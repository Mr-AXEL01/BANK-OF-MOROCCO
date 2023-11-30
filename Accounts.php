<?php
@include "DataBase.php";


// Handle Delete action
if (isset($_POST['deleteaccount']) && isset($_POST['delete'])) {
    $id = $_POST['delete'];

    // Delete associated records in the 'agency' table
    $deletetransaction = "DELETE FROM transaction WHERE accountid = $id";
    if ($conn->query($deletetransaction) !== TRUE) {
        echo "Error deleting address: " . $conn->error;
    }

    // Delete the record from the 'agency' table
    $deleteAccounts = "DELETE FROM account WHERE accountid = $id";
    if ($conn->query($deleteAccounts) !== TRUE) {
        echo "Error deleting agency: " . $conn->error;
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
            <h1 class="text-[50px] h-[10%]  text-center text-black">ACCOUNTS</h1>
            <a href="addaccounts.php" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-600 rounded">ADD ACCOUNTS</a>

        </div>
        <?php
        // Check if the 'submit' and 'bankid' are set, indicating that the form is submitted
        if (isset($_POST['submit']) && isset($_POST['userid'])) {
            $userid = $conn->real_escape_string($_POST['userid']);

            // Fetch bank details based on the bankid
            $user_sql = "SELECT * FROM users WHERE userid = '$userid'";
            $user_result = $conn->query($user_sql);

            if ($user_result->num_rows > 0) {
                $user_row = $user_result->fetch_assoc();
                echo "<div class ='flex w-[100%]  justify-center h-[60px] border-[2px] border-black border-solid items-center text-black'>";
                echo "<p class='border-[2px] border-black border-solid w-[85%] h-[100%] flex items-center  justify-center'>Username : {$user_row["username"]}</p>";
                echo "<p class='border-[2px] border-black border-solid w-[85%] h-[100%] flex items-center  justify-center'>first Name : {$user_row["firstName"]}</p>";
                echo "<p class='border-[2px] border-black border-solid w-[85%] h-[100%] flex items-center  justify-center'>family Name : {$user_row["familyName"]}</p>";
                echo "</div>";
            }

            // Fetch data based on the selected bankid for 'agency'
            $sql = "SELECT * FROM `account` WHERE userid = '$userid'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="leading-9 h-[90%]  w-[100%] text-center text-black">';
                echo '<thead>
                        <tr>
                            <th class="border-[2px] border-black border-solid w-[15%] ">ID</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">RIB</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Balance</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Edit</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Delete</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Transactions</th>
                        </tr>
                    </thead>';
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td class='border-[2px] border-black border-solid '>" . $row["accountId"] . " </td>
                            <td class='border-[2px] border-black border-solid '>" . $row["RIB"] . "  MAD</td>
                            <td class='border-[2px] border-black border-solid '> " . $row["balance"] . " </td>

                         
                               

                            <td class='border-[2px] border-black border-solid '>
                            <form action='addaccounts.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-blue-700 bg-blue-500 hover:text-white text-white '>
                            <input type='hidden' name='operation' value='" . $row["accountId"] . "'>
                            <input type='hidden' name='accountid' value='" . $row["accountId"] . "'>
                            <input type='submit'  name='editing' value='Edit'>
                        </form>
                        
                            </td>
                            <td class='border-[2px] border-black border-solid '>
                            <form action='accounts.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-red-700 bg-red-500 hover:text-white text-white '>
                                <input type='hidden' name='delete' value='" . $row["accountId"] . "'>
                                <input type='submit'  name='deleteaccount' value='Delete'>
                            </form>
                        </td>
                        <td class='border-[2px] border-black border-solid '>
                        <form action='transactions.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-gray-900 bg-black hover:text-white text-white '>

                            <input type='hidden' name='accountid' value='" . $row["accountId"] . "'>
                            <input type='submit' name='submit'  value='Show'>
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
            $sqlall = "SELECT * FROM `account`";
            $result2 = $conn->query($sqlall);

            if ($result2->num_rows > 0) {
                echo '<table class="leading-9  w-[100%] text-center h-[7vh] items-start text-black">';
                echo '<thead>
                        <tr>
                        <th class="border-[2px] border-black border-solid w-[15%] ">ID</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">RIB</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Balance</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Edit</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Delete</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Transaction</th>
                        </tr>
                    </thead>';
                while ($row = $result2->fetch_assoc()) {

                    echo "<tr>
                    <td class='border-[2px] border-black border-solid '>" . $row["accountId"] . " </td>
                    <td class='border-[2px] border-black border-solid '> " . $row["RIB"] . "</td>
                    <td class='border-[2px] border-black border-solid '> " . $row["balance"] . "  MAD</td>


                    
                               

                            <td class='border-[2px] border-black border-solid '>
                            <form action='addaccounts.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-blue-700 bg-blue-500 hover:text-white text-white '>
                            <input type='hidden' name='operation' value='" . $row["accountId"] . "'>
                            <input type='hidden' name='accountid' value='" . $row["accountId"] . "'>
                            <input type='submit'  name='editing' value='Edit'>
                        </form>
                        
                            </td>
                            <td class='border-[2px] border-black border-solid '>
                            <form action='accounts.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-red-700 bg-red-500 hover:text-white text-white '>
                                <input type='hidden' name='delete' value='" . $row["accountId"] . "'>
                                <input type='submit'  name='deleteaccount' value='Delete'>
                            </form>
                        </td>

                        <td class='border-[2px] border-black border-solid '>
                    <form action='transactions.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-gray-900 bg-black hover:text-white text-white '>

                        <input type='hidden' name='accountid' value='" . $row["accountId"] . "'>
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