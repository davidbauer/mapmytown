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
use NZZ\MyTownBundle\Model\ProjectData;
use NZZ\MyTownBundle\Model\ProjectDataPeer;
use NZZ\MyTownBundle\Model\ProjectDataQuery;

/**
 * @method ProjectDataQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProjectDataQuery orderByprojectId($order = Criteria::ASC) Order by the project_id column
 * @method ProjectDataQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method ProjectDataQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method ProjectDataQuery orderByInfo($order = Criteria::ASC) Order by the info column
 * @method ProjectDataQuery orderByCenterlatitude($order = Criteria::ASC) Order by the centerLatitude column
 * @method ProjectDataQuery orderByCenterlongitude($order = Criteria::ASC) Order by the centerLongitude column
 * @method ProjectDataQuery orderByDefaultzoom($order = Criteria::ASC) Order by the defaultZoom column
 * @method ProjectDataQuery orderByLanguage($order = Criteria::ASC) Order by the language column
 * @method ProjectDataQuery orderByButtontext($order = Criteria::ASC) Order by the buttonText column
 * @method ProjectDataQuery orderBylogoId($order = Criteria::ASC) Order by the logo_id column
 *
 * @method ProjectDataQuery groupById() Group by the id column
 * @method ProjectDataQuery groupByprojectId() Group by the project_id column
 * @method ProjectDataQuery groupByTitle() Group by the title column
 * @method ProjectDataQuery groupByDescription() Group by the description column
 * @method ProjectDataQuery groupByInfo() Group by the info column
 * @method ProjectDataQuery groupByCenterlatitude() Group by the centerLatitude column
 * @method ProjectDataQuery groupByCenterlongitude() Group by the centerLongitude column
 * @method ProjectDataQuery groupByDefaultzoom() Group by the defaultZoom column
 * @method ProjectDataQuery groupByLanguage() Group by the language column
 * @method ProjectDataQuery groupByButtontext() Group by the buttonText column
 * @method ProjectDataQuery groupBylogoId() Group by the logo_id column
 *
 * @method ProjectDataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectDataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectDataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectDataQuery leftJoinProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Project relation
 * @method ProjectDataQuery rightJoinProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Project relation
 * @method ProjectDataQuery innerJoinProject($relationAlias = null) Adds a INNER JOIN clause to the query using the Project relation
 *
 * @method ProjectDataQuery leftJoinLogo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Logo relation
 * @method ProjectDataQuery rightJoinLogo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Logo relation
 * @method ProjectDataQuery innerJoinLogo($relationAlias = null) Adds a INNER JOIN clause to the query using the Logo relation
 *
 * @method ProjectData findOne(PropelPDO $con = null) Return the first ProjectData matching the query
 * @method ProjectData findOneOrCreate(PropelPDO $con = null) Return the first ProjectData matching the query, or a new ProjectData object populated from the query conditions when no match is found
 *
 * @method ProjectData findOneByprojectId(int $project_id) Return the first ProjectData filtered by the project_id column
 * @method ProjectData findOneByTitle(string $title) Return the first ProjectData filtered by the title column
 * @method ProjectData findOneByDescription(string $description) Return the first ProjectData filtered by the description column
 * @method ProjectData findOneByInfo(string $info) Return the first ProjectData filtered by the info column
 * @method ProjectData findOneByCenterlatitude(double $centerLatitude) Return the first ProjectData filtered by the centerLatitude column
 * @method ProjectData findOneByCenterlongitude(double $centerLongitude) Return the first ProjectData filtered by the centerLongitude column
 * @method ProjectData findOneByDefaultzoom(int $defaultZoom) Return the first ProjectData filtered by the defaultZoom column
 * @method ProjectData findOneByLanguage(string $language) Return the first ProjectData filtered by the language column
 * @method ProjectData findOneByButtontext(string $buttonText) Return the first ProjectData filtered by the buttonText column
 * @method ProjectData findOneBylogoId(int $logo_id) Return the first ProjectData filtered by the logo_id column
 *
 * @method array findById(int $id) Return ProjectData objects filtered by the id column
 * @method array findByprojectId(int $project_id) Return ProjectData objects filtered by the project_id column
 * @method array findByTitle(string $title) Return ProjectData objects filtered by the title column
 * @method array findByDescription(string $description) Return ProjectData objects filtered by the description column
 * @method array findByInfo(string $info) Return ProjectData objects filtered by the info column
 * @method array findByCenterlatitude(double $centerLatitude) Return ProjectData objects filtered by the centerLatitude column
 * @method array findByCenterlongitude(double $centerLongitude) Return ProjectData objects filtered by the centerLongitude column
 * @method array findByDefaultzoom(int $defaultZoom) Return ProjectData objects filtered by the defaultZoom column
 * @method array findByLanguage(string $language) Return ProjectData objects filtered by the language column
 * @method array findByButtontext(string $buttonText) Return ProjectData objects filtered by the buttonText column
 * @method array findBylogoId(int $logo_id) Return ProjectData objects filtered by the logo_id column
 */
abstract class BaseProjectDataQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectDataQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'NZZ\\MyTownBundle\\Model\\ProjectData';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectDataQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProjectDataQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectDataQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectDataQuery) {
            return $criteria;
        }
        $query = new ProjectDataQuery(null, null, $modelAlias);

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
     * @return   ProjectData|ProjectData[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectDataPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectDataPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ProjectData A model object, or null if the key is not found
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
     * @return                 ProjectData A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `project_id`, `title`, `description`, `info`, `centerLatitude`, `centerLongitude`, `defaultZoom`, `language`, `buttonText`, `logo_id` FROM `project_data` WHERE `id` = :p0';
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
            $obj = new ProjectData();
            $obj->hydrate($row);
            ProjectDataPeer::addInstanceToPool($obj, (string) $key);
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
     * @return ProjectData|ProjectData[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ProjectData[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectDataPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectDataPeer::ID, $keys, Criteria::IN);
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
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProjectDataPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProjectDataPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectDataPeer::ID, $id, $comparison);
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
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function filterByprojectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(ProjectDataPeer::PROJECT_ID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(ProjectDataPeer::PROJECT_ID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectDataPeer::PROJECT_ID, $projectId, $comparison);
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
     * @return ProjectDataQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectDataPeer::TITLE, $title, $comparison);
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
     * @return ProjectDataQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectDataPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the info column
     *
     * Example usage:
     * <code>
     * $query->filterByInfo('fooValue');   // WHERE info = 'fooValue'
     * $query->filterByInfo('%fooValue%'); // WHERE info LIKE '%fooValue%'
     * </code>
     *
     * @param     string $info The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function filterByInfo($info = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($info)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $info)) {
                $info = str_replace('*', '%', $info);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectDataPeer::INFO, $info, $comparison);
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
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function filterByCenterlatitude($centerlatitude = null, $comparison = null)
    {
        if (is_array($centerlatitude)) {
            $useMinMax = false;
            if (isset($centerlatitude['min'])) {
                $this->addUsingAlias(ProjectDataPeer::CENTERLATITUDE, $centerlatitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($centerlatitude['max'])) {
                $this->addUsingAlias(ProjectDataPeer::CENTERLATITUDE, $centerlatitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectDataPeer::CENTERLATITUDE, $centerlatitude, $comparison);
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
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function filterByCenterlongitude($centerlongitude = null, $comparison = null)
    {
        if (is_array($centerlongitude)) {
            $useMinMax = false;
            if (isset($centerlongitude['min'])) {
                $this->addUsingAlias(ProjectDataPeer::CENTERLONGITUDE, $centerlongitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($centerlongitude['max'])) {
                $this->addUsingAlias(ProjectDataPeer::CENTERLONGITUDE, $centerlongitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectDataPeer::CENTERLONGITUDE, $centerlongitude, $comparison);
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
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function filterByDefaultzoom($defaultzoom = null, $comparison = null)
    {
        if (is_array($defaultzoom)) {
            $useMinMax = false;
            if (isset($defaultzoom['min'])) {
                $this->addUsingAlias(ProjectDataPeer::DEFAULTZOOM, $defaultzoom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($defaultzoom['max'])) {
                $this->addUsingAlias(ProjectDataPeer::DEFAULTZOOM, $defaultzoom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectDataPeer::DEFAULTZOOM, $defaultzoom, $comparison);
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
     * @return ProjectDataQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectDataPeer::LANGUAGE, $language, $comparison);
    }

    /**
     * Filter the query on the buttonText column
     *
     * Example usage:
     * <code>
     * $query->filterByButtontext('fooValue');   // WHERE buttonText = 'fooValue'
     * $query->filterByButtontext('%fooValue%'); // WHERE buttonText LIKE '%fooValue%'
     * </code>
     *
     * @param     string $buttontext The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function filterByButtontext($buttontext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($buttontext)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $buttontext)) {
                $buttontext = str_replace('*', '%', $buttontext);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjectDataPeer::BUTTONTEXT, $buttontext, $comparison);
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
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function filterBylogoId($logoId = null, $comparison = null)
    {
        if (is_array($logoId)) {
            $useMinMax = false;
            if (isset($logoId['min'])) {
                $this->addUsingAlias(ProjectDataPeer::LOGO_ID, $logoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($logoId['max'])) {
                $this->addUsingAlias(ProjectDataPeer::LOGO_ID, $logoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectDataPeer::LOGO_ID, $logoId, $comparison);
    }

    /**
     * Filter the query by a related Project object
     *
     * @param   Project|PropelObjectCollection $project The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectDataQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProject($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(ProjectDataPeer::PROJECT_ID, $project->getId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectDataPeer::PROJECT_ID, $project->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ProjectDataQuery The current query, for fluid interface
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
     * @return                 ProjectDataQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLogo($logo, $comparison = null)
    {
        if ($logo instanceof Logo) {
            return $this
                ->addUsingAlias(ProjectDataPeer::LOGO_ID, $logo->getId(), $comparison);
        } elseif ($logo instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectDataPeer::LOGO_ID, $logo->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function joinLogo($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useLogoQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLogo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Logo', '\NZZ\MyTownBundle\Model\LogoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ProjectData $projectData Object to remove from the list of results
     *
     * @return ProjectDataQuery The current query, for fluid interface
     */
    public function prune($projectData = null)
    {
        if ($projectData) {
            $this->addUsingAlias(ProjectDataPeer::ID, $projectData->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
