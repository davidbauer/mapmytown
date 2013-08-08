<?php

namespace NZZ\MyTownBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'point' table.
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
class PointTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.NZZ.MyTownBundle.Model.map.PointTableMap';

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
        $this->setName('point');
        $this->setPhpName('Point');
        $this->setClassname('NZZ\\MyTownBundle\\Model\\Point');
        $this->setPackage('src.NZZ.MyTownBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', false, 255, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('latitude', 'Latitude', 'FLOAT', false, null, null);
        $this->addColumn('longitude', 'Longitude', 'FLOAT', false, null, null);
        $this->addColumn('author_name', 'AuthorName', 'VARCHAR', false, 255, null);
        $this->addColumn('author_location', 'AuthorLocation', 'VARCHAR', false, 255, null);
        $this->addColumn('sentiment', 'Sentiment', 'INTEGER', false, 1, 0);
        $this->addColumn('is_published', 'IsPublished', 'BOOLEAN', true, 1, false);
        $this->addColumn('type', 'Type', 'VARCHAR', false, 11, 'user');
        $this->addForeignKey('project_id', 'ProjectId', 'INTEGER', 'project', 'id', true, null, null);
        $this->addColumn('creation_date', 'CreationDate', 'TIMESTAMP', true, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Project', 'NZZ\\MyTownBundle\\Model\\Project', RelationMap::MANY_TO_ONE, array('project_id' => 'id', ), null, null);
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
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
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
