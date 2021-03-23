<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Valkyrie Hurry Up Drill</title>
  </head>
  <body>

  <div class="container">

    <p>Edit lists <a href="https://docs.google.com/spreadsheets/d/1uoEYbuYBpHDi4iPTNhf6Z1m-aSBWUo_MocINnfv2BzY">here</a></p>

<?php
$url = "https://docs.google.com/spreadsheets/d/1uoEYbuYBpHDi4iPTNhf6Z1m-aSBWUo_MocINnfv2BzY/export?format=csv";
$content = file_get_contents($url);


$headers = array();
$data = array();
$lines = explode("\n",$content);

$offense = array();
$defense = array(); 
$o_positions = array();
$d_positions =  array();
$players = array();
$i=0;
foreach ($lines as $line) {
    
    $cells = explode(",",$line); 
    if ($i==0) {
        $headers = $cells;
    } else {
        #$data[] = $cells;
        if ($cells[0]) { $data['offense'][] = $cells[0]; }
        if ($cells[1]) { $data['o_roles'][] = $cells[1]; }
        if ($cells[2]) { $data['defense'][] = $cells[2]; }
        if ($cells[3]) { $data['d_roles'][] = $cells[3]; }
        if ($cells[4]) { $data['all_players'][] = $i-1; }
        if ($cells[4]) { $data['players'][] = array("name" => $cells[4], "line" => $cells[5], "skill" => $cells[6]);  }
        if ($cells[5]) { $data['line_players'][] = $cells[4]; }
        if ($cells[6]) { $data['skill_players'][] = $cells[4]; }
    }
    $i++;
}

#BUILD THE OLINE

$o_line_players = array_rand($data['line_players'],5);
$line_members = array();
foreach ($o_line_players as $pk) {
    $line_members[] = $pk;
}

#BUILD SKILL

$remaining_players = array_diff($data['skill_players'], $o_line_players);
$o_skill_players = array_rand($remaining_players,6);

$skill_members = array();

foreach ($o_skill_players as $pk) {
    $skill_members[] = $pk;

}

shuffle($line_members);
shuffle($skill_members);

echo "<h5>Offense Players</h5>";
echo "<ul>";

$i=0;
foreach ($data['o_roles'] as $role) {
    if ($i<=4) {
        echo "<li>$role - ".$data['players'][$line_members[$i]]['name']."</li>";
    } else {
        $i2 = $i-5;
        echo "<li>$role: - ".$data['players'][$skill_members[$i2]]['name']."</li>";
    }
    $i++;
}
echo "</ul>";
#find remaining players

$remaining_players = array_diff($data['all_players'], $o_line_players);
$remaining_players = array_diff($remaining_players, $o_skill_players);

# BUILD DEFENSE 

$d_players = array_rand($remaining_players,11);
echo "<h5>Defense Players</h5>";
echo "<ul>";
shuffle($d_players);
$i=0;
foreach ($data['d_roles'] as $role) {
        echo "<li>$role - ".$data['players'][$d_players[$i]]['name']."</li>";
        $i++;
}
echo "</ul>";

# SEE WHO is SITTING

$remaining_players = array_diff($remaining_players, $d_players);
echo "<h5>Sitting Players</h5>";
echo "<ul>";
foreach ($remaining_players as $pk) {
    echo "<li>".$data['players'][$pk]['name']."</li>";
}
echo "</ul>";
#CALL OFFENSE

$offense = array_rand($data['offense'],5);

echo "<h5>Offensive Plays</h5>";
echo "<ul>";
foreach ($offense as $o) {
    echo "<li>".$data['offense'][$o]."</li>";
}
echo "</ul>";
# CALL DEFENSE

$defense = $data['defense'][array_rand($data['defense'],1)];
echo "<h4>Defensive Play</h4>";
echo "<p>$defense</p>";

?>







</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>