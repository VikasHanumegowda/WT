<html>
    <head>
        <title>
            Homework 6
        </title>
        <style>
            table{
                border-collapse: collapse;
                padding: 0;
                text-align: center;
                margin: 0px;
                border-width: 1px;
                border-style: solid;
                border-color: #888;
                width: 100%;
            }
            th{
                height: 100%;
                background: #D0D0D0;
                max-width: 50%px;
                border: solid;
                border-color: #808080;
                border-width: 1px;
                padding: 0;

            }
            body {
                min-width:650px;
            }
            td {
                padding: 0;
                width:50%;
            }
        </style>
    </head>
    <body>
            <div style="width: 500px; height: auto; background: #C0C0C0;  margin-left: auto; margin-right: auto; padding-left: 2px; padding-right: 2px; border-style: solid; border-width: 1px; border-color: #808080; margin-bottom: 15px;">
                <div style="font-size: 40px;text-align: center;">Stock Search</div>
                <hr style="color: #808080;">
                <form method=POST action=<?php echo $_SERVER["PHP_SELF"]; ?>>
                    <div>
                        <p style="font-size: 20px;display: inline-block;">Enter Stock Ticker Symbol:*</p>
                        <input style="display: inline-block; width: 50%;" type="text" name="STS"><br>
                        <input style="font-size: 20px; margin-left: 245px;margin-right: 10px;" type="submit" value="Search" name="Search" id="Search">
                        <input style="font-size: 20px;" type="button" value="Clear" name="Clear">
                    </div>
                </form>
                <p>* - <i>Mandatory fields.</i></p>
            </div>
            <?php

            function startsWith($haystack, $needle)
            {
                $length = strlen($needle);
                return (substr($haystack, 0, $length) === $needle);
            }

            function test_input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if (isset($_POST["Search"])): {
                if ($_POST["STS"] == ""): {
                    echo "<script type='text/javascript'>alert('Please enter a symbol');</script>";
                }
                else: {
                    $symbol = test_input($_POST["STS"]);
                    $url = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $symbol . "&apikey=OGY0S9LG8J8ADNZW";
                    $response = file_get_contents($url);
                    $response = json_decode($response,true);
                    $date = $response["Meta Data"]["3. Last Refreshed"];
                    if (key_exists("Error Message",$response) and startsWith($response["Error Message"],"Invalid")===true):
                    {
                        echo "<table>";
                        echo "<tr><th>Error</th><td>Error: NO record has been found, please enter a valid symbol</td></tr>";
                        echo "</table>";
                    }
                    else:
                    {   #$response["Time Series (Daily)"]["2017-10-06"]["1. open"]
                        echo "<table>";
                        echo "<tr><th>Stock Ticker Symbol</th><td>".$symbol."</td></tr>";
                        echo "<tr><th>Close</th><td>".$response["Time Series (Daily)"][$date]["4. close"]."</td></tr>";
                        echo "<tr><th>Open</th><td>".$response["Time Series (Daily)"][$date]["1. open"]."</td></tr>";
//                        #echo "<tr><th>Previous Close</th><td>". ."</td></tr>";
//                        echo "<tr><th>Change</th><td>". ."</td></tr>";
//                        echo "<tr><th>Change Precent</th><td>". ."</td></tr>";
//                        echo "<tr><th>Day's Range</th><td>". ."</td></tr>";
                        echo "<tr><th>Volume</th><td>".$response["Time Series (Daily)"][$date]["5. volume"]."</td></tr>";
                        echo "<tr><th>Timestamp</th><td>".$date."</td></tr>";
//                        echo "<tr><th>Indicators</th><td>". ."</td></tr>";
                        echo "</table>";
                    }
                    endif;
                }
                endif;
            }
            endif; ?>
    </body>
</html>