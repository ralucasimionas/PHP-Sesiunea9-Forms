<?php
$inputArray = [["name" => "name", "type" => "text"]];

function createInput($name, $type)
{
  global $inputArray;

  $exista = false;
  //   var_dump($inputArray);
  foreach ($inputArray as $inputs) {
    foreach ($inputs as $value) {
      if (strlen($value) === strlen($name)) {
        $exista = true;
        break;
      }
    }
  }
  if (!$exista) {
    $newName = ucfirst($name);
    array_push($inputArray, ["name" => $newName, "type" => $type]);

    echo "<label>$newName:  </label>
    
      <input name=$newName type=$type placeholder=$newName><br/><br/>";
  } else {
    echo "<p style='color:red'>Exista deja un input cu numele '$name' .</p>";
    echo "<br/>";
  }
}

createInput("nume", "text");
createInput("varsta", "text");
createInput("telefon", "number");

?>
