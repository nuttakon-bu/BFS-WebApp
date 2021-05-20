<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

$root_path = $_SERVER["DOCUMENT_ROOT"]."/webApp";
$db = new SQLite3('database.sqlite');

function get_header() {
    global $root_path;
    include $root_path."/components/header.php";
}


function get_footer() {
    global $root_path;
    include $root_path."/components/footer.php";
}

function get_flight_info($data = []) {
    global $db;

    $flight_type = "";
    $start_date = "";
    $end_date = "";
    $carrier = "";
    $flight_no = "";
    $aircraft_type  = "";

    if(isset($data["flight_type"]) && $data["flight_type"] != ""){
        $flight_type = $data["flight_type"];
    }
    if(isset($data["schedule_start"]) && $data["schedule_start"] != ""){
        $start_date = $data["schedule_start"];
    }
    if(isset($data["schedule_end"]) && $data["schedule_end"] != ""){
        $end_date = $data["schedule_end"];
    }
    if(isset($data["carrier"]) && $data["carrier"] != ""){
        $carrier = $data["carrier"];
    }
    if(isset($data["flight_no"]) && $data["flight_no"] != ""){
        $flight_no = $data["flight_no"];
    }
    if(isset($data["aircraft_type"]) && $data["aircraft_type"] != ""){
        $aircraft_type = $data["aircraft_type"];
    }
    
    $conditions = [];
    if($flight_type != ""){
        array_push($conditions, "flight_type = '".$flight_type."'");
    }
    if($start_date != ""){
        $date = date_create($start_date);
        array_push($conditions, "schedule_date >= '".date_format($date, "d/m/Y")." 00:00:00'");
    }
    if($end_date != ""){
        $date = date_create($end_date);
        array_push($conditions, "schedule_date <= '".date_format($date, "d/m/Y")." 23:59:59'");
    }
    if($carrier != ""){
        array_push($conditions, "lower(carrier) LIKE '%".strtolower($carrier)."%'");
    }
    if($flight_no != ""){
        array_push($conditions, "lower(flight_no) LIKE '%".strtolower($flight_no)."%'");
    }
    if($aircraft_type != ""){
        array_push($conditions, "lower(aircraft_type) LIKE '%".strtolower($aircraft_type)."%'");
    }

    $sql = "SELECT schedule_date, carrier, flight_no, aircraft_type, gate, pos, reg, belt, remark FROM Flight_Information";
    if(count($conditions) > 0){
        $sql = $sql." WHERE ".implode(" AND ", $conditions);
    }
    $res = $db->query($sql);
    $result = [];

    while ($row = $res->fetchArray()) {
        array_push($result, [
            "schedule_date" => $row["schedule_date"],
            "carrier" => $row["carrier"],
            "flight_no" => $row["flight_no"],
            "aircraft_type" => $row["aircraft_type"],
            "gate" => $row["gate"],
            "position" => $row["pos"],
            "registration" => $row["reg"],
            "belt" => $row["belt"],
            "remark" => $row["remark"]
        ]);
    }

    return $result;
}

function get_report_flight_carrier($flight_type = 'Arrival'){
    global $db;

    $sql = "SELECT carrier, COUNT(*) AS sum,
            case cast (strftime('%w', substr(schedule_date,7,4) || '-' || substr(schedule_date,4,2) || '-' || substr(schedule_date,0,3)) as integer)
                when 0 then 'Sun'
                when 1 then 'Mon'
                when 2 then 'Tue'
                when 3 then 'Wed'
                when 4 then 'Thu'
                when 5 then 'Fri'
                else 'Sat' end as week_day
            FROM Flight_Information
            WHERE flight_type = '".$flight_type."'
            GROUP BY carrier, week_day";

    $res = $db->query($sql);
    $result = [];

    while ($row = $res->fetchArray()) {
        if(!isset($result[$row["carrier"]])){
            $result[$row["carrier"]] = [];
        }
        $result[$row["carrier"]][$row["week_day"]] = $row["sum"];
    }
    return $result;
}

function get_report_flight_aircraft($flight_type = 'Arrival'){
    global $db;

    $sql = "SELECT aircraft_type, COUNT(*) AS sum,
            case cast (strftime('%w', substr(schedule_date,7,4) || '-' || substr(schedule_date,4,2) || '-' || substr(schedule_date,0,3)) as integer)
                when 0 then 'Sun'
                when 1 then 'Mon'
                when 2 then 'Tue'
                when 3 then 'Wed'
                when 4 then 'Thu'
                when 5 then 'Fri'
                else 'Sat' end as week_day
            FROM Flight_Information
            WHERE flight_type = '".$flight_type."'
            GROUP BY aircraft_type, week_day";

    $res = $db->query($sql);
    $result = [];

    while ($row = $res->fetchArray()) {
        if(!isset($result[$row["aircraft_type"]])){
            $result[$row["aircraft_type"]] = [];
        }
        $result[$row["aircraft_type"]][$row["week_day"]] = $row["sum"];
    }
    return $result;
}

function get_report_flight_carrier_aircraft($flight_type = 'Arrival'){
    global $db;

    $sql = "SELECT carrier, aircraft_type, COUNT(*) AS sum,
            case cast (strftime('%w', substr(schedule_date,7,4) || '-' || substr(schedule_date,4,2) || '-' || substr(schedule_date,0,3)) as integer)
                when 0 then 'Sun'
                when 1 then 'Mon'
                when 2 then 'Tue'
                when 3 then 'Wed'
                when 4 then 'Thu'
                when 5 then 'Fri'
                else 'Sat' end as week_day
            FROM Flight_Information
            WHERE flight_type = '".$flight_type."'
            GROUP BY carrier, aircraft_type, week_day";

    $res = $db->query($sql);
    $result = [];

    while ($row = $res->fetchArray()) {
        $key = $row["carrier"]."_".$row["aircraft_type"];

        if(!isset($result[$key])){
            $result[$key] = [];
            $result[$key]["carrier"] = $row["carrier"];
            $result[$key]["aircraft_type"] = $row["aircraft_type"];
        }
        $result[$key][$row["week_day"]] = $row["sum"];
        
    }
    return $result;
}

function get_report_by_hours($flight_type = 'Arrival'){
    global $db;

    $sql = "SELECT carrier, COUNT(*) AS sum,
                case cast (strftime('%w', substr(schedule_date,7,4) || '-' || substr(schedule_date,4,2) || '-' || substr(schedule_date,0,3)) as integer)
                when 0 then 'Sun'
                when 1 then 'Mon'
                when 2 then 'Tue'
                when 3 then 'Wed'
                when 4 then 'Thu'
                when 5 then 'Fri'
                else 'Sat' end as week_day,
                substr(schedule_date,12,2) as hour
            FROM Flight_Information
            WHERE flight_type = 'Arrival'
            GROUP BY carrier, week_day, hour
            ORDER BY carrier";
    
    $res = $db->query($sql);
    $result = [];
    $days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
    $result_by_day = [];

    while ($row = $res->fetchArray()) {
        if(!isset($result[$row["week_day"]])){
            $result[$row["week_day"]] = [
                "week_day" => $row["week_day"],
                "carriers" => []
            ];
        }
        if(!isset($result[$row["week_day"]]["carriers"][$row["carrier"]])){
            $result[$row["week_day"]]["carriers"][$row["carrier"]] = [];
        }
        if(!isset($result[$row["week_day"]]["carriers"][$row["carrier"]][$row["hour"]])){
            $result[$row["week_day"]]["carriers"][$row["carrier"]][$row["hour"]] = $row["sum"];
        }else{
            $result[$row["week_day"]]["carriers"][$row["carrier"]][$row["hour"]] += $row["sum"];
        }
        
    }
    foreach ($days as $day) {
        if(isset($result[$day])){
            array_push($result_by_day,$result[$day]);
        }else{
            array_push($result_by_day,null);
        }
    }
    return $result_by_day;
}

?>