<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Food</title>            
    <link rel="stylesheet" href="css/css_reset.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/order.css">
</head>

<body>

<?php
        require_once("dbInfo.php");

        // create connection to database
        $mysqli = new mysqli($hostname, $dbUser, $dbPassword, $db);

        // check db connection
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_errno;
            exit();
        }

        // do something
        $sqlstatement = "SELECT categories.catTitle,menu.title,menu.picFilename,menu.unitPrice,menu.itemID FROM menu LEFT JOIN categories ON menu.categoryFK = categories.catID";
        $result = $mysqli -> query($sqlstatement);
?>

<?php
    session_start();
    
    require_once("header.php");
?>

    <section id="main">
        <form action="submitorder.php" method="post">
            <h1>Hi <?= $_SESSION['fullname'] ?>, please order from the items below:</h1>
            <div class="grid-container">

                <?php while ($record = $result -> fetch_assoc()) { ?>
                    <div class="col <?= $record['catTitle'] ?>"> 
                        <h1><?= $record['catTitle'] ?></h1>
                        <div class="fooditem">
                            <table>
                                <tr>
                                    <td>
                                        <img src="images/<?= $record['picFilename'] ?>" alt="">
                                    </td>
                                    <td>
                                        <span class="itemname"><?= $record['title'] ?></span><br>
                                        $<span class="price"><?= number_format($record['unitPrice'],2) ?></span>
                                    </td>
                                    <td>
                                        <span class="qty">Qty</span><br>
                                        <select name="<?= $record['itemID'] ?>" class="selectitem">
                                            <option value="0" selected>None</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                                
                    </div>
                <?php } ?>

                <div class="col totalinfo">
                    <h1>Total Order Information</h1>
                    <div id="itemised">
                    </div>      
                    
                    <div id="weather"> 
                    </div> 
                    <input id="submit_button" class="button" type="submit" value="Submit Order">
                
                </div>
            </div>
    </form>       
    </section>

<?php
    require_once("footer.php");
?>

    <script src="js/jquery.js"></script>
    <script src="js/order_1.js"></script>
    <script src="js/weather_1.js"></script>

<?php
    $result -> free_result();
    
    // close db connection
    $mysqli -> close();
?>
</body>

</html>