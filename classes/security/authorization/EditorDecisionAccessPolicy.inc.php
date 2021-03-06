<?php
/**
 * @file classes/security/authorization/EditorDecisionAccessPolicy.inc.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class EditorDecisionAccessPolicy
 * @ingroup security_authorization
 *
 * @brief Class to control access to submission workflow stage components
 */

import('lib.pkp.classes.security.authorization.internal.ContextPolicy');

class EditorDecisionAccessPolicy extends ContextPolicy {
	/**
	 * Constructor
	 * @param $request PKPRequest
	 * @param $args array request arguments
	 * @param $roleAssignments array
	 * @param $submissionParameterName string
	 * @param $stageId integer One of the WORKFLOW_STAGE_ID_* constants.
	 */
	function EditorDecisionAccessPolicy($request, &$args, $roleAssignments, $submissionParameterName, $stageId) {
		parent::ContextPolicy($request);

		// A decision can only be made if there is a valid workflow stage
		import('lib.pkp.classes.security.authorization.WorkflowStageAccessPolicy');
		$this->addPolicy(new WorkflowStageAccessPolicy($request, $args, $roleAssignments, $submissionParameterName, $stageId));

		// An editor decision can only be made if there is an editor assigned to the stage
		import('lib.pkp.classes.security.authorization.internal.ManagerRequiredPolicy');
		$this->addPolicy(new ManagerRequiredPolicy($request));
	}
}

?>
