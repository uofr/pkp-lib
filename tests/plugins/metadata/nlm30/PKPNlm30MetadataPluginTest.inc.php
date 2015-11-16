<?php

/**
 * @defgroup tests_plugins_metadata_nlm30
 */

/**
 * @file tests/plugins/metadata/nlm30/PKPNlm30MetadataPluginTest.inc.php
 *
 * Copyright (c) 2013-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class PKPNlm30MetadataPluginTest
 * @ingroup tests_plugins_metadata_nlm30
 * @see PKPNlm30MetadataPlugin
 *
 * @brief Test class for PKPNlm30MetadataPlugin.
 */


import('lib.pkp.tests.plugins.metadata.MetadataPluginTestCase');

class PKPNlm30MetadataPluginTest extends MetadataPluginTestCase {
	/**
	 * @covers Nlm30MetadataPlugin
	 * @covers PKPNlm30MetadataPlugin
	 */
	public function testNlm30MetadataPlugin() {
		$this->executeMetadataPluginTest(
			'nlm30',
			'Nlm30MetadataPlugin',
			array('citation=>nlm30', 'nlm30=>citation', 'plaintext=>nlm30-element-citation',
					'nlm30-element-citation=>nlm30-element-citation', 'nlm30-element-citation=>plaintext',
					'nlm30-element-citation=>nlm30-xml', 'submission=>nlm23-article-xml', 'submission=>nlm30-article-xml',
					'nlm30-article-xml=>nlm23-article-xml', 'submission=>reference-list'),
			array('nlm30-publication-types')
		);
	}
}
?>
