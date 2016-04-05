<h1>Polls</h1>
<div ng-app="pollApp" ng-controller="PollListCtrl" class="ui two cards">
    <div class="card " ng-repeat="poll in polls" data-id="<% poll.id %>">
        <div class="content">
            <h4 class="header"><% poll.title %></h4>
            <p class="description" ng-show="poll.description"><% poll.description %></p>
        </div>
        <div class="content">
            <div class="field" ng-repeat="answer in poll.answers" ng-hide="poll.is_voted||!user.id" style="margin-bottom: 10px">
                    <input id="answer<% answer.id %>" ng-hide="poll.multiple" type="radio" ng-model="poll.votes" name="poll" ng-value="answer.id" />
                    <input id="answer<% answer.id %>" ng-show="poll.multiple" type="checkbox" ng-model="poll.votes" name="poll[]" ng-value="answer.id" />

                    <label for="answer<% answer.id %>" style="cursor: pointer">
                        <% answer.title %>
                        <p class="meta" ng-show="answer.description"><% answer.description %></p>
                    </label>
            </div>

            <div class="ui tiny success progress answer-percentage" ng-repeat="answer in poll.answers" data-percent="<% answer.percentage %>" ng-show="poll.is_voted||!user.id">
                <div class="bar"></div>
                <div class="label"><% answer.title %></div>
            </div>

            <div ng-show="user.id">
                <br />
                <button class="ui primary button" ng-click="vote(poll)" ng-hide="poll.is_voted">
                    <i class="checkmark icon"></i> @lang('core.poll.button.vote')
                </button>
                <button class="ui orange button" ng-click="reset(poll)" ng-show="poll.is_voted">
                    <i class="remove icon"></i> @lang('core.poll.button.reset')
                </button>
            </div>
        </div>

        <div class="extra">
            <div class="ui green small label">
                @lang('core.poll.label.total_votes')
                <strong><% poll.total_votes %></strong>
            </div>
        </div>

        <div class="extra">
            <div class="right floated author" ng-bind-html="renderHtml(poll.author.name)">

            </div>
        </div>
    </div>
</div>