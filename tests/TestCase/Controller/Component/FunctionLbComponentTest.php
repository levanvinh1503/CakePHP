<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\FunctionLbComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\FunctionLbComponent Test Case
 */
class FunctionLbComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\FunctionLbComponent
     */
    public $FunctionLb;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->FunctionLb = new FunctionLbComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FunctionLb);

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
