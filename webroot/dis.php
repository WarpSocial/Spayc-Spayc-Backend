<?php 
/*
 SELECT RADIANS(28.579477) AS "dr",RADIANS(Spaycs.longitude) AS "drf",28.579477 / 57.29577951 as "ned",Spaycs.id AS "Spaycs__id", Spaycs.name AS "Spaycs__name", Spaycs.location AS "Spaycs__location", 
Spaycs.latitude AS "Spaycs__latitude", Spaycs.longitude AS "Spaycs__longitude", Spaycs.user_id AS 
"Spaycs__user_id", 
 3963.0 * ACOS(
            (sin(28.579477 / 57.29577951) * SIN(28.579477 / 57.29577951)) +
            (COS(28.579477 / 57.29577951) * COS(28.579477 / 57.29577951) * COS(77.320818 / 57.29577951 - 77.320818/ 57.29577951))
        ) AS "distance" FROM spaycs Spaycs WHERE (status = 'Active' AND parent_id = 62) 
 
ROUND
    ( 
        CAST
            (
                (
                    3959 * ACOS
                    (
                        COS(RADIANS(28.579477)) * COS(RADIANS(Spaycs.latitude)) * COS(RADIANS(Spaycs.longitude) - RADIANS(77.320818) 
                    ) +
                    SIN(RADIANS(28.579477)) * SIN(RADIANS(Spaycs.longitude))
                )
            ) AS numeric
    ), 3
) 

SELECT Spaycs.id AS "Spaycs__id", Spaycs.name AS "Spaycs__name", Spaycs.location AS "Spaycs__location", 
Spaycs.latitude AS "Spaycs__latitude", Spaycs.longitude AS "Spaycs__longitude", Spaycs.user_id AS 
"Spaycs__user_id", ROUND( CAST(
  (3959 * ACOS(
            sin(RADIANS(28.579477)) * sin(RADIANS(Spaycs.latitude)) +
            COS( RADIANS(Spaycs.latitude) * COS(RADIANS(28.579477) *
            COS(RADIANS(77.320818) - RADIANS(77.320818)) *
            SIN(RADIANS(Spaycs.longitude))
        )) AS numeric), 3) AS "distance" FROM spaycs Spaycs WHERE (status = 'Active' AND parent_id = 62) 
 
 


SELECT Spaycs.id AS "Spaycs__id", Spaycs.name AS "Spaycs__name", Spaycs.location AS "Spaycs__location", 
Spaycs.latitude AS "Spaycs__latitude", Spaycs.longitude AS "Spaycs__longitude", Spaycs.user_id AS 
"Spaycs__user_id", 3963.0 * ACOS(
            (sin(28.579477 / 57.29577951) * SIN(28.579477 / 57.29577951)) +
            (COS(28.579477 / 57.29577951) * COS(28.579477 / 57.29577951) *
         COS(77.320818 / 57.29577951 - 77.320818/ 57.29577951))
        ) AS "distance" FROM spaycs Spaycs WHERE (status = 'Active' AND parent_id = 62) 

 
NVL(Radius,0) * ACOS(
            (sin(NVL(28.579477,0) / DegToRad) * SIN(NVL(28.579477,0) / DegToRad)) +
            (COS(NVL(28.579477,0) / DegToRad) * COS(NVL(28.579477,0) / DegToRad) *
         COS(NVL(77.320818,0) / DegToRad - NVL(77.320818,0)/ DegToRad))
        )
 
 
 RETURN(
    NVL(Radius,0) * ACOS(
            (sin(NVL(Lat1,0) / DegToRad) * SIN(NVL(Lat2,0) / DegToRad)) +
            (COS(NVL(Lat1,0) / DegToRad) * COS(NVL(Lat2,0) / DegToRad) *
         COS(NVL(Lon2,0) / DegToRad - NVL(Lon1,0)/ DegToRad))
        )
);
 */
function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

echo distance(29.579477, 77.320818, 28.579477, 77.320818, "M") . " Miles<br>";
echo distance(29.579477, 77.320818, 28.579477, 77.320818, "K") . " Kilometers<br>";
echo distance(29.579477, 77.320818, 28.579477, 77.320818, "N") . " Nautical Miles<br>";
?>