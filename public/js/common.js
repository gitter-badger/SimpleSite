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
var pollApp = angular.module('pollApp', ['checklist-model'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

pollApp.controller('PollListCtrl', function ($scope, $sce, $http, $timeout) {
    $scope.updateProgressBar = function () {
        $timeout(function () {
            $('.answer-percentage').progress();
        }, 300);
    }

    $http.get(Asset.path('api/polls.json')).success(function (data) {
        $scope.polls = data;
    });

    $scope.updateProgressBar();

    $scope.vote = function (poll) {
        if (!poll.votes) {
            return false;
        }

        var arrayKeys = function (input) {
            var output = new Array();
            var counter = 0;
            for (var i in input) {
                if (!input[i]) continue;
                output[counter++] = i;
            }
            return output;
        }

        if (poll.multiple) {
            poll.votes = arrayKeys(poll.votes);
        }

        if (!$.isArray(poll.votes)) {
            poll.votes = [poll.votes];
        }

        $http.post(Asset.path('api/poll/vote/' + poll.id), {votes: poll.votes}).success(function (data) {
            $scope.polls = data;
            $scope.updateProgressBar();
        });
    }

    $scope.reset = function (poll) {
        $http.post(Asset.path('api/poll/reset/' + poll.id)).success(function (data) {
            $scope.polls = data;
            $scope.updateProgressBar();
        });
    }

    $scope.renderHtml = function (html) {
        return $sce.trustAsHtml(html);
    }
});