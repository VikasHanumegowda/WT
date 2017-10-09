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
            function addMonths(date, months) {
                var parts =date.split('/');
                //please put attention to the month (parts[0]), Javascript counts months from 0:
                // January - 0, February - 1, etc
                var mydate = new Date(parts[2],parts[0]-1,parts[1]);
                date.setMonth(mydate.getMonth() + months);
                return date;
            }

            function formatDate(date) {
                var monthNames = [
                    "January", "February", "March",
                    "April", "May", "June", "July",
                    "August", "September", "October",
                    "November", "December"
                ];

                var day = date.getDate();
                var monthIndex = date.getMonth();
                var year = date.getFullYear();

                return day + ' ' + monthNames[monthIndex] + ' ' + year;
            }

            function bringin_data(url="",indicator="",symbol) {
                console.log("URL:"+url);
                console.log("before indicator"+indicator);

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // Action to be performed when the document is read;
                    }
                };

                xhttp.open("GET", url, false);
                xhttp.send();
                var xmlDoc = xhttp.responseText;
                obj = JSON.parse(xmlDoc);


                console.log("hello"+obj);
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                if(dd<10){
                    dd='0'+dd;
                }
                if(mm<10){
                    mm='0'+mm;
                }
                var todays = dd+'/'+mm+'/'+yyyy;
                console.log(today);
                //ray("Price", "SMA", "EMA", "STOCH", "RSI", "ADX", "CCI", "BBANDS", "MACD");
                if(indicator=='Price')
                {
                    options = {
                        title: {
                            text: "Stock Price ("+todays+")"
                        },
                        subtitle: {
                            text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                        },
                        xAxis: {
                            type: 'datetime',
                            tickInterval: 24 * 3600 * 1000,
                            labels: {
                                format: '{value: %m/%d}',
                                rotation: 45,
                                align: 'middle'
                            }

                        },
                        yAxis: [{
                            title: {
                                text: 'Stock Price'
                            },
                            gridLineWidth: 0
                        }, {
                            title: {
                                text: 'Volume'
                            },
                            opposite: true
                        }],
                        legend: {
                            layout: 'vertical',
                            backgroundColor: '#FFF',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                    Highcharts.dateFormat('%m/%d', this.x) + ': ' + this.y;
                            }
                        },
                        plotOptions: {
                        },
                        series: [{
                            color: '#FF0000',
                            type: 'area',
                            name: symbol,
                            pointStart: Date.UTC(2017, 3, 1),
                            pointInterval: 7 * 24 * 3600 * 1000,
                            data: []
                        },
                            {
                                color: '#FFFFFF',
                                type: 'column',
                                name: symbol+' Volume',
                                pointStart: Date.UTC(2017, 3, 1),
                                pointInterval: 7 * 24 * 3600 * 1000,
                                data: [],
                                yAxis: 1
                            }]
                    };
                    series = [];
                    volumes = [];
                    for(x in obj["Time Series (Daily)"])
                    {
                        series.push(parseFloat(obj["Time Series (Daily)"][x]["4. close"]));
                        volumes.push(parseFloat(obj["Time Series (Daily)"][x]["5. volume"]))
                    }
                    options.series[0].data=series;
                    options.series[1].data=volumes;
                    Highcharts.chart('container', options);
                }
                else if(indicator=="SMA")
                {
                    console.log(obj["Meta Data"]["2: Indicator"]);
                    console.log(obj["Technical Analysis: SMA"]["2017-10-06"]["SMA"]);
                    console.log(obj["Technical Analysis: SMA"]);
                    options = {
                        title: {
                            text: obj["Meta Data"]["2: Indicator"]
                        },
                        subtitle: {
                            text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                        },
                        xAxis: {
                            type: 'datetime',
                            tickInterval: 24 * 3600 * 1000,
                            labels: {
                                format: '{value: %m/%d}',
                                rotation: 45,
                                align: 'middle'
                            }

                        },
                        yAxis: [{
                            title: {
                                text: 'SMA'
                            }
                        }],
                        legend: {
                            layout: 'vertical',
                            backgroundColor: '#FFF',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                    Highcharts.dateFormat('%m/%d', this.x) + ': ' + this.y;//check this again
                            }
                        },
                        plotOptions: {
                        },
                        series: [{
                            color: '#FF0000',
                            name: symbol,
                            pointStart: Date.UTC(2017, 3, 1),
                            pointInterval: 24 * 36e5,
                            data: []
                        }]
                    };
                    series = new Array();
                    for(x in obj["Technical Analysis: SMA"])
                    {
                        series.push(parseFloat(obj["Technical Analysis: SMA"][x]["SMA"]));
                    }
                    options.series[0].data=series;
                    Highcharts.chart('container', options);
                }
                else if(indicator=="EMA")
                {
                    options = {
                        title: {
                            text: obj["Meta Data"]["2: Indicator"]
                        },
                        subtitle: {
                            text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                        },
                        xAxis: {
                            type: 'datetime',
                            tickInterval: 24 * 3600 * 1000,
                            labels: {
                                format: '{value: %m/%d}',
                                rotation: 45,
                                align: 'middle'
                            }

                        },
                        yAxis: [{
                            title: {
                                text: 'EMA'
                            }
                        }],
                        legend: {
                            layout: 'vertical',
                            backgroundColor: '#FFF',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                    Highcharts.dateFormat('%m/%d', this.x) + ': ' + this.y;//check this again
                            }
                        },
                        plotOptions: {
                        },
                        series: [{
                            color: '#FF0000',
                            name: symbol,
                            pointStart: Date.UTC(2017, 3, 1),
                            pointInterval: 24 * 36e5,
                            data: []
                        }]
                    };
                    series = new Array();
                    for(x in obj["Technical Analysis: EMA"])
                    {
                        series.push(parseFloat(obj["Technical Analysis: EMA"][x]["EMA"]));
                    }
                    options.series[0].data=series;
                    Highcharts.chart('container', options);
                }
                else if(indicator=="STOCH")
                {
                    options = {
                        title: {
                            text: obj["Meta Data"]["2: Indicator"]
                        },
                        subtitle: {
                            text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                        },
                        xAxis: {
                            type: 'datetime',
                            tickInterval: 24 * 3600 * 1000,
                            labels: {
                                format: '{value: %m/%d}',
                                rotation: 45,
                                align: 'middle'
                            }

                        },
                        yAxis: [{
                            title: {
                                text: 'STOCH'
                            }
                        }],
                        legend: {
                            layout: 'vertical',
                            backgroundColor: '#FFF',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                    Highcharts.dateFormat('%m/%d', this.x) + ': ' + this.y;//check this again
                            }
                        },
                        plotOptions: {
                        },
                        series: [{
                            color: '#FF0000',
                            name: symbol+' SlowD',
                            pointStart: Date.UTC(2017, 3, 1),
                            pointInterval: 24 * 36e5,
                            data: []
                        },
                            {
                                color: '#00FF00',
                                name: symbol+' SlowK',
                                pointStart: Date.UTC(2017, 3, 1),
                                pointInterval: 24 * 36e5,
                                data: []
                            }]
                    };
                    seriesd = new Array();
                    seriesk = new Array();
                    for(x in obj["Technical Analysis: STOCH"])
                    {
                        seriesd.push(parseFloat(obj["Technical Analysis: STOCH"][x]["SlowD"]));
                        seriesk.push(parseFloat(obj["Technical Analysis: STOCH"][x]["SlowK"]));
                    }
                    options.series[0].data=seriesd;
                    options.series[1].data=seriesk;
                    Highcharts.chart('container', options);
                }
                else if(indicator=="RSI")
                {
                    options = {
                        title: {
                            text: obj["Meta Data"]["2: Indicator"]
                        },
                        subtitle: {
                            text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                        },
                        xAxis: {
                            type: 'datetime',
                            tickInterval: 24 * 3600 * 1000,
                            labels: {
                                format: '{value: %m/%d}',
                                rotation: 45,
                                align: 'middle'
                            }

                        },
                        yAxis: [{
                            title: {
                                text: 'RSI'
                            }
                        }],
                        legend: {
                            layout: 'vertical',
                            backgroundColor: '#FFF',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                    Highcharts.dateFormat('%m/%d', this.x) + ': ' + this.y;//check this again
                            }
                        },
                        plotOptions: {
                        },
                        series: [{
                            color: '#FF0000',
                            name: symbol+' RSI',
                            pointStart: Date.UTC(2017, 3, 1),
                            pointInterval: 24 * 36e5,
                            data: []
                        }]
                    };
                    series = new Array();
                    for(x in obj["Technical Analysis: RSI"])
                    {
                        series.push(parseFloat(obj["Technical Analysis: RSI"][x]["RSI"]));
                    }
                    options.series[0].data=series;
                    Highcharts.chart('container', options);
                }
                else if(indicator=="ADX")
                {
                    options = {
                        title: {
                            text: obj["Meta Data"]["2: Indicator"]
                        },
                        subtitle: {
                            text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                        },
                        xAxis: {
                            type: 'datetime',
                            tickInterval: 24 * 3600 * 1000,
                            labels: {
                                format: '{value: %m/%d}',
                                rotation: 45,
                                align: 'middle'
                            }

                        },
                        yAxis: [{
                            title: {
                                text: 'ADX'
                            }
                        }],
                        legend: {
                            layout: 'vertical',
                            backgroundColor: '#FFF',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                    Highcharts.dateFormat('%m/%d', this.x) + ': ' + this.y;//check this again
                            }
                        },
                        plotOptions: {
                        },
                        series: [{
                            color: '#FF0000',
                            name: symbol+' ADX',
                            pointStart: Date.UTC(2017, 3, 1),
                            pointInterval: 24 * 36e5,
                            data: []
                        }]
                    };
                    series = new Array();
                    for(x in obj["Technical Analysis: ADX"])
                    {
                        series.push(parseFloat(obj["Technical Analysis: ADX"][x]["ADX"]));
                    }
                    options.series[0].data=series;
                    Highcharts.chart('container', options);
                }
                else if(indicator=="CCI")
                {
                    options = {
                        title: {
                            text: obj["Meta Data"]["2: Indicator"]
                        },
                        subtitle: {
                            text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                        },
                        xAxis: {
                            type: 'datetime',
                            tickInterval: 24 * 3600 * 1000,
                            labels: {
                                format: '{value: %m/%d}',
                                rotation: 45,
                                align: 'middle'
                            }

                        },
                        yAxis: [{
                            title: {
                                text: 'CCI'
                            }
                        }],
                        legend: {
                            layout: 'vertical',
                            backgroundColor: '#FFF',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                    Highcharts.dateFormat('%m/%d', this.x) + ': ' + this.y;//check this again
                            }
                        },
                        plotOptions: {
                        },
                        series: [{
                            color: '#FF0000',
                            name: symbol+' CCI',
                            pointStart: Date.UTC(2017, 3, 1),
                            pointInterval: 24 * 36e5,
                            data: []
                        }]
                    };
                    series = new Array();
                    for(x in obj["Technical Analysis: CCI"])
                    {
                        series.push(parseFloat(obj["Technical Analysis: CCI"][x]["CCI"]));
                    }
                    options.series[0].data=series;
                    Highcharts.chart('container', options);
                }
                else if(indicator=="BBANDS")
                {
                    options = {
                        title: {
                            text: obj["Meta Data"]["2: Indicator"]
                        },
                        subtitle: {
                            text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                        },
                        xAxis: {
                            type: 'datetime',
                            tickInterval: 24 * 3600 * 1000,
                            labels: {
                                format: '{value: %m/%d}',
                                rotation: 45,
                                align: 'middle'
                            }

                        },
                        yAxis: [{
                            title: {
                                text: 'BBANDS'
                            }
                        }],
                        legend: {
                            layout: 'vertical',
                            backgroundColor: '#FFF',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                    Highcharts.dateFormat('%m/%d', this.x) + ': ' + this.y;//check this again
                            }
                        },
                        plotOptions: {
                        },
                        series: [{
                            color: '#FF0000',
                            name: symbol+' Real Middle Band',
                            pointStart: Date.UTC(2017, 3, 1),
                            pointInterval: 24 * 36e5,
                            data: []
                        },
                            {
                                color: '#00FF00',
                                name: symbol+' Real Lower Band',
                                pointStart: Date.UTC(2017, 3, 1),
                                pointInterval: 24 * 36e5,
                                data: []
                            },
                            {
                                color: '#0000FF',
                                name: symbol+' Real Upper Band',
                                pointStart: Date.UTC(2017, 3, 1),
                                pointInterval: 24 * 36e5,
                                data: []
                            }]
                    };
                    seriesm = new Array();
                    seriesl = new Array();
                    seriesu = new Array();
                    for(x in obj["Technical Analysis: BBANDS"])
                    {
                        seriesm.push(parseFloat(obj["Technical Analysis: BBANDS"][x]["Real Middle Band"]));
                        seriesl.push(parseFloat(obj["Technical Analysis: BBANDS"][x]["Real Lower Band"]));
                        seriesu.push(parseFloat(obj["Technical Analysis: BBANDS"][x]["Real Upper Band"]));
                    }
                    options.series[0].data=seriesm;
                    options.series[1].data=seriesl;
                    options.series[2].data=seriesu;
                    Highcharts.chart('container', options);
                }
                else if(indicator=="MACD")
                {
                    options = {
                        title: {
                            text: obj["Meta Data"]["2: Indicator"]
                        },
                        subtitle: {
                            text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                        },
                        xAxis: {
                            type: 'datetime',
                            tickInterval: 24 * 3600 * 1000,
                            labels: {
                                format: '{value: %m/%d}',
                                rotation: 45,
                                align: 'middle'
                            }

                        },
                        yAxis: [{
                            title: {
                                text: 'MACD'
                            }
                        }],
                        legend: {
                            layout: 'vertical',
                            backgroundColor: '#FFF',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        tooltip: {
                            formatter: function () {
                                return '<b>' + this.series.name + '</b><br/>' +
                                    Highcharts.dateFormat('%m/%d', this.x) + ': ' + this.y;//check this again
                            }
                        },
                        plotOptions: {
                        },
                        series: [{
                            color: '#FF0000',
                            name: symbol+' MACD_Signal',
                            pointStart: Date.UTC(2017, 3, 1),
                            pointInterval: 24 * 36e5,
                            data: []
                        },
                            {
                                color: '#00FF00',
                                name: symbol+' MACD',
                                pointStart: Date.UTC(2017, 3, 1),
                                pointInterval: 24 * 36e5,
                                data: []
                            },
                            {
                                color: '#0000FF',
                                name: symbol+' MACD_Hist',
                                pointStart: Date.UTC(2017, 3, 1),
                                pointInterval: 24 * 36e5,
                                data: []
                            }]
                    };
                    seriesm = new Array();
                    seriesl = new Array();
                    seriesu = new Array();
                    for(x in obj["Technical Analysis: MACD"])
                    {
                        seriesm.push(parseFloat(obj["Technical Analysis: MACD"][x]["MACD_Signal"]));
                        seriesl.push(parseFloat(obj["Technical Analysis: MACD"][x]["MACD"]));
                        seriesu.push(parseFloat(obj["Technical Analysis: MACD"][x]["MACD_Hist"]));
                    }
                    options.series[0].data=seriesm;
                    options.series[1].data=seriesl;
                    options.series[2].data=seriesu;
                    Highcharts.chart('container', options);
                }
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
                    if($x==="Price"):
                        $output.="<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$symbol."&interval=weekly&time_period=10&series_type=open&apikey=OGY0S9LG8J8ADNZW\",\"".$x."\",\"".$symbol."\")'>".$x."</p></u>";
                    else:
                        $output.="<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=".$x."&symbol=".$symbol."&interval=weekly&time_period=10&series_type=open&apikey=OGY0S9LG8J8ADNZW\",\"".$x."\",\"".$symbol."\")'>".$x."</p></u>";
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
                    $str_response = $response;
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
                        echo "</table>";
                        echo '<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';
                        echo "<script type='text/javascript'>bringin_data(url=\"https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$symbol."&interval=weekly&time_period=10&series_type=open&apikey=OGY0S9LG8J8ADNZW\",\"Price\",\"".$symbol."\");</script>";
                        ?>
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