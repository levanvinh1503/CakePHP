<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\CountPostBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\CountPostBehavior Test Case
 */
class CountPostBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\CountPostBehavior
     */
    public $CountPost;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->CountPost = new CountPostBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CountPost);

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
