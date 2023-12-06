<?php

@include "../DataBase.php";




$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';


if (isset($_POST['submit']) && isset($_POST['accountid'])) {
            $accountid = $conn->real_escape_string($_POST['accountid']);

            // Fetch bank details based on the bankid
            $account_sql = "SELECT * FROM account WHERE accountid = '$accountid'";
            $account_result = $conn->query($account_sql);

            if ($account_result->num_rows > 0) {
                $account_row = $account_result->fetch_assoc();
                echo "<div class ='flex w-[100%]  justify-center h-[60px] border-[2px] border-black border-solid items-center text-black'>";
                echo "<p class='border-[2px] border-black border-solid w-[85%] h-[100%] flex items-center font-semibold  justify-center'>RIB : {$account_row["RIB"]}</p>";
                echo "<p class='border-[2px] border-black border-solid w-[85%] h-[100%] flex items-center font-semibold  justify-center'>balance : {$account_row["balance"]} MAD</p>";
                echo "</div>";
            }


            // Fetch data based on the selected bankid for 'agency'
            $sql = "SELECT * FROM `transaction` WHERE accountid = '$accountid' AND trans_type LIKE '%$searchTerm%' ORDER BY transactionId DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="leading-9 h-[90%]  w-[100%] text-center text-black">';
                echo '<thead>
                        <tr>
                            <th class="border-[2px] border-black border-solid w-[15%] ">ID</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Operation Type</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Amount</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Created at</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Edit</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Delete</th>
                        </tr>
                    </thead>';
                while ($row = $result->fetch_assoc()) {
                    echo '<form action="transaction.php" method="post" class="h-[10vh] items-start">';
                    echo "<tr>
                            <td class='border-[2px] border-black border-solid '>" . $row["transactionId"] . " </td>
                            <td class='border-[2px] border-black border-solid '>" . $row["trans_type"] . "  </td>
                            <td class='border-[2px] border-black border-solid '> " . $row["amount"] . " MAD</td>
                            <td class='border-[2px] border-black border-solid '> " . $row["created_at"] . " </td>

                         
                               

                            <td class='border-[2px] border-black border-solid '>
                            <form action='addtransactions.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-blue-700 bg-blue-500 hover:text-white text-white '>
                            <input type='hidden' name='operation' value='" . $row["transactionId"] . "'>
                            <input type='hidden' name='transactionId' value='" . $row["transactionId"] . "'>
                            <input type='submit'  name='editing' value='Edit'>
                        </form>
                        
                            </td>
                            <td class='border-[2px] border-black border-solid '>
                            <form action='transactions.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-red-700 bg-red-500 hover:text-white text-white '>
                                <input type='hidden' name='delete' value='" . $row["transactionId"] . "'>
                                <input type='submit'  name='deletetransaction' value='Delete'>
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
            $sqlall = "SELECT * FROM `transaction` WHERE trans_type LIKE '%$searchTerm%' ORDER BY transactionId DESC";
            $result2 = $conn->query($sqlall);

            if ($result2->num_rows > 0) {
                echo '<table class="leading-9  w-[100%] text-center h-[7vh] items-start text-black">';
                echo '<thead>
                        <tr>
                        <th class="border-[2px] border-black border-solid w-[15%] ">ID</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Operation Type</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Amount</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Created at</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Edit</th>
                            <th class="border-[2px] border-black border-solid w-[15%] ">Delete</th>
                        </tr>
                    </thead>';
                while ($row = $result2->fetch_assoc()) {

                    echo "<tr>
                    <td class='border-[2px] border-black border-solid '>" . $row["transactionId"] . " </td>
                    <td class='border-[2px] border-black border-solid '> " . $row["trans_type"] . "</td>
                    <td class='border-[2px] border-black border-solid '> " . $row["amount"] . "  MAD</td>
                    <td class='border-[2px] border-black border-solid '> " . $row["created_at"] . " </td>


                 
                               

                            <td class='border-[2px] border-black border-solid '>
                            <form action='addtransactions.php' method='post' class='height-[100%] cursor-pointer width-[100%] hover:bg-blue-700 bg-blue-500 hover:text-white text-black'>
                            <input type='hidden' name='operation' value='" . $row["transactionId"] . "'>
                            <input type='hidden' name='transactionid' value='" . $row["transactionId"] . "'>
                            <input type='submit'  name='editing' value='Edit'>
                        </form>
                        
                            </td>
                            <td class='border-[2px] border-black border-solid '>
                            <form action='transactions.php' method='post' class='height-[80px] cursor-pointer w-[100%] hover:bg-red-700 bg-red-500 hover:text-white text-white '>
                                <input type='hidden' name='delete' value='" . $row["transactionId"] . "'>
                                <input type='submit'  name='deletetransaction' value='Delete'>
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