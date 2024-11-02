CREATE TABLE Technicians (
    technician_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    specialization VARCHAR(255)
);

CREATE TABLE Repairs (
    repair_id INT AUTO_INCREMENT PRIMARY KEY,
    technician_id INT,
    device_type VARCHAR(255) NOT NULL,
    problem_description TEXT,
    repair_date DATE,  -- Include the repair_date column
    FOREIGN KEY (technician_id) REFERENCES Technicians(technician_id)
);