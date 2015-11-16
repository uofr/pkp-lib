<?php

/**
 * @defgroup tests_plugins_citationLookup_crossref_filter
 */

/**
 * @file tests/plugins/citationLookup/crossref/filter/CrossrefNlm30CitationSchemaFilterTest.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CrossrefNlm30CitationSchemaFilterTest
 * @ingroup tests_plugins_citationLookup_crossref_filter
 * @see CrossrefNlm30CitationSchemaFilter
 *
 * @brief Tests for the CrossrefNlm30CitationSchemaFilter class.
 */


import('lib.pkp.plugins.citationLookup.crossref.filter.CrossrefNlm30CitationSchemaFilter');
import('lib.pkp.tests.plugins.metadata.nlm30.filter.Nlm30CitationSchemaFilterTestCase');

class CrossrefNlm30CitationSchemaFilterTest extends Nlm30CitationSchemaFilterTestCase {
	const
		ACCESS_EMAIL = 'pkp.contact@gmail.com';

	/**
	 * Test CrossRef lookup with DOI
	 * @covers CrossrefNlm30CitationSchemaFilter
	 */
	public function testExecuteWithDoi() {
		// Test article DOI lookup
		$articleTest = array(
			'testInput' => array(
				'pub-id[@pub-id-type="doi"]' => '10.1186/1471-2105-5-147'
			),
			'testOutput' => array (
				'source' => 'BMC Bioinformatics',
				'issue' => '1',
				'volume' => '5',
				'date' => '2004',
				'fpage' => 147,
				'uri' => 'http://www.biomedcentral.com/1471-2105/5/147',
				'person-group[@person-group-type="author"]' => array (
					array ('given-names' => array('Hao'), 'surname' => 'Chen'),
					array ('given-names' => array('Burt', 'M'), 'surname' => 'Sharp')
				),
				'pub-id[@pub-id-type="doi"]' => '10.1186/1471-2105-5-147',
				'issn[@pub-type="ppub"]' => '14712105',
				'[@publication-type]' => 'journal'
			)
		);

		// Conference Proceeding
		$conferenceTest = array (
			'testInput' => array(
				'pub-id[@pub-id-type="doi"]' => '10.1145/311625.311726'
			),
			'testOutput' => array(
				'conf-name' => 'ACM SIGGRAPH 99 Conference abstracts and applications on   - SIGGRAPH \'99',
				'isbn' => '1581131038',
				'publisher-name' => 'ACM Press',
				'publisher-loc' => 'New York, New York, USA',
				'article-title' => 'The SIGGRAFFITI wall',
				'date' => '1999',
				'fpage' => 94,
				'uri' => 'http://portal.acm.org/citation.cfm?doid=311625.311726',
				'person-group[@person-group-type="author"]' => array (
					array ('given-names' => array('Richard'), 'surname' => 'Dunn-Roberts')
				),
				'pub-id[@pub-id-type="doi"]' => '10.1145/311625.311726',
				'[@publication-type]' => 'conf-proc'
			)
		);

		// Book
		$bookTest = array (
			'testInput' => array(
				'pub-id[@pub-id-type="doi"]' => '10.1093/ref:odnb/31418'
			),
			'testOutput' => array(
				'source' => 'The Oxford Dictionary of National Biography',
				'date' => '2004-09-23',
				'publisher-name' => 'Oxford University Press',
				'publisher-loc' => 'Oxford',
				'person-group[@person-group-type="author"]' =>
				array (
					array ('given-names' => array('H', 'C', 'G'), 'surname' => 'Matthew'),
					array ('given-names' => array('B'), 'surname' => 'Harrison')
				),
				'[@publication-type]' => 'book'
			)
		);

		// Build the test citations array
		$citationFilterTests = array(
			$articleTest,
			$conferenceTest,
			$bookTest
		);

		// Execute the tests
		$filter = new CrossrefNlm30CitationSchemaFilter(PersistableFilter::tempGroup(
				'metadata::lib.pkp.plugins.metadata.nlm30.schema.Nlm30CitationSchema(CITATION)',
				'metadata::lib.pkp.plugins.metadata.nlm30.schema.Nlm30CitationSchema(CITATION)'));
		$filter->setEmail(self::ACCESS_EMAIL);
		$this->assertNlm30CitationSchemaFilter($citationFilterTests, $filter);
	}

	/**
	 * Test CrossRef lookup without DOI
	 * @covers CrossrefNlm30CitationSchemaFilter
	 */
	public function testExecuteWithOpenurl10Search() {
		// Build the test citations array
		$citationFilterTests = array(
			array(
				'testInput' => array(
					'person-group[@person-group-type="author"]' => array (
						array ('given-names' => array('Hao'), 'surname' => 'Chen'),
					),
					'source' => 'BMC Bioinformatics',
					'issue' => '1',
					'volume' => '5',
					'fpage' => 147,
					'[@publication-type]' => 'journal'
				),
				'testOutput' => array (
					'source' => 'BMC Bioinformatics',
					'issue' => '1',
					'volume' => '5',
					'date' => '2004',
					'fpage' => 147,
					'uri' => 'http://www.biomedcentral.com/1471-2105/5/147',
					'issn[@pub-type="ppub"]' => '14712105',
					'person-group[@person-group-type="author"]' => array (
						array ('given-names' => array('Hao'), 'surname' => 'Chen'),
						array ('given-names' => array('Burt', 'M'), 'surname' => 'Sharp')
					),
					'pub-id[@pub-id-type="doi"]' => '10.1186/1471-2105-5-147',
					'[@publication-type]' => 'journal'
				)
			)
		);

		// Execute the test
		$filter = new CrossrefNlm30CitationSchemaFilter(PersistableFilter::tempGroup(
				'metadata::lib.pkp.plugins.metadata.nlm30.schema.Nlm30CitationSchema(CITATION)',
				'metadata::lib.pkp.plugins.metadata.nlm30.schema.Nlm30CitationSchema(CITATION)'));
		$filter->setEmail(self::ACCESS_EMAIL);
		$this->assertNlm30CitationSchemaFilter($citationFilterTests, $filter);
	}
}
?>
