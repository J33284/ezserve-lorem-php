<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

// Query the database to fetch businesses with a status of 0

$businesses = $DB->query("SELECT * FROM business WHERE status = 0");


?>

<?= element('header') ?>

<?= element('admin-side-nav') ?>


<div id="admin-reg" class="admin-reg overflow-auto">
    <table class="table table-hover table-responsive ">
        <thead >
            <tr>
                <th scope="col">#</th>
                <th scope="col">Business Name</th>
                <th scope="col">Accept</th>
                <th scope="col">Reject</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($businesses as $key => $business) : ?>
                <tr class="sticky-top mt-3">
                    <th scope="row"><?= $key + 1 ?></th>
                    <td data-bs-toggle="collapse" data-bs-target="#demo1" class="accordion-toggle" data-id="<?= $business['businessCode'] ?>">
                        <?= $business['busName'] ?>
                    </td>
                    <td>
                        <input class="form-check-input accept-checkbox" type="checkbox" value="<?= $business['businessCode'] ?>" id="AcceptCheckBox">
                    </td>
                    <td>
                        <input class="form-check-input reject-checkbox" type="checkbox" value="<?= $business['businessCode'] ?>" id="RejectCheckBox">
                    </td>
                </tr>
                <tr >
                     <td colspan="6" class="hidden ">
                        <div class="accordian-body collapse" id="demo1"> 
                        <?= element('admin-bus-form') ?>
                        </div> </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.querySelectorAll('.accept-checkbox').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        const businessCode = this.value;
        if (this.checked) {
            updateStatusToAccepted(businessCode);
        }
    });
});

function updateStatusToAccepted(businessCode) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'adminFunction', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert('Business status updated to Accepted.');
            } else {
                alert('Failed to update status. Please try again.');
            }
        }
    };
    
    const data = `businessCode=${businessCode}`;
    xhr.send(data);
}

</script>

<?= element('footer') ?>
