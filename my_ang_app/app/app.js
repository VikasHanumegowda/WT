var app = angular.module('stockApp', ['ngAnimate', 'ngMaterial']);

app.controller('myCtrl', function ($scope, $http) {

    this.querySearch = function (query) {
        return $http.get("http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/?symbol=" + query + "&second=mark")
            .then(function (response) {
                console.log("hello");
                return JSON.parse(response.data);
            })
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
        $scope.hide_fav = true;
        $scope.show_fav = false;

        $scope.hide_details = false;
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
        // var lat= $scope.lat;
        // var long=$scope.long;
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
            $http({
                method: 'GET',
                url: "http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params: {"symbol": $scope.symbol, "second": "ema"}
            }).then(function successCallback(response) {
                $scope.ema = response.data;
                console.log("ema");
                console.log($scope.ema);
                //                 /*Rendering Starts*/
                //                 $scope.setData($scope.id);
            });
        });


    }

    $('#inputSymbol').tooltip('disable');
    $('#inputSymbol').tooltip('hide');
    $scope.symbol_typed = "";
})
;
