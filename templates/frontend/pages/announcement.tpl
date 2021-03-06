{**
 * templates/frontend/pages/announcements.tpl
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @brief Display the page which represents a single announcement
 *
 * @uses $announcement Announcement The announcement to display
 *}
{include file="common/frontend/header.tpl" pageTitleTranslated=$announcement->getLocalizedTitle()}

<div class="page page_announcement">

	{* Display book details *}
	{include file="frontend/objects/announcement_full.tpl"}

</div><!-- .page -->

{include file="common/frontend/footer.tpl"}
