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
#print_r($lines);
$offense = array();
$defense = array(); 
$o_positions = array();
$d_positions =  array();
$players = array();
$remaining_players = array();
$i=0;
foreach ($lines as $line) {
    $cells = null;
    $cells = explode(",",$line); 
    if ($i==0) {
        $headers = $cells;
    } else {
        #$data[] = $cells;
        #print_r($cells);
        if ($cells[0]) { $data['offense'][] = $cells[0]; }
        if ($cells[1]) { $data['o_roles'][] = $cells[1]; }
        if ($cells[2]) { $data['defense'][] = $cells[2]; }
        if ($cells[3]) { $data['d_roles'][] = $cells[3]; }
        $missing = $cells[7];
        #echo "---->".$missing."<-----";
        if (!$missing) {
            #echo "adding row $i\n";
            if ($cells[4]) { $data['all_players'][] = $i-1; }
            if ($cells[4]) { $data['players'][$i-1] = array("name" => $cells[4], "line" => $cells[5], "skill" => $cells[6]);  }
            if ($cells[5]) { $data['line_players'][] = $i-1; }
            if ($cells[6]) { $data['skill_players'][] = $i-1; }
        } else {
            if ($cells[4]) { $data['missing'][$i-1] = array("name" => $cells[4], "line" => $cells[5], "skill" => $cells[6]);  }
        }
    }
    #$cells7 = $cells[7];
    #echo "--->$cells7<---";
    $i++;
}
$all_players = $data['players'];
#print_r($data['players']);

echo "<h5>All non-missing Players</h5>\n";
echo "<ul>\n";
$i = 0;
foreach ($data['players'] as $pk => $player) {
    $i++;
    echo "<li>$i) $pk ".$player['name']."</li>\n";
}
echo "</ul>\n";





#BUILD THE OLINE
echo "<!-- ALL O LINE --->\n";
#print_r($data['line_players']);

echo "<!-- 5 Random O Line Player --->\n";
$o_line_players = array();
$o_line_players = array_rand($data['line_players'],5);
#print_r($o_line_players);

$selected_line_players = array();
foreach ($o_line_players as $k => $pk) {
    #echo "-$pk\n";
    $selected_line_players[] = $data['line_players'][$pk];
}
#print_r($selected_line_players);


#BUILD SKILL
echo "<!-- All SKILL Players --->\n";
#print_r($data['skill_players']);
$remaining_players = array_diff($data['skill_players'], $o_line_players);

echo "<!-- Remaining Skill after Line Selections --->\n";
#print_r($remaining_players);
$o_skill_players = array_rand($remaining_players,6);
echo "<!-- 6 Random Skill --->\n";
#print_r($o_skill_players);

$selected_skill_players = array();
foreach ($o_skill_players as $k => $pk) {
    #echo "-$pk\n";
    $selected_skill_players[] = $remaining_players[$pk];
}
#print_r($selected_skill_players);

echo "<!-- FINAL LINE --->\n";
#print_r($o_line_players);

echo "<!-- FINAL SKILL --->\n";
#print_r($selected_skill_players);











shuffle($selected_line_players);
shuffle($selected_skill_players);













echo "<!-- SUFFLED LINE --->\n";
#print_r($selected_line_players);

echo "<!-- SHUFFLED SKILL --->\n";
#print_r($selected_skill_players);

echo "<h5>Offense Players</h5>\n";
echo "<ul>\n";

$i=0;
foreach ($data['o_roles'] as $role) {
    if ($i<=4) {

        echo "<li>$role - ".$data['players'][$selected_line_players[$i]]['name']."</li>\n";
    } else {
        $i2 = $i-5;
        echo "<li>$role: - ".$data['players'][$selected_skill_players[$i2]]['name']."</li>\n";
    }
    $i++;
}
echo "</ul>\n";
#find remaining players

$remaining_players = array_diff($data['all_players'], $selected_line_players);
#print_r($remaining_players);
$remaining_players = array_diff($remaining_players, $selected_skill_players);
#print_r($remaining_players);

# BUILD DEFENSE 
echo "<!-- select 11 defense playser --->\n";
$d_players = array_rand($remaining_players,11);
$selected_d_players = array();
foreach ($d_players as $k => $pk) {
    #echo "-$pk\n";
    $selected_d_players[] = $remaining_players[$pk];
}

#print_r($selected_d_players);

echo "<h5>Defense Players</h5>\n";
echo "<ul>\n";
shuffle($selected_d_players);
$i=0;
foreach ($data['d_roles'] as $role) {
        echo "<li>$role - ".$data['players'][$selected_d_players[$i]]['name']."</li>\n";
        $i++;
}
echo "</ul>\n";

# SEE WHO is SITTING

$remaining_players = array_diff($remaining_players, $selected_d_players);

#print_r($remaining_players);
#print_r($all_players);
echo "<h5>Sitting Players</h5>\n";
echo "<ul>\n";
foreach ($remaining_players as $pk) {
    echo "<li>".$all_players[$pk]['name']."</li>\n";
}
echo "</ul>\n";

# SEE WHO is MISSING
#print_r($data['missing']);
echo "<h5>Missing Players</h5>\n";
echo "<ul>\n";
$i =0;
foreach ($data['missing'] as $m) {
    $i++;
    echo "<li>$i) ".$m['name']."</li>\n";
}
echo "</ul>\n";

#CALL OFFENSE

$offense = array_rand($data['offense'],5);

echo "<h5>Offensive Plays</h5>\n";
echo "<ul>\n";
foreach ($offense as $o) {
    echo "<li>".$data['offense'][$o]."</li>\n";
}
echo "</ul>\n";
# CALL DEFENSE

$defense = $data['defense'][array_rand($data['defense'],1)];
echo "<h4>Defensive Play</h4>\n";
echo "<p>$defense</p>\n";

?>







</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>