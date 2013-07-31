<?php

namespace NZZ\MyTownBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'project_data' table.
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
class ProjectDataTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.NZZ.MyTownBundle.Model.map.ProjectDataTableMap';

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
        $this->setName('project_data');
        $this->setPhpName('ProjectData');
        $this->setClassname('NZZ\\MyTownBundle\\Model\\ProjectData');
        $this->setPackage('src.NZZ.MyTownBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('project_id', 'projectId', 'INTEGER', 'project', 'id', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 255, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('info', 'Info', 'LONGVARCHAR', false, null, null);
        $this->addColumn('centerLatitude', 'Centerlatitude', 'FLOAT', false, null, null);
        $this->addColumn('centerLongitude', 'Centerlongitude', 'FLOAT', false, null, null);
        $this->addColumn('defaultZoom', 'Defaultzoom', 'INTEGER', false, null, null);
        $this->addColumn('language', 'Language', 'VARCHAR', true, 2, null);
        $this->addColumn('buttonText', 'Buttontext', 'VARCHAR', true, 255, null);
        $this->addForeignKey('logo_id', 'logoId', 'INTEGER', 'logo', 'id', false, null, null);
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
