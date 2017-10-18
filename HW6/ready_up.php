<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <title>
        Homework 6
    </title>
    <style>
        table {
            border-collapse: collapse;
            padding: 0;
            text-align: center;
            margin: 0;
            border-width: 1px;
            border-style: solid;
            border-color: #888;
            width: 100%;
        }

        th {
            background: #D0D0D0;
            width: 35%;
            border: solid;
            border-color: #808080;
            border-width: 1px;
            padding: 0;

        }

        body {
            min-width: 650px;
        }

        td {
            background: #F0F0F0;
            width: 65%;
            border: solid;
            border-color: #808080;
            border-width: 1px;
            padding: 0;
        }

        span img {
            height: 19px;
            width: auto;
        }

        a img {
            width: 10%;
            height: auto;
        }
    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript">
        function convertToServerTimeZone(datestr){

            //EST
            offset = -5.0

            clientDate = new Date(datestr);
            utc = clientDate.getTime() + (clientDate.getTimezoneOffset() * 60000);

            serverDate = new Date(utc + (3600000*offset));

            alert (serverDate.toLocaleString());


        }
        function formatDate(date) {
            var monthNames = [
                "01", "02", "03",
                "04", "05", "06", "07",
                "08", "09", "10",
                "11", "12"
            ];

            var day = date.getDate();
            var monthIndex = date.getMonth();
            var year = date.getFullYear();

            return day + '/' + monthNames[monthIndex] + '/' + year;
        }

        function bringin_data(url="", indicator="", symbol) {
            console.log("URL:" + url);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // Action to be performed when the document is read;
                    var xmlDoc = xhttp.responseText;
                    obj = JSON.parse(xmlDoc);
                    var today = new Date();
                    console.log(today);
                    var today_str = formatDate(today);
                    console.log(today_str);
                    if (indicator == 'Price') {
                        options = {
                            title: {
                                text: "Stock Price (" + today_str + ")"
                            },
                            subtitle: {
                                text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                            },
                            xAxis: {
                                type: 'datetime',
                                tickInterval: 7 * 24 * 3600 * 1000,
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
//                            tooltip: {
//                                formatter: function () {
//                                    return Highcharts.dateFormat('%m/%d', this.x) + '<br/>' + this.series.name + ': ' + this.y;
//                                }
//                            },
                            plotOptions: {
                                area: {
                                    threshold: null
                                },
                                line: {
                                    threshold: null
                                }
                            },
                            series: [{
                                color: '#FF0000',
                                type: 'area',
                                name: symbol,

                                pointStart: Date(2017, 3, 1),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            },
                                {
                                    color: '#FFFFFF',
                                    type: 'column',
                                    name: symbol + ' Volume',
                                    pointStart: Date.UTC(2017, 3, 1),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: [],
                                    yAxis: 1
                                }]
                        };
                        series = [];
                        volumes = [];
                        count = 0;
                        for (x in obj["Time Series (Daily)"]) {
                            count += 1;
                            console.log(count + " " + x);
                            series.unshift(parseFloat(obj["Time Series (Daily)"][x]["4. close"]));
                            volumes.unshift(parseFloat(obj["Time Series (Daily)"][x]["5. volume"]))
                            if(count == 200)
                                break;
                        }
                        options.series[0].data = series;
                        options.series[1].data = volumes;
                        Highcharts.chart('container', options);
                    }
                    else if (indicator == "SMA") {
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
                                tickInterval: 7 * 24 * 3600 * 1000,
                                labels: {
                                    format: '{value: %m/%d}',
                                    rotation: 0,
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
                            plotOptions: {},
                            series: [{
                                color: '#FF0000',
                                name: symbol,
                                pointStart: Date.UTC(2017, 5, 1),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            }]
                        };
                        series = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: SMA"]) {
                            console.log(count + " " + x);
                            count += 1;
                            series.unshift(parseFloat(obj["Technical Analysis: SMA"][x]["SMA"]));
                        }
                        options.series[0].data = series;
                        Highcharts.chart('container', options);
                    }
                    else if (indicator == "EMA") {
                        options = {
                            title: {
                                text: obj["Meta Data"]["2: Indicator"]
                            },
                            subtitle: {
                                text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                            },
                            xAxis: {
                                type: 'datetime',
                                tickInterval: 7 * 24 * 3600 * 1000,
                                labels: {
                                    format: '{value: %m/%d}',
                                    rotation: 45,
                                    align: 'middle'
                                }


                            }
                            ,
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
                            plotOptions: {},
                            series: [{
                                color: '#FF0000',
                                name: symbol,
                                pointStart: Date.UTC(2017, 5, 1),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            }]
                        };
                        series = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: EMA"]) {
                            console.log(count + " " + x);
                            count += 1;
                            series.unshift(parseFloat(obj["Technical Analysis: EMA"][x]["EMA"]));
                        }
                        options.series[0].data = series;
                        Highcharts.chart('container', options);
                    }
                    else if (indicator == "STOCH") {
                        options = {
                            title: {
                                text: obj["Meta Data"]["2: Indicator"]
                            },
                            subtitle: {
                                text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                            },
                            xAxis: {
                                type: 'datetime',
                                tickInterval: 7 * 24 * 3600 * 1000,
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
                            plotOptions: {},
                            series: [{
                                color: '#FF0000',
                                name: symbol + ' SlowD',
                                pointStart: Date.UTC(2017, 5, 1),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            },
                                {
                                    color: '#00FF00',
                                    name: symbol + ' SlowK',
                                    pointStart: Date.UTC(2017, 5, 1),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: []
                                }]
                        };
                        seriesd = new Array();
                        seriesk = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: STOCH"]) {
                            console.log(count + " " + x);
                            count += 1;
                            seriesd.unshift(parseFloat(obj["Technical Analysis: STOCH"][x]["SlowD"]));
                            seriesk.unshift(parseFloat(obj["Technical Analysis: STOCH"][x]["SlowK"]));
                        }
                        options.series[0].data = seriesd;
                        options.series[1].data = seriesk;
                        Highcharts.chart('container', options);
                    }
                    else if (indicator == "RSI") {
                        options = {
                            title: {
                                text: obj["Meta Data"]["2: Indicator"]
                            },
                            subtitle: {
                                text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                            },
                            xAxis: {
                                type: 'datetime',
                                tickInterval: 7 * 24 * 3600 * 1000,
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
                            plotOptions: {},
                            series: [{
                                color: '#FF0000',
                                name: symbol + ' RSI',
                                pointStart: Date.UTC(2017, 5, 1),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            }]
                        };
                        series = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: RSI"]) {
                            console.log(count + " " + x);
                            count += 1;
                            series.unshift(parseFloat(obj["Technical Analysis: RSI"][x]["RSI"]));
                        }
                        options.series[0].data = series;
                        Highcharts.chart('container', options);
                    }
                    else if (indicator == "ADX") {
                        options = {
                            title: {
                                text: obj["Meta Data"]["2: Indicator"]
                            },
                            subtitle: {
                                text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                            },
                            xAxis: {
                                type: 'datetime',
                                tickInterval: 7 * 24 * 3600 * 1000,
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
                            plotOptions: {},
                            series: [{
                                color: '#FF0000',
                                name: symbol + ' ADX',
                                pointStart: Date.UTC(2017, 5, 1),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            }]
                        };
                        series = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: ADX"]) {
                            console.log(count + " " + x);
                            count += 1;
                            series.unshift(parseFloat(obj["Technical Analysis: ADX"][x]["ADX"]));
                        }
                        options.series[0].data = series;
                        Highcharts.chart('container', options);
                    }
                    else if (indicator == "CCI") {
                        options = {
                            title: {
                                text: obj["Meta Data"]["2: Indicator"]
                            },
                            subtitle: {
                                text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                            },
                            xAxis: {
                                type: 'datetime',
                                tickInterval: 7 * 24 * 3600 * 1000,
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
                            plotOptions: {},
                            series: [{
                                color: '#FF0000',
                                name: symbol + ' CCI',
                                pointStart: Date.UTC(2017, 5, 1),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            }]
                        };
                        series = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: CCI"]) {
                            console.log(count + " " + x);
                            count += 1;
                            series.unshift(parseFloat(obj["Technical Analysis: CCI"][x]["CCI"]));
                        }
                        options.series[0].data = series;
                        Highcharts.chart('container', options);
                    }
                    else if (indicator == "BBANDS") {
                        options = {
                            title: {
                                text: obj["Meta Data"]["2: Indicator"]
                            },
                            subtitle: {
                                text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                            },
                            xAxis: {
                                type: 'datetime',
                                tickInterval: 7 * 24 * 3600 * 1000,
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
                            plotOptions: {},
                            series: [{
                                color: '#FF0000',
                                name: symbol + ' Real Middle Band',
                                pointStart: Date.UTC(2017, 5, 1),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            },
                                {
                                    color: '#00FF00',
                                    name: symbol + ' Real Lower Band',
                                    pointStart: Date.UTC(2017, 5, 1),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: []
                                },
                                {
                                    color: '#0000FF',
                                    name: symbol + ' Real Upper Band',
                                    pointStart: Date.UTC(2017, 5, 1),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: []
                                }]
                        };
                        seriesm = new Array();
                        seriesl = new Array();
                        seriesu = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: BBANDS"]) {
                            console.log(count + " " + x);
                            count += 1;
                            seriesm.unshift(parseFloat(obj["Technical Analysis: BBANDS"][x]["Real Middle Band"]));
                            seriesl.unshift(parseFloat(obj["Technical Analysis: BBANDS"][x]["Real Lower Band"]));
                            seriesu.unshift(parseFloat(obj["Technical Analysis: BBANDS"][x]["Real Upper Band"]));
                        }
                        options.series[0].data = seriesm;
                        options.series[1].data = seriesl;
                        options.series[2].data = seriesu;
                        Highcharts.chart('container', options);
                    }
                    else if (indicator == "MACD") {
                        options = {
                            title: {
                                text: obj["Meta Data"]["2: Indicator"]
                            },
                            subtitle: {
                                text: "<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>"
                            },
                            xAxis: {
                                type: 'datetime',
                                tickInterval: 7 * 24 * 3600 * 1000,
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
                            plotOptions: {},
                            series: [{
                                color: '#FF0000',
                                name: symbol + ' MACD_Signal',
                                pointStart: Date.UTC(2017, 5, 1),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            },
                                {
                                    color: '#00FF00',
                                    name: symbol + ' MACD',
                                    pointStart: Date.UTC(2017, 5, 1),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: []
                                },
                                {
                                    color: '#0000FF',
                                    name: symbol + ' MACD_Hist',
                                    pointStart: Date.UTC(2017, 5, 1),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: []
                                }]
                        };
                        seriesm = new Array();
                        seriesl = new Array();
                        seriesu = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: MACD"]) {
                            console.log(count + " " + x);
                            count += 1;
                            seriesm.unshift(parseFloat(obj["Technical Analysis: MACD"][x]["MACD_Signal"]));
                            seriesl.unshift(parseFloat(obj["Technical Analysis: MACD"][x]["MACD"]));
                            seriesu.unshift(parseFloat(obj["Technical Analysis: MACD"][x]["MACD_Hist"]));
                        }
                        options.series[0].data = seriesm;
                        options.series[1].data = seriesl;
                        options.series[2].data = seriesu;
                        Highcharts.chart('container', options);
                    }
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();

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
            <input style="font-size: 20px; margin-left: 245px;margin-right: 10px;" type="submit" value="Search"
                   name="Search" id="Search">
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
    $list = array("Price", "SMA", "EMA", "STOCH", "RSI", "ADX", "CCI", "BBANDS", "MACD");
    $output = "";
    foreach ($list as $x) {
        if ($x === "Price"):
            $output .= "<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $symbol . "&interval=daily&outputsize=full&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</p></u>";
        elseif ($x === 'STOCH'):
            $output .= "<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&outputsize=compact&time_period=10&slowkmatype=1&slowdmatype=1&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</p></u>";
        elseif ($x === 'BBANDS'):
            $output .= "<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=5&series_type=close&nbdevup=3&nbdevdn=3&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</p></u>";
        elseif ($x === 'SMA'):
            $output .= "<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</p></u>";
        elseif ($x === 'EMA'):
            $output .= "<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</p></u>";
        elseif ($x === 'RSI'):
            $output .= "<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</p></u>";
        elseif ($x === 'ADX'):
            $output .= "<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</p></u>";
        elseif ($x === 'CCI'):
            $output .= "<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</p></u>";
        elseif ($x === 'MACD'):
            $output .= "<u><p style='display:inline; margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</p></u>";
        endif;
    }
    return $output;
}

if (isset($_POST["Search"])): {
    if ($_POST["STS"] == ""): {
        echo "<script type='text/javascript'>alert('Please enter a symbol');</script>";
    } else: {
        $symbol = test_input($_POST["STS"]);
        $url = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $symbol . "&apikey=OGY0S9LG8J8ADNZW";
        $response = file_get_contents($url);
        $str_response = $response;
        $response = json_decode($response, true);

        if (key_exists("Error Message", $response) and startsWith($response["Error Message"], "Invalid") === true): {
            echo "<table>";
            echo "<tr><th>Error</th><td>Error: NO record has been found, please enter a valid symbol</td></tr>";
            echo "</table>";
        } else: {
            date_default_timezone_set("America/Los_Angeles");
            $date = $response["Meta Data"]["3. Last Refreshed"];
            $date = new DateTime($date);
            $date = date_format($date, "Y-m-d");
            $close = $response["Time Series (Daily)"][$date]["4. close"];
            $open = $response["Time Series (Daily)"][$date]["1. open"];
            $prev_date = date('Y-m-d', strtotime($date . ' -1 day'));
            while (key_exists($prev_date, $response["Time Series (Daily)"]) == false)
                $prev_date = date('Y-m-d', strtotime($prev_date . ' -1 day'));
            $prev_close = $response["Time Series (Daily)"][$prev_date]["4. close"];
            $format = '%.2f';
            $change = sprintf($format, abs(floatval($close) - floatval($prev_close)));
            $change_percent = sprintf($format, 100.0 * $change / floatval($prev_close));
            $pos_change = false;
            if (floatval($prev_close) <= floatval($close)):
                $pos_change = true;
            endif;
            echo "<table>";
            echo "<tr><th>Stock Ticker Symbol</th><td>" . $symbol . "</td></tr>";
            echo "<tr><th>Close</th><td>" . $close . "</td></tr>";
            echo "<tr><th>Open</th><td>" . $open . "</td></tr>";
            echo "<tr><th>Previous Close</th><td>" . $prev_close . "</td></tr>";
            if ($pos_change):
                echo "<tr><th>Change</th><td>" . $change . "<span><img src=\"http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png\"/></span></td></tr>
<tr><th>Change Percent</th><td>" . $change_percent . "%<span><img src=\"http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png\"/></span></td></tr>";
            else:
                echo "<tr><th>Change</th><td>" . $change . "<span><img src=\"http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png\"/></span></td></tr>
<tr><th>Change Percent</th><td>" . $change_percent . "<span><img src=\"http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png\"/></span></td></tr>";
            endif;
            $format = "%.4f-%.4f";
            echo "<tr><th>Day's Range</th><td>" . sprintf($format, $response["Time Series (Daily)"][$date]["3. low"], $response["Time Series (Daily)"][$date]["2. high"]) . "</td></tr>";
            echo "<tr><th>Volume</th><td>" . number_format(floatval($response["Time Series (Daily)"][$date]["5. volume"]), 0, ".", ",") . "</td></tr>";
            echo "<tr><th>Timestamp</th><td>" . $date . "</td></tr>";
            echo "<tr><th>Indicators</th><td>" . print_indicators_list($symbol) . "</td></tr>";
            echo "</table>";
            echo '<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';
            echo '<a href=' . $_SERVER["PHP_SELF"] . '?expand=true style="text-align: center; margin-left: auto; margin-right: auto;"><div><p>Click to show stock news</p><br><img src="http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png"/></div></a>';
            echo '<div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';
            echo "<script type='text/javascript'>bringin_data(url=\"https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $symbol . "&interval=daily&time_period=10&outputsize=full&series_type=close&apikey=OGY0S9LG8J8ADNZW\",\"Price\",\"" . $symbol . "\");</script>";
            ?>
            <!--<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>-->
            <?php
        }
        endif;
    }
    endif;
}
endif;

//            function expand_function()
//            {
//                echo "I just ran the expand function!!";
//            }
//            if(isset($_GET["expand"]))
//            {
//                expand_function();
//            }

?>
<NOSCRIPT>
</body>
</html>