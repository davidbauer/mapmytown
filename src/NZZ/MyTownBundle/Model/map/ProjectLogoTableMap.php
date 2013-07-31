<?php

namespace NZZ\MyTownBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'project_logo' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.NZZ.MyTownBundle.Model.map
 */
class ProjectLogoTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.NZZ.MyTownBundle.Model.map.ProjectLogoTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('project_logo');
        $this->setPhpName('ProjectLogo');
        $this->setClassname('NZZ\\MyTownBundle\\Model\\ProjectLogo');
        $this->setPackage('src.NZZ.MyTownBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('project_id', 'projectId', 'INTEGER', 'project', 'id', true, null, null);
        $this->addForeignKey('logo_id', 'logoId', 'INTEGER', 'logo', 'id', true, null, null);
        $this->addColumn('position', 'Position', 'INTEGER', false, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Project', 'NZZ\\MyTownBundle\\Model\\Project', RelationMap::MANY_TO_ONE, array('project_id' => 'id', ), 'CASCADE', 'CASCADE');
        $this->addRelation('Logo', 'NZZ\\MyTownBundle\\Model\\Logo', RelationMap::MANY_TO_ONE, array('logo_id' => 'id', ), 'CASCADE', 'CASCADE');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'alternative_coding_standards' =>  array (
  'brackets_newline' => 'false',
  'remove_closing_comments' => 'true',
  'use_whitespace' => 'true',
  'tab_size' => '4',
  'strip_comments' => 'false',
),
        );
    } // getBehaviors()

}
