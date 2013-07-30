<?php

namespace NZZ\MyTownBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'points' table.
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
class PointsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.NZZ.MyTownBundle.Model.map.PointsTableMap';

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
        $this->setName('points');
        $this->setPhpName('Points');
        $this->setClassname('NZZ\\MyTownBundle\\Model\\Points');
        $this->setPackage('src.NZZ.MyTownBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('latitude', 'Latitude', 'FLOAT', false, null, null);
        $this->addColumn('longitude', 'Longitude', 'FLOAT', false, null, null);
        $this->addColumn('submitterName', 'Submittername', 'VARCHAR', false, 255, null);
        $this->addColumn('submitterLocation', 'Submitterlocation', 'VARCHAR', false, 255, null);
        $this->addForeignKey('projectId', 'Projectid', 'INTEGER', 'projects', 'id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Projects', 'NZZ\\MyTownBundle\\Model\\Projects', RelationMap::MANY_TO_ONE, array('projectId' => 'id', ), null, null);
    } // buildRelations()

} // PointsTableMap
