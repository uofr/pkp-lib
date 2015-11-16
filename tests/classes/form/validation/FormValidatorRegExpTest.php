<?php

/**
 * @file tests/metadata/FormValidatorRegExpTest.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class FormValidatorRegExpTest
 * @ingroup tests_classes_form_validation
 * @see FormValidatorRegExp
 *
 * @brief Test class for FormValidatorRegExp.
 */

import('lib.pkp.tests.PKPTestCase');
import('lib.pkp.classes.form.Form');

class FormValidatorRegExpTest extends PKPTestCase {
	/**
	 * @covers FormValidatorRegExp
	 * @covers FormValidator
	 */
	public function testIsValid() {
		$form = new Form('some template');
		$form->setData('testData', 'some data');

		$validator = new FormValidatorRegExp($form, 'testData', FORM_VALIDATOR_REQUIRED_VALUE, 'some.message.key', '/some.*/');
		self::assertTrue($validator->isValid());

		$validator = new FormValidatorRegExp($form, 'testData', FORM_VALIDATOR_REQUIRED_VALUE, 'some.message.key', '/some more.*/');
		self::assertFalse($validator->isValid());
	}
}
?>
