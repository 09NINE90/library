<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['id'])) {
    header("location: index.php");
}
include_once "header.php";
?>

<body>
    <div class="wrap">
        <section class="search">
            <form action="#" method="POST">
                <header>Поиск книг</header>
                <div class="field input">
                    Фамилия<input type="text" name="surname">
                    Имя<input type="text" name="name">
                    Отчество<input type="text" name="patronymic">
                    Год
                    <div class="year">
                        <input type="text" name="from" placeholder="От">
                        <input type="text" name="to" placeholder="До">
                    </div>
                    Название<input type="text" name="title">
                </div>
                <div class="field button">
                    <input type="submit" name="button" value="Поиск">
                    <?php
                    if ($_SESSION['login'] == 'admin') {
                    ?>
                        <input type="submit" name="update" value="Добавить">
                    <?php
                    }
                    ?>
                </div>

            </form>
        </section>

        <?php
        if ($_REQUEST['update']) {
            $surname = $_REQUEST['surname'];
            $name = $_REQUEST['name'];
            $patronymic = $_REQUEST['patronymic'];
            $from = $_REQUEST['from'];
            $to = $_REQUEST['to'];
            $title = $_REQUEST['title'];
            if (!empty($surname) && !empty($name) && !empty($from) && !empty($title)) {
                $sql = "SELECT * FROM writers WHERE surname = '{$surname}' AND name = '{$name}' AND patronymic = '{$patronymic}'";
                $sql = mysqli_query($conn, $sql);
                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_array($sql);
                    $id = $row['id'];
                } else {
                    $sql = "INSERT INTO writers (surname,name,patronymic) VALUES ('$surname', '$name', '$patronymic')";
                    $sql = mysqli_query($conn, $sql);
                    $sql = "SELECT id FROM writers WHERE surname = '{$surname}' AND name = '{$name}' AND patronymic = '{$patronymic}'";
                    $sql = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($sql);
                    $id = $row['id'];
                }
                $sql = "INSERT INTO books (title,year_release,writers_id) VALUES ('$title', '$from', '$id')";
                $sql = mysqli_query($conn, $sql);
            }
        }
        
        if ($_REQUEST['button']) {
            $surname = $_REQUEST['surname'];
            $name = $_REQUEST['name'];
            $patronymic = $_REQUEST['patronymic'];
            $from = $_REQUEST['from'];
            $to = $_REQUEST['to'];
            $title = $_REQUEST['title'];
            function search($sql)
            { ?>
                <table>
                    <tbody>
                        <tr>
                            <td>Фамилия</td>
                            <td>Имя</td>
                            <td>Отчество</td>
                            <td>Название</td>
                            <td>Год издания</td>
                        </tr>
                        <?php
                        if (mysqli_num_rows($sql) > 0) {
                            while ($row = mysqli_fetch_array($sql)) {

                                echo "<tr>\n<td>" . $row["surname"] . "</td>" . "\n" . "<td>" . "" . $row["name"] . "
                                </td>" . "\n" . "<td>" . "" . $row["patronymic"] . "</td>" . "\n" . "<td>" . "" . $row["title"] .
                                    "</td>" . "\n" . "<td>" . "" . $row["year_release"] . " год </td>" . "\n" . "</tr>" . "\n";
                            }
                        } ?>
                    </tbody>
                </table>
        <?php
            }
            $str = "SELECT *  FROM books b LEFT JOIN writers w ON w.id = b.writers_id WHERE";
            $check = false;
            if (!empty($surname) || !empty($name) || !empty($patronymic)  || !empty($from) || !empty($to) || !empty($title)) {
                if (!empty($surname)) {
                    $str = $str . " surname LIKE '%{$surname}%'";
                    $check = true;
                }
                if (!empty($name)) {
                    if ($check) {
                        $str = $str . " AND name LIKE '%{$name}%'";
                    } else {
                        $str = $str . " name LIKE '%{$name}%'";
                        $check = true;
                    }
                }
                if (!empty($patronymic)) {
                    if ($check) {
                        $str = $str . " AND patronymic LIKE '%{$patronymic}%'";
                    } else {
                        $str = $str . " patronymic LIKE '%{$patronymic}%'";
                        $check = true;
                    }
                }
                if (!empty($title)) {
                    if ($check) {
                        $str = $str . " AND title LIKE '{%$title}%'";
                    } else {
                        $str = $str . " title LIKE '%{$title}%'";
                        $check = true;
                    }
                }
                if (!empty($from)) {
                    echo 111;
                    if ($check) {
                        $str = $str . " AND year_release >= '%{$from}%'";
                    } else {
                        $str = $str . " year_release >= '%{$from}%'";
                        $check = true;
                    }
                }
                if (!empty($to)) {
                    if ($check) {
                        $str = $str . " AND year_release <= '{$to}'";
                    } else {
                        $str = $str . " year_release <= '{$to}'";
                        $check = true;
                    }
                }
                $str = $str . "ORDER BY year_release";
                $sql = mysqli_query($conn, $str);
                search($sql);
            } else {
                echo "ничего не нашлось";
            }
        }
        ?>
    </div>
</body>

</html>