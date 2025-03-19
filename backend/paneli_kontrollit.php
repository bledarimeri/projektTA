<?php

include 'db.php';

// Merr numrin e desiminatorëve
$sql = "SELECT COUNT(*) AS numri_desiminatoreve FROM desiminatoret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$numri_desiminatoreve = $stmt->fetch(PDO::FETCH_ASSOC)['numri_desiminatoreve'];

// Merr numrin e vullnetarëve
$sql = "SELECT COUNT(*) AS numri_vullnetareve FROM vullnetaret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$numri_vullnetareve = $stmt->fetch(PDO::FETCH_ASSOC)['numri_vullnetareve'];

// Merr numrin e mentorëve
$sql = "SELECT COUNT(*) AS numri_mentoreve FROM mentoret";
$stmt = $conn->prepare($sql);
$stmt->execute();
$numri_mentoreve = $stmt->fetch(PDO::FETCH_ASSOC)['numri_mentoreve'];

// Merr numrin e projekteve në zhvillim
$sql = "SELECT COUNT(*) AS projektet_ne_zhvillim FROM projektet WHERE statusi = 'ne zhvillim'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$projektet_ne_zhvillim = $stmt->fetch(PDO::FETCH_ASSOC)['projektet_ne_zhvillim'];

// Merr numrin e projekteve të përfunduara
$sql = "SELECT COUNT(*) AS projektet_e_perfunduara FROM projektet WHERE statusi = 'perfunduara'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$projektet_e_perfunduara = $stmt->fetch(PDO::FETCH_ASSOC)['projektet_e_perfunduara'];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Paneli i kontrollit</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 100%;
        margin: 0 auto;
        padding-right: 20px;
    }

    .stat-container {
        display: flex;
        justify-content: space-around;
        margin-bottom: 50px;
    }

    .stat-box {
        width: 200px;
        height: 200px;
        background-color: #f2a900;
        color: black;
        text-align: center;
        vertical-align: middle;
        line-height: 40px;
        margin: 15px;
        font-size: 20px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        border-radius: 10px;
    }

    .calendar-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 60px;
    }

    .calendar {
        margin-top: 40px;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .calendar table {
        border-collapse: collapse;
        width: 100%;
    }

    .calendar th,
    .calendar td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .calendar th {
        background-color: #f2a900;
        color: black;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Paneli i kontrollit</h1>
        <div class="stat-container">
            <div class="stat-box">
                <div>Numri i Desiminatorëve</div>
                <div><?= $numri_desiminatoreve ?></div>
            </div>
            <div class="stat-box">
                <div>Numri i Vullnetarëve</div>
                <div><?= $numri_vullnetareve ?></div>
            </div>
            <div class="stat-box">
                <div>Numri i Mentorëve</div>
                <div><?= $numri_mentoreve ?></div>
            </div>
            <div class="stat-box">
                <div>Projektet në zhvillim</div>
                <div><?= $projektet_ne_zhvillim ?></div>
            </div>
            <div class="stat-box">
                <div>Projektet e përfunduara</div>
                <div><?= $projektet_e_perfunduara ?></div>
            </div>
        </div>

        <div class="calendar-container">
            <label for="ora">Zgjidh Orën:</label>
            <select id="ora" name="ora">
                <option value="1">11:00</option>
                <option value="2">12:00</option>
                <option value="3">13:00</option>
                <!-- Shto opsione të tjera këtu -->
            </select>
            <div id="calendar" class="calendar"></div>
        </div>
    </div>

    <script>
    // Kalendar dummy për demonstrim
    document.getElementById('calendar').innerHTML = `
        <table>
            <thead>
                <tr>
                    <th>SUN</th>
                    <th>MON</th>
                    <th>TUE</th>
                    <th>WED</th>
                    <th>THU</th>
                    <th>FRI</th>
                    <th>SAT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>13</td>
                    <td>14</td>
                    <td>15</td>
                    <td>16</td>
                    <td>17</td>
                    <td>18</td>
                </tr>
                <tr>
                    <td>19</td>
                    <td>20</td>
                    <td>21</td>
                    <td>22</td>
                    <td>23</td>
                    <td>24</td>
                    <td>25</td>
                </tr>
                <tr>
                    <td>26</td>
                    <td>27</td>
                    <td>28</td>
                    <td>29</td>
                    <td>30</td>
                    <td>31</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    `;
    </script>
</body>

</html>