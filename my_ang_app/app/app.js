var app = angular.module('stockApp', ['ngAnimate', 'ngMaterial']);
String.prototype.format = function () {
    var formatted = this;
    for (var arg in arguments) {
        formatted = formatted.replace("{" + arg + "}", arguments[arg]);
    }
    return formatted;
};
String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};

app.controller('myCtrl', function ($scope, $http) {

        //initializations
        $scope.first_highstock = 1;
        $scope.disable_show_details_button = true;
        $scope.show_fav = true;
        $scope.show_details = false;
        $scope.id_for_upper_tabs = 1;

        $scope.order_by = 'a';
        $scope.sort_selected = 'Default';


        if (!$scope.fav_list)
            $scope.fav_list = [];
        $scope.isfav = false;

        $scope.timestamp = moment().add(3, 'hours').format("YYYY-MM-DD HH:mm:ss") + " EST";


        $('#inputSymbol').tooltip('disable');
        $('#inputSymbol').tooltip('hide');
        $scope.symbol_typed = "";

        $scope.isfav = false;

        $scope.symbol_typed = "";
        $scope.symbol = "";


        $scope.automatic_refresh = function () {

        }

        $scope.sortTable = function () {
            column_name = $scope.sort_selected;

            order_by = $scope.order_by;
            console.log(order_by);
            if (order_by === "a")
                asc = true;
            else
                asc = false;
            console.log(column_name);
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("fav_table");
            switching = true;
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.getElementsByTagName("TR");
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    if (column_name === "Symbol") {
                        x = rows[i].getElementsByTagName("TD")[0];
                        y = rows[i + 1].getElementsByTagName("TD")[0];
                        //check if the two rows should switch place:
                        if (asc) {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                //if so, mark as a switch and break the loop:

                                shouldSwitch = true;
                                break;
                            }
                        }
                        else {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                //if so, mark as a switch and break the loop:

                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    else if (column_name === "Stock Price") {
                        x = rows[i].getElementsByTagName("TD")[1];
                        y = rows[i + 1].getElementsByTagName("TD")[1];
                        //check if the two rows should switch place:
                        if (asc) {
                            if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                                console.log("true");
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }
                        else {
                            if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
                                console.log("true");
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    else if (column_name === "Change") {
                        x = rows[i].getElementsByTagName("TD")[0];
                        y = rows[i + 1].getElementsByTagName("TD")[0];
                        //check if the two rows should switch place:

                        if (asc) {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }
                        else {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    else if (column_name === "Change Percent") {
                        x = rows[i].getElementsByTagName("TD")[0];
                        y = rows[i + 1].getElementsByTagName("TD")[0];
                        //check if the two rows should switch place:

                        if (asc) {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }
                        else {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    else if (column_name === "Volume") {
                        x = rows[i].getElementsByTagName("TD")[3];
                        y = rows[i + 1].getElementsByTagName("TD")[3];
                        //check if the two rows should switch place:
                        // console.log(x.innerHTML);
                        // console.log(parseFloat(x.innerHTML));

                        x_inner = x.innerHTML;
                        y_inner = y.innerHTML;

                        x_inner = x_inner.replaceAll(",", "");
                        y_inner = y_inner.replaceAll(",", "");

                        console.log(parseInt(x_inner));
                        console.log(parseInt(y_inner));
                        if (asc) {
                            if (parseInt(x_inner) > parseInt(y_inner)) {
                                console.log("true");
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }
                        else {
                            if (parseInt(x_inner) < parseInt(y_inner)) {
                                console.log("true");
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }
                    else if (column_name === "Default") {
                        if (asc) {
                            $scope.load_fav_list();
                        }
                        else {
                            $scope.fav_list = $scope.fav_list.reverse();

                        }
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }

        $scope.isStarred = function () { //checking starred value on reloading
            var match = false;
            var list = angular.fromJson(localStorage.getItem("favouriteList"));
            angular.forEach(list, function (entry) {
                if (entry.symbol === $scope.ticker_symbol) {
                    console.log("match found");
                    match = true;
                    return match;
                }
            });
            return match;
        }

        $scope.load_fav_list = function () {
            $scope.fav_list = angular.fromJson(localStorage.getItem("favouriteList"));
            console.log($scope.fav_list);

        }

        $scope.load_fav_list();

        $scope.addFav = function () {
            var list = [];
            $scope.isFav = true;
            var item_to_add = {
                'symbol': $scope.ticker_symbol,
                'stock_price': $scope.last_price,
                'change': $scope.change,
                'change_percent': $scope.change_percent,
                'volume': $scope.volume
            };
            var favouriteList = localStorage.getItem("favouriteList");

            if (favouriteList) {
                list = angular.fromJson(favouriteList); //parse
            }
            list.push(item_to_add);
            localStorage.setItem("favouriteList", JSON.stringify(list));
            $scope.load_fav_list();
            $scope.$evalAsync();
        }

        $scope.deleteFav_for_star = function () {

            $scope.isFav = false;
            list = angular.fromJson(localStorage.getItem("favouriteList")); //parsing list
            angular.forEach(list, function (additem, index) {
                if (additem.symbol == $scope.ticker_symbol) {
                    list.splice(index, 1);
                }
            });
            localStorage.setItem("favouriteList", JSON.stringify(list));
            $scope.load_fav_list();
            $scope.$evalAsync();
        }

        $scope.deleteFav = function (item) {
            if (item.symbol == $scope.ticker_symbol)
                $scope.isFav = false;
            list = angular.fromJson(localStorage.getItem("favouriteList")); //parsing list
            angular.forEach(list, function (additem, index) {
                if (additem.symbol == item.symbol) {
                    list.splice(index, 1);
                }
            });
            localStorage.setItem("favouriteList", JSON.stringify(list));
            $scope.load_fav_list();
            $scope.$evalAsync();
        }

        // $scope.timestamp = convertToServerTimeZone() + " EST";
        $scope.stringToDate = function (_date, _format, _delimiter) {
            var formatLowerCase = _format.toLowerCase();
            var formatItems = formatLowerCase.split(_delimiter);
            var dateItems = _date.split(_delimiter);
            var monthIndex = formatItems.indexOf("mm");
            var dayIndex = formatItems.indexOf("dd");
            var yearIndex = formatItems.indexOf("yyyy");
            var month = parseInt(dateItems[monthIndex]);
            month -= 1;
            var formatedDate = new Date(dateItems[yearIndex], month, dateItems[dayIndex]);
            return formatedDate;
        }


        $scope.clickSetUpperTab = function (id)  //set tab on click
        {
            $scope.id_for_upper_tabs = id;
            if ($scope.id_for_upper_tabs == 2)
                $scope.populate_highstock();

        }


        $scope.populate_highstock = function () {
            if ($scope.first_highstock === 1)
                $scope.first_highstock = 0;
            else
                $('container_for_highstock').highcharts().destroy();
            var chart = Highcharts.stockChart('container_for_highstock', $scope.options_for_highstock);

        }

        $scope.isSetUpper = function (id) {       //true or false
            if ($scope.id_for_upper_tabs == id)
                return true;
            else
                return false;
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
                        height: (9 / 20 * 100) + '%',
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
                // console.log("SMA before charts");
                console.log(options.series[0].data);
                Highcharts.chart('container_for_indicators', options);
                // console.log("SMA after charts");

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
            $scope.load_fav_list();
        }

        $scope.flip_to_details = function () {
            $scope.show_fav = false;
            $scope.show_details = true;
            $scope.sort_selected = "Default";
            $scope.disable_show_details_button = false;
            $scope.id_for_indicators = 1;
        }
        $scope.init_bars = function () {
            $scope.progress_bar_for_stock_details_active = true;
            $scope.progress_bar_for_sma_active = true;
            $scope.progress_bar_for_ema_active = true;
            $scope.progress_bar_for_rsi_active = true;
            $scope.progress_bar_for_macd_active = true;
            $scope.progress_bar_for_bbands_active = true;
            $scope.progress_bar_for_stoch_active = true;
            $scope.progress_bar_for_adx_active = true;
            $scope.progress_bar_for_cci_active = true;
            $scope.progress_bar_for_news_active = true;

            $scope.error_bar_for_stock_details_active = false;
            $scope.error_bar_for_sma_active = false;
            $scope.error_bar_for_ema_active = false;
            $scope.error_bar_for_rsi_active = false;
            $scope.error_bar_for_macd_active = false;
            $scope.error_bar_for_bbands_active = false;
            $scope.error_bar_for_stoch_active = false;
            $scope.error_bar_for_adx_active = false;
            $scope.error_bar_for_cci_active = false;
            $scope.error_bar_for_news_active = false;
            $scope.isFav = false;
            $scope.stock_data_not_loaded = true;
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
            symbol = symbol.toUpperCase();
            return symbol;
        }

        $scope.clear_reload = function () {
            console.log("clear");
            location.reload(false);
        }


        $scope.submit = function () {
            // $scope.hide_fav = true;


            $scope.init_bars();
            $scope.flip_to_details();
            symbol = $("#inputSymbol").val();//value from the input text field
            $scope.symbol = symbol;
            // console.log("valueis Ola!");
            console.log("valueis" + symbol);

            console.log("valueis" + $scope.symbol);
            $scope.symbol = test_input(symbol);
            $scope.ticker_symbol = $scope.symbol;
            $scope.$evalAsync();

            if (!symbol) {
                $('#inputSymbol').tooltip('enable');
                $('#inputSymbol').tooltip('show');
                return;
            }
            else {
                $('#inputSymbol').tooltip('disable');
            }

            // TIME SERIES DATA

            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "tsd"}
            }).then(function successCallback(response) {

                $scope.tsd = response.data;
                hell_data = $scope.tsd;
                console.log(hell_data.hasOwnProperty("Meta Data"));
                if (hell_data.hasOwnProperty("Meta Data")) {
                    console.log("tsd");
                    console.log($scope.tsd);
                    obj = $scope.tsd;
                    console.log("data");
                    console.log("data");
                    date = obj["Meta Data"]["3. Last Refreshed"];
                    date = moment(date).format("YYYY-MM-DD");
                    console.log(date);
                    symbol_for_chart = obj["Meta Data"]["2. Symbol"];

                    $scope.stock_data_not_loaded = false;
                    $scope.isfav = $scope.isStarred();

                    console.log(obj["Time Series (Daily)"][date]);
                    $scope.volume = parseInt(obj["Time Series (Daily)"][date]["5. volume"]).toLocaleString();
                    $scope.last_price = parseFloat(obj["Time Series (Daily)"][date]["4. close"]).toFixed(2); //current_close_price
                    $scope.prev_date = moment(date).subtract(1, "day").format("YYYY-MM-DD");
                    while (!obj["Time Series (Daily)"].hasOwnProperty($scope.prev_date))
                        $scope.prev_date = moment($scope.prev_date).subtract(1, "day").format("YYYY-MM-DD");
                    $scope.prev_close = parseFloat(obj["Time Series (Daily)"][$scope.prev_date]["4. close"]).toFixed(2);
                    $scope.day_range = "{0} - {1}".format(parseFloat(obj["Time Series (Daily)"][date]["3. low"]).toFixed(2), parseFloat(obj["Time Series (Daily)"][date]["2. high"]).toFixed(2));
                    $scope.open_value = parseFloat(obj['Time Series (Daily)'][date]["1. open"]).toFixed(2);
                    $scope.change = ($scope.prev_close - $scope.last_price).toFixed(2);
                    $scope.is_positive_change = $scope.change >= 0;
                    $scope.change_percent = ($scope.change * 100 / $scope.prev_close).toFixed(2);

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
                    for (x in obj["Time Series (Daily)"]) {
                        count += 1;
                        var today_date = new Date(x);
                        series.unshift(Array(today_date, parseFloat(obj["Time Series (Daily)"][x]["4. close"])));
                        volumes.unshift(Array(today_date, parseFloat(obj["Time Series (Daily)"][x]["5. volume"])));
//                            }
                        if (count == 185)
                            break;
                    }
                    options.series[0].data = series;
                    options.series[1].data = volumes;
                    Highcharts.chart("container_for_indicators", options);
                    $scope.progress_bar_for_stock_details_active = false;

                    $scope.options_for_highstock = {

                        chart: {
                            height: 400,
                            width: 1200
                        },

                        title: {
                            text: $scope.symbol + ' Stock Value'
                        },

                        subtitle: {
                            text: '<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>'
                        },

                        rangeSelector: {
                            selected: 1
                        },

                        series: [{
                            name: $scope.symbol + ' Stock Price',
                            data: [],
                            type: 'area',
                            threshold: null,
                            tooltip: {
                                valueDecimals: 2
                            }
                        }],


                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    chart: {
                                        maxWidth: 500,
                                        minWidth: 200
                                    },
                                    subtitle: {
                                        text: '<a href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>'
                                    },
                                    navigator: {
                                        enabled: true
                                    }
                                }
                            }]
                        }
                    };
                    series = [];
                    count = 0;
                    for (x in obj["Time Series (Daily)"]) {
                        count += 1;
                        var today_date = new Date(x);
                        series.unshift(Array(today_date, parseFloat(obj["Time Series (Daily)"][x]["4. close"])));
                        // if (count == 1000)
                        //     break;
                    }
                    console.log(series);
                    $scope.options_for_highstock.series[0].data = series;
                    $scope.progress_bar_for_stock_details_active = false;

                }
                else {
                    $scope.progress_bar_for_stock_details_active = false;

                    $scope.error_bar_for_stock_details_active = true;
                }
                $scope.$evalAsync();


            });

            //END OF TIME SERIES DATA


            //OTHER DATA FOR INDICATORS

            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "stoch"}
            }).then(function successCallback(response) {
                    $scope.stoch = response.data;
                    hell_data = $scope.stoch;
                    console.log(hell_data.hasOwnProperty("Meta Data"));
                    if (hell_data.hasOwnProperty("Meta Data")) {
                        console.log("stoch");
                        console.log($scope.stoch);
                        $scope.progress_bar_for_stoch_active = false;
                    }
                    else {
                        $scope.progress_bar_for_stoch_active = false;
                        $scope.error_bar_for_stoch_active = true;
                    }
                }
            );
            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "bbands"}
            }).then(function successCallback(response) {
                $scope.bbands = response.data;
                hell_data = $scope.bbands;
                console.log(hell_data.hasOwnProperty("Meta Data"));
                if (hell_data.hasOwnProperty("Meta Data")) {
                    console.log("bbands");
                    console.log($scope.bbands);
                    $scope.progress_bar_for_bbands_active = false;
                }
                else {
                    $scope.progress_bar_for_bbands_active = false;
                    $scope.error_bar_for_bbands_active = true;
                }
            })
            ;
            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "sma"}
            }).then(function successCallback(response) {
                    $scope.sma = response.data;
                    hell_data = $scope.sma;
                    console.log(hell_data.hasOwnProperty("Meta Data"));
                    if (hell_data.hasOwnProperty("Meta Data")) {
                        console.log("sma");
                        console.log($scope.sma);
                        $scope.progress_bar_for_sma_active = false;
                    }
                    else {
                        $scope.progress_bar_for_sma_active = false;
                        $scope.error_bar_for_sma_active = true;
                    }
                }
            );
            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "ema"}
            }).then(function successCallback(response) {
                    $scope.ema = response.data;
                    hell_data = $scope.ema;
                    console.log(hell_data.hasOwnProperty("Meta Data"));

                    if (hell_data.hasOwnProperty("Meta Data")) {
                        console.log("ema");
                        console.log($scope.ema);
                        $scope.progress_bar_for_ema_active = false;
                    }
                    else {
                        $scope.progress_bar_for_ema_active = false;
                        $scope.error_bar_for_ema_active = true;
                    }
                }
            );
            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "rsi"}
            }).then(function successCallback(response) {
                    $scope.rsi = response.data;
                    hell_data = $scope.rsi;
                    console.log(hell_data.hasOwnProperty("Meta Data"));
                    if (hell_data.hasOwnProperty("Meta Data")) {
                        console.log("rsi");
                        console.log($scope.rsi);
                        $scope.progress_bar_for_rsi_active = false;
                    }
                    else {
                        $scope.progress_bar_for_rsi_active = false;
                        $scope.error_bar_for_rsi_active = true;
                    }
                }
            );
            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "adx"}
            }).then(function successCallback(response) {
                    $scope.adx = response.data;
                    hell_data = $scope.adx;
                    console.log(hell_data.hasOwnProperty("Meta Data"));

                    if (hell_data.hasOwnProperty("Meta Data")) {
                        console.log("adx");
                        console.log($scope.adx);
                        $scope.progress_bar_for_adx_active = false;
                    }
                    else {
                        $scope.progress_bar_for_adx_active = false;
                        $scope.error_bar_for_adx_active = true;
                    }
                }
            );
            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "cci"}
            }).then(function successCallback(response) {
                    $scope.cci = response.data;
                    hell_data = $scope.cci;
                    console.log(hell_data.hasOwnProperty("Meta Data"));

                    if (hell_data.hasOwnProperty("Meta Data")) {
                        console.log("cci");
                        console.log($scope.cci);
                        $scope.progress_bar_for_cci_active = false;
                    }
                    else {
                        $scope.progress_bar_for_cci_active = false;
                        $scope.error_bar_for_cci_active = true;
                    }
                }
            );
            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "macd"}
            }).then(function successCallback(response) {
                    $scope.macd = response.data;
                    hell_data = $scope.macd;
                    console.log(hell_data.hasOwnProperty("Meta Data"));
                    if (hell_data.hasOwnProperty("Meta Data")) {
                        console.log("macd");
                        console.log($scope.macd);
                        $scope.progress_bar_for_macd_active = false;
                    }
                    else {
                        $scope.progress_bar_for_macd_active = false;
                        $scope.error_bar_for_macd_active = true;
                    }
                }
            );
            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "news"}
            }).then(function successCallback(response) {
                    $scope.news = [];
                    for (x = 0; x < 5; x++)
                        $scope.news.push(response.data.channel.item[x]);
                    hell_data = $scope.news;
                    console.log(angular.equals(hell_data, []));
                    if (angular.equals(hell_data, [])) {
                        console.log("news");
                        console.log($scope.news[0]);
                        $scope.progress_bar_for_news_active = false;
                    }
                    else {
                        $scope.progress_bar_for_news_active = false;
                        $scope.error_bar_for_news_active = true;
                    }
                }
            );

        }

    }
)
;
