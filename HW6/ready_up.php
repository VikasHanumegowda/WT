<html>
    <head>
        <title>
            Homework 6
        </title>
        <style>
            body {
                min-width:650px;
            }
            td {
                padding: 0px;
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
//                    echo $response;
                    $response = json_decode($response,true);
                    //echo $response->"Error Message";
                    if (startsWith($response["Error Message"],"Invalid")):
                    {
                          echo "<table style=\"text-align:center; margin:0px; border-width:1px; padding:0px; border-style:solid; border-color:#888; width:100%\">";
                          echo "<tr><th style=\"height:100%; background:#D0D0D0; border-right: solid; border-color: #808080; border-width: 1px; padding: 0px;\">Error</th><td>Error: NO record has been found, please enter a valid symbol</td></tr>";
                          echo "</table>";
                    }
                    else:
                    {
                        echo "<table style=\"text-align:center; margin:0px; border-width:1px; padding:0px; border-style:solid; border-color:#888; width:100%\">";
                        echo "<tr><th style=\"height:100%; background:#D0D0D0; max-width: 300px; border-right: solid; border-color: #808080; border-width: 1px; padding: 0px;\"></th><td>Error: NO record has been found, please enter a valid symbol</td></tr>";
                        echo "</table>";
                    }
                    endif;
                }
                endif;
            }
            endif; ?>


</body>
</html>