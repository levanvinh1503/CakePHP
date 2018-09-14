<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TblStaffTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TblStaffTable Test Case
 */
class TblStaffTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TblStaffTable
     */
    public $TblStaff;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tbl_staff'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TblStaff') ? [] : ['className' => TblStaffTable::class];
        $this->TblStaff = TableRegistry::getTableLocator()->get('TblStaff', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TblStaff);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
