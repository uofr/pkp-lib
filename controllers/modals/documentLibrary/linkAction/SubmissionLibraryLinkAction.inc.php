<?php

/**
 * @file controllers/grid/files/submissionDocuments/SubmissionLibraryLinkAction.inc.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SubmissionLibraryLinkAction
 * @ingroup controllers_grid_files_submissionDocuments
 *
 * @brief An action to open up the submission documents modal.
 */

import('lib.pkp.classes.linkAction.LinkAction');

class SubmissionLibraryLinkAction extends LinkAction {

	/**
	 * Constructor
	 * @param $request Request
	 * @param $submissionId int the ID of the submission to present link for
	 * to show information about.
	 */
	function SubmissionLibraryLinkAction($request, $submissionId) {
		$dispatcher = $request->getDispatcher();
		AppLocale::requireComponents(LOCALE_COMPONENT_PKP_EDITOR);
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		parent::LinkAction(
			'editorialHistory',
			new AjaxModal(
				$dispatcher->url(
					$request, ROUTE_COMPONENT, null,
					'modals.documentLibrary.DocumentLibraryHandler',
					'documentLibrary',
					null,
					array('submissionId' => $submissionId)
				),
				__('editor.submissionLibrary'),
				'modal_information'
			),
			__('editor.submissionLibrary'), 'more_info'
		);
	}
}

?>
