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
use NZZ\MyTownBundle\Model\Project;
use NZZ\MyTownBundle\Model\ProjectLogo;
use NZZ\MyTownBundle\Model\ProjectLogoPeer;
use NZZ\MyTownBundle\Model\ProjectLogoQuery;

/**
 * @method ProjectLogoQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProjectLogoQuery orderByprojectId($order = Criteria::ASC) Order by the project_id column
 * @method ProjectLogoQuery orderBylogoId($order = Criteria::ASC) Order by the logo_id column
 * @method ProjectLogoQuery orderByPosition($order = Criteria::ASC) Order by the position column
 *
 * @method ProjectLogoQuery groupById() Group by the id column
 * @method ProjectLogoQuery groupByprojectId() Group by the project_id column
 * @method ProjectLogoQuery groupBylogoId() Group by the logo_id column
 * @method ProjectLogoQuery groupByPosition() Group by the position column
 *
 * @method ProjectLogoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectLogoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectLogoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectLogoQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method ProjectLogoQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method ProjectLogoQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method ProjectLogoQuery leftJoinLogo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Logo relation
 * @method ProjectLogoQuery rightJoinLogo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Logo relation
 * @method ProjectLogoQuery innerJoinLogo($relationAlias = null) Adds a INNER JOIN clause to the query using the Logo relation
 *
 * @method ProjectLogo findOne(PropelPDO $con = null) Return the first ProjectLogo matching the query
 * @method ProjectLogo findOneOrCreate(PropelPDO $con = null) Return the first ProjectLogo matching the query, or a new ProjectLogo object populated from the query conditions when no match is found
 *
 * @method ProjectLogo findOneByprojectId(int $project_id) Return the first ProjectLogo filtered by the project_id column
 * @method ProjectLogo findOneBylogoId(int $logo_id) Return the first ProjectLogo filtered by the logo_id column
 * @method ProjectLogo findOneByPosition(int $position) Return the first ProjectLogo filtered by the position column
 *
 * @method array findById(int $id) Return ProjectLogo objects filtered by the id column
 * @method array findByprojectId(int $project_id) Return ProjectLogo objects filtered by the project_id column
 * @method array findBylogoId(int $logo_id) Return ProjectLogo objects filtered by the logo_id column
 * @method array findByPosition(int $position) Return ProjectLogo objects filtered by the position column
 */
abstract class BaseProjectLogoQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectLogoQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'NZZ\\MyTownBundle\\Model\\ProjectLogo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectLogoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProjectLogoQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectLogoQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectLogoQuery) {
            return $criteria;
        }
        $query = new ProjectLogoQuery();
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
     * @return   ProjectLogo|ProjectLogo[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectLogoPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectLogoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ProjectLogo A model object, or null if the key is not found
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
     * @return                 ProjectLogo A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `project_id`, `logo_id`, `position` FROM `project_logo` WHERE `id` = :p0';
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
            $obj = new ProjectLogo();
            $obj->hydrate($row);
            ProjectLogoPeer::addInstanceToPool($obj, (string) $key);
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
     * @return ProjectLogo|ProjectLogo[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ProjectLogo[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectLogoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectLogoPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectLogoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectLogoPeer::ID, $keys, Criteria::IN);
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
     * @return ProjectLogoQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProjectLogoPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProjectLogoPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectLogoPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the project_id column
     *
     * Example usage:
     * <code>
     * $query->filterByprojectId(1234); // WHERE project_id = 1234
     * $query->filterByprojectId(array(12, 34)); // WHERE project_id IN (12, 34)
     * $query->filterByprojectId(array('min' => 12)); // WHERE project_id >= 12
     * $query->filterByprojectId(array('max' => 12)); // WHERE project_id <= 12
     * </code>
     *
     * @see       filterByProject()
     *
     * @param     mixed $projectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectLogoQuery The current query, for fluid interface
     */
    public function filterByprojectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(ProjectLogoPeer::PROJECT_ID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(ProjectLogoPeer::PROJECT_ID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectLogoPeer::PROJECT_ID, $projectId, $comparison);
    }

    /**
     * Filter the query on the logo_id column
     *
     * Example usage:
     * <code>
     * $query->filterBylogoId(1234); // WHERE logo_id = 1234
     * $query->filterBylogoId(array(12, 34)); // WHERE logo_id IN (12, 34)
     * $query->filterBylogoId(array('min' => 12)); // WHERE logo_id >= 12
     * $query->filterBylogoId(array('max' => 12)); // WHERE logo_id <= 12
     * </code>
     *
     * @see       filterByLogo()
     *
     * @param     mixed $logoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectLogoQuery The current query, for fluid interface
     */
    public function filterBylogoId($logoId = null, $comparison = null)
    {
        if (is_array($logoId)) {
            $useMinMax = false;
            if (isset($logoId['min'])) {
                $this->addUsingAlias(ProjectLogoPeer::LOGO_ID, $logoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($logoId['max'])) {
                $this->addUsingAlias(ProjectLogoPeer::LOGO_ID, $logoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectLogoPeer::LOGO_ID, $logoId, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition(1234); // WHERE position = 1234
     * $query->filterByPosition(array(12, 34)); // WHERE position IN (12, 34)
     * $query->filterByPosition(array('min' => 12)); // WHERE position >= 12
     * $query->filterByPosition(array('max' => 12)); // WHERE position <= 12
     * </code>
     *
     * @param     mixed $position The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectLogoQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(ProjectLogoPeer::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(ProjectLogoPeer::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectLogoPeer::POSITION, $position, $comparison);
    }

    /**
     * Filter the query by a related Project object
     *
     * @param   Project|PropelObjectCollection $project The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectLogoQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(ProjectLogoPeer::PROJECT_ID, $project->getId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectLogoPeer::PROJECT_ID, $project->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ProjectLogoQuery The current query, for fluid interface
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
     * Filter the query by a related Logo object
     *
     * @param   Logo|PropelObjectCollection $logo The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectLogoQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLogo($logo, $comparison = null)
    {
        if ($logo instanceof Logo) {
            return $this
                ->addUsingAlias(ProjectLogoPeer::LOGO_ID, $logo->getId(), $comparison);
        } elseif ($logo instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectLogoPeer::LOGO_ID, $logo->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByLogo() only accepts arguments of type Logo or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Logo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectLogoQuery The current query, for fluid interface
     */
    public function joinLogo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Logo');

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
            $this->addJoinObject($join, 'Logo');
        }

        return $this;
    }

    /**
     * Use the Logo relation Logo object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \NZZ\MyTownBundle\Model\LogoQuery A secondary query class using the current class as primary query
     */
    public function useLogoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLogo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Logo', '\NZZ\MyTownBundle\Model\LogoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ProjectLogo $projectLogo Object to remove from the list of results
     *
     * @return ProjectLogoQuery The current query, for fluid interface
     */
    public function prune($projectLogo = null)
    {
        if ($projectLogo) {
            $this->addUsingAlias(ProjectLogoPeer::ID, $projectLogo->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
