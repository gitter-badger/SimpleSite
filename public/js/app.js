'use strict';

var pollApp = angular.module('pollApp', ['myApp', 'checklist-model'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

pollApp.filter("sanitize", ['$sce', function ($sce) {
    return function (htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    }
}]);

pollApp.controller('PollListCtrl', function ($scope, $sce, USER, $http, $timeout) {
    $scope.updateProgressBar = function () {
        $timeout(function () {
            $('.answer-percentage').progress();
        }, 300);
    }

    $scope.user = USER;

    $http.get('api/polls.json').success(function (data) {
        $scope.polls = data;
    });

    $scope.updateProgressBar();

    $scope.vote = function (poll) {
        if (!poll.votes) {
            return false;
        }

        $http.post('api/poll/vote/' + poll.id, {votes: selected}).success(function (data) {
            $scope.polls = data;
            $scope.updateProgressBar();
        });
    }

    $scope.reset = function (poll) {
        $http.post('api/poll/reset/' + poll.id).success(function (data) {
            $scope.polls = data;
            $scope.updateProgressBar();
        });
    }

    $scope.renderHtml = function (html) {
        return $sce.trustAsHtml(html);
    }
});