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
use NZZ\MyTownBundle\Model\Project;
use NZZ\MyTownBundle\Model\ProjectLogo;
use NZZ\MyTownBundle\Model\ProjectPeer;
use NZZ\MyTownBundle\Model\ProjectQuery;

/**
 * @method ProjectQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProjectQuery orderByShortname($order = Criteria::ASC) Order by the shortname column
 * @method ProjectQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method ProjectQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method ProjectQuery orderByCenterlatitude($order = Criteria::ASC) Order by the centerLatitude column
 * @method ProjectQuery orderByCenterlongitude($order = Criteria::ASC) Order by the centerLongitude column
 * @method ProjectQuery orderByDefaultzoom($order = Criteria::ASC) Order by the defaultZoom column
 * @method ProjectQuery orderByLanguage($order = Criteria::ASC) Order by the language column
 *
 * @method ProjectQuery groupById() Group by the id column
 * @method ProjectQuery groupByShortname() Group by the shortname column
 * @method ProjectQuery groupByTitle() Group by the title column
 * @method ProjectQuery groupByDescription() Group by the description column
 * @method ProjectQuery groupByCenterlatitude() Group by the centerLatitude column
 * @method ProjectQuery groupByCenterlongitude() Group by the centerLongitude column
 * @method ProjectQuery groupByDefaultzoom() Group by the defaultZoom column
 * @method ProjectQuery groupByLanguage() Group by the language column
 *
 * @method ProjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectQuery leftJoinProjectLogo($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectLogo relation
 * @method ProjectQuery rightJoinProjectLogo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectLogo relation
 * @method ProjectQuery innerJoinProjectLogo($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectLogo relation
 *
 * @method ProjectQuery leftJoinPoint($relationAlias = null) Adds a LEFT JOIN clause to the query using the Point relation
 * @method ProjectQuery rightJoinPoint($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Point relation
 * @method ProjectQuery innerJoinPoint($relationAlias = null) Adds a INNER JOIN clause to the query using the Point relation
 *
 * @method Project findOne(PropelPDO $con = null) Return the first Project matching the query
 * @method Project findOneOrCreate(PropelPDO $con = null) Return the first Project matching the query, or a new Project object populated from the query conditions when no match is found
 *
 * @method Project findOneByShortname(string $shortname) Return the first Project filtered by the shortname column
 * @method Project findOneByTitle(string $title) Return the first Project filtered by the title column
 * @method Project findOneByDescription(string $description) Return the first Project filtered by the description column
 * @method Project findOneByCenterlatitude(double $centerLatitude) Return the first Project filtered by the centerLatitude column
 * @method Project findOneByCenterlongitude(double $centerLongitude) Return the first Project filtered by the centerLongitude column
 * @method Project findOneByDefaultzoom(int $defaultZoom) Return the first Project filtered by the defaultZoom column
 * @method Project findOneByLanguage(string $language) Return the first Project filtered by the language column
 *
 * @method array findById(int $id) Return Project objects filtered by the id column
 * @method array findByShortname(string $shortname) Return Project objects filtered by the shortname column
 * @method array findByTitle(string $title) Return Project objects filtered by the title column
 * @method array findByDescription(string $description) Return Project objects filtered by the description column
 * @method array findByCenterlatitude(double $centerLatitude) Return Project objects filtered by the centerLatitude column
 * @method array findByCenterlongitude(double $centerLongitude) Return Project objects filtered by the centerLongitude column
 * @method array findByDefaultzoom(int $defaultZoom) Return Project objects filtered by the defaultZoom column
 * @method array findByLanguage(string $language) Return Project objects filtered by the language column
 */
abstract class BaseProjectQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'NZZ\\MyTownBundle\\Model\\Project', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProjectQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectQuery) {
            return $criteria;
        }
        $query = new ProjectQuery();
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
     * @return   Project|Project[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Project A model object, or null if the key is not found
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
     * @return                 Project A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `shortname`, `title`, `description`, `centerLatitude`, `centerLongitude`, `defaultZoom`, `language` FROM `project` WHERE `id` = :p0';
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
            $obj = new Project();
            $obj->hydrate($row);
            ProjectPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Project|Project[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Project[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectPeer::ID, $keys, Criteria::IN);
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProjectPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProjectPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::ID, $id, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectPeer::SHORTNAME, $shortname, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectPeer::TITLE, $title, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectPeer::DESCRIPTION, $description, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByCenterlatitude($centerlatitude = null, $comparison = null)
    {
        if (is_array($centerlatitude)) {
            $useMinMax = false;
            if (isset($centerlatitude['min'])) {
                $this->addUsingAlias(ProjectPeer::CENTERLATITUDE, $centerlatitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($centerlatitude['max'])) {
                $this->addUsingAlias(ProjectPeer::CENTERLATITUDE, $centerlatitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::CENTERLATITUDE, $centerlatitude, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByCenterlongitude($centerlongitude = null, $comparison = null)
    {
        if (is_array($centerlongitude)) {
            $useMinMax = false;
            if (isset($centerlongitude['min'])) {
                $this->addUsingAlias(ProjectPeer::CENTERLONGITUDE, $centerlongitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($centerlongitude['max'])) {
                $this->addUsingAlias(ProjectPeer::CENTERLONGITUDE, $centerlongitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::CENTERLONGITUDE, $centerlongitude, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByDefaultzoom($defaultzoom = null, $comparison = null)
    {
        if (is_array($defaultzoom)) {
            $useMinMax = false;
            if (isset($defaultzoom['min'])) {
                $this->addUsingAlias(ProjectPeer::DEFAULTZOOM, $defaultzoom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($defaultzoom['max'])) {
                $this->addUsingAlias(ProjectPeer::DEFAULTZOOM, $defaultzoom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::DEFAULTZOOM, $defaultzoom, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectPeer::LANGUAGE, $language, $comparison);
    }

    /**
     * Filter the query by a related ProjectLogo object
     *
     * @param   ProjectLogo|PropelObjectCollection $projectLogo  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectLogo($projectLogo, $comparison = null)
    {
        if ($projectLogo instanceof ProjectLogo) {
            return $this
                ->addUsingAlias(ProjectPeer::ID, $projectLogo->getprojectId(), $comparison);
        } elseif ($projectLogo instanceof PropelObjectCollection) {
            return $this
                ->useProjectLogoQuery()
                ->filterByPrimaryKeys($projectLogo->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectLogo() only accepts arguments of type ProjectLogo or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectLogo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function joinProjectLogo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectLogo');

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
            $this->addJoinObject($join, 'ProjectLogo');
        }

        return $this;
    }

    /**
     * Use the ProjectLogo relation ProjectLogo object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \NZZ\MyTownBundle\Model\ProjectLogoQuery A secondary query class using the current class as primary query
     */
    public function useProjectLogoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectLogo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectLogo', '\NZZ\MyTownBundle\Model\ProjectLogoQuery');
    }

    /**
     * Filter the query by a related Point object
     *
     * @param   Point|PropelObjectCollection $point  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPoint($point, $comparison = null)
    {
        if ($point instanceof Point) {
            return $this
                ->addUsingAlias(ProjectPeer::ID, $point->getProjectid(), $comparison);
        } elseif ($point instanceof PropelObjectCollection) {
            return $this
                ->usePointQuery()
                ->filterByPrimaryKeys($point->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPoint() only accepts arguments of type Point or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Point relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function joinPoint($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Point');

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
            $this->addJoinObject($join, 'Point');
        }

        return $this;
    }

    /**
     * Use the Point relation Point object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \NZZ\MyTownBundle\Model\PointQuery A secondary query class using the current class as primary query
     */
    public function usePointQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPoint($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Point', '\NZZ\MyTownBundle\Model\PointQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Project $project Object to remove from the list of results
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function prune($project = null)
    {
        if ($project) {
            $this->addUsingAlias(ProjectPeer::ID, $project->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
