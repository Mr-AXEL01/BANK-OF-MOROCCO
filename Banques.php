<?php
@include "DataBase.php";


// Handle Delete action
if (isset($_POST['Deletes']) && isset($_POST['bankid'])) {
    $id = $_POST['bankid'];

    // Delete associated records in the 'agency' table
    $deleteAgencies = "DELETE FROM agency WHERE bankId = $id";
    $conn->query($deleteAgencies);

    $deleteATM = "DELETE FROM atm WHERE bankid = $id";
    $conn->query($deleteATM);

    // Delete the record from the 'bank' table
    $deleteBank = "DELETE FROM bank WHERE bankid = $id";
    $conn->query($deleteBank);
}


?>














<!DOCTYPE html>
<html lang="en">

<head>
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
    <section class="min-h-[95vh] w-[100vw] bg-gray-100  bg-cover">
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
            <h1 class="text-[50px] h-[10%]  text-center text-black">BANKS</h1>
            <a href="addbank.php" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-600 rounded">ADD BANKS</a>

        </div>



        <table class="leading-9 w-[100%]  text-black text-center">
            <thead class="text-black">
                <tr>
                    <th class="border-[2px] border-black border-solid w-[11%]">Logo</th>
                    <th class="border-[2px] border-black border-solid w-[12%]">Bank</th>
                    <th class="border-[2px] border-black border-solid w-[12%]">ID</th>
                    <th class="border-[2px] border-black border-solid w-[12%]">Edit</th>
                    <th class="border-[2px] border-black border-solid w-[12%]">Delete</th>
                    <th class="border-[2px] border-black border-solid w-[12%]">Agences</th>
                    <th class="border-[2px] border-black border-solid w-[12%]">ATM</th>
                </tr>
            </thead>
            <tbody class = "h-[5vh]">
                <?php



                $sql = "SELECT logo, name, bankid FROM bank";
                $result = $conn->query($sql);


                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $id = $row["bankid"];
                        echo "<tr>
                    <td class='border-[2px] border-black border-solid '><img class='h-[33px] w-[200px]' src='" . $row["logo"] . "' alt=''></td>
                    <td class='border-[2px] border-black border-solid '>" . $row["name"] . "</td>
                    <td class='border-[2px] border-black border-solid '>" . $row["bankid"] . "</td>
                    <td class='border-[2px] border-black border-solid '>
                   
                    <form action='addbank.php' method='post' class = 'h-[5vh]  cursor-pointer width-[150px] hover:bg-blue-700 bg-blue-500 rounded-[4px] hover:text-white text-black'>
                    <input type='hidden' name='operation' value='" . $row["bankid"] . "'>
                    <input type='hidden' name='bankid' value='" . $row["bankid"] . "'>
                    <input type='submit'  value='Edit'>
                    
                    </form>
                

                
                </td>
                
                    <td class='border-[2px] border-black border-solid '>
                    <form action='banques.php' method='post' class = 'h-[5vh]  cursor-pointer width-[150px] hover:bg-red-700 bg-red-500 hover:text-white text-black'>
                        <input type='hidden' name='bankid' value='" . $row["bankid"] . "'>
                        <input type='submit'  name='Deletes' value='Delete'>
                    </form>
                </td>
                
                    <td class='border-[2px] border-black border-solid '>
                        <form action='agences.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-gray-900 bg-black hover:text-white text-white '>
                            <input type='hidden' name='bankid' value='" . $row["bankid"] . "'>
                            <input type='submit'  name='submit' value='Agences'>
                        </form>
                    </td>
                    <td class='border-[2px] border-black border-solid '>
                    <form action='ATM.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-gray-900 bg-black hover:text-white text-white '>
                        <input type='hidden' name='bankid' value='" . $row["bankid"] . "'>
                        <input type='submit'  name='submit' value='ATM'>
                    </form>
                </td>
                </tr><br>";
                    }
                } else {
                    // Handle case when there are no rows in the table
                }
                $conn->close();
                ?>
            </tbody>
        </table>




    </section>
    <footer class="text-center h-[5vh] text-white bg-black flex items-center justify-center">
        <h2>Copyright © 2030 Hashtag Developer. All Rights Reserved</h2>
    </footer>
    <script src="navbar.js">

    </script>

</body>

</html>