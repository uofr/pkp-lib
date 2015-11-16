<?php

/**
 * @defgroup tests_plugins_citationLookup_isbndb_filter
 */

/**
 * @file tests/plugins/citationLookup/isbndb/filter/IsbndbIsbnNlm30CitationSchemaFilterTest.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class IsbndbIsbnNlm30CitationSchemaFilterTest
 * @ingroup tests_plugins_citationLookup_isbndb_filter
 *
 * @brief Tests for IsbndbNlm30CitationSchemaIsbnFilter
 */


require_mock_env('env2');

import('lib.pkp.plugins.citationLookup.isbndb.filter.IsbndbIsbnNlm30CitationSchemaFilter');
import('lib.pkp.tests.plugins.citationLookup.isbndb.filter.IsbndbNlm30CitationSchemaFilterTest');

class IsbndbIsbnNlm30CitationSchemaFilterTest extends IsbndbNlm30CitationSchemaFilterTest {

	/**
	 * @covers IsbndbIsbnNlm30CitationSchemaFilter
	 * @covers IsbndbNlm30CitationSchemaFilter
	 */
	public function testExecute() {
		// Test data
		$isbnLookupTest = array(
			'testInput' => '9780820452425', // ISBN
			'testOutput' => array(
				'source' => array(
					'en_US' => 'After literacy: essays'
				),
				'date' => '2001',
				'person-group[@person-group-type="author"]' => array(
					0 => array('given-names' => array('John'), 'surname' => 'Willinsky')
				),
				'publisher-loc' => 'New York',
				'publisher-name' => 'P. Lang',
				'isbn' => '9780820452425',
				'[@publication-type]' => 'book'
			)
		);

		// Build the test array
		$citationFilterTests = array(
			$isbnLookupTest
		);

		// Test the filter
		$filter = new IsbndbIsbnNlm30CitationSchemaFilter(PersistableFilter::tempGroup(
				'primitive::string',
				'metadata::lib.pkp.plugins.metadata.nlm30.schema.Nlm30CitationSchema(CITATION)'));

		$apiKey = $this->_getIsbndbApiKey();
		if (!$apiKey) $this->markTestSkipped('ISBNDB API key not available.');

		$filter->setData('apiKey', $apiKey);
		$this->assertNlm30CitationSchemaFilter($citationFilterTests, $filter);
	}
}
?>
