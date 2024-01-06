<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Results</title>

    <style>
        body {
            text-align: center;
            margin-top: 200px;
            margin-left: 170px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <h2>Voucher Results</h2>

    <?php
    global $DB;

    // Fetch voucher data from the database
    $result = $DB->query("SELECT * FROM voucher");

    if ($result->num_rows > 0) {
    ?>
        <table>
            <tr>
                <th>Business Name</th>
                <th>Branch Name</th>
                <th>Voucher Code</th>
                <th>Condition</th>
                <th>Discount Value</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>

            <?php
            while ($row = $result->fetch_assoc()) {
                // Fetch business name based on businessCode
                $businessCode = $row["businessCode"];
                $busNameResult = $DB->query("SELECT busName FROM business WHERE businessCode = '$businessCode'");
                $busName = ($busNameResult->num_rows > 0) ? $busNameResult->fetch_assoc()["busName"] : '';

                // Fetch branch name based on branchCode
                $branchCode = $row["branchCode"];
                $branchNameResult = $DB->query("SELECT branchName FROM branches WHERE branchCode = '$branchCode'");
                $branchName = ($branchNameResult->num_rows > 0) ? $branchNameResult->fetch_assoc()["branchName"] : '';
            ?>
                <tr>
                    <td><?= $busName ?></td>
                    <td><?= $branchName ?></td>
                    <td><?= $row["voucherCode"] ?></td>
                    <td><?= $row["cond"] ?></td>
                    <td><?= ($row["discountType"] === 'percentage') ? $row["discountValue"] . '%' : '₱' . $row["discountValue"] ?></td>
                    <td><?= $row["startDate"] ?></td>
                    <td><?= $row["endDate"] ?></td>
                </tr>
            <?php
            }
            ?>

        </table>

    <?php
    } else {
        echo "<p>No vouchers found.</p>";
    }
    ?>

    <!-- Button to add a voucher -->
    <a href="?page=create_voucher"><button>Add Voucher</button></a>

</body>

</html>
