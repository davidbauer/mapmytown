<?php

namespace NZZ\MyTownBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use NZZ\MyTownBundle\Model\Points;
use NZZ\MyTownBundle\Model\PointsQuery;
use NZZ\MyTownBundle\Model\Projects;
use NZZ\MyTownBundle\Model\ProjectsPeer;
use NZZ\MyTownBundle\Model\ProjectsQuery;

abstract class BaseProjects extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'NZZ\\MyTownBundle\\Model\\ProjectsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ProjectsPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the shortname field.
     * @var        string
     */
    protected $shortname;

    /**
     * The value for the centerlatitude field.
     * @var        double
     */
    protected $centerlatitude;

    /**
     * The value for the centerlongitude field.
     * @var        double
     */
    protected $centerlongitude;

    /**
     * The value for the defaultzoom field.
     * @var        int
     */
    protected $defaultzoom;

    /**
     * The value for the language field.
     * @var        string
     */
    protected $language;

    /**
     * @var        PropelObjectCollection|Points[] Collection to store aggregation of Points objects.
     */
    protected $collPointss;
    protected $collPointssPartial;

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
     * An array of objects scheduled for deletion.
     * @var        PropelObjectCollection
     */
    protected $pointssScheduledForDeletion = null;

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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [shortname] column value.
     *
     * @return string
     */
    public function getShortname()
    {
        return $this->shortname;
    }

    /**
     * Get the [centerlatitude] column value.
     *
     * @return double
     */
    public function getCenterlatitude()
    {
        return $this->centerlatitude;
    }

    /**
     * Get the [centerlongitude] column value.
     *
     * @return double
     */
    public function getCenterlongitude()
    {
        return $this->centerlongitude;
    }

    /**
     * Get the [defaultzoom] column value.
     *
     * @return int
     */
    public function getDefaultzoom()
    {
        return $this->defaultzoom;
    }

    /**
     * Get the [language] column value.
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = ProjectsPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ProjectsPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [shortname] column.
     *
     * @param string $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setShortname($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->shortname !== $v) {
            $this->shortname = $v;
            $this->modifiedColumns[] = ProjectsPeer::SHORTNAME;
        }


        return $this;
    } // setShortname()

    /**
     * Set the value of [centerlatitude] column.
     *
     * @param double $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setCenterlatitude($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->centerlatitude !== $v) {
            $this->centerlatitude = $v;
            $this->modifiedColumns[] = ProjectsPeer::CENTERLATITUDE;
        }


        return $this;
    } // setCenterlatitude()

    /**
     * Set the value of [centerlongitude] column.
     *
     * @param double $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setCenterlongitude($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->centerlongitude !== $v) {
            $this->centerlongitude = $v;
            $this->modifiedColumns[] = ProjectsPeer::CENTERLONGITUDE;
        }


        return $this;
    } // setCenterlongitude()

    /**
     * Set the value of [defaultzoom] column.
     *
     * @param int $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setDefaultzoom($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->defaultzoom !== $v) {
            $this->defaultzoom = $v;
            $this->modifiedColumns[] = ProjectsPeer::DEFAULTZOOM;
        }


        return $this;
    } // setDefaultzoom()

    /**
     * Set the value of [language] column.
     *
     * @param string $v new value
     * @return Projects The current object (for fluent API support)
     */
    public function setLanguage($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->language !== $v) {
            $this->language = $v;
            $this->modifiedColumns[] = ProjectsPeer::LANGUAGE;
        }


        return $this;
    } // setLanguage()

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
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->shortname = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->centerlatitude = ($row[$startcol + 3] !== null) ? (double) $row[$startcol + 3] : null;
            $this->centerlongitude = ($row[$startcol + 4] !== null) ? (double) $row[$startcol + 4] : null;
            $this->defaultzoom = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->language = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 7; // 7 = ProjectsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Projects object", $e);
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
            $con = Propel::getConnection(ProjectsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ProjectsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collPointss = null;

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
            $con = Propel::getConnection(ProjectsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ProjectsQuery::create()
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
            $con = Propel::getConnection(ProjectsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ProjectsPeer::addInstanceToPool($this);
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

            if ($this->pointssScheduledForDeletion !== null) {
                if (!$this->pointssScheduledForDeletion->isEmpty()) {
                    PointsQuery::create()
                        ->filterByPrimaryKeys($this->pointssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pointssScheduledForDeletion = null;
                }
            }

            if ($this->collPointss !== null) {
                foreach ($this->collPointss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[] = ProjectsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProjectsPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProjectsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ProjectsPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(ProjectsPeer::SHORTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`shortname`';
        }
        if ($this->isColumnModified(ProjectsPeer::CENTERLATITUDE)) {
            $modifiedColumns[':p' . $index++]  = '`centerLatitude`';
        }
        if ($this->isColumnModified(ProjectsPeer::CENTERLONGITUDE)) {
            $modifiedColumns[':p' . $index++]  = '`centerLongitude`';
        }
        if ($this->isColumnModified(ProjectsPeer::DEFAULTZOOM)) {
            $modifiedColumns[':p' . $index++]  = '`defaultZoom`';
        }
        if ($this->isColumnModified(ProjectsPeer::LANGUAGE)) {
            $modifiedColumns[':p' . $index++]  = '`language`';
        }

        $sql = sprintf(
            'INSERT INTO `projects` (%s) VALUES (%s)',
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
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`shortname`':
                        $stmt->bindValue($identifier, $this->shortname, PDO::PARAM_STR);
                        break;
                    case '`centerLatitude`':
                        $stmt->bindValue($identifier, $this->centerlatitude, PDO::PARAM_STR);
                        break;
                    case '`centerLongitude`':
                        $stmt->bindValue($identifier, $this->centerlongitude, PDO::PARAM_STR);
                        break;
                    case '`defaultZoom`':
                        $stmt->bindValue($identifier, $this->defaultzoom, PDO::PARAM_INT);
                        break;
                    case '`language`':
                        $stmt->bindValue($identifier, $this->language, PDO::PARAM_STR);
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
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = ProjectsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collPointss !== null) {
                    foreach ($this->collPointss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
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
        $pos = ProjectsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getShortname();
                break;
            case 3:
                return $this->getCenterlatitude();
                break;
            case 4:
                return $this->getCenterlongitude();
                break;
            case 5:
                return $this->getDefaultzoom();
                break;
            case 6:
                return $this->getLanguage();
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
        if (isset($alreadyDumpedObjects['Projects'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Projects'][$this->getPrimaryKey()] = true;
        $keys = ProjectsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getShortname(),
            $keys[3] => $this->getCenterlatitude(),
            $keys[4] => $this->getCenterlongitude(),
            $keys[5] => $this->getDefaultzoom(),
            $keys[6] => $this->getLanguage(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collPointss) {
                $result['Pointss'] = $this->collPointss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ProjectsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setName($value);
                break;
            case 2:
                $this->setShortname($value);
                break;
            case 3:
                $this->setCenterlatitude($value);
                break;
            case 4:
                $this->setCenterlongitude($value);
                break;
            case 5:
                $this->setDefaultzoom($value);
                break;
            case 6:
                $this->setLanguage($value);
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
        $keys = ProjectsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setShortname($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setCenterlatitude($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCenterlongitude($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDefaultzoom($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setLanguage($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProjectsPeer::DATABASE_NAME);

        if ($this->isColumnModified(ProjectsPeer::ID)) $criteria->add(ProjectsPeer::ID, $this->id);
        if ($this->isColumnModified(ProjectsPeer::NAME)) $criteria->add(ProjectsPeer::NAME, $this->name);
        if ($this->isColumnModified(ProjectsPeer::SHORTNAME)) $criteria->add(ProjectsPeer::SHORTNAME, $this->shortname);
        if ($this->isColumnModified(ProjectsPeer::CENTERLATITUDE)) $criteria->add(ProjectsPeer::CENTERLATITUDE, $this->centerlatitude);
        if ($this->isColumnModified(ProjectsPeer::CENTERLONGITUDE)) $criteria->add(ProjectsPeer::CENTERLONGITUDE, $this->centerlongitude);
        if ($this->isColumnModified(ProjectsPeer::DEFAULTZOOM)) $criteria->add(ProjectsPeer::DEFAULTZOOM, $this->defaultzoom);
        if ($this->isColumnModified(ProjectsPeer::LANGUAGE)) $criteria->add(ProjectsPeer::LANGUAGE, $this->language);

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
        $criteria = new Criteria(ProjectsPeer::DATABASE_NAME);
        $criteria->add(ProjectsPeer::ID, $this->id);

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
     * @param object $copyObj An object of Projects (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setShortname($this->getShortname());
        $copyObj->setCenterlatitude($this->getCenterlatitude());
        $copyObj->setCenterlongitude($this->getCenterlongitude());
        $copyObj->setDefaultzoom($this->getDefaultzoom());
        $copyObj->setLanguage($this->getLanguage());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getPointss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPoints($relObj->copy($deepCopy));
                }
            }

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
     * @return Projects Clone of current object.
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
     * @return ProjectsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ProjectsPeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Points' == $relationName) {
            $this->initPointss();
        }
    }

    /**
     * Clears out the collPointss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Projects The current object (for fluent API support)
     * @see        addPointss()
     */
    public function clearPointss()
    {
        $this->collPointss = null; // important to set this to null since that means it is uninitialized
        $this->collPointssPartial = null;

        return $this;
    }

    /**
     * reset is the collPointss collection loaded partially
     *
     * @return void
     */
    public function resetPartialPointss($v = true)
    {
        $this->collPointssPartial = $v;
    }

    /**
     * Initializes the collPointss collection.
     *
     * By default this just sets the collPointss collection to an empty array (like clearcollPointss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPointss($overrideExisting = true)
    {
        if (null !== $this->collPointss && !$overrideExisting) {
            return;
        }
        $this->collPointss = new PropelObjectCollection();
        $this->collPointss->setModel('Points');
    }

    /**
     * Gets an array of Points objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Projects is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Points[] List of Points objects
     * @throws PropelException
     */
    public function getPointss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPointssPartial && !$this->isNew();
        if (null === $this->collPointss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPointss) {
                // return empty collection
                $this->initPointss();
            } else {
                $collPointss = PointsQuery::create(null, $criteria)
                    ->filterByProjects($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPointssPartial && count($collPointss)) {
                      $this->initPointss(false);

                      foreach($collPointss as $obj) {
                        if (false == $this->collPointss->contains($obj)) {
                          $this->collPointss->append($obj);
                        }
                      }

                      $this->collPointssPartial = true;
                    }

                    $collPointss->getInternalIterator()->rewind();
                    return $collPointss;
                }

                if($partial && $this->collPointss) {
                    foreach($this->collPointss as $obj) {
                        if($obj->isNew()) {
                            $collPointss[] = $obj;
                        }
                    }
                }

                $this->collPointss = $collPointss;
                $this->collPointssPartial = false;
            }
        }

        return $this->collPointss;
    }

    /**
     * Sets a collection of Points objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pointss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Projects The current object (for fluent API support)
     */
    public function setPointss(PropelCollection $pointss, PropelPDO $con = null)
    {
        $pointssToDelete = $this->getPointss(new Criteria(), $con)->diff($pointss);

        $this->pointssScheduledForDeletion = unserialize(serialize($pointssToDelete));

        foreach ($pointssToDelete as $pointsRemoved) {
            $pointsRemoved->setProjects(null);
        }

        $this->collPointss = null;
        foreach ($pointss as $points) {
            $this->addPoints($points);
        }

        $this->collPointss = $pointss;
        $this->collPointssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Points objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Points objects.
     * @throws PropelException
     */
    public function countPointss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPointssPartial && !$this->isNew();
        if (null === $this->collPointss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPointss) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPointss());
            }
            $query = PointsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProjects($this)
                ->count($con);
        }

        return count($this->collPointss);
    }

    /**
     * Method called to associate a Points object to this object
     * through the Points foreign key attribute.
     *
     * @param    Points $l Points
     * @return Projects The current object (for fluent API support)
     */
    public function addPoints(Points $l)
    {
        if ($this->collPointss === null) {
            $this->initPointss();
            $this->collPointssPartial = true;
        }
        if (!in_array($l, $this->collPointss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPoints($l);
        }

        return $this;
    }

    /**
     * @param    Points $points The points object to add.
     */
    protected function doAddPoints($points)
    {
        $this->collPointss[]= $points;
        $points->setProjects($this);
    }

    /**
     * @param    Points $points The points object to remove.
     * @return Projects The current object (for fluent API support)
     */
    public function removePoints($points)
    {
        if ($this->getPointss()->contains($points)) {
            $this->collPointss->remove($this->collPointss->search($points));
            if (null === $this->pointssScheduledForDeletion) {
                $this->pointssScheduledForDeletion = clone $this->collPointss;
                $this->pointssScheduledForDeletion->clear();
            }
            $this->pointssScheduledForDeletion[]= clone $points;
            $points->setProjects(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->shortname = null;
        $this->centerlatitude = null;
        $this->centerlongitude = null;
        $this->defaultzoom = null;
        $this->language = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collPointss) {
                foreach ($this->collPointss as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collPointss instanceof PropelCollection) {
            $this->collPointss->clearIterator();
        }
        $this->collPointss = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProjectsPeer::DEFAULT_STRING_FORMAT);
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
