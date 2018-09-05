<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\HeaderHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\HeaderHelper Test Case
 */
class HeaderHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\HeaderHelper
     */
    public $Header;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Header = new HeaderHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Header);

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
