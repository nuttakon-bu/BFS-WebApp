<?php
include dirname(__FILE__)."/functions/functions.php";
get_header();

$flight_list = get_flight_info($_GET); 
?>

<div class="row">
    <div class="col">
        <form class="card" method="GET" action="index.php">
            <div class="card-header">
                <h1>Search Flights</h1>
            </div>
            <div class="card-body">
                <div class="row py-1">
                    <div class="col-12 col-md-2 text-start text-md-end">
                        Flight Type :
                    </div>
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="flight_type" value="Arrival" <?php echo isset($_GET["flight_type"]) && $_GET["flight_type"] == "Arrival" ? "checked" : "" ?> >
                            <label class="form-check-label" for="inlineRadio1">Arrival</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="flight_type" value="Departure" <?php echo isset($_GET["flight_type"]) && $_GET["flight_type"] == "Departure" ? "checked" : "" ?> >
                            <label class="form-check-label" for="inlineRadio2">Departure</label>
                        </div>
                    </div>
                </div>
                <div class="row py-1">
                    <div class="col-12 col-md-2 text-start text-md-end">
                        Schedule Date :
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" name="schedule_start" placeholder="Start Date" value="<?php echo isset($_GET["schedule_start"]) ? $_GET["schedule_start"] : "" ?>" >
                            <span class="input-group-text"> - </span>
                            <input type="date" class="form-control" name="schedule_end" placeholder="End Date" value="<?php echo isset($_GET["schedule_end"]) ? $_GET["schedule_end"] : "" ?>"  >
                        </div>
                    </div>
                </div>
                <div class="row py-1">
                    <div class="col-12 col-md-2 text-start text-md-end">
                        Carrier :
                    </div>
                    <div class="col">
                        <input autocomplete="off" type="text" name="carrier" class="form-control" placeholder="Carrier" value="<?php echo isset($_GET["carrier"]) ? $_GET["carrier"] : "" ?>" >    
                    </div>
                </div> 
                <div class="row py-1">
                    <div class="col-12 col-md-2 text-start text-md-end">
                        Flight No :
                    </div>
                    <div class="col">
                        <input autocomplete="off" type="text" name="flight_no" class="form-control" placeholder="Flight No" value="<?php echo isset($_GET["flight_no"]) ? $_GET["flight_no"] : "" ?>" >
                    </div>
                </div>
                <div class="row py-1">
                    <div class="col-12 col-md-2 text-start text-md-end">
                        Aircraft Type :
                    </div>
                    <div class="col">
                        <input autocomplete="off" type="text" name="aircraft_type" class="form-control" placeholder="Aircraft Type" value="<?php echo isset($_GET["aircraft_type"]) ? $_GET["aircraft_type"] : "" ?>" >
                    </div>
                </div>
                <div class="row py-1">
                    <div class="col text-end">
                        <a role="button" href="index.php" class="btn btn-outline-primary">Clear</a>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row mt-5">
    <h1>Flights Information</h1>
    <div class="col">
        <table id="flight_table" class="table table-bordered table-hover table-striped py-3 w-100" style="visibility:hidden;">
            <thead>
                <tr class="text-center">
                    <th>Schedule Date</th>
                    <th>Carrier</th>
                    <th>Flight No</th>
                    <th>Aircraft Type</th>
                    <th>Gate</th>
                    <th>Position</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flight_list as $key => $flight) : ?>
                <tr class="text-center">
                    <td><?php echo $flight["schedule_date"] ?></td>
                    <td><?php echo $flight["carrier"] ?></td>
                    <td><?php echo $flight["flight_no"] ?></td>
                    <td><?php echo $flight["aircraft_type"] ?></td>
                    <td><?php echo $flight["gate"] ?></td>
                    <td><?php echo $flight["position"] ?></td>
                    <td>
                        <button id="more_button" type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-info='<?php echo json_encode($flight) ?>' >
                            More
                        </button>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Flight More Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row py-1">
            <div class="col-3 text-end">
                Registration :
            </div>
            <div id="registration" class="col"></div>
        </div> 
        <div class="row py-1">
            <div class="col-3 text-end">
                Belt :
            </div>
            <div id="belt" class="col"></div>
        </div> 
        <div class="row py-1">
            <div class="col-3 text-end">
                Remark :
            </div>
            <div id="remark" class="col"></div>
        </div> 
      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
    $('#flight_table').DataTable();
    $('#flight_table').css("visibility","visible");
} );

$('.btn-sm').click( function(){
    var dataStr = $(this).attr('data-info');
    var data = JSON.parse(dataStr);
        
    if(!data.registration || $.trim(data.registration) == "")  
        $('#registration').html(" - ")
    else
        $('#registration').html(data.registration)
        
    if(!data.belt || $.trim(data.belt) == "")
        $('#belt').html(" - ")  
    else
        $('#belt').html(data.belt)

    if(!data.remark || $.trim(data.remark) == "")
        $('#remark').html(" - ")
    else
        $('#remark').html(data.remark)
})

</script>

<?php get_footer(); ?>