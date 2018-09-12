<?php 
function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = rad2deg(acos(sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta))));
//  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
$unit = strtoupper($unit);

  if ($unit == "KM") {
    return ($miles * 1.609344);
  }
//  } else if ($unit == "N") {
////      return ($miles * 0.8684);
//       return($dist);
//    } else {
//          return($dist);
//      }
}

echo distance(  28.7041, 77.1025, 28.5355161, 77.3910265,"km") . " Kilometer<br>";
?>
<!--
to get row within particular range(in km) using lat long...

3959 - use for miles.
6371- use for km

SELECT *, (6371 * acos(cos(radians(28.7041)) * cos(radians(pickup_lat)) * cos( radians(pickup_long) - radians(77.1025)) + sin(radians(28.7041)) * 
sin(radians(pickup_lat)))) 
AS distance
FROM qa_job_posts HAVING distance < 15 ORDER BY distance LIMIT 0 , 10
-->