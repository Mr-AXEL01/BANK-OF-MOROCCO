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
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags and stylesheets go here -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
            <form action="accounts.php" method="post" class="flex items-center mr-[10px]">
                    <input type="text" name="search" placeholder="Search UserName..." class="p-2 border border-gray-300 rounded-md" >
                </form>         
        </header>
        <script src="navbar.js"> </script>


        <div class="flex justify-evenly items-center mb-[50px]">
            <h1 class="text-[50px] h-[10%]  text-center text-black">ACCOUNTS</h1>
            <a href="addaccounts.php" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-600 rounded">ADD ACCOUNTS</a>

        </div>
        <div id="searched">





</div>
    </section>

    <footer class="text-center h-[5vh] text-white bg-black flex items-center justify-center">
        <h2>Copyright © 2030 Hashtag Developer. All Rights Reserved</h2>
    </footer>
    <script>
    function load_data(search = '') {
        $.ajax({
            url: 'ajaxaffich/accountaffich.php',
            type: 'GET',
            data: { search: search },
            success: function(response) {
                $('#searched').html(response);
            }
        });
    }

    $(document).ready(function() {
        load_data(); // Initial data load

        $('input[name="search"]').on('input', function() {
            load_data($(this).val());
        });
    });
</script>

</body>

</html>