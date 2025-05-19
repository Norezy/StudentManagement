<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS</title>
        <!-- bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  

        <!-- DataTables CSS -->
        <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.2.2/af-2.7.0/b-3.2.2/b-colvis-3.2.2/b-html5-3.2.2/b-print-3.2.2/cr-2.0.4/date-1.5.5/fc-5.0.4/fh-4.0.1/kt-2.12.1/r-3.0.4/rg-1.5.1/rr-1.5.0/sc-2.4.3/sb-1.8.2/sp-2.3.3/sl-3.0.0/sr-1.4.1/datatables.min.css" rel="stylesheet" integrity="sha384-6gM1RUmcWWtU9mNI98EhVNlLX1LDErxSDu2o/YRIeXq34o77tQYTXLzJ/JLBNkNV" crossorigin="anonymous">

        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- fontawsome JS -->
        <script src="https://kit.fontawesome.com/ff3a3043e1.js" crossorigin="anonymous"></script>

        <!-- apexcharts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        
</head>
<body id="body-bg">
<style>
        body#body-bg {
            background: #334EAC;
            background: linear-gradient(90deg,rgba(51, 78, 172, 1) 0%, rgba(74, 222, 128, 1) 31%);
            display: flex;
            flex-direction: row;
            align-items: flex-start; /* Ensures both sidebar and content stretch to the same height */
            min-height: 120vh;
        }

        .nav-link.active {
            font-weight: bold;
            background-color: rgba(112, 150, 209, 0.6);
        }

        #sidebar:hover {
            background-color: rgba(112, 150, 209, 0.6);
            font-size: 18px;
            font-weight: bold;
        }
        .main-content {
            flex-grow: 1; /* Takes up the remaining space */
        }

        table td {
            text-align: center;
            vertical-align: middle; 
        }

        table th {
            text-align: center; 
            vertical-align: middle;
        }
</style>
       
