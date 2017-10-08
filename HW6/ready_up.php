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
                margin: 0;
                border-width: 1px;
                border-style: solid;
                border-color: #888;
                width: 100%;
            }
            th{
                background: #D0D0D0;
                width: 50%;
                border: solid;
                border-color: #808080;
                border-width: 1px;
                padding: 0;

            }
            body {
                min-width:650px;
            }
            td {
                background: #F0F0F0;
                width: 50%;
                border: solid;
                border-color: #808080;
                border-width: 1px;
                padding: 0;
            }
            span img{
                height: 19px;
                width: auto;
            }
        </style>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>

        <script type="text/javascript">
            function bringin_data(url) {
//                var xhttp = new XMLHttpRequest();
//                xhttp.onreadystatechange = function() {
//                    if (this.readyState == 4 && this.status == 200) {
//                        // Action to be performed when the document is read;
//                    }
//                };
//                xhttp.open("GET",url , false);
//                xhttp.send();
//                var xmlDoc = xhttp.responseText;
//                obj = JSON.parse(xmlDoc);
                Highcharts.chart('container', {
                    chart: {
                        type: 'area'
                    },
                    title: {
                        text: 'US and USSR nuclear stockpiles'
                    },
                    subtitle: {
                        text: 'Source: <a href="http://thebulletin.metapress.com/content/c4120650912x74k7/fulltext.pdf">' +
                        'thebulletin.metapress.com</a>'
                    },
                    xAxis: {
                        allowDecimals: false,
                        labels: {
                            formatter: function () {
                                return this.value; // clean, unformatted number for year
                            }
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Nuclear weapon states'
                        },
                        labels: {
                            formatter: function () {
                                return this.value / 1000 + 'k';
                            }
                        }
                    },
                    tooltip: {
                        pointFormat: '{series.name} produced <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
                    },
                    plotOptions: {
                        area: {
                            pointStart: 1940,
                            marker: {
                                enabled: false,
                                symbol: 'circle',
                                radius: 2,
                                states: {
                                    hover: {
                                        enabled: true
                                    }
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'USA',
                        data: [null, null, null, null, null, 6, 11, 32, 110, 235, 369, 640,
                            1005, 1436, 2063, 3057, 4618, 6444, 9822, 15468, 20434, 24126,
                            27387, 29459, 31056, 31982, 32040, 31233, 29224, 27342, 26662,
                            26956, 27912, 28999, 28965, 27826, 25579, 25722, 24826, 24605,
                            24304, 23464, 23708, 24099, 24357, 24237, 24401, 24344, 23586,
                            22380, 21004, 17287, 14747, 13076, 12555, 12144, 11009, 10950,
                            10871, 10824, 10577, 10527, 10475, 10421, 10358, 10295, 10104]
                    }, {
                        name: 'USSR/Russia',
                        data: [null, null, null, null, null, null, null, null, null, null,
                            5, 25, 50, 120, 150, 200, 426, 660, 869, 1060, 1605, 2471, 3322,
                            4238, 5221, 6129, 7089, 8339, 9399, 10538, 11643, 13092, 14478,
                            15915, 17385, 19055, 21205, 23044, 25393, 27935, 30062, 32049,
                            33952, 35804, 37431, 39197, 45000, 43000, 41000, 39000, 37000,
                            35000, 33000, 31000, 29000, 27000, 25000, 24000, 23000, 22000,
                            21000, 20000, 19000, 18000, 18000, 17000, 16000]
                    }]
                });

            }
        </script>
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

            function print_indicators_list($symbol)
            {
                $list =array("Price", "SMA", "EMA", "STOCH", "RSI", "ADX", "CCI", "BBANDS", "MACD");
                $output="";
                foreach($list as $x)
                {
                    if($x=="Price"):
                        $output.="<a href='' value='https://www.alphavantage.co/query?
function=TIME_SERIES_DAILY&symbol=".$symbol."&interval=weekly&time_period=10&series_type=open&apikey=OGY0S9LG8J8ADNZW' onclick='bringin_data(this.value)'>".$x."</a>    ";
                    else:
                        $output.="<a href='https://www.alphavantage.co/query?
function=".$x."&symbol=".$symbol."&interval=weekly&time_period=10&series_type=open&apikey=OGY0S9LG8J8ADNZW'>".$x."</a>    ";
                    endif;
                }
                return $output;
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

                    if (key_exists("Error Message",$response) and startsWith($response["Error Message"],"Invalid")===true):
                    {
                        echo "<table>";
                        echo "<tr><th>Error</th><td>Error: NO record has been found, please enter a valid symbol</td></tr>";
                        echo "</table>";
                    }
                    else:
                    {
                        date_default_timezone_set("America/Los_Angeles");

                        $date = $response["Meta Data"]["3. Last Refreshed"];
                        $format = '%.2f';
                        $close = $response["Time Series (Daily)"][$date]["4. close"];
                        $open = $response["Time Series (Daily)"][$date]["1. open"];
                        $prev_date = date('Y-m-d', strtotime($date .' -1 day'));
                        $prev_close = $response["Time Series (Daily)"][$prev_date]["4. close"];
                        $change = sprintf($format,abs(floatval($close)-floatval($prev_close)));
                        $change_percent = sprintf($format,100.0*$change/floatval($prev_close));
                        $pos_change = false;
                        if(floatval($prev_close)<=floatval($close)):
                            $pos_change=true;
                        endif;
                        echo "<table>";
                        echo "<tr><th>Stock Ticker Symbol</th><td>".$symbol."</td></tr>";
                        echo "<tr><th>Close</th><td>".$close."</td></tr>";
                        echo "<tr><th>Open</th><td>".$open."</td></tr>";
                        echo "<tr><th>Previous Close</th><td>".$prev_close."</td></tr>";
                        if($pos_change):
                            echo "<tr><th>Change</th><td>".$change."<span><img src=\"http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png\"/></span></td></tr>
<tr><th>Change Percent</th><td>".$change_percent."%<span><img src=\"http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png\"/></span></td></tr>";
                        else:
                            echo "<tr><th>Change</th><td>".$change."<span><img src=\"http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png\"/></span></td></tr>
<tr><th>Change Percent</th><td>".$change_percent."<span><img src=\"http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png\"/></span></td></tr>";
                        endif;
                        $format="%.4f-%.4f";
                        echo "<tr><th>Day's Range</th><td>".sprintf($format,$response["Time Series (Daily)"][$date]["3. low"],$response["Time Series (Daily)"][$date]["4. close"])."</td></tr>";
                        echo "<tr><th>Volume</th><td>".number_format(floatval($response["Time Series (Daily)"][$date]["5. volume"]),0,".",",")."</td></tr>";
                        echo "<tr><th>Timestamp</th><td>".$date."</td></tr>";
                        echo "<tr><th>Indicators</th><td>".print_indicators_list($symbol)."</td></tr>";
                        echo "</table>";?>
                        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    <?php
                    }
                    endif;
                }
                endif;
            }
            endif; ?>

    <NOSCRIPT>
    </body>
</html>