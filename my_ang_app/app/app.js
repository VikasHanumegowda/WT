

var app = angular.module('stockApp', ['ngAnimate']);

app.controller('myCtrl', function($scope, $http){


    $scope.querySearch = function(query) {
        return $http.get("http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input="+"query")
            .then(function (response) {
                // response.data.forEach(function (element) {
                    console.log(response.data);
                    return response.data;
                // })
            });
    }
    $scope.querySearch = function(query){
        return $http.get("https://api.github.com/search/users", {params: {q: query}})
            .then(function(response){
                return response.data.items;
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
        symbol = trim(symbol);
        console.log(symbol);
        symbol = escapeHtml(symbol);
        return symbol;
    }

    $scope.symbol_typed = "";
    $scope.symbol="";
    $scope.submit = function () {
        symbol = $("#inputSymbol").val();//value from the input text field
        $scope.symbol = symbol;
        console.log("valueis"+symbol);
        symbol = test_input(symbol);
        if(!symbol) {
            $('#inputSymbol').tooltip('enable');
            $('#inputSymbol').tooltip('show');
            return;
        }
        else {
            $('#inputSymbol').tooltip('disable');
        }
        // $scope.showTableWait();
        // $scope.activeProgressbar=true;
        // var lat= $scope.lat;
        // var long=$scope.long;
        // var url = 'http://www.sodium-task-95910.appspot.com/?keyword';
        // console.log(keyword);
        // $http({
        //     method:'GET',
        //     url:"http://www.sodium-task-95910.appspot.com/?",
        //     params:{"data": keyword, "type": "user"}
        // }).then(function successCallback(response) {
        //     $scope.userData = response.data.data;
        //     $scope.userPage= response.data.paging;
        //     console.log(response.data.data);
        //     console.log(response.data.paging);
        //     if( !$scope.userPage)
        //     {
        //         $scope.userAppend['hasNext']=false;
        //         $scope.userAppend['hasPrev']=false;
        //     }
        //     else {
        //         $scope.userAppend = $scope.append($scope.userPage, "user");
        //         console.log(response.data.data);
        //     }
        //     angular.forEach($scope.userData, function(entry) {
        //         entry.isFav = $scope.isStarred(entry.id);
        //     });
        //     $http({
        //         method:'GET',
        //         url:"http://www.sodium-task-95910.appspot.com/?",
        //         params:{"data": keyword, "type": "page"}
        //     }).then(function successCallback(response) {
        //         $scope.pageData = response.data.data;
        //         console.log(response.data.data);
        //         $scope.pagePage=response.data.paging;
        //         if( !$scope.pagePage)
        //         {
        //             $scope.pageAppend['hasNext']=false;
        //             $scope.pageAppend['hasPrev']=false;
        //         }
        //         else {
        //             $scope.pageAppend=$scope.append($scope.pagePage,"page");
        //             console.log(response.data.paging);
        //         }
        //         angular.forEach($scope.pageData, function(entry) {
        //             entry.isFav = $scope.isStarred(entry.id);
        //         });
        //         $http({
        //             method:'GET',
        //             url:"http://www.sodium-task-95910.appspot.com/?",
        //             params:{"data": keyword, "type": "event"}
        //         }).then(function successCallback(response) {
        //             $scope.eventData = response.data.data;
        //             console.log(  response.data.paging );
        //             $scope.eventPage=response.data.paging;
        //             if( !$scope.eventPage)
        //             {
        //                 $scope.eventAppend['hasNext']=false;
        //                 $scope.eventAppend['hasPrev']=false;
        //             }
        //             else {
        //                 $scope.eventAppend=$scope.append($scope.eventPage,"event");
        //                 console.log(response.data.paging);
        //             }
        //             angular.forEach($scope.eventData, function(entry) {
        //                 entry.isFav = $scope.isStarred(entry.id);
        //             });
        //             //    console.log( response.data );
        //             $http({
        //                 method:'GET',
        //                 url:"http://www.sodium-task-95910.appspot.com/?",
        //                 params:{"data": keyword, "type": "place","lat": lat,"long":long}
        //             }).then(function successCallback(response) {
        //                 $scope.placeData = response.data.data;
        //                 console.log( response.data.paging );
        //                 $scope.placePage=response.data.paging;
        //                 if( !$scope.placePage)
        //                 {
        //                     $scope.placeAppend['hasNext']=false;
        //                     $scope.placeAppend['hasPrev']=false;
        //                 }
        //                 else {
        //                     $scope.placeAppend=$scope.append($scope.placePage,"place");
        //                     console.log(response.data.paging);
        //                 }
        //                 angular.forEach($scope.placeData, function(entry) {
        //                     entry.isFav = $scope.isStarred(entry.id);
        //                 });
        //                 //   console.log( response.data );
        //                 $http({
        //                     method:'GET',
        //                     url:"http://www.sodium-task-95910.appspot.com/?",
        //                     params:{"data": keyword, "type": "group"}
        //                 }).then(function successCallback(response) {
        //                     $scope.groupData = response.data.data;
        //                     console.log(response.data.paging);
        //                     $scope.groupPage=response.data.paging;
        //                     if( !$scope.groupPage)
        //                     {
        //                         $scope.groupAppend['hasNext']=false;
        //                         $scope.groupAppend['hasPrev']=false;
        //                     }
        //                     else {
        //                         $scope.groupAppend=$scope.append($scope.groupPage,"group");
        //                         console.log(response.data.paging);
        //                     }
        //                     angular.forEach($scope.groupData, function(entry) {
        //                         entry.isFav = $scope.isStarred(entry.id);
        //                     });
        //                     /*Rendering Starts*/
        //                     $scope.setData($scope.id);
        //                 });
        //             });
        //         });
        //     });
        // });
    }

    $('#inputSymbol').tooltip('disable');
    $('#inputSymbol').tooltip('hide');
    $scope.symbol_typed = "";
});
