<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Repair Shop</title>
    <link rel="stylesheet" href="style.css">  
</head>
<body>

    <?php
    session_start(); // Start the session

    // Display success message if it exists
    if (isset($_SESSION['success_message'])) {
        echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
        unset($_SESSION['success_message']); 
    }

    // Display error message if it exists
    if (isset($_SESSION['error_message'])) {
        echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']); 
    }
    ?>

    <h1>Welcome To Computer Repair Shop Management System</h1>

    <h2>Add New Technician</h2>
    <form action="core/handleForms.php" method="POST">
        <label for="firstName">First Name</label>
        <input type="text" name="firstName">

        <label for="lastName">Last Name</label>
        <input type="text" name="lastName">

        <label for="specialization">Specialization</label>
        <input type="text" name="specialization">

        <button type="submit">Add Technician</button>
    </form>

    <h2>Technicians and Their Repairs</h2>

    <?php $technicians = getAllTechnicians($pdo); ?>
    <?php foreach ($technicians as $technician): ?>
        <h3><?php echo $technician['first_name'] . " " . $technician['last_name']; ?></h3>

        <table style="width:100%; margin-top: 20px;">
            <tr>
                <th>Repair ID</th>
                <th>Device Type</th>
                <th>Problem Description</th>
                <th>Repair Date</th>
                <th>Actions</th> 
            </tr>

            <?php $repairs = getRepairsByTechnicianID($pdo, $technician['technician_id']); ?>
            <?php foreach ($repairs as $repair): ?>
                <tr>
                    <td><?php echo $repair['repair_id']; ?></td>
                    <td><?php echo $repair['device_type']; ?></td>
                    <td><?php echo $repair['problem_description']; ?></td>
                    <td><?php echo $repair['repair_date']; ?></td>
                    <td>
                        <a href="editrepair.php?repair_id=<?php echo $repair['repair_id']; ?>">Edit</a> | 
                        <a href="deletewebdev.php?technician_id=<?php echo $technician['technician_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?> 
        </table>

        <h4>Add New Repair for <?php echo $technician['first_name'] . " " . $technician['last_name']; ?></h4>
        <form action="core/handleForms.php" method="POST">
            <label for="device_type">Device Type:</label>
            <input type="text" name="device_type" required>

            <label for="problem_description">Problem Description:</label>
            <textarea name="problem_description" required></textarea>

            <label for="repair_date">Repair Date:</label>
            <input type="date" name="repair_date" required> 

            <input type="hidden" name="technician_id" value="<?php echo $technician['technician_id']; ?>">

            <button type="submit" name="insertNewRepairBtn">Insert New Repair</button>
        </form>

    <?php endforeach; ?>

</body>
</html>