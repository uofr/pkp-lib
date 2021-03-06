{**
 * lib/pkp/templates/common/header.tpl
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Common site header.
 *}
<!DOCTYPE html>
<html lang="{$currentLocale|replace:"_":"-"}" xml:lang="{$currentLocale|replace:"_":"-"}">
{if !$pageTitleTranslated}{translate|assign:"pageTitleTranslated" key=$pageTitle}{/if}
{include file="core:common/headerHead.tpl"}
<body class="pkp_page_{$requestedPage|escape|default:"index"} pkp_op_{$requestedOp|escape|default:"index"}">
	<script type="text/javascript">
		// Initialise JS handler.
		$(function() {ldelim}
			$('body').pkpHandler(
				'$.pkp.controllers.SiteHandler',
				{ldelim}
					{if $isUserLoggedIn}
						inlineHelpState: {$initialHelpState},
					{/if}
					toggleHelpUrl: {url|json_encode page="user" op="toggleHelp" escape=false},
					toggleHelpOnText: {$toggleHelpOnText|json_encode},
					toggleHelpOffText: {$toggleHelpOffText|json_encode},
					{include file="core:controllers/notification/notificationOptions.tpl"}
				{rdelim});
		{rdelim});
	</script>
	<div class="pkp_structure_page">
		<header class="pkp_structure_head">
			<nav class="pkp_navigation" id="headerNavigationContainer">

				{* Logo or site title *}
				<div class="pkp_site_name">
					{if $currentJournal && $multipleContexts}
						{url|assign:"homeUrl" journal="index" router=$smarty.const.ROUTE_PAGE}
					{else}
						{url|assign:"homeUrl" page="index" router=$smarty.const.ROUTE_PAGE}
					{/if}
					{if $displayPageHeaderLogo && is_array($displayPageHeaderLogo)}
						<a href="{$homeUrl}" class="is_img">
							<img src="{$publicFilesDir}/{$displayPageHeaderLogo.uploadName|escape:"url"}" {if $displayPageHeaderLogoAltText != ''}alt="{$displayPageHeaderLogoAltText|escape}"{else}alt="{translate key="common.pageHeaderLogo.altText"}"{/if} />
						</a>
					{elseif $displayPageHeaderTitle && is_array($displayPageHeaderTitle)}
						<a href="{$homeUrl}" class="is_img">
							<img src="{$publicFilesDir}/{$displayPageHeaderTitle.uploadName|escape:"url"}" {if $displayPageHeaderTitleAltText != ''}alt="{$displayPageHeaderTitleAltText|escape}"{else}alt="{translate key="common.pageHeader.altText"}"{/if} />
						</a>
					{elseif $displayPageHeaderTitle}
						<a href="{$homeUrl}" class="is_text">{$displayPageHeaderTitle}</a>
					{else}
						<a href="{$homeUrl}" class="is_img">
							<img src="{$baseUrl}/templates/images/structure/ojs_logo.png" alt="{$applicationName|escape}" title="{$applicationName|escape}" width="180" height="90" />
						</a>
					{/if}
				</div>

				{* Primary navigation menu *}
				{if $isUserLoggedIn}
					<script type="text/javascript">
						// Attach the JS file tab handler.
						$(function() {ldelim}
							$('#navigationPrimary').pkpHandler(
									'$.pkp.controllers.MenuHandler');
						{rdelim});
					 </script>
					<ul id="navigationPrimary" class="pkp_navigation_primary pkp_nav_list">

						{url|assign:fetchTaskUrl router=$smarty.const.ROUTE_COMPONENT component="page.PageHandler" op="tasks" escape=false}
						{capture assign="tasksNavPlaceholder"}
							<a href="#">
								{translate key="common.tasks"}
								<span class="pkp_spinner"></span>
							</a>
						{/capture}
						{load_url_in_el el="li" class="pkp_tasks" id="userTasksWrapper" url=$fetchTaskUrl placeholder=$tasksNavPlaceholder}

						{if array_intersect(array(ROLE_ID_MANAGER, ROLE_ID_ASSISTANT, ROLE_ID_REVIEWER, ROLE_ID_AUTHOR), (array)$userRoles)}
							<li>
								<a href="{url router=$smarty.const.ROUTE_PAGE page="dashboard"}">
									{translate key="navigation.dashboard"}
								</a>
							</li>
						{/if}

						{if array_intersect(array(ROLE_ID_MANAGER), (array)$userRoles)}
							<li class="has-submenu">
								<a href="{url router=$smarty.const.ROUTE_PAGE page="management" op="settings" path="index"}">{translate key="navigation.settings"}</a>
								<ul>
									<li><a href="{$contextSettingsUrl}">{translate key="context.context"}</a></li>
									<li><a href="{url router=$smarty.const.ROUTE_PAGE page="management" op="settings" path="website"}">{translate key="manager.website"}</a></li>
									<li><a href="{url router=$smarty.const.ROUTE_PAGE page="management" op="settings" path="publication"}">{translate key="manager.workflow"}</a></li>
									<li><a href="{url router=$smarty.const.ROUTE_PAGE page="management" op="settings" path="distribution"}">{translate key="manager.distribution"}</a></li>
									<li><a href="{url router=$smarty.const.ROUTE_PAGE page="management" op="settings" path="access"}">{translate key="navigation.access"}</a></li>
								</ul>
							</li>
							<li class="has-submenu">
								<a href="{url router=$smarty.const.ROUTE_PAGE page="management" op="tools" path="index"}">{translate key="navigation.tools"}</a>
								<ul>
									<li><a href="{url router=$smarty.const.ROUTE_PAGE page="management" op="importexport"}">{translate key="navigation.tools.importExport"}</a></li>
									<li><a href="{url router=$smarty.const.ROUTE_PAGE page="manager" op="statistics"}">{translate key="navigation.tools.statistics"}</a></li>
								</ul>
							</li>
						{/if}
					</ul>
				{/if}

				{url|assign:fetchHeaderUrl router=$smarty.const.ROUTE_COMPONENT component="page.PageHandler" op="userNavBackend" escape=false}
				{load_url_in_div class="pkp_navigation_user" id="navigationUserWrapper" url=$fetchHeaderUrl}
			</nav><!-- pkp_navigation -->
		</header>

		<div class="pkp_structure_content">

			<script type="text/javascript">
				// Attach the JS page handler to the main content wrapper.
				$(function() {ldelim}
					$('div.pkp_structure_main').pkpHandler('$.pkp.controllers.PageHandler');
				{rdelim});
			</script>

			<div class="pkp_structure_main">
				{** allow pages to provide their own titles **}
				{if !$suppressPageTitle}
					<div class="pkp_page_title">
						<h2>{$pageTitleTranslated}</h2>
						{if $currentJournal}
							<h3>{$currentJournal->getLocalizedName()}</h3>
						{/if}
					</div>
				{/if}
