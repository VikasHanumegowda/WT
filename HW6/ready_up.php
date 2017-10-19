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

            margin: 0;
            border-width: 1px;
            border-style: solid;
            border-color: #888;
            width: 100%;
        }

        th {
            background: #D0D0D0;
            width: 35%;
            text-align: left;
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
            text-align: center;
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
            margin: 0px;
            width: 10%;
            height: auto;
        }
    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript">
        function togglefunc() {
            if (document.getElementById('container2').style.display == 'none') {
                document.getElementById('container2').style.display = 'block';
            }
            else {
                document.getElementById('container2').style.display = 'none';
            }
        }

        function build_news_div() {
            var array = "<?php echo $array ?>" ;
            console.log(array);
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
                    var day = today.getDate();
                    var monthIndex = today.getMonth();
                    var year = today.getFullYear();
                    var today_str = formatDate(today);
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
                                tickAmount: 8,
                                gridLineWidth: 0
                            }, {
                                title: {
                                    text: 'Volume'
                                },
                                max: null,
                                tickAmount: 8,
                                gridLineWidth: 0,
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
                                    return Highcharts.dateFormat('%m/%d', this.x) + '<br/>' + this.series.name + ': ' + this.y;
                                }
                            },
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
                                pointStart: Date.UTC(2017, monthIndex - 6, day),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            },
                                {
                                    color: '#F0F0F0',
                                    type: 'column',
                                    name: symbol + ' Volume',
                                    pointStart: Date.UTC(2017, monthIndex - 6, day),
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
                            series.unshift(parseFloat(obj["Time Series (Daily)"][x]["4. close"]));
                            volumes.unshift(parseFloat(obj["Time Series (Daily)"][x]["5. volume"]))
                            if (count == 184)
                                break;
                        }
                        options.series[0].data = series;
                        options.series[1].data = volumes;
                        Highcharts.chart('container', options);
                    }
                    else if (indicator == "SMA") {
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
                                    text: 'SMA'
                                },
                                max: null,
                                tickAmount: 8,
                                gridLineWidth: 0
                            }],
                            legend: {
                                layout: 'vertical',
                                backgroundColor: '#FFF',
                                align: 'right',
                                verticalAlign: 'middle'
                            },
                            tooltip: {
                                formatter: function () {
                                    return Highcharts.dateFormat('%m/%d', this.x) + '<br/>' + this.series.name + ': ' + this.y;
                                }
                            },
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
                                name: symbol,
                                pointStart: Date.UTC(2017, monthIndex - 6, day),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            }]
                        };
                        series = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: SMA"]) {
                            count += 1;
                            series.unshift(parseFloat(obj["Technical Analysis: SMA"][x]["SMA"]));
                            if (count == 184)
                                break;
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
                            },
                            yAxis: [{
                                title: {
                                    text: 'EMA'
                                },
                                max: null,
                                tickAmount: 8,
                                gridLineWidth: 0
                            }],
                            legend: {
                                layout: 'vertical',
                                backgroundColor: '#FFF',
                                align: 'right',
                                verticalAlign: 'middle'
                            },
                            tooltip: {
                                formatter: function () {
                                    return Highcharts.dateFormat('%m/%d', this.x) + '<br/>' + this.series.name + ': ' + this.y;
                                }
                            },
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
                                name: symbol,
                                pointStart: Date.UTC(2017, monthIndex - 6, day),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            }]
                        };
                        series = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: EMA"]) {
                            count += 1;
                            series.unshift(parseFloat(obj["Technical Analysis: EMA"][x]["EMA"]));
                            if (count == 184)
                                break;
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
                                },
                                max: null,
                                tickAmount: 8,
                                gridLineWidth: 0
                            }],
                            legend: {
                                layout: 'vertical',
                                backgroundColor: '#FFF',
                                align: 'right',
                                verticalAlign: 'middle'
                            },
                            tooltip: {
                                formatter: function () {
                                    return Highcharts.dateFormat('%m/%d', this.x) + '<br/>' + this.series.name + ': ' + this.y;
                                }
                            },
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
                                name: symbol + ' SlowD',
                                pointStart: Date.UTC(2017, monthIndex - 6, day),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            },
                                {
                                    color: '#00FF00',
                                    name: symbol + ' SlowK',
                                    pointStart: Date.UTC(2017, monthIndex - 6, day),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: []
                                }]
                        };
                        seriesd = new Array();
                        seriesk = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: STOCH"]) {
                            count += 1;
                            seriesd.unshift(parseFloat(obj["Technical Analysis: STOCH"][x]["SlowD"]));
                            seriesk.unshift(parseFloat(obj["Technical Analysis: STOCH"][x]["SlowK"]));
                            if (count == 184)
                                break;
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
                                },
                                max: null,
                                tickAmount: 8,
                                gridLineWidth: 0
                            }],
                            legend: {
                                layout: 'vertical',
                                backgroundColor: '#FFF',
                                align: 'right',
                                verticalAlign: 'middle'
                            },
                            tooltip: {
                                formatter: function () {
                                    return Highcharts.dateFormat('%m/%d', this.x) + '<br/>' + this.series.name + ': ' + this.y;
                                }
                            },
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
                                name: symbol + ' RSI',
                                pointStart: Date.UTC(2017, monthIndex - 6, day),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            }]
                        };
                        series = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: RSI"]) {
                            count += 1;
                            series.unshift(parseFloat(obj["Technical Analysis: RSI"][x]["RSI"]));
                            if (count == 184)
                                break;
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
                                },
                                max: null,
                                tickAmount: 8,
                                gridLineWidth: 0
                            }],
                            legend: {
                                layout: 'vertical',
                                backgroundColor: '#FFF',
                                align: 'right',
                                verticalAlign: 'middle'
                            },
                            tooltip: {
                                formatter: function () {
                                    return Highcharts.dateFormat('%m/%d', this.x) + '<br/>' + this.series.name + ': ' + this.y;
                                }
                            },
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
                                name: symbol + ' ADX',
                                pointStart: Date.UTC(2017, monthIndex - 6, day),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            }]
                        };
                        series = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: ADX"]) {
                            count += 1;
                            series.unshift(parseFloat(obj["Technical Analysis: ADX"][x]["ADX"]));
                            if (count == 184)
                                break;
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
                                },
                                max: null,
                                tickAmount: 8,
                                gridLineWidth: 0
                            }],
                            legend: {
                                layout: 'vertical',
                                backgroundColor: '#FFF',
                                align: 'right',
                                verticalAlign: 'middle'
                            },
                            tooltip: {
                                formatter: function () {
                                    return Highcharts.dateFormat('%m/%d', this.x) + '<br/>' + this.series.name + ': ' + this.y;
                                }
                            },
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
                                name: symbol + ' CCI',
                                pointStart: Date.UTC(2017, monthIndex - 6, day),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            }]
                        };
                        series = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: CCI"]) {
                            count += 1;
                            series.unshift(parseFloat(obj["Technical Analysis: CCI"][x]["CCI"]));
                            if (count == 184)
                                break;
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
                                },
                                max: null,
                                tickAmount: 8,
                                gridLineWidth: 0
                            }],
                            legend: {
                                layout: 'vertical',
                                backgroundColor: '#FFF',
                                align: 'right',
                                verticalAlign: 'middle'
                            },
                            tooltip: {
                                formatter: function () {
                                    return Highcharts.dateFormat('%m/%d', this.x) + '<br/>' + this.series.name + ': ' + this.y;
                                }
                            },
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
                                name: symbol + ' Real Middle Band',
                                pointStart: Date.UTC(2017, monthIndex - 6, day),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            },
                                {
                                    color: '#00FF00',
                                    name: symbol + ' Real Lower Band',
                                    pointStart: Date.UTC(2017, monthIndex - 6, day),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: []
                                },
                                {
                                    color: '#0000FF',
                                    name: symbol + ' Real Upper Band',
                                    pointStart: Date.UTC(2017, monthIndex - 6, day),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: []
                                }]
                        };
                        seriesm = new Array();
                        seriesl = new Array();
                        seriesu = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: BBANDS"]) {
                            count += 1;
                            seriesm.unshift(parseFloat(obj["Technical Analysis: BBANDS"][x]["Real Middle Band"]));
                            seriesl.unshift(parseFloat(obj["Technical Analysis: BBANDS"][x]["Real Lower Band"]));
                            seriesu.unshift(parseFloat(obj["Technical Analysis: BBANDS"][x]["Real Upper Band"]));
                            if (count == 184)
                                break;
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
                                },
                                max: null,
                                tickAmount: 8,
                                gridLineWidth: 0
                            }],
                            legend: {
                                layout: 'vertical',
                                backgroundColor: '#FFF',
                                align: 'right',
                                verticalAlign: 'middle'
                            },
                            tooltip: {
                                formatter: function () {
                                    return Highcharts.dateFormat('%m/%d', this.x) + '<br/>' + this.series.name + ': ' + this.y;
                                }
                            },
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
                                name: symbol + ' MACD_Signal',
                                pointStart: Date.UTC(2017, monthIndex - 6, day),
                                pointInterval: 24 * 3600 * 1000,
                                data: []
                            },
                                {
                                    color: '#00FF00',
                                    name: symbol + ' MACD',
                                    pointStart: Date.UTC(2017, monthIndex - 6, day),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: []
                                },
                                {
                                    color: '#0000FF',
                                    name: symbol + ' MACD_Hist',
                                    pointStart: Date.UTC(2017, monthIndex - 6, day),
                                    pointInterval: 24 * 3600 * 1000,
                                    data: []
                                }]
                        };
                        seriesm = new Array();
                        seriesl = new Array();
                        seriesu = new Array();
                        count = 0;
                        for (x in obj["Technical Analysis: MACD"]) {
                            count += 1;
                            seriesm.unshift(parseFloat(obj["Technical Analysis: MACD"][x]["MACD_Signal"]));
                            seriesl.unshift(parseFloat(obj["Technical Analysis: MACD"][x]["MACD"]));
                            seriesu.unshift(parseFloat(obj["Technical Analysis: MACD"][x]["MACD_Hist"]));
                            if (count == 184)
                                break;
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
            $output .= "<u onMouseOver=\"this.style.color='#444'\"  onMouseOut=\"this.style.color='#00F'\" style='color: blue; cursor: pointer; display:inline;'><a style=' margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $symbol . "&interval=daily&outputsize=full&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</a></u>";
        elseif ($x === 'STOCH'):
            $output .= "<u onMouseOver=\"this.style.color='#444'\"  onMouseOut=\"this.style.color='#00F'\" style='color: blue; cursor: pointer; display:inline;'><a style=' margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&outputsize=compact&time_period=10&slowkmatype=1&slowdmatype=1&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</a></u>";
        elseif ($x === 'BBANDS'):
            $output .= "<u onMouseOver=\"this.style.color='#444'\"  onMouseOut=\"this.style.color='#00F'\" style='color: blue; cursor: pointer; display:inline;'><a style=' margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=5&series_type=close&nbdevup=3&nbdevdn=3&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</a></u>";
        elseif ($x === 'SMA'):
            $output .= "<u onMouseOver=\"this.style.color='#444'\"  onMouseOut=\"this.style.color='#00F'\" style='color: blue; cursor: pointer; display:inline;'><a style=' margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</a></u>";
        elseif ($x === 'EMA'):
            $output .= "<u onMouseOver=\"this.style.color='#444'\"  onMouseOut=\"this.style.color='#00F'\" style='color: blue; cursor: pointer; display:inline;'><a style=' margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</a></u>";
        elseif ($x === 'RSI'):
            $output .= "<u onMouseOver=\"this.style.color='#444'\"  onMouseOut=\"this.style.color='#00F'\" style='color: blue; cursor: pointer; display:inline;'><a style=' margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</a></u>";
        elseif ($x === 'ADX'):
            $output .= "<u onMouseOver=\"this.style.color='#444'\"  onMouseOut=\"this.style.color='#00F'\" style='color: blue; cursor: pointer; display:inline;'><a style=' margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</a></u>";
        elseif ($x === 'CCI'):
            $output .= "<u onMouseOver=\"this.style.color='#444'\"  onMouseOut=\"this.style.color='#00F'\" style='color: blue; cursor: pointer; display:inline;'><a style=' margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</a></u>";
        elseif ($x === 'MACD'):
            $output .= "<u onMouseOver=\"this.style.color='#444'\"  onMouseOut=\"this.style.color='#00F'\" style='color: blue; cursor: pointer; display:inline;'><a style=' margin: 0 8px;' onclick='bringin_data(url=\"https://www.alphavantage.co/query?function=" . $x . "&symbol=" . $symbol . "&interval=daily&time_period=10&series_type=close&apikey=OGY0S9LG8J8ADNZW\",\"" . $x . "\",\"" . $symbol . "\")'>" . $x . "</a></u>";
        endif;
    }
    return $output;
}

function give_news_table_str($title_arr, $link_arr, $date_arr)
{
    $output = "";
    return string;
}

if (isset($_POST["Search"])): {
    if ($_POST["STS"] == ""): {
        echo "<script type='text/javascript'>alert('Please enter a symbol');</script>";
    } else: {
        $symbol = test_input($_POST["STS"]);
        $url_for_alphavantage_initial = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $symbol . "&apikey=OGY0S9LG8J8ADNZW";
        $response_from_alphavantage_initial = file_get_contents($url_for_alphavantage_initial);
        $url_for_news = "https://seekingalpha.com/api/sa/combined/" . $symbol . ".xml";
        $response = file_get_contents($url_for_news);
        $news_obj = simplexml_load_string($response);
        $response_json = json_encode($response);
        $array = json_decode($response_json);

//            $item_array = array(1,2,3,4,5);
//            $title_array = array(1,2,3,4,5);
//            $link_array = array(1,2,3,4,5);
//            $pubDate_array = array(1,2,3,4,5);
//            foreach($news_obj as $x) {
//                for($i =0; $i <5;$i++)
//                {
//                    $item_array[$i] = $x->item[$i];
//                    $title_array[$i]=$item_array[$i]->title;
//                    $link_array[$i]=$item_array[$i]->link;
//                    $pubDate_array[$i]=$item_array[$i]->pubDate;
//
//                    print_r($item_array[$i]);
//                    print_r("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
//                }
//                print_r("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
//            }
        $array_of_tuples = array();

        $response_from_alphavantage_initial = json_decode($response_from_alphavantage_initial, true);

        if (key_exists("Error Message", $response_from_alphavantage_initial)
            and startsWith($response_from_alphavantage_initial["Error Message"], "Invalid") === true): {
            echo "<table>";
            echo "<tr><th>Error</th><td>Error: NO record has been found, please enter a valid symbol</td></tr>";
            echo "</table>";
        } else: {
            date_default_timezone_set("America/New_York");
            $date = $response_from_alphavantage_initial["Meta Data"]["3. Last Refreshed"];
            $date = new DateTime($date);
            $date = date_format($date, "Y-m-d");
            $close = $response_from_alphavantage_initial["Time Series (Daily)"][$date]["4. close"];
            $open = $response_from_alphavantage_initial["Time Series (Daily)"][$date]["1. open"];
            $prev_date = date('Y-m-d', strtotime($date . ' -1 day'));
            while (key_exists($prev_date, $response_from_alphavantage_initial["Time Series (Daily)"]) == false)
                $prev_date = date('Y-m-d', strtotime($prev_date . ' -1 day'));
            $prev_close = $response_from_alphavantage_initial["Time Series (Daily)"][$prev_date]["4. close"];
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
            echo "<tr><th>Day's Range</th><td>" . sprintf($format, $response_from_alphavantage_initial["Time Series (Daily)"][$date]["3. low"], $response_from_alphavantage_initial["Time Series (Daily)"][$date]["2. high"]) . "</td></tr>";
            echo "<tr><th>Volume</th><td>" . number_format(floatval($response_from_alphavantage_initial["Time Series (Daily)"][$date]["5. volume"]), 0, ".", ",") . "</td></tr>";
            echo "<tr><th>Timestamp</th><td>" . $date . "</td></tr>";
            echo "<tr><th>Indicators</th><td>" . print_indicators_list($symbol) . "</td></tr>";
            echo "</table>";
            echo "<br/>";
            echo '<div id="container" style="border: 1px solid #888;min-width: 310px; height: 400px; margin: 0 auto"></div>';
            echo "<br/>";
            echo '<div id="toggler_button" style="margin: 8px;"><a href="javascript:;" onclick=togglefunc() style="text-align: center; margin-left: auto; margin-right: auto;"><div><p>Click to show stock news</p><img src="http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png"/></div></a></div>';
            echo '<div id="container2" style="display:none;border: 1px solid #888;min-width: 310px; height: 400px; margin: 0 auto"></div>';
            echo "<script type='text/javascript'>bringin_data(url=\"https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=" . $symbol . "&interval=daily&outputsize=full&apikey=OGY0S9LG8J8ADNZW\",\"Price\",\"" . $symbol . "\");</script>";
            echo "<script type='text/javascript'>function build_news_div() {var array = '" . $array . "';console.log(array);}build_news_div();</script>";

        }
        endif;
    }
    endif;
}
endif;
?>
<NOSCRIPT>
</body>
</html>