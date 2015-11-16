<?php

/**
 * @file tests/classes/metadata/DateStringNormalizerFilterTest.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CitationParserServiceTest
 * @ingroup tests_classes_metadata
 * @see DateStringNormalizerFilter
 *
 * @brief Tests for the DateStringNormalizerFilter class.
 */

import('lib.pkp.tests.PKPTestCase');
import('lib.pkp.classes.metadata.DateStringNormalizerFilter');

class DateStringNormalizerFilterTest extends PKPTestCase {
	/**
	 * @covers DateStringNormalizerFilter
	 */
	public function testExecute() {
		$filter = new DateStringNormalizerFilter();
		self::assertEquals('2003', $filter->execute($dateString = ' 2003 '));
		self::assertEquals('2003-07', $filter->execute($dateString = ' 2003  Jul '));
		self::assertEquals('2003-07-05', $filter->execute($dateString = ' 2003  Jul 5 '));
		self::assertEquals('2003', $filter->execute($dateString = ' 2003  5 '));
		self::assertNull($filter->execute($dateString = 'unparsable string'));
	}
}
?>
