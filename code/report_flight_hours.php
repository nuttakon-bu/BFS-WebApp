<?php
include dirname(__FILE__)."/functions/functions.php";
get_header();

$hours = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21","22", "23"];

$report_arrival_list = get_report_by_hours('Arrival');
$report_departure_list = get_report_by_hours('Departure');
?>

<style>
.table-responsive{
    max-height: 300px !important;
}
</style>

<div class="card" method="GET" action="index.php">
    <div class="card-header">
        <h1>Flight Information by Hours</h1>
    </div>
    <div class="card-body">

        <div class="row mb-5">
            <h2>Arrival</h2>
            <div class="col table-responsive">
                <table id="arrival_table" class="table table-bordered table-hover table-striped py-3 w-100" >
                    <thead>
                        <tr class="text-center">
                            <th colspan="2">Total Flights</th>
                            <th colspan="<?php echo count($hours) ?>">Hours</th>
                        </tr>
                        <tr class="text-center">
                            <th>Week Day</th>
                            <th>Carrier</th>
                            <?php foreach ($hours as $key => $hour) : ?>
                            <th><?php echo $hour ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $day = "";
                            foreach ($report_arrival_list as $key => $flight) :
                                foreach ($flight["carriers"] as $key_carrier => $carrier) : 
                        ?>
                            <tr class="text-center">
                                <td><?php echo $flight["week_day"] == $day ? "" : $flight["week_day"] ?></td>
                                <td><?php echo $key_carrier ?></td>
                                <?php foreach ($hours as $key => $hour) : ?>
                                <td><?php echo isset($carrier[$hour]) ? $carrier[$hour] : "" ?></td>
                                <?php endforeach ?>
                            </tr>
                        <?php 
                                $day = $flight["week_day"];
                                endforeach ;
                            endforeach ;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <h2>Departure</h2>
            <div class="col table-responsive">
                <table id="departure_table" class="table table-bordered table-hover table-striped py-3 w-100" >
                    <thead>
                        <tr class="text-center">
                            <th colspan="2">Total Flights</th>
                            <th colspan="<?php echo count($hours) ?>">Hours</th>
                        </tr>
                        <tr class="text-center">
                            <th>Week Day</th>
                            <th>Carrier</th>
                            <?php foreach ($hours as $key => $hour) : ?>
                            <th><?php echo $hour ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $day = "";
                            foreach ($report_departure_list as $key => $flight) :
                                foreach ($flight["carriers"] as $key_carrier => $carrier) : 
                        ?>
                            <tr class="text-center">
                                <td><?php echo $flight["week_day"] == $day ? "" : $flight["week_day"] ?></td>
                                <td><?php echo $key_carrier ?></td>
                                <?php foreach ($hours as $key => $hour) : ?>
                                <td><?php echo isset($carrier[$hour]) ? $carrier[$hour] : "" ?></td>
                                <?php endforeach ?>
                            </tr>
                        <?php 
                                $day = $flight["week_day"];
                                endforeach ;
                            endforeach ;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


<?php get_footer(); ?>