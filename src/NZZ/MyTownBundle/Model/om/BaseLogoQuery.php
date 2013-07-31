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
use NZZ\MyTownBundle\Model\Logo;
use NZZ\MyTownBundle\Model\LogoPeer;
use NZZ\MyTownBundle\Model\LogoQuery;
use NZZ\MyTownBundle\Model\ProjectData;
use NZZ\MyTownBundle\Model\ProjectLogo;

/**
 * @method LogoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method LogoQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method LogoQuery orderByCaption($order = Criteria::ASC) Order by the caption column
 * @method LogoQuery orderByUrl($order = Criteria::ASC) Order by the url column
 *
 * @method LogoQuery groupById() Group by the id column
 * @method LogoQuery groupByTitle() Group by the title column
 * @method LogoQuery groupByCaption() Group by the caption column
 * @method LogoQuery groupByUrl() Group by the url column
 *
 * @method LogoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method LogoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method LogoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method LogoQuery leftJoinProjectData($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectData relation
 * @method LogoQuery rightJoinProjectData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectData relation
 * @method LogoQuery innerJoinProjectData($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectData relation
 *
 * @method LogoQuery leftJoinProjectLogo($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectLogo relation
 * @method LogoQuery rightJoinProjectLogo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectLogo relation
 * @method LogoQuery innerJoinProjectLogo($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectLogo relation
 *
 * @method Logo findOne(PropelPDO $con = null) Return the first Logo matching the query
 * @method Logo findOneOrCreate(PropelPDO $con = null) Return the first Logo matching the query, or a new Logo object populated from the query conditions when no match is found
 *
 * @method Logo findOneByTitle(string $title) Return the first Logo filtered by the title column
 * @method Logo findOneByCaption(string $caption) Return the first Logo filtered by the caption column
 * @method Logo findOneByUrl(string $url) Return the first Logo filtered by the url column
 *
 * @method array findById(int $id) Return Logo objects filtered by the id column
 * @method array findByTitle(string $title) Return Logo objects filtered by the title column
 * @method array findByCaption(string $caption) Return Logo objects filtered by the caption column
 * @method array findByUrl(string $url) Return Logo objects filtered by the url column
 */
abstract class BaseLogoQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseLogoQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'NZZ\\MyTownBundle\\Model\\Logo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new LogoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   LogoQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return LogoQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof LogoQuery) {
            return $criteria;
        }
        $query = new LogoQuery();
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
     * @return   Logo|Logo[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LogoPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(LogoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Logo A model object, or null if the key is not found
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
     * @return                 Logo A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `title`, `caption`, `url` FROM `logo` WHERE `id` = :p0';
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
            $obj = new Logo();
            $obj->hydrate($row);
            LogoPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Logo|Logo[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Logo[]|mixed the list of results, formatted by the current formatter
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
     * @return LogoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LogoPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return LogoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LogoPeer::ID, $keys, Criteria::IN);
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
     * @return LogoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LogoPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LogoPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogoPeer::ID, $id, $comparison);
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
     * @return LogoQuery The current query, for fluid interface
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

        return $this->addUsingAlias(LogoPeer::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the caption column
     *
     * Example usage:
     * <code>
     * $query->filterByCaption('fooValue');   // WHERE caption = 'fooValue'
     * $query->filterByCaption('%fooValue%'); // WHERE caption LIKE '%fooValue%'
     * </code>
     *
     * @param     string $caption The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return LogoQuery The current query, for fluid interface
     */
    public function filterByCaption($caption = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($caption)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $caption)) {
                $caption = str_replace('*', '%', $caption);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LogoPeer::CAPTION, $caption, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return LogoQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $url)) {
                $url = str_replace('*', '%', $url);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LogoPeer::URL, $url, $comparison);
    }

    /**
     * Filter the query by a related ProjectData object
     *
     * @param   ProjectData|PropelObjectCollection $projectData  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 LogoQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectData($projectData, $comparison = null)
    {
        if ($projectData instanceof ProjectData) {
            return $this
                ->addUsingAlias(LogoPeer::ID, $projectData->getlogoId(), $comparison);
        } elseif ($projectData instanceof PropelObjectCollection) {
            return $this
                ->useProjectDataQuery()
                ->filterByPrimaryKeys($projectData->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectData() only accepts arguments of type ProjectData or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectData relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return LogoQuery The current query, for fluid interface
     */
    public function joinProjectData($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectData');

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
            $this->addJoinObject($join, 'ProjectData');
        }

        return $this;
    }

    /**
     * Use the ProjectData relation ProjectData object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \NZZ\MyTownBundle\Model\ProjectDataQuery A secondary query class using the current class as primary query
     */
    public function useProjectDataQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProjectData($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectData', '\NZZ\MyTownBundle\Model\ProjectDataQuery');
    }

    /**
     * Filter the query by a related ProjectLogo object
     *
     * @param   ProjectLogo|PropelObjectCollection $projectLogo  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 LogoQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectLogo($projectLogo, $comparison = null)
    {
        if ($projectLogo instanceof ProjectLogo) {
            return $this
                ->addUsingAlias(LogoPeer::ID, $projectLogo->getlogoId(), $comparison);
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
     * @return LogoQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Logo $logo Object to remove from the list of results
     *
     * @return LogoQuery The current query, for fluid interface
     */
    public function prune($logo = null)
    {
        if ($logo) {
            $this->addUsingAlias(LogoPeer::ID, $logo->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
