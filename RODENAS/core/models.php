<?php

function getAllTechnicians($pdo) {
    $sql = "SELECT * FROM Technicians";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getTechnicianByID($pdo, $technician_id) {
    $sql = "SELECT * FROM Technicians WHERE technician_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$technician_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function getAllRepairs($pdo) {
    $sql = "SELECT * FROM Repairs";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getRepairByID($pdo, $repair_id) {
    $sql = "SELECT  
                R.repair_id AS repair_id,
                R.device_type AS device_type,
                R.problem_description AS problem_description,
                R.repair_date AS repair_date,
                CONCAT(T.first_name, ' ', T.last_name) AS technician_name,
                R.technician_id AS technician_id 
            FROM Repairs R
            JOIN Technicians T ON R.technician_id = T.technician_id
            WHERE R.repair_id = ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$repair_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function getRepairsByTechnicianID($pdo, $technician_id) {
    $sql = "SELECT  
                R.repair_id AS repair_id,
                R.device_type AS device_type,
                R.problem_description AS problem_description,
                R.repair_date AS repair_date,
                CONCAT(T.first_name, ' ', T.last_name) AS technician_name
            FROM Repairs R
            JOIN Technicians T ON R.technician_id = T.technician_id
            WHERE R.technician_id = ?
            GROUP BY R.repair_id"; 

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$technician_id]);

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function insertTechnician($pdo, $firstName, $lastName, $specialization) {
    $sql = "INSERT INTO Technicians (first_name, last_name, specialization) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$firstName, $lastName, $specialization]);
}

function insertRepair($pdo, $device_type, $problem_description, $technician_id, $repair_date) {  
    $sql = "INSERT INTO Repairs (device_type, problem_description, technician_id, repair_date) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$device_type, $problem_description, $technician_id, $repair_date]); 

    if ($executeQuery) {
        return true;
    }
}

function updateTechnician($pdo, $technician_id, $firstName, $lastName, $specialization) {
    $sql = "UPDATE Technicians  
            SET first_name = ?,  
                last_name = ?,  
                specialization = ?  
            WHERE technician_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$firstName, $lastName, $specialization, $technician_id]);
}

function updateRepair($pdo, $repair_id, $device_type, $problem_description) {
    $sql = "UPDATE Repairs  
            SET device_type = ?,  
                problem_description = ?
            WHERE repair_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$device_type, $problem_description, $repair_id]);
}

function deleteTechnician($pdo, $technician_id) {
    // First, delete related repairs
    $deleteRepairsSql = "DELETE FROM Repairs WHERE technician_id = ?";
    $deleteRepairsStmt = $pdo->prepare($deleteRepairsSql);
    $deleteRepairsStmt->execute([$technician_id]); 

    // Then, delete the technician
    $deleteTechnicianSql = "DELETE FROM Technicians WHERE technician_id = ?";
    $deleteTechnicianStmt = $pdo->prepare($deleteTechnicianSql);
    return $deleteTechnicianStmt->execute([$technician_id]); 
}


function getProjectByID($pdo, $project_id) {
    $sql = "SELECT 
                projects.project_id AS project_id,
                projects.project_name AS project_name,
                projects.technologies_used AS technologies_used,
                projects.date_added AS date_added,
                CONCAT(web_devs.first_name,' ', web_devs.last_name) AS project_owner
            FROM projects
            JOIN web_devs ON projects.web_dev_id = web_devs.web_dev_id
            WHERE projects.project_id = ?"; 

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$project_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function updateProject($pdo, $project_name, $technologies_used, $project_id) {
    $sql = "UPDATE projects 
            SET project_name = ?, technologies_used = ? 
            WHERE project_id = ?"; 

    $stmt = $pdo->prepare($sql);                                                        
    $executeQuery = $stmt->execute([$project_name, $technologies_used, $project_id]);

    if ($executeQuery) {
        return true;
    }                                                                   
}

function deleteProject($pdo, $project_id) {
    $sql = "DELETE FROM projects WHERE project_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$project_id]);

    if ($executeQuery) {
        return true;
    }
}

?>