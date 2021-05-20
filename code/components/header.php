<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flights Information</title>
    <link rel="stylesheet" href="./public/style/bootstrap.min.css">
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="./public/script/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="container-fluid mb-5">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">Search</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Reports</a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="report_flight_carrier.php">Carrier</a></li>
            <li><a class="dropdown-item" href="report_flight_aircraft.php">Aircraft</a></li>
            <li><a class="dropdown-item" href="report_flight_carrier_aircraft.php">Carrier & Aircraft</a></li>
            <li><a class="dropdown-item" href="report_flight_hours.php">Hours</a></li>
            </ul>
        </li>
    </ul>
</div>
<div class="container">


