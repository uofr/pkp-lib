<?php

/**
 * @file tests/plugin/metadata/nlm30/filter/PKPSubmissionNlm30XmlFilterTest.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class PKPSubmissionNlm30XmlFilterTest
 * @ingroup tests_plugin_metadata_nlm30_filter
 * @see PKPSubmissionNlm30XmlFilter
 *
 * @brief Tests for the PKPSubmissionNlm30XmlFilterTest class.
 */

import('lib.pkp.tests.plugins.metadata.nlm30.filter.Nlm30XmlFilterTestCase');
import('lib.pkp.plugins.metadata.nlm30.filter.PKPSubmissionNlm30XmlFilter');

class PKPSubmissionNlm30XmlFilterTest extends Nlm30XmlFilterTestCase {
	/**
	 * @covers PKPSubmissionNlm30XmlFilter
	 */
	public function testExecute() {
		// Instantiate test meta-data for a citation.
		import('lib.pkp.classes.metadata.MetadataDescription');
		$nameSchemaName = 'lib.pkp.plugins.metadata.nlm30.schema.Nlm30NameSchema';
		$nameDescription = new MetadataDescription($nameSchemaName, ASSOC_TYPE_AUTHOR);
		$nameDescription->addStatement('given-names', $value = 'Peter');
		$nameDescription->addStatement('given-names', $value = 'B');
		$nameDescription->addStatement('surname', $value = 'Bork');
		$nameDescription->addStatement('prefix', $value = 'Mr.');

		$citationSchemaName = 'lib.pkp.plugins.metadata.nlm30.schema.Nlm30CitationSchema';
		$citationDescription = new MetadataDescription($citationSchemaName, ASSOC_TYPE_CITATION);
		$citationDescription->addStatement('person-group[@person-group-type="author"]', $nameDescription);
		$citationDescription->addStatement('article-title', $value = 'PHPUnit in a nutshell', 'en_US');
		$citationDescription->addStatement('date', $value = '2009-08-17');
		$citationDescription->addStatement('size', $value = 320);
		$citationDescription->addStatement('uri', $value = 'http://phpunit.org/nutshell');
		$citationDescription->addStatement('[@publication-type]', $value = 'book');

		$citation =& $this->getCitation($citationDescription);

		// Persist a few copies of the citation for testing.
		$citationDao =& $this->getCitationDao();
		for ($seq = 1; $seq <= 10; $seq++) {
			$citation->setSeq($seq);
			$citation->setCitationState(CITATION_APPROVED);
			$citationId = $citationDao->insertObject($citation);
			self::assertTrue(is_numeric($citationId));
			self::assertTrue($citationId > 0);
		}

		// Execute the filter and check the outcome.
		$mockSubmission =& $this->getTestSubmission();
		// FIXME: Add NLM 3.0 tag set schema validation as soon as we implement the full tag set, see #5648.
		$filter = new PKPSubmissionNlm30XmlFilter(PersistableFilter::tempGroup(
				'class::lib.pkp.classes.submission.Submission',
				'xml::*'));
		$nlm30Xml = $filter->execute($mockSubmission);

		self::assertXmlStringEqualsXmlFile('./lib/pkp/tests/plugins/metadata/nlm30/filter/sample-nlm30-citation.xml', $nlm30Xml);
	}
}
?>
