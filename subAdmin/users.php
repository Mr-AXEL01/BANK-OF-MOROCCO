


 <?php
 session_start();

    @include "DataBase.php";

// if($_SESSION['user_type'] !== 'subAdmin'){

//     header("Location: index.php");

// }

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

    <body class ="bg-gray-100  bg-cover">
            <header class="header sticky w-[100%] top-0 bg-white shadow-md flex items-center justify-between px-8 py-02 z-50 	">
            <a href="" class="flex items-center font-bold text-blue-950	gap-[7px]">
                <img src="images/CentralLogo.png" alt="" class="md:h-[60px] md:w-[150px] h-[35px] w-[90px]">
                ADMIN
            </a>
                <nav class="nav font-semibold w-[100%] text-lg">
                    <ul class="flex items-center w-[100%] justify-center  ">

                 

                        <li class="p-4 border-b-2 border-blue-500 border-opacity-0 hover:border-opacity-100 hover:text-blue-500 duration-200 cursor-pointer">
                            <select name="clients" id="selectOptions1" class="outline-none rounded">
                                <option class="font-semibold text-lg" value="client">Operations</option>

                                <option class="font-semibold text-lg" value="client">Users</option>
                                <option class="font-semibold text-lg" value="accounts">accounts</option>
                                <option class="font-semibold text-lg" value="transactions">transactions</option>
                            </select>
                        </li>
                        <li class="p-4 border-b-2 border-red-500 border-opacity-0 hover:border-opacity-100 hover:text-red-500 duration-200 cursor-pointer">
                        <a href="index.php" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Log Out</a>
                    </li>
                    </ul>
                </nav>
                <form action="users.php" method="post" class="flex items-center mr-[10px]">
                    <input type="text" name="search" placeholder="Search UserName..." class="p-2 border border-gray-300 rounded-md" >
                </form>
            </header>
            <script src="navbar.js">

            </script>

            <div class="flex justify-evenly items-center mb-[50px]">
                <h1 class="text-[50px] h-[10%]  text-center text-black">USERS</h1>
                <a href="registre.php" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-blue-600 rounded">Add USERS</a>

            </div>
            <section class="min-h-[75vh]">

            <div id="searched">





            </div>
        </section>

        <footer class="text-center h-[5vh] text-white bg-black flex items-center justify-center">
            <h2>Copyright © 2030 Hashtag Developer. All Rights Reserved,</h2>
        </footer>

        <script>
    function load_data(search = '') {
        $.ajax({
            url: 'ajaxaffich/usersaffich.php',
            type: 'GET',
            data: { search: search },
            success: function(response) {
                $('#searched').html(response);
            }
        });
    }

    $(document).ready(function() {
        load_data(); 

        $('input[name="search"]').on('input', function() {
            load_data($(this).val());
        });
    });
</script>


    </body>

    </html>