<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../plugins/FPDF/fpdf.php';
require_once '../models/User.php';
require_once '../database/Database.php';
require_once '../models/Subject.php';
require_once '../models/Course.php';


$database = new Database();
$db = $database->getConnection();
User::setConnection($db);
$user = User::find($_POST['id']);

$pdf = new FPDF('L', 'mm', 'Legal');
$pdf->AddPage();
$pdf->headerPDF();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
if ($user) {
    if ($user->role != 'instructor') {
        header("Location: ../users/");
        exit();
    }

    $subjects = $user->subjects();

    $pdf->SetFont('Arial', 'B', 25);
    $pdf->Cell(0, 10, strtoupper($user->role) . ' RECORD', 0, 1, 'C');
    $pdf->Ln(5);

    $userInfo = [
    'Name' => ucwords($user->name),
    'Email' => strtolower($user->email),
    'Role' => ucfirst($user->role),
    'Status' => ucfirst($user->status),
];

    $pdf->SetFont('Arial', '', 12);
    $labelWidth = 25;
    $valueWidth = 60;
    $gapWidth = 100; // 👈 space between column pairs
    $i = 0;

    foreach ($userInfo as $label => $value) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell($labelWidth, 10, $label . ':', 0, 0);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell($valueWidth, 10, $value, 0, 0);

        $i++;

        // Insert gap after first pair (2 items)
        if ($i % 2 == 1) {
            $pdf->Cell($gapWidth, 10, '', 0, 0); // 👈 this is the gap
        }

        // Move to next line after second pair
        if ($i % 2 == 0) {
            $pdf->Ln(5);
        }
    }

    $pdf->Ln(5);

    // Table headers
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetFillColor(6, 31, 92);  // Navy blue
    $pdf->SetTextColor(255, 255, 255); // White text
    $pdf->SetDrawColor(6, 31, 92);

    $pdf->Cell(25, 11, 'NO.', 1, 0, 'C', true);
    $pdf->Cell(50, 11, 'CATALOG NO.', 1, 0, 'C', true);
    $pdf->Cell(110, 11, 'SUBJECT NAME', 1, 0, 'C', true);
    $pdf->Cell(80, 11, 'COURSE', 1, 0, 'C', true);
    $pdf->Cell(0, 11, 'YEAR LEVEL', 1, 0, 'C', true);
    $pdf->Ln(10);

    // Table rows
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);

    if (!$subjects || count($subjects) == 0) {
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 36);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(335, 15, 'No subjects assigned.', 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
    } else {
        $i = 1;
        foreach ($subjects as $subject) {
            $courseName = $subject->course()->code;
            switch ($subject->year_level) {
                case 1:
                    $yearLevel = '1st Year';
                    break;
                case 2:
                    $yearLevel = '2nd Year';
                    break;
                case 3:
                    $yearLevel = '3rd Year';
                    break;
                case 4:
                    $yearLevel = '4th Year';
                    break;
                default:
                    $yearLevel = 'N/A';
                    break;
            }

            $pdf->Cell(25, 10, $i++, 'LB', 0, 'C');
            $pdf->Cell(50, 10, $subject->catalog_no, 'B', 0, 'C');
            $pdf->Cell(110, 10, $subject->name, 'B', 0, 'C');
            $pdf->Cell(80, 10, $courseName, 'B', 0, 'C');
            $pdf->Cell(0, 10, $yearLevel, 'RB', 0, 'C');
            $pdf->Ln(10);
        }
    }
} else {
    $pdf->Ln(10);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->SetFont('Arial', 'B', 48);
    $pdf->Cell(0, 10, 'No Users found', 0, 1, 'C');
    $pdf->SetTextColor(0, 0, 0);
}

$pdf->Output('I', 'instructor_user_record.pdf');
}else {
    header("Location: ../");
    exit();
}
?>
