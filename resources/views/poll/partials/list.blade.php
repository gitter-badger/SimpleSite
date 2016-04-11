<div ng-app="pollApp" ng-controller="PollListCtrl" class="ui two cards">
    <div class="card" ng-repeat="poll in polls" data-id="<% poll.id %>">
        @include('poll.partials.poll')
    </div>
</div>