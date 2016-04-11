var PostMembers = angular.module('PostMembers', [], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

PostMembers.controller('PostMembersCtrl', function ($scope, $sce, $http, $timeout) {
    $scope.is_guest = ! User.isLoggedIn();
    $timeout(function () {
        $http.get(Asset.path('api/post/' + $scope.postId + '/members.json')).success(function (data) {
            $scope.count = data.count;
            $scope.members = data.members;
            $scope.is_member = data.is_member;
        });
    }, 10);

    $scope.attend = function () {
        $http.post(Asset.path('api/post/' + $scope.postId + '/members.json')).success(function (data) {
            $scope.count = data.count;
            $scope.members = data.members;
            $scope.is_member = data.is_member;
        });
    }

    $scope.showMembers = function () {
        $('.ui.modal').modal('show');
    }

    $scope.renderHtml = function (html) {
        return $sce.trustAsHtml(html);
    }
});