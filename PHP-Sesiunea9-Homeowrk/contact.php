<?php

$reguli = [
  "nume" => [
    "required" => true,
    "min" => 3,
    "max" => 20,
  ],
  "telefon" => [
    "required" => true,
    "min" => 10,
    "max" => 12,
  ],
  "localitate" => [
    "required" => true,
    "max" => 25,
  ],
  "varsta" => [
    "required" => true,
  ],
  "genul" => [
    "required" => true,
  ],
];

$women = [
  [
    "nume" => "Ioana",
    "telefon" => "0721224556",
    "localitate" => "Oradea",
    "varsta" => "22",
    "genul" => "feminin",
  ],
  [
    "nume" => "Diana",
    "telefon" => "0743589120",
    "localitate" => "Cluj",
    "varsta" => "27",
    "genul" => "feminin",
  ],
  [
    "nume" => "Adela",
    "telefon" => "0720917472",
    "localitate" => "Timisoara",
    "varsta" => "31",
    "genul" => "feminin",
  ],
  [
    "nume" => "Maria",
    "telefon" => "0752679012",
    "localitate" => "Sibiu",
    "varsta" => "23",
    "genul" => "feminin",
  ],
  [
    "nume" => "Andreea",
    "telefon" => "0734123789",
    "localitate" => "Bucuresti",
    "varsta" => "33",
    "genul" => "feminin",
  ],
  [
    "nume" => "Mihaela",
    "telefon" => "0729072644",
    "localitate" => "Constanta",
    "varsta" => "29",
    "genul" => "feminin",
  ],
];

$men = [
  [
    "nume" => "Stefan",
    "telefon" => "0729765234",
    "localitate" => "Satu Mare",
    "varsta" => "28",
    "genul" => "masculin",
  ],
  [
    "nume" => "Bogdan",
    "telefon" => "0741257890",
    "localitate" => "Oradea",
    "varsta" => "31",
    "genul" => "masculin",
  ],
  [
    "nume" => "Mihai",
    "telefon" => "0728653998",
    "localitate" => "Iasi",
    "varsta" => "22",
    "genul" => "masculin",
  ],
  [
    "nume" => "Alex",
    "telefon" => "0757876112",
    "localitate" => "Sighisoara",
    "varsta" => "24",
    "genul" => "masculin",
  ],
  [
    "nume" => "Andrei",
    "telefon" => "0721222675",
    "localitate" => "Craiova",
    "varsta" => "35",
    "genul" => "masculin",
  ],
  [
    "nume" => "Denis",
    "telefon" => "0737129065",
    "localitate" => "Braila",
    "varsta" => "23",
    "genul" => "masculin",
  ],
];

// 1.functie refolosibila pentru superglobala $_POST +
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
      if ($numeCamp !== "genul") {
        $camp = htmlspecialchars($_POST[$numeCamp]);
      } // curatam inputul de posibile atacuri XSS

      // 3.Pune mesaje de eroare pentru fiecare validare esuata
      //      3.1 setam mesajul de eroare $_POST['errors']['numele campului']

      switch ($regulaKey) {
        case "required":
          if ($regulaValue) {
            if (!isset($camp) || empty($camp)) {
              $_POST["errors"][$numeCamp] =
                "Campul " . $numeCamp . " este obligatoriu.";
            }
          }
          break;
        case "min":
          if (strlen($camp) < $regulaValue) {
            $_POST["errors"][$numeCamp] =
              "Campul " . $numeCamp . " este prea scurt.";
          }

          break;
        case "max":
          if (strlen($camp) > $regulaValue) {
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
        // folosim pentru existenta si sa nu fie gol
        "min" => 3,
        // pentru numar minim de caractere
        "max" => 20,
        // pentru numar maxim de caractere
      ],
      "telefon" => [
        "required" => true,
        "min" => 10,
        "max" => 12,
      ],
      "localitate" => [
        "required" => true,
        "max" => 25,
      ],
      "varsta" => [
        "required" => true,
      ],
      "genul" => [
        "required" => true,
      ],
    ])
  ) {
    // continuam cu logica
    // adaugam in lista
    $exista = false;
    if ($_POST["genul"] === "feminin") {
      foreach ($women as $ar) {
        if (strtolower($ar["nume"]) === strtolower($_POST["nume"])) {
          $exista = true;
        }
      }
    } else {
      foreach ($men as $ar) {
        if (strtolower($ar["nume"]) === strtolower($_POST["nume"])) {
          $exista = true;
        }
      }
    }

    if (!$exista) {
      $participant = [
        "nume" => $_POST["nume"],
        "telefon" => $_POST["telefon"],
        "localitate" => $_POST["localitate"],
        "varsta" => $_POST["varsta"],
        "genul" => $_POST["genul"],
      ];

      if ($_POST["genul"] === "feminin") {
        array_push($women, $participant);
      } else {
        array_push($men, $participant);
      }
    } else {
      echo "Participantul exista deja";
      echo "<br/>";
    }
  } else {
    echo "Nu ati introdus datele corect!";
    echo "<br/>";
  }
  echo $_POST["nume"];
} else {
  echo "esuat";
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  if (isset($_GET["womensearch"]) && !empty($_GET["womensearch"])) {
    echo $_GET["womensearch"];
    echo "<br/>";

    $womenResults = array_filter($women, function ($arr) {
      if (strtolower($arr["nume"]) === strtolower($_GET["womensearch"])) {
        return true;
      }
      return false;
    });

    $women = $womenResults;
  } elseif (isset($_GET["mensearch"]) && !empty($_GET["mensearch"])) {
    echo $_GET["mensearch"];
    echo "<br/>";

    $menResults = array_filter($men, function ($arr) {
      if (strtolower($arr["nume"]) === strtolower($_GET["mensearch"])) {
        return true;
      }
      return false;
    });

    $men = $menResults;
  }
}

function errorCheck($camp)
{
  if (isset($_POST["errors"][$camp]) && !empty($_POST["errors"][$camp])) {
    echo $_POST["errors"][$camp];
  }
}
?>

<html>
<h1>Contact</h1>
<form method="post" action="<?php echo htmlspecialchars(
  $_SERVER["PHP_SELF"]
); ?>">
    <input type="text" name='nume' placeholder="Numele participantului" />
    <br>
    <p style="color:red">
    <?php errorCheck("nume"); ?></p>
    <br>

    <input type="text" name='telefon' placeholder="Numar de telefon" />
    <br>
    <p style="color:red">
    <?php errorCheck("telefon"); ?></p>
    <br>

    <input type="text" name='localitate' placeholder="Localitate" />
    <br>
    <p style="color:red">
    <?php errorCheck("localitate"); ?></p>
    <br>

    <input type="number" name='varsta' placeholder="Varsta" />
    <br>
    <p style="color:red">
    <?php errorCheck("varsta"); ?></p>
    <br>


    <label>Genul</label>
    <br>
    <label>Masculin</label>
    <input type="radio" value='masculin' name="genul" />
    <br>
    <label>Feminin</label>
    <input type="radio" value='feminin' name="genul" />
    <br>
    <p style="color:red">
    <?php errorCheck("genul"); ?></p>
    <br>
    <input type="submit" value="Trimite" />
</form>


<h3>Participanti de sex feminin</h3>
<table>
    <tr>
        <th>Nume</th>
        <th>Telefon</th>
        <th>Localitate</th>
        <th>Varsta</th>
    </tr>
    <?php foreach ($women as $ar): ?>
        <tr>
            <td><?php echo $ar["nume"]; ?></td>
            <td><?php echo $ar["telefon"]; ?></td>
            <td><?php echo $ar["localitate"]; ?></td>
            <td><?php echo $ar["varsta"]; ?></td>
        </tr>
    <?php endforeach; ?> 
</table>

<form method="GET" action="<?php $_SERVER["PHP_SELF"]; ?>">
   <br/> <label>Cautare participant de sex feminin:</label><br/>
    <input type="text" placeholder="Numele participantului" name="womensearch"/>
    <button type="submit">Cauta</button>  

    

</form>
<br/>
<h3>Participanti de sex masculin</h3>
<table>
    <tr>
        <th>Nume</th>
        <th>Telefon</th>
        <th>Localitate</th>
        <th>Varsta</th>
    </tr>
    <?php foreach ($men as $ar): ?>
        <tr>
            <td><?php echo $ar["nume"]; ?></td>
            <td><?php echo $ar["telefon"]; ?></td>
            <td><?php echo $ar["localitate"]; ?></td>
            <td><?php echo $ar["varsta"]; ?></td>
        </tr>
    <?php endforeach; ?> 
</table>
<form method="GET" action="<?php $_SERVER["PHP_SELF"]; ?>">
    <br/><label>Cautare participant de sex masculin:</label><br/>
    <input type="text" placeholder="Numele participantului" name="mensearch"/>
    <button type="submit">Cauta</button>  

    

</form>

</html>