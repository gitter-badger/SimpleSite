<div ng-app="PostMembers" ng-controller="PostMembersCtrl" ng-init="postId='{{ $post->id }}'" ng-model="postId">
    <div class="ui labeled button" tabindex="0" ng-hide="is_guest || is_member">
        <button class="ui green button" ng-click="attend()" ng-hide="is_member">
            <i class="checkmark icon"></i> @lang('core.post.button.attend')
        </button>
        <a class="ui basic green label" ng-click="showMembers()">
            [[ count ]]
        </a>
    </div>

    {{--
    <div ng-show="is_guest || is_member">
        <a class="ui green statistic" ng-click="showMembers()">
            <div class="value">
                <i class="child icon"></i>  [[ count ]]
            </div>
            <div class="label">
                @lang('core.post.label.total_members')
            </div>
        </a>
    </div>
    --}}

    <h2>@lang('core.post.label.members')</h2>
    <div class="members-list ui mini">
        <div class="ui horizontal relaxed selection list">
            <div class="item" ng-repeat="member in members">
                <img class="ui avatar image" ng-src="[[ member.avatar_url ]]">
                <div class="content">
                    <a class="header" href="[[ member.link ]]" target="_blank">[[ member.display_name ]]</a>
                </div>
            </div>
        </div>
    </div>
</div>