<!DOCTYPE html>
<html><head><title>{$page_title}</title>
<link rel="stylesheet" type="text/css" href="wtactics.css" />
<script type="text/javascript" src="util.js"></script>
<meta charset="UTF-8" />
</head>
<body>
	<div id="header">
		<div id="title">Cardscape - {$cfg.general.game}</div>
		<div id="menubar"> | {* stuff that everyone is allowed *}
			<a href="index.php">Home</a> |
			<a href="index.php?browse=0">Browse cards</a> |
			<a href="index.php?statistics">statistics</a> |

{*guest stuff. Not adequate for failed logins but who cares? *}
{if $role == 'guest' && !isset( $smarty.get.login_submit )}
	<a href="index.php?login">login/register</a> |
{else}{*member stuff*}
	<a href="index.php?usercp">control panel</a> |
	<a href="index.php?new_card">suggest new card</a> |
	<a href="index.php?recent_activity">recent activity</a> |
	<a href="index.php?logout">logout</a> |
{/if}
{*admin stuff TODO *}
		</div>		

	</div>
