{**
 * controllers/grid/plugins/pluginGalleryGridFilter.tpl
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Filter template for plugin gallery grid.
 *}
<script>
	// Attach the form handler to the form.
	$('#pluginGallerySearchForm').pkpHandler('$.pkp.controllers.form.ClientFormHandler',
		{ldelim}
			trackFormChanges: false
		{rdelim}
	);
</script>
<form class="pkp_form filter" id="pluginGallerySearchForm" action="{url router=$smarty.const.ROUTE_COMPONENT op="fetchGrid"}" method="post">
	{fbvFormArea id="userSearchFormArea"}
		{fbvFormSection}
			{fbvElement type="select" id="category" from=$filterData.categories selected=$filterSelectionData.category translate=false size=$fbvStyles.size.SMALL inline=true}
			{fbvElement type="text" id="pluginText" value=$filterSelectionData.pluginText size=$fbvStyles.size.LARGE inline=true}
		{/fbvFormSection}
		{* Buttons generate their own section *}
		{fbvFormButtons hideCancel=true submitText="common.search"}
	{/fbvFormArea}
</form>
