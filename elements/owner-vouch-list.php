<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Results</title>

    <style>
        body {
            text-align: center;
            margin-top: 120px;
            margin-left: 200px;
        }

        table {
            border: 1px solid #000;
            margin: 0 auto;
        }

        button {
            display: block;
            margin-top: 20px;
        }

        .centered-button {
        display: flex;
        justify-content: center;
        margin-top: 20px;
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
                <th>Business Code</th>
                <th>Branch Code</th>
                <th>Voucher Code</th>
                <th>Discount Type</th>
                <th>Discount Value</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>

            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $row["businessCode"] ?></td>
                    <td><?= $row["branchCode"] ?></td>
                    <td><?= $row["voucherCode"] ?></td>
                    <td><?= $row["discountType"] ?></td>
                    <td><?= $row["discountValue"] ?></td>
                    <td><?= $row["startDate"] ?></td>
                    <td><?= $row["endDate"] ?></td>
                </tr>
            <?php
            }
            ?>

        </table>

    <?php
    } else {
        echo "No vouchers found.";
    }
    ?>

    <!-- Button to add a voucher -->
<div class="centered-button">
    <a href="?page=create_voucher"><button>Add Voucher</button></a>
</div>

</body>

</html>
