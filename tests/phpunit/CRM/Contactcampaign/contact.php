<?php

require_once 'CiviTest/CiviUnitTestCase.php';

/**
 * FIXME
 */
class CRM_Contactcampaign_MyTest extends CiviUnitTestCase {
  function setUp() {
 
    parent::setUp();
  }

  function tearDown() {
    parent::tearDown();
  }

  /**
   * Test that 1^2 == 1
   */
  function testSquareOfOne() {
    $this->assertEquals(1, 1*1);
  }

  /**
   * Test that 8^2 == 64
   */
  function testSquareOfEight() {
    $this->assertEquals(64, 8*8);
  }
}