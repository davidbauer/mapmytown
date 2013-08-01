<?php

namespace NZZ\MyTownBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use NZZ\MyTownBundle\Model\Tracking;
use NZZ\MyTownBundle\Model\TrackingPeer;
use NZZ\MyTownBundle\Model\TrackingQuery;

/**
 * @method TrackingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method TrackingQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method TrackingQuery orderByProvider($order = Criteria::ASC) Order by the provider column
 * @method TrackingQuery orderByBody($order = Criteria::ASC) Order by the body column
 *
 * @method TrackingQuery groupById() Group by the id column
 * @method TrackingQuery groupByTitle() Group by the title column
 * @method TrackingQuery groupByProvider() Group by the provider column
 * @method TrackingQuery groupByBody() Group by the body column
 *
 * @method TrackingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method TrackingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method TrackingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Tracking findOne(PropelPDO $con = null) Return the first Tracking matching the query
 * @method Tracking findOneOrCreate(PropelPDO $con = null) Return the first Tracking matching the query, or a new Tracking object populated from the query conditions when no match is found
 *
 * @method Tracking findOneByTitle(string $title) Return the first Tracking filtered by the title column
 * @method Tracking findOneByProvider(string $provider) Return the first Tracking filtered by the provider column
 * @method Tracking findOneByBody(string $body) Return the first Tracking filtered by the body column
 *
 * @method array findById(int $id) Return Tracking objects filtered by the id column
 * @method array findByTitle(string $title) Return Tracking objects filtered by the title column
 * @method array findByProvider(string $provider) Return Tracking objects filtered by the provider column
 * @method array findByBody(string $body) Return Tracking objects filtered by the body column
 */
abstract class BaseTrackingQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseTrackingQuery object.
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
            $modelName = 'NZZ\\MyTownBundle\\Model\\Tracking';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new TrackingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   TrackingQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return TrackingQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof TrackingQuery) {
            return $criteria;
        }
        $query = new TrackingQuery(null, null, $modelAlias);

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
     * @return   Tracking|Tracking[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TrackingPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(TrackingPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Tracking A model object, or null if the key is not found
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
     * @return                 Tracking A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `title`, `provider`, `body` FROM `tracking` WHERE `id` = :p0';
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
            $obj = new Tracking();
            $obj->hydrate($row);
            TrackingPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Tracking|Tracking[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Tracking[]|mixed the list of results, formatted by the current formatter
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
     * @return TrackingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TrackingPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return TrackingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TrackingPeer::ID, $keys, Criteria::IN);
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
     * @return TrackingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TrackingPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TrackingPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TrackingPeer::ID, $id, $comparison);
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
     * @return TrackingQuery The current query, for fluid interface
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

        return $this->addUsingAlias(TrackingPeer::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the provider column
     *
     * Example usage:
     * <code>
     * $query->filterByProvider('fooValue');   // WHERE provider = 'fooValue'
     * $query->filterByProvider('%fooValue%'); // WHERE provider LIKE '%fooValue%'
     * </code>
     *
     * @param     string $provider The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TrackingQuery The current query, for fluid interface
     */
    public function filterByProvider($provider = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($provider)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $provider)) {
                $provider = str_replace('*', '%', $provider);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TrackingPeer::PROVIDER, $provider, $comparison);
    }

    /**
     * Filter the query on the body column
     *
     * Example usage:
     * <code>
     * $query->filterByBody('fooValue');   // WHERE body = 'fooValue'
     * $query->filterByBody('%fooValue%'); // WHERE body LIKE '%fooValue%'
     * </code>
     *
     * @param     string $body The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TrackingQuery The current query, for fluid interface
     */
    public function filterByBody($body = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($body)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $body)) {
                $body = str_replace('*', '%', $body);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TrackingPeer::BODY, $body, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   Tracking $tracking Object to remove from the list of results
     *
     * @return TrackingQuery The current query, for fluid interface
     */
    public function prune($tracking = null)
    {
        if ($tracking) {
            $this->addUsingAlias(TrackingPeer::ID, $tracking->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
