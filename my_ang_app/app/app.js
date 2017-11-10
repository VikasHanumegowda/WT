

var app = angular.module('stockApp', ['ngAnimate','ngMaterial']);

app.controller('myCtrl', function($scope, $http){

    this.querySearch = function(query){
        return $http.get("http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/?symbol="+query+"&second=mark")
            .then(function(response){
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

    function test_input(symbol)
    {
        symbol = symbol.trim();
        console.log(symbol);
        symbol = escapeHtml(symbol);
        return symbol;
    }

    $scope.symbol_typed = "";
    $scope.symbol="";

    $scope.submit = function () {
        symbol = $("#inputSymbol").val();//value from the input text field
        $scope.symbol = symbol;
        // console.log("valueis Ola!");
        console.log("valueis"+symbol);
        console.log("valueis"+$scope.symbol);
        $scope.symbol = test_input(symbol);
        if(!symbol) {
            $('#inputSymbol').tooltip('enable');
            $('#inputSymbol').tooltip('show');
            return;
        }
        else {
            $('#inputSymbol').tooltip('disable');
        }
        // $scope.showTableWait();
        $scope.activeProgressbar=true;
        // var lat= $scope.lat;
        // var long=$scope.long;
        $http({
            method:'GET',
            url:"http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
            params:{"symbol": $scope.symbol, "second": "news"}
        }).then(function successCallback(response) {
            $scope.news = response.data.channel.item;
            console.log($scope.news[0]);


            // angular.forEach($scope.userData, function(entry) {
            //     entry.isFav = $scope.isStarred(entry.id);
            // });


            $http({
                method:'GET',
                url:"http://homework8-env.wjdp2sdqus.us-west-2.elasticbeanstalk.com/",
                params:{"symbol": $scope.symbol, "second": "tsd"}
            }).then(function successCallback(response) {
                $scope.tsd = response.data;
                console.log("tsd");
                console.log($scope.tsd);
                // $scope.pageData = response.data.data;
                // console.log(response.data.data);
                // $scope.pagePage=response.data.paging;
                // if( !$scope.pagePage)
                // {
                //     $scope.pageAppend['hasNext']=false;
                //     $scope.pageAppend['hasPrev']=false;
                // }
                // else {
                //     $scope.pageAppend=$scope.append($scope.pagePage,"page");
                //     console.log(response.data.paging);
                // }
                // angular.forEach($scope.pageData, function(entry) {
                //     entry.isFav = $scope.isStarred(entry.id);
                // });


            //     $http({
            //         method:'GET',
            //         url:"http://www.sodium-task-95910.appspot.com/?",
            //         params:{"data": keyword, "type": "event"}
            //     }).then(function successCallback(response) {
            //         $scope.eventData = response.data.data;
            //         console.log(  response.data.paging );
            //         $scope.eventPage=response.data.paging;
            //         if( !$scope.eventPage)
            //         {
            //             $scope.eventAppend['hasNext']=false;
            //             $scope.eventAppend['hasPrev']=false;
            //         }
            //         else {
            //             $scope.eventAppend=$scope.append($scope.eventPage,"event");
            //             console.log(response.data.paging);
            //         }
            //         angular.forEach($scope.eventData, function(entry) {
            //             entry.isFav = $scope.isStarred(entry.id);
            //         });
            //         //    console.log( response.data );
            //         $http({
            //             method:'GET',
            //             url:"http://www.sodium-task-95910.appspot.com/?",
            //             params:{"data": keyword, "type": "place","lat": lat,"long":long}
            //         }).then(function successCallback(response) {
            //             $scope.placeData = response.data.data;
            //             console.log( response.data.paging );
            //             $scope.placePage=response.data.paging;
            //             if( !$scope.placePage)
            //             {
            //                 $scope.placeAppend['hasNext']=false;
            //                 $scope.placeAppend['hasPrev']=false;
            //             }
            //             else {
            //                 $scope.placeAppend=$scope.append($scope.placePage,"place");
            //                 console.log(response.data.paging);
            //             }
            //             angular.forEach($scope.placeData, function(entry) {
            //                 entry.isFav = $scope.isStarred(entry.id);
            //             });
            //             //   console.log( response.data );
            //             $http({
            //                 method:'GET',
            //                 url:"http://www.sodium-task-95910.appspot.com/?",
            //                 params:{"data": keyword, "type": "group"}
            //             }).then(function successCallback(response) {
            //                 $scope.groupData = response.data.data;
            //                 console.log(response.data.paging);
            //                 $scope.groupPage=response.data.paging;
            //                 if( !$scope.groupPage)
            //                 {
            //                     $scope.groupAppend['hasNext']=false;
            //                     $scope.groupAppend['hasPrev']=false;
            //                 }
            //                 else {
            //                     $scope.groupAppend=$scope.append($scope.groupPage,"group");
            //                     console.log(response.data.paging);
            //                 }
            //                 angular.forEach($scope.groupData, function(entry) {
            //                     entry.isFav = $scope.isStarred(entry.id);
            //                 });
            //                 /*Rendering Starts*/
            //                 $scope.setData($scope.id);
            //             });
            //         });
            //     });
            });
        });
    }

    $('#inputSymbol').tooltip('disable');
    $('#inputSymbol').tooltip('hide');
    $scope.symbol_typed = "";
});
