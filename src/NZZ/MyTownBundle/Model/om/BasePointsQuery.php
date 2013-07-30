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
use NZZ\MyTownBundle\Model\Points;
use NZZ\MyTownBundle\Model\PointsPeer;
use NZZ\MyTownBundle\Model\PointsQuery;
use NZZ\MyTownBundle\Model\Projects;

/**
 * @method PointsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method PointsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method PointsQuery orderByLatitude($order = Criteria::ASC) Order by the latitude column
 * @method PointsQuery orderByLongitude($order = Criteria::ASC) Order by the longitude column
 * @method PointsQuery orderBySubmittername($order = Criteria::ASC) Order by the submitterName column
 * @method PointsQuery orderBySubmitterlocation($order = Criteria::ASC) Order by the submitterLocation column
 * @method PointsQuery orderByProjectid($order = Criteria::ASC) Order by the projectId column
 *
 * @method PointsQuery groupById() Group by the id column
 * @method PointsQuery groupByDescription() Group by the description column
 * @method PointsQuery groupByLatitude() Group by the latitude column
 * @method PointsQuery groupByLongitude() Group by the longitude column
 * @method PointsQuery groupBySubmittername() Group by the submitterName column
 * @method PointsQuery groupBySubmitterlocation() Group by the submitterLocation column
 * @method PointsQuery groupByProjectid() Group by the projectId column
 *
 * @method PointsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PointsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PointsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PointsQuery leftJoinProjects($relationAlias = null) Adds a LEFT JOIN clause to the query using the Projects relation
 * @method PointsQuery rightJoinProjects($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Projects relation
 * @method PointsQuery innerJoinProjects($relationAlias = null) Adds a INNER JOIN clause to the query using the Projects relation
 *
 * @method Points findOne(PropelPDO $con = null) Return the first Points matching the query
 * @method Points findOneOrCreate(PropelPDO $con = null) Return the first Points matching the query, or a new Points object populated from the query conditions when no match is found
 *
 * @method Points findOneByDescription(string $description) Return the first Points filtered by the description column
 * @method Points findOneByLatitude(double $latitude) Return the first Points filtered by the latitude column
 * @method Points findOneByLongitude(double $longitude) Return the first Points filtered by the longitude column
 * @method Points findOneBySubmittername(string $submitterName) Return the first Points filtered by the submitterName column
 * @method Points findOneBySubmitterlocation(string $submitterLocation) Return the first Points filtered by the submitterLocation column
 * @method Points findOneByProjectid(int $projectId) Return the first Points filtered by the projectId column
 *
 * @method array findById(int $id) Return Points objects filtered by the id column
 * @method array findByDescription(string $description) Return Points objects filtered by the description column
 * @method array findByLatitude(double $latitude) Return Points objects filtered by the latitude column
 * @method array findByLongitude(double $longitude) Return Points objects filtered by the longitude column
 * @method array findBySubmittername(string $submitterName) Return Points objects filtered by the submitterName column
 * @method array findBySubmitterlocation(string $submitterLocation) Return Points objects filtered by the submitterLocation column
 * @method array findByProjectid(int $projectId) Return Points objects filtered by the projectId column
 */
abstract class BasePointsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasePointsQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'NZZ\\MyTownBundle\\Model\\Points', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PointsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   PointsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PointsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PointsQuery) {
            return $criteria;
        }
        $query = new PointsQuery();
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
     * @return   Points|Points[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PointsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PointsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Points A model object, or null if the key is not found
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
     * @return                 Points A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `description`, `latitude`, `longitude`, `submitterName`, `submitterLocation`, `projectId` FROM `points` WHERE `id` = :p0';
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
            $obj = new Points();
            $obj->hydrate($row);
            PointsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Points|Points[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Points[]|mixed the list of results, formatted by the current formatter
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
     * @return PointsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PointsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PointsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PointsPeer::ID, $keys, Criteria::IN);
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
     * @return PointsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PointsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PointsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointsPeer::ID, $id, $comparison);
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
     * @return PointsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PointsPeer::DESCRIPTION, $description, $comparison);
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
     * @return PointsQuery The current query, for fluid interface
     */
    public function filterByLatitude($latitude = null, $comparison = null)
    {
        if (is_array($latitude)) {
            $useMinMax = false;
            if (isset($latitude['min'])) {
                $this->addUsingAlias(PointsPeer::LATITUDE, $latitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($latitude['max'])) {
                $this->addUsingAlias(PointsPeer::LATITUDE, $latitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointsPeer::LATITUDE, $latitude, $comparison);
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
     * @return PointsQuery The current query, for fluid interface
     */
    public function filterByLongitude($longitude = null, $comparison = null)
    {
        if (is_array($longitude)) {
            $useMinMax = false;
            if (isset($longitude['min'])) {
                $this->addUsingAlias(PointsPeer::LONGITUDE, $longitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($longitude['max'])) {
                $this->addUsingAlias(PointsPeer::LONGITUDE, $longitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointsPeer::LONGITUDE, $longitude, $comparison);
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
     * @return PointsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PointsPeer::SUBMITTERNAME, $submittername, $comparison);
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
     * @return PointsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PointsPeer::SUBMITTERLOCATION, $submitterlocation, $comparison);
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
     * @see       filterByProjects()
     *
     * @param     mixed $projectid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PointsQuery The current query, for fluid interface
     */
    public function filterByProjectid($projectid = null, $comparison = null)
    {
        if (is_array($projectid)) {
            $useMinMax = false;
            if (isset($projectid['min'])) {
                $this->addUsingAlias(PointsPeer::PROJECTID, $projectid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectid['max'])) {
                $this->addUsingAlias(PointsPeer::PROJECTID, $projectid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointsPeer::PROJECTID, $projectid, $comparison);
    }

    /**
     * Filter the query by a related Projects object
     *
     * @param   Projects|PropelObjectCollection $projects The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PointsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjects($projects, $comparison = null)
    {
        if ($projects instanceof Projects) {
            return $this
                ->addUsingAlias(PointsPeer::PROJECTID, $projects->getId(), $comparison);
        } elseif ($projects instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PointsPeer::PROJECTID, $projects->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProjects() only accepts arguments of type Projects or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Projects relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PointsQuery The current query, for fluid interface
     */
    public function joinProjects($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Projects');

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
            $this->addJoinObject($join, 'Projects');
        }

        return $this;
    }

    /**
     * Use the Projects relation Projects object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \NZZ\MyTownBundle\Model\ProjectsQuery A secondary query class using the current class as primary query
     */
    public function useProjectsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjects($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Projects', '\NZZ\MyTownBundle\Model\ProjectsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Points $points Object to remove from the list of results
     *
     * @return PointsQuery The current query, for fluid interface
     */
    public function prune($points = null)
    {
        if ($points) {
            $this->addUsingAlias(PointsPeer::ID, $points->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
