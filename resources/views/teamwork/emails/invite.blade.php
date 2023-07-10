You have been invited to join account : {{$team->name}}.<br />
If you do not already have an user account, you will need to register for one first.
<a href="https://connect.dataczar.com/register">https://connect.dataczar.com/register</a>
Click here to join: <a href="{{route('teams.accept_invite', $invite->accept_token)}}">{{route('teams.accept_invite', $invite->accept_token)}}</a>
