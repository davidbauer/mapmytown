<?php

namespace NZZ\MyTownBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'project' table.
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
class ProjectTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.NZZ.MyTownBundle.Model.map.ProjectTableMap';

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
        $this->setName('project');
        $this->setPhpName('Project');
        $this->setClassname('NZZ\\MyTownBundle\\Model\\Project');
        $this->setPackage('src.NZZ.MyTownBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('slug', 'Slug', 'VARCHAR', false, 10, null);
        $this->addColumn('defaultZoom', 'Defaultzoom', 'INTEGER', false, null, null);
        $this->addColumn('defaultLanguage', 'Defaultlanguage', 'VARCHAR', true, 2, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ProjectData', 'NZZ\\MyTownBundle\\Model\\ProjectData', RelationMap::ONE_TO_MANY, array('id' => 'project_id', ), 'CASCADE', 'CASCADE', 'ProjectDatas');
        $this->addRelation('ProjectLogo', 'NZZ\\MyTownBundle\\Model\\ProjectLogo', RelationMap::ONE_TO_MANY, array('id' => 'project_id', ), 'CASCADE', 'CASCADE', 'ProjectLogos');
        $this->addRelation('Point', 'NZZ\\MyTownBundle\\Model\\Point', RelationMap::ONE_TO_MANY, array('id' => 'project_id', ), null, null, 'Points');
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
