<?php

/**
 * @file tests/plugins/citationLookup/isbndb/filter/IsbndbNlm30CitationSchemaFilterTest.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class IsbndbNlm30CitationSchemaFilterTest
 * @ingroup tests_plugins_citationLookup_isbndb_filter
 *
 * @brief Basic configuration for Isbndb tests
 */


import('lib.pkp.tests.plugins.metadata.nlm30.filter.Nlm30CitationSchemaFilterTestCase');

class IsbndbNlm30CitationSchemaFilterTest extends Nlm30CitationSchemaFilterTestCase {
	/**
	 * Get the ISBNDB API key
	 */
	protected function _getIsbndbApiKey() {
		return getenv('ISBNDB_TEST_APIKEY');
	}
}
?>
