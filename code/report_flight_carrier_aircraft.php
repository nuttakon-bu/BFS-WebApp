<?php
include dirname(__FILE__)."/functions/functions.php";
get_header();

$report_arrival_list = get_report_flight_carrier_aircraft('Arrival');
$report_departure_list = get_report_flight_carrier_aircraft('Departure');
?>

<div class="card" method="GET" action="index.php">
    <div class="card-header">
        <h1>Flight Information by Carrier & Aircraft Type</h1>
    </div>
    <div class="card-body">

        <div class="row mb-5">
            <h2>Arrival</h2>
            <div class="col">
                <table id="arrival_table" class="table table-bordered table-hover table-striped py-3 w-100" style="visibility:hidden;">
                    <thead>
                        <tr class="text-center">
                            <th colspan="2">Total Flights</th>
                            <th colspan="7">Week Day</th>
                        </tr>
                        <tr class="text-center">
                            <th>carrier</th>
                            <th>Aircraft Type</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                            <th>Sun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report_arrival_list as $key => $flight) : ?>
                        <tr class="text-center">
                            <td><?php echo $flight["carrier"] ?></td>
                            <td><?php echo $flight["aircraft_type"] ?></td>
                            <td><?php echo isset($flight["Mon"]) ? $flight["Mon"] : "" ?></td>
                            <td><?php echo isset($flight["Tue"]) ? $flight["Tue"] : "" ?></td>
                            <td><?php echo isset($flight["Wed"]) ? $flight["Wed"] : "" ?></td>
                            <td><?php echo isset($flight["Thu"]) ? $flight["Thu"] : "" ?></td>
                            <td><?php echo isset($flight["Fri"]) ? $flight["Fri"] : "" ?></td>
                            <td><?php echo isset($flight["Sat"]) ? $flight["Sat"] : "" ?></td>
                            <td><?php echo isset($flight["Sun"]) ? $flight["Sun"] : "" ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <h2>Departure</h2>
            <div class="col">
                <table id="departure_table" class="table table-bordered table-hover table-striped py-3 w-100" style="visibility:hidden;">
                    <thead>
                        <tr class="text-center">
                            <th colspan="2">Total Flights</th>
                            <th colspan="7">Week Day</th>
                        </tr>
                        <tr class="text-center">
                            <th>carrier</th>
                            <th>Aircraft Type</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                            <th>Sun</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report_departure_list as $key => $flight) : ?>
                        <tr class="text-center">
                            <td><?php echo $flight["carrier"] ?></td>
                            <td><?php echo $flight["aircraft_type"] ?></td>
                            <td><?php echo isset($flight["Mon"]) ? $flight["Mon"] : "" ?></td>
                            <td><?php echo isset($flight["Tue"]) ? $flight["Tue"] : "" ?></td>
                            <td><?php echo isset($flight["Wed"]) ? $flight["Wed"] : "" ?></td>
                            <td><?php echo isset($flight["Thu"]) ? $flight["Thu"] : "" ?></td>
                            <td><?php echo isset($flight["Fri"]) ? $flight["Fri"] : "" ?></td>
                            <td><?php echo isset($flight["Sat"]) ? $flight["Sat"] : "" ?></td>
                            <td><?php echo isset($flight["Sun"]) ? $flight["Sun"] : "" ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>





<script>

$(document).ready(function() {
    $('#arrival_table').DataTable();
    $('#arrival_table').css("visibility","visible");

    $('#departure_table').DataTable();
    $('#departure_table').css("visibility","visible");
} );

</script>


<?php get_footer(); ?>