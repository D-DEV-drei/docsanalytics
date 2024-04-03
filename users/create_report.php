<?php
require_once '../config/db.php';
require_once '../fpdf/fpdf.php'; // Include FPDF library

// Retrieve the report ID from the URL parameter
if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    // Retrieve data from the reports table based on the report ID
    $sql = "SELECT f.file_name, r.report_name, r.report_description, r.created_at, r.access, r.user, r.download, r.upload, r.include_access, r.include_users, r.include_downloads, r.include_uploads
    FROM fms_g14_reports AS r
    inner join fms_g14_folder as f on f.id = r.folder_id
    WHERE r.id = ?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "i", $report_id);

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Bind result variables
        mysqli_stmt_bind_result($stmt, $folder, $report_name, $description, $created_at, $Access, $Users, $Downloads, $Uploads, $include_access, $include_users, $include_downloads, $include_uploads);

        // Fetch data
        mysqli_stmt_fetch($stmt);

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle errors
        echo "Error: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);

    // Create PDF or display the report data
    $pdf = new FPDF();
    $pdf->AddPage();

    // Title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, $folder, 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);

    // Description
    $pdf->Cell(0, 10, 'Description: ' . $description, 0, 1, 'C');

    // Creation Date
    $formatted_date = date("F j, Y", strtotime($created_at));
    $pdf->Cell(0, 10, 'Date: ' . $formatted_date, 0, 1, 'C');

    // Table Headers
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Name', 1);
    $pdf->Cell(0, 10, 'Data', 1);
    $pdf->Ln();

    // Include only the checked checkboxes in the PDF
    if ($Access) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 10, 'No. of Access', 1);
        $pdf->Cell(0, 10, $include_access, 1);
        $pdf->Ln();
    }

    if ($Users) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 10, 'No. of Users', 1);
        $pdf->Cell(0, 10, $include_users, 1);
        $pdf->Ln();
    }

    if ($Downloads) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 10, 'No. of Downloads', 1);
        $pdf->Cell(0, 10, $include_downloads, 1);
        $pdf->Ln();
    }

    if ($Uploads) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(80, 10, 'No. of Uploads', 1);
        $pdf->Cell(0, 10, $include_uploads, 1);
        $pdf->Ln();
    }

    // Output PDF
    $pdf->Output();
} else {
    // Report ID is missing, handle the error (redirect, display message, etc.)
    echo "Report ID is missing.";
}
