<?php

namespace NZZ\MyTownBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelException;
use \PropelPDO;
use NZZ\MyTownBundle\Model\Point;
use NZZ\MyTownBundle\Model\PointPeer;
use NZZ\MyTownBundle\Model\PointQuery;
use NZZ\MyTownBundle\Model\Project;
use NZZ\MyTownBundle\Model\ProjectQuery;

abstract class BasePoint extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'NZZ\\MyTownBundle\\Model\\PointPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        PointPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the latitude field.
     * @var        double
     */
    protected $latitude;

    /**
     * The value for the longitude field.
     * @var        double
     */
    protected $longitude;

    /**
     * The value for the author_name field.
     * @var        string
     */
    protected $author_name;

    /**
     * The value for the author_location field.
     * @var        string
     */
    protected $author_location;

    /**
     * The value for the sentiment field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $sentiment;

    /**
     * The value for the is_published field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_published;

    /**
     * The value for the type field.
     * Note: this column has a database default value of: 'user'
     * @var        string
     */
    protected $type;

    /**
     * The value for the project_id field.
     * @var        int
     */
    protected $project_id;

    /**
     * @var        Project
     */
    protected $aProject;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->sentiment = 0;
        $this->is_published = false;
        $this->type = 'user';
    }

    /**
     * Initializes internal state of BasePoint object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {

        return $this->title;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {

        return $this->description;
    }

    /**
     * Get the [latitude] column value.
     *
     * @return double
     */
    public function getLatitude()
    {

        return $this->latitude;
    }

    /**
     * Get the [longitude] column value.
     *
     * @return double
     */
    public function getLongitude()
    {

        return $this->longitude;
    }

    /**
     * Get the [author_name] column value.
     *
     * @return string
     */
    public function getAuthorName()
    {

        return $this->author_name;
    }

    /**
     * Get the [author_location] column value.
     *
     * @return string
     */
    public function getAuthorLocation()
    {

        return $this->author_location;
    }

    /**
     * Get the [sentiment] column value.
     *
     * @return int
     */
    public function getSentiment()
    {

        return $this->sentiment;
    }

    /**
     * Get the [is_published] column value.
     *
     * @return boolean
     */
    public function getIsPublished()
    {

        return $this->is_published;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {

        return $this->type;
    }

    /**
     * Get the [project_id] column value.
     *
     * @return int
     */
    public function getProjectId()
    {

        return $this->project_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Point The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = PointPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [title] column.
     *
     * @param  string $v new value
     * @return Point The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = PointPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return Point The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = PointPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Set the value of [latitude] column.
     *
     * @param  double $v new value
     * @return Point The current object (for fluent API support)
     */
    public function setLatitude($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->latitude !== $v) {
            $this->latitude = $v;
            $this->modifiedColumns[] = PointPeer::LATITUDE;
        }


        return $this;
    } // setLatitude()

    /**
     * Set the value of [longitude] column.
     *
     * @param  double $v new value
     * @return Point The current object (for fluent API support)
     */
    public function setLongitude($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->longitude !== $v) {
            $this->longitude = $v;
            $this->modifiedColumns[] = PointPeer::LONGITUDE;
        }


        return $this;
    } // setLongitude()

    /**
     * Set the value of [author_name] column.
     *
     * @param  string $v new value
     * @return Point The current object (for fluent API support)
     */
    public function setAuthorName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->author_name !== $v) {
            $this->author_name = $v;
            $this->modifiedColumns[] = PointPeer::AUTHOR_NAME;
        }


        return $this;
    } // setAuthorName()

    /**
     * Set the value of [author_location] column.
     *
     * @param  string $v new value
     * @return Point The current object (for fluent API support)
     */
    public function setAuthorLocation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->author_location !== $v) {
            $this->author_location = $v;
            $this->modifiedColumns[] = PointPeer::AUTHOR_LOCATION;
        }


        return $this;
    } // setAuthorLocation()

    /**
     * Set the value of [sentiment] column.
     *
     * @param  int $v new value
     * @return Point The current object (for fluent API support)
     */
    public function setSentiment($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->sentiment !== $v) {
            $this->sentiment = $v;
            $this->modifiedColumns[] = PointPeer::SENTIMENT;
        }


        return $this;
    } // setSentiment()

    /**
     * Sets the value of the [is_published] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Point The current object (for fluent API support)
     */
    public function setIsPublished($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_published !== $v) {
            $this->is_published = $v;
            $this->modifiedColumns[] = PointPeer::IS_PUBLISHED;
        }


        return $this;
    } // setIsPublished()

    /**
     * Set the value of [type] column.
     *
     * @param  string $v new value
     * @return Point The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = PointPeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [project_id] column.
     *
     * @param  int $v new value
     * @return Point The current object (for fluent API support)
     */
    public function setProjectId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->project_id !== $v) {
            $this->project_id = $v;
            $this->modifiedColumns[] = PointPeer::PROJECT_ID;
        }

        if ($this->aProject !== null && $this->aProject->getId() !== $v) {
            $this->aProject = null;
        }


        return $this;
    } // setProjectId()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->sentiment !== 0) {
                return false;
            }

            if ($this->is_published !== false) {
                return false;
            }

            if ($this->type !== 'user') {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->title = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->description = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->latitude = ($row[$startcol + 3] !== null) ? (double) $row[$startcol + 3] : null;
            $this->longitude = ($row[$startcol + 4] !== null) ? (double) $row[$startcol + 4] : null;
            $this->author_name = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->author_location = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->sentiment = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->is_published = ($row[$startcol + 8] !== null) ? (boolean) $row[$startcol + 8] : null;
            $this->type = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->project_id = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 11; // 11 = PointPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Point object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aProject !== null && $this->project_id !== $this->aProject->getId()) {
            $this->aProject = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(PointPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = PointPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProject = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(PointPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = PointQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(PointPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PointPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aProject !== null) {
                if ($this->aProject->isModified() || $this->aProject->isNew()) {
                    $affectedRows += $this->aProject->save($con);
                }
                $this->setProject($this->aProject);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = PointPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PointPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PointPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(PointPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(PointPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`description`';
        }
        if ($this->isColumnModified(PointPeer::LATITUDE)) {
            $modifiedColumns[':p' . $index++]  = '`latitude`';
        }
        if ($this->isColumnModified(PointPeer::LONGITUDE)) {
            $modifiedColumns[':p' . $index++]  = '`longitude`';
        }
        if ($this->isColumnModified(PointPeer::AUTHOR_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`author_name`';
        }
        if ($this->isColumnModified(PointPeer::AUTHOR_LOCATION)) {
            $modifiedColumns[':p' . $index++]  = '`author_location`';
        }
        if ($this->isColumnModified(PointPeer::SENTIMENT)) {
            $modifiedColumns[':p' . $index++]  = '`sentiment`';
        }
        if ($this->isColumnModified(PointPeer::IS_PUBLISHED)) {
            $modifiedColumns[':p' . $index++]  = '`is_published`';
        }
        if ($this->isColumnModified(PointPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(PointPeer::PROJECT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`project_id`';
        }

        $sql = sprintf(
            'INSERT INTO `point` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`description`':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '`latitude`':
                        $stmt->bindValue($identifier, $this->latitude, PDO::PARAM_STR);
                        break;
                    case '`longitude`':
                        $stmt->bindValue($identifier, $this->longitude, PDO::PARAM_STR);
                        break;
                    case '`author_name`':
                        $stmt->bindValue($identifier, $this->author_name, PDO::PARAM_STR);
                        break;
                    case '`author_location`':
                        $stmt->bindValue($identifier, $this->author_location, PDO::PARAM_STR);
                        break;
                    case '`sentiment`':
                        $stmt->bindValue($identifier, $this->sentiment, PDO::PARAM_INT);
                        break;
                    case '`is_published`':
                        $stmt->bindValue($identifier, (int) $this->is_published, PDO::PARAM_INT);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case '`project_id`':
                        $stmt->bindValue($identifier, $this->project_id, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aProject !== null) {
                if (!$this->aProject->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProject->getValidationFailures());
                }
            }


            if (($retval = PointPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }



            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_STUDLYPHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_STUDLYPHPNAME)
    {
        $pos = PointPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getTitle();
                break;
            case 2:
                return $this->getDescription();
                break;
            case 3:
                return $this->getLatitude();
                break;
            case 4:
                return $this->getLongitude();
                break;
            case 5:
                return $this->getAuthorName();
                break;
            case 6:
                return $this->getAuthorLocation();
                break;
            case 7:
                return $this->getSentiment();
                break;
            case 8:
                return $this->getIsPublished();
                break;
            case 9:
                return $this->getType();
                break;
            case 10:
                return $this->getProjectId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_STUDLYPHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_STUDLYPHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Point'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Point'][$this->getPrimaryKey()] = true;
        $keys = PointPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getDescription(),
            $keys[3] => $this->getLatitude(),
            $keys[4] => $this->getLongitude(),
            $keys[5] => $this->getAuthorName(),
            $keys[6] => $this->getAuthorLocation(),
            $keys[7] => $this->getSentiment(),
            $keys[8] => $this->getIsPublished(),
            $keys[9] => $this->getType(),
            $keys[10] => $this->getProjectId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach($virtualColumns as $key => $virtualColumn)
        {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProject) {
                $result['Project'] = $this->aProject->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_STUDLYPHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_STUDLYPHPNAME)
    {
        $pos = PointPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setDescription($value);
                break;
            case 3:
                $this->setLatitude($value);
                break;
            case 4:
                $this->setLongitude($value);
                break;
            case 5:
                $this->setAuthorName($value);
                break;
            case 6:
                $this->setAuthorLocation($value);
                break;
            case 7:
                $this->setSentiment($value);
                break;
            case 8:
                $this->setIsPublished($value);
                break;
            case 9:
                $this->setType($value);
                break;
            case 10:
                $this->setProjectId($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_STUDLYPHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_STUDLYPHPNAME)
    {
        $keys = PointPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setLatitude($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setLongitude($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setAuthorName($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setAuthorLocation($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setSentiment($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setIsPublished($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setType($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setProjectId($arr[$keys[10]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PointPeer::DATABASE_NAME);

        if ($this->isColumnModified(PointPeer::ID)) $criteria->add(PointPeer::ID, $this->id);
        if ($this->isColumnModified(PointPeer::TITLE)) $criteria->add(PointPeer::TITLE, $this->title);
        if ($this->isColumnModified(PointPeer::DESCRIPTION)) $criteria->add(PointPeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(PointPeer::LATITUDE)) $criteria->add(PointPeer::LATITUDE, $this->latitude);
        if ($this->isColumnModified(PointPeer::LONGITUDE)) $criteria->add(PointPeer::LONGITUDE, $this->longitude);
        if ($this->isColumnModified(PointPeer::AUTHOR_NAME)) $criteria->add(PointPeer::AUTHOR_NAME, $this->author_name);
        if ($this->isColumnModified(PointPeer::AUTHOR_LOCATION)) $criteria->add(PointPeer::AUTHOR_LOCATION, $this->author_location);
        if ($this->isColumnModified(PointPeer::SENTIMENT)) $criteria->add(PointPeer::SENTIMENT, $this->sentiment);
        if ($this->isColumnModified(PointPeer::IS_PUBLISHED)) $criteria->add(PointPeer::IS_PUBLISHED, $this->is_published);
        if ($this->isColumnModified(PointPeer::TYPE)) $criteria->add(PointPeer::TYPE, $this->type);
        if ($this->isColumnModified(PointPeer::PROJECT_ID)) $criteria->add(PointPeer::PROJECT_ID, $this->project_id);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(PointPeer::DATABASE_NAME);
        $criteria->add(PointPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Point (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setLatitude($this->getLatitude());
        $copyObj->setLongitude($this->getLongitude());
        $copyObj->setAuthorName($this->getAuthorName());
        $copyObj->setAuthorLocation($this->getAuthorLocation());
        $copyObj->setSentiment($this->getSentiment());
        $copyObj->setIsPublished($this->getIsPublished());
        $copyObj->setType($this->getType());
        $copyObj->setProjectId($this->getProjectId());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Point Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return PointPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new PointPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Project object.
     *
     * @param                  Project $v
     * @return Point The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProject(Project $v = null)
    {
        if ($v === null) {
            $this->setProjectId(NULL);
        } else {
            $this->setProjectId($v->getId());
        }

        $this->aProject = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Project object, it will not be re-added.
        if ($v !== null) {
            $v->addPoint($this);
        }


        return $this;
    }


    /**
     * Get the associated Project object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Project The associated Project object.
     * @throws PropelException
     */
    public function getProject(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aProject === null && ($this->project_id !== null) && $doQuery) {
            $this->aProject = ProjectQuery::create()->findPk($this->project_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProject->addPoints($this);
             */
        }

        return $this->aProject;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->title = null;
        $this->description = null;
        $this->latitude = null;
        $this->longitude = null;
        $this->author_name = null;
        $this->author_location = null;
        $this->sentiment = null;
        $this->is_published = null;
        $this->type = null;
        $this->project_id = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->aProject instanceof Persistent) {
              $this->aProject->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aProject = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PointPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
