<?php

namespace NZZ\MyTownBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use NZZ\MyTownBundle\Model\Point;
use NZZ\MyTownBundle\Model\PointPeer;
use NZZ\MyTownBundle\Model\PointQuery;
use NZZ\MyTownBundle\Model\Project;

/**
 * @method PointQuery orderById($order = Criteria::ASC) Order by the id column
 * @method PointQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method PointQuery orderByLatitude($order = Criteria::ASC) Order by the latitude column
 * @method PointQuery orderByLongitude($order = Criteria::ASC) Order by the longitude column
 * @method PointQuery orderBySubmittername($order = Criteria::ASC) Order by the submitterName column
 * @method PointQuery orderBySubmitterlocation($order = Criteria::ASC) Order by the submitterLocation column
 * @method PointQuery orderByProjectid($order = Criteria::ASC) Order by the projectId column
 *
 * @method PointQuery groupById() Group by the id column
 * @method PointQuery groupByDescription() Group by the description column
 * @method PointQuery groupByLatitude() Group by the latitude column
 * @method PointQuery groupByLongitude() Group by the longitude column
 * @method PointQuery groupBySubmittername() Group by the submitterName column
 * @method PointQuery groupBySubmitterlocation() Group by the submitterLocation column
 * @method PointQuery groupByProjectid() Group by the projectId column
 *
 * @method PointQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PointQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PointQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PointQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method PointQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method PointQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method Point findOne(PropelPDO $con = null) Return the first Point matching the query
 * @method Point findOneOrCreate(PropelPDO $con = null) Return the first Point matching the query, or a new Point object populated from the query conditions when no match is found
 *
 * @method Point findOneByDescription(string $description) Return the first Point filtered by the description column
 * @method Point findOneByLatitude(double $latitude) Return the first Point filtered by the latitude column
 * @method Point findOneByLongitude(double $longitude) Return the first Point filtered by the longitude column
 * @method Point findOneBySubmittername(string $submitterName) Return the first Point filtered by the submitterName column
 * @method Point findOneBySubmitterlocation(string $submitterLocation) Return the first Point filtered by the submitterLocation column
 * @method Point findOneByProjectid(int $projectId) Return the first Point filtered by the projectId column
 *
 * @method array findById(int $id) Return Point objects filtered by the id column
 * @method array findByDescription(string $description) Return Point objects filtered by the description column
 * @method array findByLatitude(double $latitude) Return Point objects filtered by the latitude column
 * @method array findByLongitude(double $longitude) Return Point objects filtered by the longitude column
 * @method array findBySubmittername(string $submitterName) Return Point objects filtered by the submitterName column
 * @method array findBySubmitterlocation(string $submitterLocation) Return Point objects filtered by the submitterLocation column
 * @method array findByProjectid(int $projectId) Return Point objects filtered by the projectId column
 */
abstract class BasePointQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasePointQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'NZZ\\MyTownBundle\\Model\\Point', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PointQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   PointQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PointQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PointQuery) {
            return $criteria;
        }
        $query = new PointQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Point|Point[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PointPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PointPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Point A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Point A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `description`, `latitude`, `longitude`, `submitterName`, `submitterLocation`, `projectId` FROM `point` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Point();
            $obj->hydrate($row);
            PointPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Point|Point[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Point[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PointPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PointPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PointPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PointPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PointPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the latitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLatitude(1234); // WHERE latitude = 1234
     * $query->filterByLatitude(array(12, 34)); // WHERE latitude IN (12, 34)
     * $query->filterByLatitude(array('min' => 12)); // WHERE latitude >= 12
     * $query->filterByLatitude(array('max' => 12)); // WHERE latitude <= 12
     * </code>
     *
     * @param     mixed $latitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function filterByLatitude($latitude = null, $comparison = null)
    {
        if (is_array($latitude)) {
            $useMinMax = false;
            if (isset($latitude['min'])) {
                $this->addUsingAlias(PointPeer::LATITUDE, $latitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($latitude['max'])) {
                $this->addUsingAlias(PointPeer::LATITUDE, $latitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointPeer::LATITUDE, $latitude, $comparison);
    }

    /**
     * Filter the query on the longitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLongitude(1234); // WHERE longitude = 1234
     * $query->filterByLongitude(array(12, 34)); // WHERE longitude IN (12, 34)
     * $query->filterByLongitude(array('min' => 12)); // WHERE longitude >= 12
     * $query->filterByLongitude(array('max' => 12)); // WHERE longitude <= 12
     * </code>
     *
     * @param     mixed $longitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function filterByLongitude($longitude = null, $comparison = null)
    {
        if (is_array($longitude)) {
            $useMinMax = false;
            if (isset($longitude['min'])) {
                $this->addUsingAlias(PointPeer::LONGITUDE, $longitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($longitude['max'])) {
                $this->addUsingAlias(PointPeer::LONGITUDE, $longitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointPeer::LONGITUDE, $longitude, $comparison);
    }

    /**
     * Filter the query on the submitterName column
     *
     * Example usage:
     * <code>
     * $query->filterBySubmittername('fooValue');   // WHERE submitterName = 'fooValue'
     * $query->filterBySubmittername('%fooValue%'); // WHERE submitterName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $submittername The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function filterBySubmittername($submittername = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($submittername)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $submittername)) {
                $submittername = str_replace('*', '%', $submittername);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PointPeer::SUBMITTERNAME, $submittername, $comparison);
    }

    /**
     * Filter the query on the submitterLocation column
     *
     * Example usage:
     * <code>
     * $query->filterBySubmitterlocation('fooValue');   // WHERE submitterLocation = 'fooValue'
     * $query->filterBySubmitterlocation('%fooValue%'); // WHERE submitterLocation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $submitterlocation The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function filterBySubmitterlocation($submitterlocation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($submitterlocation)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $submitterlocation)) {
                $submitterlocation = str_replace('*', '%', $submitterlocation);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PointPeer::SUBMITTERLOCATION, $submitterlocation, $comparison);
    }

    /**
     * Filter the query on the projectId column
     *
     * Example usage:
     * <code>
     * $query->filterByProjectid(1234); // WHERE projectId = 1234
     * $query->filterByProjectid(array(12, 34)); // WHERE projectId IN (12, 34)
     * $query->filterByProjectid(array('min' => 12)); // WHERE projectId >= 12
     * $query->filterByProjectid(array('max' => 12)); // WHERE projectId <= 12
     * </code>
     *
     * @see       filterByProject()
     *
     * @param     mixed $projectid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function filterByProjectid($projectid = null, $comparison = null)
    {
        if (is_array($projectid)) {
            $useMinMax = false;
            if (isset($projectid['min'])) {
                $this->addUsingAlias(PointPeer::PROJECTID, $projectid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectid['max'])) {
                $this->addUsingAlias(PointPeer::PROJECTID, $projectid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointPeer::PROJECTID, $projectid, $comparison);
    }

    /**
     * Filter the query by a related Project object
     *
     * @param   Project|PropelObjectCollection $project The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PointQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(PointPeer::PROJECTID, $project->getId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PointPeer::PROJECTID, $project->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProject() only accepts arguments of type Project or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Project relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function joinProject($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Project');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Project');
        }

        return $this;
    }

    /**
     * Use the Project relation Project object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \NZZ\MyTownBundle\Model\ProjectQuery A secondary query class using the current class as primary query
     */
    public function useProjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Project', '\NZZ\MyTownBundle\Model\ProjectQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Point $point Object to remove from the list of results
     *
     * @return PointQuery The current query, for fluid interface
     */
    public function prune($point = null)
    {
        if ($point) {
            $this->addUsingAlias(PointPeer::ID, $point->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
