
    <h2>Voucher Results</h2>

    <?php
  
    global $DB;

    // Fetch voucher data from the database
    $result = $DB->query("SELECT * FROM voucher");

    if ($result->num_rows > 0) {
        // Display the table if there are results
        echo "<table border='1'>
                <tr>
                    <th>Business Code</th>
                    <th>Branch Code</th>
                    <th>Voucher Code</th>
                    <th>Discount Type</th>
                    <th>Discount Value</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["businessCode"] . "</td>
                    <td>" . $row["branchCode"] . "</td>
                    <td>" . $row["voucherCode"] . "</td>
                    <td>" . $row["discountType"] . "</td>
                    <td>" . $row["discountValue"] . "</td>
                    <td>" . $row["startDate"] . "</td>
                    <td>" . $row["endDate"] . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No vouchers found.";
    }
    ?>

