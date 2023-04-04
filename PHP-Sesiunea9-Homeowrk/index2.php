<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

$arrayNemodificat = [
  ["nume" => "Cosmin", "varsta" => 30, "genul" => "masculin"],
  ["nume" => "Mihaela", "varsta" => 24, "genul" => "feminin"],
  ["nume" => "Claudiu", "varsta" => 45, "genul" => "masculin"],
  ["nume" => "Costel", "varsta" => 60, "genul" => "masculin"],
  ["nume" => "Maria", "varsta" => 17, "genul" => "feminin"],
];

$array = $arrayNemodificat;

function validateInput($reguliDeValidare)
{
  // 2.Verifica valorile trimise din formular prin $_POST
  //      2.1 Folosim un parametru pentru verificare
  //      2.2 Folosim ca parametru un array
  //      2.3 const $array = ['nume' => 'required|min:3|max:20']
  //      2.3.1 $array = ['nume' => ['required' => true, 'min'=> 3, 'max'=>20]] --> varianta folosita
  foreach ($reguliDeValidare as $numeCamp => $reguli) {
    // parcurgem reguli de validare
    foreach ($reguli as $regulaKey => $regulaValue) {
      // parcurgem fiecare regula

      // 3.Pune mesaje de eroare pentru fiecare validare esuata
      //      3.1 setam mesajul de eroare $_POST['errors']['numele campului']
      switch ($regulaKey) {
        case "required":
          if ($regulaValue) {
            if (!isset($_POST[$numeCamp]) || empty($_POST[$numeCamp])) {
              $_POST["errors"][$numeCamp] =
                "Campul " . $numeCamp . " este obligatoriu.";
            }
          }
          break;
        case "min":
          if (strlen($_POST[$numeCamp]) < $regulaValue) {
            $_POST["errors"][$numeCamp] =
              "Campul " . $numeCamp . " este prea scurt.";
          }

          break;
        case "max":
          if (strlen($_POST[$numeCamp]) > $regulaValue) {
            $_POST["errors"][$numeCamp] =
              "Campul " . $numeCamp . "  este prea lung.";
          }
          break;
        default:
          break;
      }
    }
  }
  // 4.Opreste executia daca sunt validari esuate
  //      4.1 daca este setat $_POST['errors'] si nu este gol $_POST['errors']
  //      4.2 return false
  if (isset($_POST["errors"]) && !empty($_POST["errors"])) {
    return false;
  }

  return true;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (
    validateInput([
      "nume" => [
        "required" => true,
        "min" => 3,
        "max" => 15,
      ],
      "varsta" => [
        "required" => true,
      ],
      "genul" => [
        "required" => true,
      ],
    ])
  ) {
    echo '<p style="color:green">Datele au fost inregistrate cu succes.</p>';
    $_POST = [];
  } else {
    echo '<p style="color:red">Nu ati introdus datele corect!</p>';
    echo "<br>";
  }
}

function errorCheck($camp)
{
  if (isset($_POST["errors"][$camp]) && !empty($_POST["errors"][$camp])) {
    echo $_POST["errors"][$camp];
  }
}

function keepData(string $camp)
{
  if (isset($_POST[$camp])) {
    echo $_POST[$camp];
  }
}
?>

<html>
<a href="/despre.php">Despre
    Noi</a>
<br />
<a href="/produse.php">Produse</a>
<br />
<a href="/contact.php">Contact</a>
<br />
<h3>Formular inscriere</h3>
<form method="POST" action="<?php echo htmlspecialchars(
  $_SERVER["PHP_SELF"]
); ?>">
    <label>Nume Participant</label>
    <input type="text" placeholder="numele participantului" name="nume" value="<?php keepData(
      "nume"
    ); ?>" />
   <p style="color:red">
    <?php errorCheck("nume"); ?></p>
    <br />

    <label>Varsta</label>
    <input type="number" placeholder="varsta" name="varsta" value="<?php keepData(
      "varsta"
    ); ?>" />
    <p style="color:red">
    <?php errorCheck("varsta"); ?></p>
    <br />

    <label>Genul:</label>
    <br />
    <label>Masculin</label>
    <input type="radio" value="masculin" name="genul" <?php if (
      isset($_POST["genul"]) &&
      $_POST["genul"] === "masculin"
    ) {
      echo "checked";
    } ?> />
    <label>Feminin</label>
    <input type="radio" value="feminin" name="genul" <?php if (
      isset($_POST["genul"]) &&
      $_POST["genul"] === "feminin"
    ) {
      echo "checked";
    } ?> />
     <p style="color:red">
    <?php errorCheck("genul"); ?></p>
    <br />
    <button>Trimite</button>
</form>

<form method="GET" action="<?php $_SERVER["PHP_SELF"]; ?>">
    <label>Nume Participant</label>
    <input type="text" placeholder="numele participantului" name="nume" />
    <input type="submit" value="cauta" />
</form>

<table>
    <tr>
        <th>Nume</th>
        <th>Varsta</th>
        <th>Genul</th>
    </tr>
    <?php foreach ($array as $ar): ?>
        <tr>
            <td>
                <?php echo $ar["nume"]; ?>
            </td>
            <td>
                <?php echo $ar["varsta"]; ?>
            </td>
            <td>
                <?php echo $ar["genul"]; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</html>