@extends('layouts.app')

@section('content')
    <div class="ui container" ng-app="UsersApp" ng-controller="UsersAppCtrl">
        <div class="box">
            <h2>@lang('core.title.users')</h2>

            <table class="ui selectable padded very basic table searchable">
                <colgroup>
                    <col />
                    <col width="100px" />
                    <col width="150px" />
                    <col width="200px" />
                </colgroup>
                <thead>
                    <tr>
                        <th></th>
                        <th class="center aligned">@lang('core.user.field.phone_internal')</th>
                        <th class="right aligned">@lang('core.user.field.phone_mobile')</th>
                        <th>@lang('core.user.field.email')</th>
                    </tr>
                </thead>
                <tbody ng-repeat="(key, users) in usersData">
                    <tr>
                        <th colspan="4">[[ key ]]</th>
                    </tr>
                    <tr ng-repeat="user in users" ng-dblclick="redirectToProfile(user)">
                        <td>
                            <h4 class="ui header">
                                <img ng-src="[[ user.avatar_url ]]" class="ui mini circular image" ng-click="openProfile(user)">

                                <div class="content">
                                    <strong>[[ user.display_name ]]</strong>
                                    <div class="sub header">
                                        [[ user.position ]]
                                    </div>
                                </div>
                            </h4>
                        </td>
                        <td class="center aligned">
                            <strong ng-show="user.phone_internal > 0">[[ user.phone_internal ]]</strong>
                        </td>
                        <td class="right aligned">
                            [[ user.phone_mobile ]]
                        </td>
                        <td>
                            <a href="mailto:[[ user.email ]]">[[ user.email ]]</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="ui modal" ng-controller="UserDetailAppCtrl">
            <i class="close icon"></i>
            <div class="content">
                <div class="ui items">
                    <div class="ui item dz-default" id="uploadAvatar">
                        <div class="ui medium bordered image segment">
                            <img ng-src="[[ user.avatar_url_or_blank ]]" />
                        </div>

                        <div class="content">
                            <h1>[[ user.display_name ]]</h1>

                            <div class="ui section divider"></div>

                            <div class="meta">
                                [[ user.position ]]
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
var UsersApp = angular.module('UsersApp', [], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

UsersApp.controller('UsersAppCtrl', function ($scope, $http, $timeout) {
    $scope.usersData = [];

    $http.get(Asset.path('api/users.json')).success(function (data) {
        $scope.usersData = data;

        $timeout(function () {
            $scope.initSearch();
        }, 100);
    });


    $scope.initSearch = function() {
        $('.searchable').filterTable({
            label: '<i class="search icon"></i>',
            containerTag: 'div',
            placeholder: 'Введите слово для поиска',
            containerClass: 'ui large fluid icon input input-search'
        });
    }

    $scope.openProfile = function(user) {
        $scope.$broadcast('openProfile', user);
    }

    $scope.redirectToProfile = function(user) {
       window.location.href = '/user/'+user.id;
    }
});

UsersApp.controller('UserDetailAppCtrl', function ($scope, $http) {
    $scope.$on('openProfile', function(event, user) {
        $scope.user = user;
        $('.ui.modal').modal('show');
    });
});
</script>
@endsection