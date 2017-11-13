var app = angular.module('stockApp', ['ngAnimate', 'ngMaterial']);

app.controller('myCtrl', function ($scope, $http) {

    //initializations
    $scope.disable_show_details_button = true;
    $scope.show_fav = true;
    $scope.show_details = false;
    $scope.id_for_upper_tabs = 1;
    $scope.isSetUpper = function (id) {       //true or false
        if ($scope.id_for_upper_tabs == id)
            return true;
        else
            return false;
    }

    $scope.clickSetUpperTab = function (id)  //set tab on click
    {
        $scope.id_for_upper_tabs = id;


    }
    $scope.isSet = function (id) {       //true or false
        if ($scope.id_for_indicators == id)
            return true;
        else
            return false;
    }

    $scope.clickSetTab = function (id)  //set tab on click
    {
        $scope.id_for_indicators = id;
        switch ($scope.id_for_indicators) {
            case 1:
                $scope.data_symbol = 'r';
                $scope.data_data = $scope.tsd;
                break;
            case 2:
                $scope.data_symbol = 'SMA';
                $scope.data_data = $scope.sma;
                break;
            case 3:
                $scope.data_symbol = 'EMA';
                $scope.data_data = $scope.ema;
                break;
            case 4:
                $scope.data_symbol = 'STOCH';
                $scope.data_data = $scope.stoch;
                break;
            case 5:
                $scope.data_symbol = 'RSI';
                $scope.data_data = $scope.rsi;
                break;
            case 6:
                $scope.data_symbol = 'ADX';
                $scope.data_data = $scope.adx;
                break;
            case 7:
                $scope.data_symbol = 'CCI';
                $scope.data_data = $scope.cci;
                break;
            case 8:
                $scope.data_symbol = 'BBANDS';
                $scope.data_data = $scope.bbands;
                break;
            case 9:
                $scope.data_symbol = 'MACD';
                $scope.data_data = $scope.macd;
                break;
        }
        console.log($scope.data_symbol, $scope.data_data);
        $scope.set_data_for_indicators($scope.data_symbol, $scope.data_data);

    }

    $scope.set_data_for_indicators = function (indicator, data) {
        // var xmlDoc = xhttp.responseText;
        // obj = JSON.parse(xmlDoc);
        // $date1 = $response_from_alphavantage_initial["Meta Data"]["3. Last Refreshed"];
        obj = data;
        // console.log("data");
        // console.log("data");
        console.log(data);
        date = obj["Meta Data"]["3: Last Refreshed"];
        symbol_for_chart = obj["Meta Data"]["1: Symbol"];

        var today = new Date(date);
        var day = today.getDate() + 1;
        var monthIndex = today.getMonth();
        var year = today.getFullYear();
        var today_str = formatDate(today);
        //this is for second clicks and will not be called or made use of during the webpage loading from the server
        //Please go through  the code again aince I parse the whole volume/price json in PHP only
        if (indicator == 'r') {
            date = obj["Meta Data"]["3. Last Refreshed"];
            symbol_for_chart = obj["Meta Data"]["2. Symbol"];
            today = new Date(date);
            day = today.getDate() + 1;
            monthIndex = today.getMonth();
            year = today.getFullYear();
            today_str = formatDate(today);
            options = {
                chart: {
                    zoomType: 'x'
                },
                title: {
                    text: symbol_for_chart + ' Stock Price and Volume'
                },
                subtitle: {
                    text: '<a href=\'https://www.alphavantage.co/\'>Source: Alpha Vantage</a>'
                },
                xAxis: {
                    // endOnTick: true,
                    // startOnTick: true,
                    showFirstLabel: true,
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
                tooltip: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m/%d', this.x) + '<br/><span style=\"color:' + this.series.color + ';\">\u25CF</span>' + this.series.name + ': ' + this.y;
                    }
                },
                plotOptions: {
                    area: {
                        // threshold: null
                    },
                    line: {
                        threshold: null
                    }
                },
                series: [{
                    color: '#FF0000',
                    type: 'area',
                    name: symbol_for_chart,
                    pointStart: Date.UTC(2017, monthIndex - 6, day),
                    pointInterval: 24 * 3600 * 1000,
                    data: []
                },
                    {
                        color: '#F0F0F0',
                        type: 'column',
                        name: symbol_for_chart + ' Volume',
                        pointStart: Date.UTC(2017, monthIndex - 6, day),
                        pointInterval: 24 * 3600 * 1000,
                        data: [],
                        yAxis: 1
                    }]
            };
            series = [];
            volumes = [];
            count = 0;
            for (x in obj['Time Series (Daily)']) {
                count += 1;
                var today_date = new Date(x);
                series.unshift(Array(today_date, parseFloat(obj['Time Series (Daily)'][x]['4. close'])));
                volumes.unshift(Array(today_date, parseFloat(obj['Time Series (Daily)'][x]['5. volume'])));
//                            }
                if (count == 185)
                    break;
            }
            options.series[0].data = series;
            options.series[1].data = volumes;
            Highcharts.chart('container_for_indicators', options);
        }
        else if (indicator == "SMA") {
             var options = {
                 chart: {
                     zoomType: 'x'
                 },
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
                tooltip: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m/%d', this.x) + '<br/><span style="color:' + this.series.color + ';">\u25CF</span>' + this.series.name + ': ' + this.y;
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
                    name: symbol_for_chart,
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
                if (count == 185)
                    break;
            }
            options.series[0].data = series;
            console.log("SMA before charts");
            console.log(options.series[0].data);
            Highcharts.chart('container_for_indicators', options);
            console.log("SMA after charts");

        }
        else if (indicator == "EMA") {
            options = {
                chart: {
                    zoomType: 'x'
                },
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
                tooltip: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m/%d', this.x) + '<br/><span style="color:' + this.series.color + ';">\u25CF</span>' + this.series.name + ': ' + this.y;
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
                    name: symbol_for_chart,
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
                if (count == 185)
                    break;
            }
            options.series[0].data = series;
            console.log("EMA before charts");
            Highcharts.chart('container_for_indicators', options);
        }
        else if (indicator == "STOCH") {
            options = {
                chart: {
                    zoomType: 'x'
                },
                title:  {
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
                tooltip: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m/%d', this.x) + '<br/><span style="color:' + this.series.color + ';">\u25CF</span>' + this.series.name + ': ' + this.y;
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
                    name: symbol_for_chart + ' SlowD',
                    pointStart: Date.UTC(2017, monthIndex - 6, day),
                    pointInterval: 24 * 3600 * 1000,
                    data: []
                },
                    {
                        color: '#00FF00',
                        name: symbol_for_chart + ' SlowK',
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
                if (count == 185)
                    break;
            }
            options.series[0].data = seriesd;
            options.series[1].data = seriesk;
            Highcharts.chart('container_for_indicators', options);
        }
        else if (indicator == "RSI") {
            options = {
                chart: {
                    zoomType: 'x'
                },
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
                tooltip: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m/%d', this.x) + '<br/><span style="color:' + this.series.color + ';">\u25CF</span>' + this.series.name + ': ' + this.y;
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
                    name: symbol_for_chart + ' RSI',
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
                if (count == 185)
                    break;
            }
            options.series[0].data = series;
            Highcharts.chart('container_for_indicators', options);
        }
        else if (indicator == "ADX") {
            options = {
                chart: {
                    zoomType: 'x'
                },
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
                tooltip: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m/%d', this.x) + '<br/><span style="color:' + this.series.color + ';">\u25CF</span>' + this.series.name + ': ' + this.y;
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
                    name: symbol_for_chart + ' ADX',
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
                if (count == 185)
                    break;
            }
            options.series[0].data = series;
            Highcharts.chart('container_for_indicators', options);
        }
        else if (indicator == "CCI") {
            options = {
                chart: {
                    zoomType: 'x'
                },
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
                tooltip: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m/%d', this.x) + '<br/><span style="color:' + this.series.color + ';">\u25CF</span>' + this.series.name + ': ' + this.y;
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
                    name: symbol_for_chart + ' CCI',
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
                if (count == 185)
                    break;
            }
            options.series[0].data = series;
            Highcharts.chart('container_for_indicators', options);
        }
        else if (indicator == "BBANDS") {
            options = {
                chart: {
                    zoomType: 'x'
                },
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
                tooltip: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m/%d', this.x) + '<br/><span style="color:' + this.series.color + ';">\u25CF</span>' + this.series.name + ': ' + this.y;
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
                    name: symbol_for_chart + ' Real Middle Band',
                    pointStart: Date.UTC(2017, monthIndex - 6, day),
                    pointInterval: 24 * 3600 * 1000,
                    data: []
                },
                    {
                        color: '#00FF00',
                        name: symbol_for_chart + ' Real Lower Band',
                        pointStart: Date.UTC(2017, monthIndex - 6, day),
                        pointInterval: 24 * 3600 * 1000,
                        data: []
                    },
                    {
                        color: '#0000FF',
                        name: symbol_for_chart + ' Real Upper Band',
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
                if (count == 185)
                    break;
            }
            options.series[0].data = seriesm;
            options.series[1].data = seriesl;
            options.series[2].data = seriesu;
            Highcharts.chart('container_for_indicators', options);
        }
        else if (indicator == "MACD") {
            options = {
                chart: {
                    zoomType: 'x'
                },
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
                tooltip: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m/%d', this.x) + '<br/><span style="color:' + this.series.color + ';">\u25CF</span>' + this.series.name + ': ' + this.y;
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
                    name: symbol_for_chart + ' MACD_Signal',
                    pointStart: Date.UTC(2017, monthIndex - 6, day),
                    pointInterval: 24 * 3600 * 1000,
                    data: []
                },
                    {
                        color: '#00FF00',
                        name: symbol_for_chart + ' MACD',
                        pointStart: Date.UTC(2017, monthIndex - 6, day),
                        pointInterval: 24 * 3600 * 1000,
                        data: []
                    },
                    {
                        color: '#0000FF',
                        name: symbol_for_chart + ' MACD_Hist',
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
                if (count == 185)
                    break;
            }
            options.series[0].data = seriesm;
            options.series[1].data = seriesl;
            options.series[2].data = seriesu;
            Highcharts.chart('container_for_indicators', options);
        }
    }

    function formatDate(date) {
        var monthNames = [
            "01", "02", "03",
            "04", "05", "06", "07",
            "08", "09", "10",
            "11", "12"
        ];

        var day = date.getDate() + 1;
        var monthIndex = date.getMonth();
        var year = date.getFullYear();

        return day + '/' + monthNames[monthIndex] + '/' + year;
    }

    $scope.flip_to_fav = function () {
        $scope.show_fav = true;
        $scope.show_details = false;
    }

    $scope.flip_to_details = function () {
        $scope.show_fav = false;
        $scope.show_details = true;
    }


    $scope.querySearch = function (query) {
        $scope.arr = [];
        console.log("in query search before ajax call");
        $http.get("http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/?symbol=" + query + "&second=mark")
            .then(function (response) {
                $scope.arr = response.data;
                // $scope.arr;
            });
        console.log("in query search after ajax call");

        return $scope.arr;
    }


    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function test_input(symbol) {
        symbol = symbol.trim();
        console.log(symbol);
        symbol = escapeHtml(symbol);
        return symbol;
    }

    $scope.symbol_typed = "";
    $scope.symbol = "";

    $scope.submit = function () {
        // $scope.hide_fav = true;
        $scope.show_fav = false;
        $scope.disable_show_details_button = false;
        $scope.id_for_indicators = 1;
        // $scope.hide_details = false;
        $scope.show_details = true;
        symbol = $("#inputSymbol").val();//value from the input text field
        $scope.symbol = symbol;
        // console.log("valueis Ola!");
        console.log("valueis" + symbol);
        console.log("valueis" + $scope.symbol);
        $scope.symbol = test_input(symbol);
        if (!symbol) {
            $('#inputSymbol').tooltip('enable');
            $('#inputSymbol').tooltip('show');
            return;
        }
        else {
            $('#inputSymbol').tooltip('disable');
        }
        // $scope.showTableWait();
        $scope.activeProgressbar = true;
        $http({
            method: 'GET',
            url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params: {"symbol": $scope.symbol, "second": "news"}
        }).then(function successCallback(response) {
            $scope.news = response.data.channel.item;
            console.log($scope.news[0]);


            // angular.forEach($scope.userData, function(entry) {
            //     entry.isFav = $scope.isStarred(entry.id);
            // });


        });
        $http({
            method: 'GET',
            url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params: {"symbol": $scope.symbol, "second": "tsd"}
        }).then(function successCallback(response) {
            $scope.tsd = response.data;
            console.log("tsd");
            console.log($scope.tsd);

            // angular.forEach($scope.pageData, function(entry) {
            //     entry.isFav = $scope.isStarred(entry.id);
            // });

            obj = $scope.tsd;
            console.log("data");
            console.log("data");
            console.log(obj);
            date = obj["Meta Data"]["3. Last Refreshed"];
            symbol_for_chart = obj["Meta Data"]["2. Symbol"];
            var today = new Date(date);
            var day = today.getDate() + 1;
            var monthIndex = today.getMonth();
            var year = today.getFullYear();
            var today_str = formatDate(today);
            options = {
                chart: {
                    zoomType: 'x'
                },
                title: {
                    text: symbol_for_chart + ' Stock Price and Volume'
                },
                subtitle: {
                    text: '<a href=\'https://www.alphavantage.co/\'>Source: Alpha Vantage</a>'
                },
                xAxis: {
                    // endOnTick: true,
                    // startOnTick: true,
                    showFirstLabel: true,
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
                tooltip: {
                    formatter: function () {
                        return Highcharts.dateFormat('%m/%d', this.x) + '<br/><span style=\"color:' + this.series.color + ';\">\u25CF</span>' + this.series.name + ': ' + this.y;
                    }
                },
                plotOptions: {
                    area: {
                        // threshold: null
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
            for (x in obj['Time Series (Daily)']) {
                count += 1;
                var today_date = new Date(x);
                series.unshift(Array(today_date, parseFloat(obj['Time Series (Daily)'][x]['4. close'])));
                volumes.unshift(Array(today_date, parseFloat(obj['Time Series (Daily)'][x]['5. volume'])));
//                            }
                if (count == 185)
                    break;
            }
            options.series[0].data = series;
            options.series[1].data = volumes;
            Highcharts.chart('container_for_indicators', options);

        });
        $http({
            method: 'GET',
            url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params: {"symbol": $scope.symbol, "second": "stoch"}
        }).then(function successCallback(response) {
            $scope.stoch = response.data;
            console.log("stoch");
            console.log($scope.stoch);

            //         angular.forEach($scope.eventData, function(entry) {
            //             entry.isFav = $scope.isStarred(entry.id);
            //         });
            //         //    console.log( response.data );
        });
        $http({
            method: 'GET',
            url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params: {"symbol": $scope.symbol, "second": "bbands"}
        }).then(function successCallback(response) {
            $scope.bbands = response.data;
            console.log("bbands");
            console.log($scope.bbands);
            //             angular.forEach($scope.placeData, function(entry) {
            //                 entry.isFav = $scope.isStarred(entry.id);
            //             });
            //             //   console.log( response.data );
        });
        $http({
            method: 'GET',
            url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params: {"symbol": $scope.symbol, "second": "sma"}
        }).then(function successCallback(response) {
            $scope.sma = response.data;
            console.log("sma");
            console.log($scope.sma);
            //                 angular.forEach($scope.groupData, function(entry) {
            //                     entry.isFav = $scope.isStarred(entry.id);
            //                 });
        });
        $http({
            method: 'GET',
            url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params: {"symbol": $scope.symbol, "second": "ema"}
        }).then(function successCallback(response) {
            $scope.ema = response.data;
            console.log("ema");
            console.log($scope.ema);
        });
        $http({
            method: 'GET',
            url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params: {"symbol": $scope.symbol, "second": "rsi"}
        }).then(function successCallback(response) {
            $scope.rsi = response.data;
            console.log("rsi");
            console.log($scope.rsi);
        });
        $http({
            method: 'GET',
            url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params: {"symbol": $scope.symbol, "second": "adx"}
        }).then(function successCallback(response) {
            $scope.adx = response.data;
            console.log("adx");
            console.log($scope.adx);
        });
        $http({
            method: 'GET',
            url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params: {"symbol": $scope.symbol, "second": "cci"}
        }).then(function successCallback(response) {
            $scope.cci = response.data;
            console.log("cci");
            console.log($scope.cci);
        });
        $http({
            method: 'GET',
            url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params: {"symbol": $scope.symbol, "second": "macd"}
        }).then(function successCallback(response) {
            $scope.macd = response.data;
            console.log("macd");
            console.log($scope.macd);
        });


    }

    $('#inputSymbol').tooltip('disable');
    $('#inputSymbol').tooltip('hide');
    $scope.symbol_typed = "";
})
;
