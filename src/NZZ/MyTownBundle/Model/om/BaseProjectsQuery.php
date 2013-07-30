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
use NZZ\MyTownBundle\Model\Projects;
use NZZ\MyTownBundle\Model\ProjectsPeer;
use NZZ\MyTownBundle\Model\ProjectsQuery;

/**
 * @method ProjectsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProjectsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method ProjectsQuery orderByShortname($order = Criteria::ASC) Order by the shortname column
 * @method ProjectsQuery orderByCenterlatitude($order = Criteria::ASC) Order by the centerLatitude column
 * @method ProjectsQuery orderByCenterlongitude($order = Criteria::ASC) Order by the centerLongitude column
 * @method ProjectsQuery orderByDefaultzoom($order = Criteria::ASC) Order by the defaultZoom column
 * @method ProjectsQuery orderByLanguage($order = Criteria::ASC) Order by the language column
 *
 * @method ProjectsQuery groupById() Group by the id column
 * @method ProjectsQuery groupByName() Group by the name column
 * @method ProjectsQuery groupByShortname() Group by the shortname column
 * @method ProjectsQuery groupByCenterlatitude() Group by the centerLatitude column
 * @method ProjectsQuery groupByCenterlongitude() Group by the centerLongitude column
 * @method ProjectsQuery groupByDefaultzoom() Group by the defaultZoom column
 * @method ProjectsQuery groupByLanguage() Group by the language column
 *
 * @method ProjectsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectsQuery leftJoinPoints($relationAlias = null) Adds a LEFT JOIN clause to the query using the Points relation
 * @method ProjectsQuery rightJoinPoints($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Points relation
 * @method ProjectsQuery innerJoinPoints($relationAlias = null) Adds a INNER JOIN clause to the query using the Points relation
 *
 * @method Projects findOne(PropelPDO $con = null) Return the first Projects matching the query
 * @method Projects findOneOrCreate(PropelPDO $con = null) Return the first Projects matching the query, or a new Projects object populated from the query conditions when no match is found
 *
 * @method Projects findOneByName(string $name) Return the first Projects filtered by the name column
 * @method Projects findOneByShortname(string $shortname) Return the first Projects filtered by the shortname column
 * @method Projects findOneByCenterlatitude(double $centerLatitude) Return the first Projects filtered by the centerLatitude column
 * @method Projects findOneByCenterlongitude(double $centerLongitude) Return the first Projects filtered by the centerLongitude column
 * @method Projects findOneByDefaultzoom(int $defaultZoom) Return the first Projects filtered by the defaultZoom column
 * @method Projects findOneByLanguage(string $language) Return the first Projects filtered by the language column
 *
 * @method array findById(int $id) Return Projects objects filtered by the id column
 * @method array findByName(string $name) Return Projects objects filtered by the name column
 * @method array findByShortname(string $shortname) Return Projects objects filtered by the shortname column
 * @method array findByCenterlatitude(double $centerLatitude) Return Projects objects filtered by the centerLatitude column
 * @method array findByCenterlongitude(double $centerLongitude) Return Projects objects filtered by the centerLongitude column
 * @method array findByDefaultzoom(int $defaultZoom) Return Projects objects filtered by the defaultZoom column
 * @method array findByLanguage(string $language) Return Projects objects filtered by the language column
 */
abstract class BaseProjectsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectsQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'NZZ\\MyTownBundle\\Model\\Projects', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProjectsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectsQuery) {
            return $criteria;
        }
        $query = new ProjectsQuery();
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
     * @return   Projects|Projects[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Projects A model object, or null if the key is not found
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
     * @return                 Projects A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `name`, `shortname`, `centerLatitude`, `centerLongitude`, `defaultZoom`, `language` FROM `projects` WHERE `id` = :p0';
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
            $obj = new Projects();
            $obj->hydrate($row);
            ProjectsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Projects|Projects[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Projects[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectsPeer::ID, $keys, Criteria::IN);
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
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProjectsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProjectsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the shortname column
     *
     * Example usage:
     * <code>
     * $query->filterByShortname('fooValue');   // WHERE shortname = 'fooValue'
     * $query->filterByShortname('%fooValue%'); // WHERE shortname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shortname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByShortname($shortname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shortname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shortname)) {
                $shortname = str_replace('*', '%', $shortname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::SHORTNAME, $shortname, $comparison);
    }

    /**
     * Filter the query on the centerLatitude column
     *
     * Example usage:
     * <code>
     * $query->filterByCenterlatitude(1234); // WHERE centerLatitude = 1234
     * $query->filterByCenterlatitude(array(12, 34)); // WHERE centerLatitude IN (12, 34)
     * $query->filterByCenterlatitude(array('min' => 12)); // WHERE centerLatitude >= 12
     * $query->filterByCenterlatitude(array('max' => 12)); // WHERE centerLatitude <= 12
     * </code>
     *
     * @param     mixed $centerlatitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByCenterlatitude($centerlatitude = null, $comparison = null)
    {
        if (is_array($centerlatitude)) {
            $useMinMax = false;
            if (isset($centerlatitude['min'])) {
                $this->addUsingAlias(ProjectsPeer::CENTERLATITUDE, $centerlatitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($centerlatitude['max'])) {
                $this->addUsingAlias(ProjectsPeer::CENTERLATITUDE, $centerlatitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::CENTERLATITUDE, $centerlatitude, $comparison);
    }

    /**
     * Filter the query on the centerLongitude column
     *
     * Example usage:
     * <code>
     * $query->filterByCenterlongitude(1234); // WHERE centerLongitude = 1234
     * $query->filterByCenterlongitude(array(12, 34)); // WHERE centerLongitude IN (12, 34)
     * $query->filterByCenterlongitude(array('min' => 12)); // WHERE centerLongitude >= 12
     * $query->filterByCenterlongitude(array('max' => 12)); // WHERE centerLongitude <= 12
     * </code>
     *
     * @param     mixed $centerlongitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByCenterlongitude($centerlongitude = null, $comparison = null)
    {
        if (is_array($centerlongitude)) {
            $useMinMax = false;
            if (isset($centerlongitude['min'])) {
                $this->addUsingAlias(ProjectsPeer::CENTERLONGITUDE, $centerlongitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($centerlongitude['max'])) {
                $this->addUsingAlias(ProjectsPeer::CENTERLONGITUDE, $centerlongitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::CENTERLONGITUDE, $centerlongitude, $comparison);
    }

    /**
     * Filter the query on the defaultZoom column
     *
     * Example usage:
     * <code>
     * $query->filterByDefaultzoom(1234); // WHERE defaultZoom = 1234
     * $query->filterByDefaultzoom(array(12, 34)); // WHERE defaultZoom IN (12, 34)
     * $query->filterByDefaultzoom(array('min' => 12)); // WHERE defaultZoom >= 12
     * $query->filterByDefaultzoom(array('max' => 12)); // WHERE defaultZoom <= 12
     * </code>
     *
     * @param     mixed $defaultzoom The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByDefaultzoom($defaultzoom = null, $comparison = null)
    {
        if (is_array($defaultzoom)) {
            $useMinMax = false;
            if (isset($defaultzoom['min'])) {
                $this->addUsingAlias(ProjectsPeer::DEFAULTZOOM, $defaultzoom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($defaultzoom['max'])) {
                $this->addUsingAlias(ProjectsPeer::DEFAULTZOOM, $defaultzoom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::DEFAULTZOOM, $defaultzoom, $comparison);
    }

    /**
     * Filter the query on the language column
     *
     * Example usage:
     * <code>
     * $query->filterByLanguage('fooValue');   // WHERE language = 'fooValue'
     * $query->filterByLanguage('%fooValue%'); // WHERE language LIKE '%fooValue%'
     * </code>
     *
     * @param     string $language The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function filterByLanguage($language = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($language)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $language)) {
                $language = str_replace('*', '%', $language);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectsPeer::LANGUAGE, $language, $comparison);
    }

    /**
     * Filter the query by a related Points object
     *
     * @param   Points|PropelObjectCollection $points  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPoints($points, $comparison = null)
    {
        if ($points instanceof Points) {
            return $this
                ->addUsingAlias(ProjectsPeer::ID, $points->getProjectid(), $comparison);
        } elseif ($points instanceof PropelObjectCollection) {
            return $this
                ->usePointsQuery()
                ->filterByPrimaryKeys($points->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPoints() only accepts arguments of type Points or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Points relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function joinPoints($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Points');

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
            $this->addJoinObject($join, 'Points');
        }

        return $this;
    }

    /**
     * Use the Points relation Points object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \NZZ\MyTownBundle\Model\PointsQuery A secondary query class using the current class as primary query
     */
    public function usePointsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPoints($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Points', '\NZZ\MyTownBundle\Model\PointsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Projects $projects Object to remove from the list of results
     *
     * @return ProjectsQuery The current query, for fluid interface
     */
    public function prune($projects = null)
    {
        if ($projects) {
            $this->addUsingAlias(ProjectsPeer::ID, $projects->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
