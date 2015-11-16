<?php

/**
 * @file tests/classes/metadata/MetadataDescriptionDAOTest.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class MetadataDescriptionDAOTest
 * @ingroup tests_classes_metadata
 * @see MetadataDescriptionDAO
 *
 * @brief Test class for MetadataDescriptionDAO.
 */

import('lib.pkp.tests.DatabaseTestCase');
import('lib.pkp.classes.metadata.MetadataDescriptionDAO');
import('lib.pkp.classes.metadata.MetadataDescription');

class MetadataDescriptionDAOTest extends DatabaseTestCase {

	protected function getAffectedTables() {
		return array('metadata_descriptions', 'metadata_description_settings');
	}

	/**
	 * @see DatabaseTestCase::setUp()
	 */
	protected function setUp() {
		// Remove after fixing problem with database access.
		return;
	}

	/**
	 * @covers MetadataDescriptionDAO
	 *
	 * FIXME: The test data used here and in the CitationDAOTest
	 * are very similar. We should find a way to not duplicate this
	 * test data.
	 */
	public function testMetadataDescriptionCrud() {
		$this->markTestSkipped();
		$metadataDescriptionDao = DAORegistry::getDAO('MetadataDescriptionDAO');

		$nameDescription = new MetadataDescription('lib.pkp.plugins.metadata.nlm30.schema.Nlm30NameSchema', ASSOC_TYPE_AUTHOR);
		$nameDescription->addStatement('given-names', $value = 'Peter');
		$nameDescription->addStatement('given-names', $value = 'B');
		$nameDescription->addStatement('surname', $value = 'Bork');
		$nameDescription->addStatement('prefix', $value = 'Mr.');

		$testDescription = new MetadataDescription('lib.pkp.plugins.metadata.nlm30.schema.Nlm30CitationSchema', ASSOC_TYPE_CITATION);
		$testDescription->setAssocId(999999);
		$testDescription->setDisplayName('test meta-data description');
		$testDescription->setSeq(5);
		$testDescription->addStatement('person-group[@person-group-type="author"]', $nameDescription);
		$testDescription->addStatement('article-title', $value = 'PHPUnit in a nutshell', 'en_US');
		$testDescription->addStatement('article-title', $value = 'PHPUnit in Kürze', 'de_DE');
		$testDescription->addStatement('date', $value = '2009-08-17');
		$testDescription->addStatement('size', $value = 320);
		$testDescription->addStatement('uri', $value = 'http://phpunit.org/nutshell');

		// Create meta-data description
		$metadataDescriptionId = $metadataDescriptionDao->insertObject($testDescription);
		self::assertTrue(is_numeric($metadataDescriptionId));
		self::assertTrue($metadataDescriptionId > 0);

		// Retrieve meta-data description by id
		$metadataDescriptionById = $metadataDescriptionDao->getObjectById($metadataDescriptionId);
		$testDescription->removeSupportedMetadataAdapter('lib.pkp.plugins.metadata.nlm30.schema.Nlm30CitationSchema'); // Required for comparison
		$metadataDescriptionById->getMetadataSchema(); // Instantiates the internal metadata-schema.
		self::assertEquals($testDescription, $metadataDescriptionById);

		$metadataDescriptionsByAssocIdDaoFactory = $metadataDescriptionDao->getObjectsByAssocId(ASSOC_TYPE_CITATION, 999999);
		$metadataDescriptionsByAssocId = $metadataDescriptionsByAssocIdDaoFactory->toArray();
		self::assertEquals(1, count($metadataDescriptionsByAssocId));
		$metadataDescriptionsByAssocId[0]->getMetadataSchema(); // Instantiates the internal metadata-schema.
		self::assertEquals($testDescription, $metadataDescriptionsByAssocId[0]);

		// Update meta-data description
		$testDescription->removeStatement('date');
		$testDescription->addStatement('article-title', $value = 'PHPUnit rápido', 'pt_BR');

		$metadataDescriptionDao->updateObject($testDescription);
		$testDescription->removeSupportedMetadataAdapter('lib.pkp.plugins.metadata.nlm30.schema.Nlm30CitationSchema'); // Required for comparison
		$metadataDescriptionAfterUpdate = $metadataDescriptionDao->getObjectById($metadataDescriptionId);
		$metadataDescriptionAfterUpdate->getMetadataSchema(); // Instantiates the internal metadata-schema.
		self::assertEquals($testDescription, $metadataDescriptionAfterUpdate);

		// Delete meta-data description
		$metadataDescriptionDao->deleteObjectsByAssocId(ASSOC_TYPE_CITATION, 999999);
		self::assertNull($metadataDescriptionDao->getObjectById($metadataDescriptionId));
	}
}
?>
