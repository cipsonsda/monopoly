<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gry komputerowe</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

    <!-- Blok nagłówkowy -->
    <header>
        <h1>Ranking gier komputerowych</h1>
    </header>

    <!-- Blok sekcji lewej -->
    <aside class="lewy">
        <h3>Top 5 gier w tym miesiącu</h3>
        <ul>
            <?php
                $conn = new mysqli('localhost', 'root', '', 'dane');
                $conn->set_charset("utf8");

                $sql1 = "SELECT nazwa, punkty FROM gry ORDER BY punkty DESC LIMIT 5";
                $res1 = $conn->query($sql1);
                while($row = $res1->fetch_assoc()) {
                    echo "<li>" . $row['nazwa'] . " <span class='punkty'>" . $row['punkty'] . "</span></li>";
                }
            ?>
        </ul>

        <h3>Nasz sklep</h3>
        <p><a href="http://sklep.gry.pl" target="_blank">Tu kupisz gry</a></p>

        <h3>Stronę wykonał</h3>
        <p>00000000000</p>
    </aside>

    <!-- Blok sekcji środkowej: Skrypt 2 (wyświetlenie wszystkich gier/postaci) -->
    <section class="srodkowy">
        <?php
            $sql2 = "SELECT nazwa, zdjecie FROM gry";
            $res2 = $conn->query($sql2);
            while($row = $res2->fetch_assoc()) {
                echo "<div class='blok-gry'>";
                echo "<img src='" . $row['zdjecie'] . "' alt='" . $row['nazwa'] . "'>";
                echo "<p>" . $row['nazwa'] . "</p>";
                echo "</div>";
            }
        ?>
    </section>

    <!-- Blok sekcji prawej -->
    <aside class="prawy">
        <h3>Dodaj nową grę</h3>
        <form action="gry.php" method="POST">
            <label for="nazwa">nazwa</label>
            <input type="text" id="nazwa" name="nazwa">

            <label for="opis">opis</label>
            <input type="text" id="opis" name="opis">

            <label for="cena">cena</label>
            <input type="text" id="cena" name="cena">

            <label for="zdjecie">zdjęcie</label>
            <input type="text" id="zdjecie" name="zdjecie">

            <input type="submit" value="DODAJ">
        </form>
        <?php
            if (!empty($_POST['nazwa'])) {
                $n = $conn->real_escape_string($_POST['nazwa']);
                $o = $conn->real_escape_string($_POST['opis']);
                $c = floatval($_POST['cena']);
                $z = $conn->real_escape_string($_POST['zdjecie']);
                $sql_ins = "INSERT INTO gry (nazwa, opis, cena, zdjecie, punkty) VALUES ('$n', '$o', $c, '$z', 0)";
                $conn->query($sql_ins);
            }
        ?>
    </aside>

    <!-- Blok stopki: Skrypt 3 -->
    <footer>
        <form action="gry.php" method="POST">
            <input type="text" id="szukaj_id" name="szukaj_id">
            <input type="submit" value="Pokaż opis">
        </form>
        <?php
            if (!empty($_POST['szukaj_id'])) {
                $id = intval($_POST['szukaj_id']);
                $sql3 = "SELECT nazwa, punkty, cena, opis FROM gry WHERE id = $id";
                $res3 = $conn->query($sql3);
                if ($row3 = $res3->fetch_assoc()) {
                    echo "<div id='opis-wynik'>";
                    echo "<p><strong>" . $row3['nazwa'] . ", " . $row3['punkty'] . " punktów, " . $row3['cena'] . " zł</strong></p>";
                    echo "<p>" . $row3['opis'] . "</p>";
                    echo "</div>";
                }
            }
            $conn->close();
        ?>
    </footer>

</body>
</html>
