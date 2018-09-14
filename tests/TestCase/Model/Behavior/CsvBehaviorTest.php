<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\CsvBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\CsvBehavior Test Case
 */
class CsvBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\CsvBehavior
     */
    public $Csv;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Csv = new CsvBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Csv);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
