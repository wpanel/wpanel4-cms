<?php 

/**
 * @copyright Eliel de Paula <dev@elieldepaula.com.br>
 * @license http://wpanel.org/license
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * -----------------------------------------------------------------------------
 * Licensed originaly under MIT license by Lonnie Ezell
 * https://github.com/lonnieezell/my_model
 * -----------------------------------------------------------------------------
 * 
 * MY_Model
 *
 * An extension of CodeIgniter's built-in model that provides a convenient
 * base to quickly and easily build your database-backed models off of.
 *
 * Provides observers, soft-deletes, basic CRUD functions, helpful functions,
 * and more.
 *
 * This pulls many ideas and inspiration from Jamie Rumbelow's excellent MY_Model
 * and the ideas described in his CodeIgniter Handbook, as well as from Laravel
 * and Rails.
 *
 * To help in master/slave scenarios where you might have a different database
 * to read from then you do to write to. By default, the model will only load
 * the 'default' database and use it form both read and write connections.
 */
class MY_Model extends CI_Model {

    /**
     * The model's default table name.
     *
     * @var string;
     */
    protected   $table_name;

    /**
     * The model's default primary key.
     *
     * @var string
     */
    protected   $primary_key    = 'id';

    /**
     * Field name to use to the created time column in the DB table.
     *
     * @var string
     * @access protected
     */
    protected $created_field = 'created_on';

    /**
     * Field name to use to the modified time column in the DB table.
     *
     * @var string
     * @access protected
     */
    protected $modified_field = 'modified_on';

    /**
     * Whether or not to auto-fill a 'created_on' field on inserts.
     *
     * @var boolean
     * @access protected
     */
    protected $set_created  = TRUE;

    /**
     * Whether or not to auto-fill a 'modified_on' field on updates.
     *
     * @var boolean
     * @access protected
     */
    protected $set_modified = TRUE;

    /*
        Var: $log_user
        If TRUE, will log user id for 'created_by', 'modified_by' and 'deleted_by'.

        Access:
            Protected
    */
    protected $log_user = TRUE;

    /*
        Var: $created_by_field
        Field name to use to the created by column in the DB table.

        Access:
            Protected
    */
    protected $created_by_field = 'created_by';

    /*
        Var: $modified_by_field
        Field name to use to the modified by column in the DB table.

        Access:
            Protected
    */
    protected $modified_by_field = 'modified_by';

    /*
        Var: $deleted_by_field
        Field name to use for the deleted by column in the DB table.

        Access:
            Protected
    */
    protected $deleted_by_field = 'deleted_by';

    /**
     * The type of date/time field used for created_on and modified_on fields.
     * Valid types are: 'int', 'datetime', 'date'
     *
     * @var string
     * @access protected
     */
    protected $date_format = 'int';

    /**
     * Support for soft_deletes.
     */
    protected   $soft_deletes       = FALSE;
    protected   $soft_delete_key    = 'deleted';
    protected   $temp_with_deleted  = FALSE;

    /**
     * Various callbacks available to the class. They are simple lists of
     * method names (methods will be ran on $this).
     */
    protected $before_insert  = array();
    protected $after_insert     = array();
    protected $before_update    = array();
    protected $after_update     = array();
    protected $before_find      = array();
    protected $after_find       = array();
    protected $before_delete    = array();
    protected $after_delete     = array();

    protected $callback_parameters  = array();

    /**
     * Protected, non-modifiable attributes
     */
    protected $protected_attributes = array();

    /**
     * An array of validation rules. This needs to be the same format
     * as validation rules passed to the Form_validation library.
     *
     * You can override this value into a string that is the name
     * of a rule group, if you've saved the rules array into
     * a config file as described in the CodeIgniter User Guide.
     * http://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#savingtoconfig
     */
    protected $validation_rules = array();

    /**
     * An array of rules to be added to the validation rules during
     * insert type methods. This is commonly used to add a required rule
     * that is only needed during inserts and not updates. The array
     * requires the field_name as the key and the additional rules
     * as the value string.
     *
     *      array(
     *          'password' => 'required|matches[password]',
     *          'username' => 'required'
     *      )
     */
    protected $insert_validation_rules = array();

    /**
     * Optionally skip the validation. Used in conjunction with
     * skip_validation() to skip data validation for any future calls.
     */
    protected $skip_validation = FALSE;

    /**
     * By default, we return items as objects. You can change this for the
     * entire class by setting this value to 'array' instead of 'object'.
     * Alternatively, you can do it on a per-instance basis using the
     * 'as_array()' and 'as_object()' methods.
     */
    protected $return_type      = 'object';
    protected $temp_return_type = NULL;

    /*
        If TRUE, inserts will return the last_insert_id. However,
        this can potentially slow down large imports drastically
        so you can turn it off with the return_insert_id(false) method.
        This will simply return TRUE, instead.

        IMPORTANT: Turning this to false will bypass any after_insert
        trigger events.
     */
    protected $return_insert_id = true;

    /**
     * The database connection to use for all write-type calls.
     */
    protected $dbw;

    /**
     * The database connection to use for all read-type calls.
     */
    protected $dbr;

    //--------------------------------------------------------------------

    /**
     * Gets our model up and running.
     *
     * You can provide your own connections for read and/or write databases
     * by passing them in the constructor.
     *
     * @param DB object $write_db A CI_DB connection.
     * @param DB object $read_db A CI_DB connection.
     */
    public function __construct(&$write_db=null, &$read_db=null)
    {
        // Always protect our attributes
        array_unshift($this->before_insert, 'protect_attributes');
        array_unshift($this->before_update, 'protect_attributes');

        // Check our auto-set features and make sure they are part of
        // our observer system.
        if ($this->set_created === true) array_unshift($this->before_insert, 'created_on');
        if ($this->set_modified === true) array_unshift($this->before_update, 'modified_on');

        // Make sure our temp return type is correct.
        $this->temp_return_type = $this->return_type;

        /*
            Passed DB connections?
         */
        if (is_object($write_db))
        {
            $this->dbw = $write_db;
        }

        if (is_object($read_db))
        {
            $this->dbr = $read_db;
        }

        /*
            Make sure we have a dbw and a dbr to use.

            Start with the writeable db. If we don't have
            one (passed in) then try to use the global $this->db
            object, if exists. Otherwise, load the database
            and then use $this->db
         */
        if (!isset($this->db))
        {
            $this->load->database();
        }

        if ( ! is_object($this->dbw))
        {
            $this->dbw = $this->db;
        }

        // If there's no read db, use the write db.
        if ( ! is_object($this->dbr))
        {
            $this->dbr = $this->dbw;
        }

        log_message('debug', 'MY_Model Class Initialized');
    }

    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
    // CRUD Methods
    //--------------------------------------------------------------------

    /**
     * A simple way to grab the first result of a search only.
     */
    public function first()
    {
        $rows = $this->limit(1)->find_all();

        if (is_array($rows) && count($rows) == 1)
        {
            return $rows[0];
        }

        return $rows;
    }

    //--------------------------------------------------------------------


    /**
     * Finds a single record based on it's primary key. Will ignore deleted rows.
     *
     * @param  mixed $id The primary_key value of the object to retrieve.
     * @return object
     */
    public function find($id)
    {
        $this->trigger('before_find');

        // Ignore any soft-deleted rows
        if ($this->soft_deletes && $this->temp_with_deleted !== TRUE)
        {
            $this->dbr->where($this->table_name.'.'.$this->soft_delete_key, FALSE);
        }

        $this->dbr->where($this->primary_key, $id);
        $row = $this->dbr->get($this->table_name);
        $row = $row->{$this->_return_type()}();

        $row = $this->trigger('after_find', $row);

        if ($this->temp_return_type == 'json')
        {
            $row = json_encode($row);
        }

        // Reset our return type
        $this->temp_return_type = $this->return_type;

        return $row;
    }

    //--------------------------------------------------------------------

    /**
     * Fetch a single record based on an arbitrary WHERE call. Can be
     * any valid value to $this->db->where(). Will not pull in deleted rows
     * if using soft deletes.
     *
     * @return object
     */
    public function find_by()
    {
        $where = func_get_args();
        $this->_set_where($where, 'dbr');

        // Ignore any soft-deleted rows
        if ($this->soft_deletes && $this->temp_with_deleted !== TRUE)
        {
            $this->dbr->where($this->soft_delete_key, FALSE);
        }

        $this->trigger('before_find');

        $row = $this->dbr->get($this->table_name);
        $row = $row->{$this->_return_type()}();

        $row = $this->trigger('after_find', $row);

        if ($this->temp_return_type == 'json')
        {
            $row = json_encode($row);
        }

        // Reset our return type
        $this->temp_return_type = $this->return_type;

        return $row;
    }

    //--------------------------------------------------------------------

    /**
     * Retrieves a number of items based on an array of primary_values passed in.
     *
     * @param  array $values An array of primary key values to find.
     *
     * @return object or FALSE
     */
    public function find_many($values)
    {
        $this->dbr->where_in($this->primary_key, $values);

        return $this->find_all();
    }

    //--------------------------------------------------------------------

    /**
     * Retrieves a number of items based on an arbitrary WHERE call. Can be
     * any set of parameters valid to $db->where.
     *
     * @return object or FALSE
     */
    public function find_many_by()
    {
        $where = func_get_args();
        $this->_set_where($where, 'dbr');

        return $this->find_all();
    }

    //--------------------------------------------------------------------

    /**
     * Fetch all of the records in the table. Can be used with scoped calls
     * to restrict the results.
     *
     * @return object or FALSE
     */
    public function find_all()
    {
        $this->trigger('before_find');

        // Ignore any soft-deleted rows
        if ($this->soft_deletes && $this->temp_with_deleted !== TRUE)
        {
            $this->dbr->where($this->table_name.'.'.$this->soft_delete_key, FALSE);
        }

        $rows = $this->db->get($this->table_name);
        $rows = $rows->{$this->_return_type(true)}();

        if (is_array($rows))
        {
            foreach ($rows as $key => &$row)
            {
                $row = $this->trigger('after_find', $row, ($key == count($rows) - 1));
            }
        }

        if ($this->temp_return_type == 'json')
        {
            $rows = json_encode($rows);
        }

        // Reset our return type
        $this->temp_return_type = $this->return_type;

        return $rows;
    }

    //--------------------------------------------------------------------

    /**
     * Inserts data into the database.
     *
     * @param  array $data An array of key/value pairs to insert to database.
     *
     * @return mixed       The primary_key value of the inserted record, or FALSE.
     */
    public function insert($data)
    {
        $data = $this->trigger('before_insert', $data);

        if ($this->skip_validation === FALSE)
        {
            $data = $this->validate($data, 'insert');

            // If $data is false, we didn't validate
            // so we need to get out of here.
            if ( ! $data)
            {
                return FALSE;
            }
        }

        if($this->set_created and empty($data[$this->created_field]))
        {
            $data[$this->created_field] = $this->set_date();
        }

        if($this->log_user)
        {
            $data[$this->created_by_field] = $this->auth->user_id();
        }

        $this->dbw->insert($this->table_name, $data);

        if ($this->return_insert_id)
        {
            $id = $this->dbw->insert_id();

            $this->trigger('after_insert', $id);
        }
        else
        {
            $id = true;
        }

        return $id;
    }

    //--------------------------------------------------------------------

    /**
     * Inserts multiple rows into the database at once. Takes an associative
     * array of value pairs.
     *
     * $data = array(
     *     array(
     *         'title' => 'My title'
     *     ),
     *     array(
     *         'title'  => 'My Other Title'
     *     )
     * );
     *
     * @param  array $data An associate array of rows to insert
     *
     * @return bool
     */
    public function insert_batch($data)
    {
        if ($this->skip_validation === FALSE)
        {
            $data = $this->validate($data, 'insert');
            if ( ! $data)
            {
                return FALSE;
            }
        }

        $data['batch'] = true;
        $data = $this->trigger('before_insert', $data);

        unset($data['batch']);

        return $this->dbw->insert_batch($this->table_name, $data);
    }

    //--------------------------------------------------------------------

    /**
     * Updates an existing record in the database.
     *
     * @param  mixed $id   The primary_key value of the record to update.
     * @param  array $data An array of value pairs to update in the record.
     * @return bool
     */
    public function update($id, $data)
    {
        $data = $this->trigger('before_update', $data);

        if ($this->skip_validation === FALSE)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return FALSE;
            }
        }

        $this->dbw->where($this->primary_key, $id);

        if ($this->log_user)
        {
            $data[$this->modified_by_field] = $this->auth->user_id();
        }

        $this->dbw->set($data);

        $result = $this->dbw->update($this->table_name);

        $this->trigger('after_update', array($data, $result));

        return $result;
    }

    //--------------------------------------------------------------------

    /**
     * Updates multiple records in the database at once.
     *
     * $data = array(
     *     array(
     *         'title'  => 'My title',
     *         'body'   => 'body 1'
     *     ),
     *     array(
     *         'title'  => 'Another Title',
     *         'body'   => 'body 2'
     *     )
     * );
     *
     * The $where_key should be the name of the column to match the record on.
     * If $where_key == 'title', then each record would be matched on that
     * 'title' value of the array. This does mean that the array key needs
     * to be provided with each row's data.
     *
     * @param  array $data      An associate array of row data to update.
     * @param  string $where_key The column name to match on.
     * @return bool
     */
    public function update_batch($data, $where_key)
    {
        foreach ($data as &$row)
        {
            $row = $this->trigger('before_update', $row);
        }

        $result = $this->dbw->update_batch($this->table_name, $data, $where_key);

        foreach ($data as &$row)
        {
            $this->trigger('after_update', array($row, $result));
        }

        return $result;
    }

    //--------------------------------------------------------------------

    /**
     * Updates many records by an array of ids.
     *
     * While update_batch() allows modifying multiple, arbitrary rows of data
     * on each row, update_many() sets the same values for each row.
     *
     * $ids = array(1, 2, 3, 5, 12);
     * $data = array(
     *     'deleted_by' => 1
     * );
     *
     * $this->model->update_many($ids, $data);
     *
     * @param  array $ids  An array of primary_key values to update.
     * @param  array $data An array of value pairs to modify in each row.
     * @return bool
     */
    public function update_many($ids, $data)
    {
        $data = $this->trigger('before_update', $data);

        if ($this->skip_validation === FALSE)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return FALSE;
            }
        }

        $this->dbw->where_in($this->primary_key, $ids);
        $this->dbw->set($data);
        $result = $this->dbw->update($this->table_name);

        $this->trigger('after_update', array($data, $result));

        return $result;
    }

    //--------------------------------------------------------------------

    /**
     * Update records in the database using a standard WHERE clause.
     *
     * Your last parameter should be the $data array with values to update
     * on the rows. Any additional parameters should be provided to make up
     * a typical WHERE clause. This could be a single array, or a column name
     * and a value.
     *
     * $data = array('deleted_by' => 1);
     * $wheres = array('user_id' => 15);
     *
     * $this->update_by($wheres, $data);
     * $this->update_by('user_id', 15, $data);
     *
     * @param array $data An array of data pairs to update
     * @param one or more WHERE-acceptable entries.
     * @return bool
     */
    public function update_by()
    {
        $args = func_get_args();
        $data = array_pop($args);
        $this->_set_where($args, 'dbw');

        $data = $this->trigger('before_update', $data);

        if ($this->skip_validation === FALSE)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return FALSE;
            }
        }

        $this->dbw->set($data);
        $result = $this->dbw->update($this->table_name);

        $this->trigger('after_update', array($data, $result));

        return $result;
    }

    //--------------------------------------------------------------------

    /**
     * Updates all records and sets the value pairs passed in the array.
     *
     * @param  array $data An array of value pairs with the data to change.
     * @return bool
     */
    public function update_all($data)
    {
        $data = $this->trigger('before_update', $data);

        if ($skip_validation === FALSE)
        {
            $data = $this->validate($data);
            if ( ! $data)
            {
                return FALSE;
            }
        }

        $this->dbw->set($data);
        $result = $this->dbw->update($this->table_name);

        $this->trigger('after_update', array($data, $result));

        return $result;
    }

    //--------------------------------------------------------------------

    /**
     * Deletes a row by it's primary key value.
     *
     * @param  mixed $id The primary key value of the row to delete.
     * @return bool
     */
    public function delete($id)
    {
        $this->trigger('before_delete', $id);

         $this->dbw->where($this->primary_key, $id);

        if ($this->soft_deletes)
        {
            $sets = $this->log_user ? array($this->soft_delete_key => 1, $this->deleted_by_field => $this->auth->user_id()) : array($this->soft_delete_key => 1);

            $result = $this->dbw->update($this->table_name, $sets);
        }

        // Hard Delete
        else {
            $result = $this->dbw->delete($this->table_name);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }

    //--------------------------------------------------------------------

    public function delete_by()
    {
        $where = func_get_args();
        $this->_set_where($where, 'dbw');

        $where = $this->trigger('before_delete', $where);

        if ($this->soft_deletes)
        {
            $sets = $this->log_user ? array($this->soft_delete_key => 1, $this->deleted_by_field => $this->auth->user_id()) : array($this->soft_delete_key => 1);

            $result = $this->dbw->update($this->table_name, $sets);
        }
        else
        {
            $result = $this->dbw->delete($this->table_name);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }

    //--------------------------------------------------------------------

    /**
     * A convenience method to delete many rows of data when you have an
     * array of id's to delete. The same thing as:
     *
     *      $this->model->where_in($ids)->delete();
     *
     * @param  array $ids An array of primary keys to be deleted.
     */
    public function delete_many($ids)
    {
        $ids = $this->trigger('before_delete', $ids);

        $this->dbw->where_in($ids);

        if ($this->soft_deletes)
        {
            $sets = $this->log_user ? array($this->soft_delete_key => 1, $this->deleted_by_field => $this->auth->user_id()) : array($this->soft_delete_key => 1);

            $result = $this->dbw->update($this->table_name, $sets);
        }
        else
        {
            $result = $this->dbw->delete($this->table_name);
        }

        $this->trigger('after_delete', $result);

        return $result;
    }

    //--------------------------------------------------------------------

    /**
     * Empty a table.
     *
     * @param $table String Table name.
     * @return mixed
     */
    public function empty_table($table = NULL)
    {
        return $this->db->empty_table($table);
    }

    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
    // Scope Methods
    //--------------------------------------------------------------------

    /**
     * Sets the value of the soft deletes flag.
     *
     * @param  boolean $val If TRUE, should perform a soft delete. If FALSE, a hard delete.
     */
    public function soft_delete($val=TRUE)
    {
        $this->soft_deletes = $val;

        return $this;
    }

    //--------------------------------------------------------------------

    /**
     * Temporarily sets our return type to an array.
     */
    public function as_array()
    {
        $this->temp_return_type = 'array';

        return $this;
    }

    //--------------------------------------------------------------------

    /**
     * Temporarily sets our return type to an object.
     */
    public function as_object()
    {
        $this->temp_return_type = 'object';

        return $this;
    }

    //--------------------------------------------------------------------

    /**
     * Temporarily sets our object return to a json object.
     */
    public function as_json()
    {
        $this->temp_return_type = 'json';

        return $this;
    }

    //--------------------------------------------------------------------


    /**
     * Also fetches deleted items for this request only.
     */
    public function with_deleted()
    {
        $this->temp_with_deleted = TRUE;

        return $this;
    }

    //--------------------------------------------------------------------

    /**
     * Sets the value of the skip_validation flag
     *
     * @param Bool $skip (optional) whether to skip validation in the model
     *
     * @return Object    returns $this to allow method chaining
     */
    public function skip_validation($skip=TRUE)
    {
        $this->skip_validation = $skip;

        return $this;
    }

    //--------------------------------------------------------------------


    //--------------------------------------------------------------------
    // Utility Methods
    //--------------------------------------------------------------------

    /**
     * Counts number of rows modified by an arbitrary WHERE call.
     * @return INT
     */
    public function count_by()
    {
        $where = func_get_args();
        $this->_set_where($where, 'dbr');

        return $this->dbr->count_all_results($this->table_name);
    }

    //--------------------------------------------------------------------

    /**
     * Counts total number of records, disregarding any previous conditions.
     *
     * @return int
     */
    public function count_all()
    {
        return $this->dbr->count_all($this->table_name);
    }

    //--------------------------------------------------------------------

    /**
     * Getter for the table name.
     *
     * @return string The name of the table used by this class.
     */
    public function table()
    {
        return $this->table_name;
    }

    //--------------------------------------------------------------------

    /**
     * A convenience method to return options for form dropdown menus.
     *
     * Can pass either Key ID and Label Table names or Just Label Table name.
     *
     * @return array The options for the dropdown.
     */
    function format_dropdown()
    {
        $args = func_get_args();

        if (count($args) == 2)
        {
            list($key, $value) = $args;
        }
        else
        {
            $key = $this->primary_key;
            $value = $args[0];
        }

        $query = $this->dbr->select(array($key, $value))->get($this->table_name);

        $options = array();
        foreach ($query->result() as $row)
        {
            $options[$row->{$key}] = $row->{$value};
        }

        return $options;

    }

    //--------------------------------------------------------------------

    /**
     * A convenience method to return only a single field of the specified row.
     *
     * @param mixed  $id    The primary_key value to match against.
     * @param string $field The field to search for.
     *
     * @return bool|mixed The value of the field.
     */
    public function get_field($id=NULL, $field='')
    {
        $this->dbr->select($field);
        $this->dbr->where($this->primary_key, $id);
        $query = $this->dbr->get($this->table);

        if ($query && $query->num_rows() > 0)
        {
            return $query->row()->$field;
        }

        return FALSE;

    }

    //---------------------------------------------------------------

    /**
     * Checks whether a field/value pair exists within the table.
     *
     * @param string $field The field to search for.
     * @param string $value The value to match $field against.
     *
     * @return bool TRUE/FALSE
     */
    public function is_unique($field, $value)
    {
        $this->dbr->where($field, $value);
        $query = $this->dbr->get($this->table_name);

        if ($query && $query->num_rows() == 0)
        {
            return TRUE;
        }

        return FALSE;

    }

    //---------------------------------------------------------------

    //--------------------------------------------------------------------
    // Observers
    //--------------------------------------------------------------------

    /**
     * Sets the created on date for the object based on the
     * current date/time and date_format. Will not overwrite existing.
     *
     * @param array  $row  The array of data to be inserted
     *
     * @return array
     */
    public function created_on($row)
    {
        if (!array_key_exists($this->created_field, $row))
        {
            $row[$this->created_field] = $this->set_date();
        }

        return $row;
    } // end created_on()

    //--------------------------------------------------------------------

    /**
     * Sets the modified_on date for the object based on the
     * current date/time and date_format. Will not overwrite existing.
     *
     * @param array  $row  The array of data to be inserted
     *
     * @return array
     */
    public function modified_on($row)
    {
        if (!array_key_exists($this->modified_field, $row))
        {
            $row[$this->modified_field] = $this->set_date();
        }

        return $row;
    }

    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
    // Internal Methods
    //--------------------------------------------------------------------

    /**
     * Return the method name for the current return type
     */
    protected function _return_type($multi = FALSE)
    {
        $method = ($multi) ? 'result' : 'row';

        // If our type is either 'array' or 'json', we'll simply use the array version
        // of the function, since the database library doesn't support json.
        return $this->temp_return_type == 'array' ? $method . '_array' : $method;
    }

    //--------------------------------------------------------------------

    /**
     * Set WHERE parameters
     */
    protected function _set_where($params, $db_type)
    {
        if (count($params) == 1)
        {
            $this->{$db_type}->where($params[0]);
        }
        else
        {
            $this->{$db_type}->where($params[0], $params[1]);
        }
    }

    //--------------------------------------------------------------------

    /**
     * Triggers a model-specific event and call each of it's observers.
     *
     * @param string    $event  The name of the event to trigger
     * @param mixed     $data   The data to be passed to the callback functions.
     *
     * @return mixed
     */
    public function trigger($event, $data=false)
    {
        if (!isset($this->$event) || !is_array($this->$event))
        {
            return $data;
        }

        foreach ($this->$event as $method)
        {
            if (strpos($method, '('))
            {
                preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);
                $this->callback_parameters = explode(',', $matches[3]);
            }

            $data = call_user_func_array(array($this, $method), array($data));
        }

        return $data;
    }
    
    /**
     * Get the validation rules for the model.
     *
     * @uses $empty_validation_rules Observer to generate validation rules if
     * they are empty.
     *
     * @param string $type The type of validation rules to retrieve: 'update' or
     * 'insert'. If 'insert', appends rules set in $insert_validation_rules.
     *
     * @return array The validation rules for the model or an empty array.
     */
    public function get_validation_rules($type = 'update')
    {
        $temp_validation_rules = $this->validation_rules;
        // When $validation_rules is empty (or not an array), try to generate the
        // rules by triggering the $empty_validation_rules observer.
        if (empty($temp_validation_rules) || ! is_array($temp_validation_rules)) {
            $temp_validation_rules = $this->trigger('empty_validation_rules', $temp_validation_rules);
            if (empty($temp_validation_rules) || ! is_array($temp_validation_rules)) {
                return [];
            }
            // If the observer returns a non-empty array, prevent calling it again
            // for this instance of the model.
            $this->validation_rules = $temp_validation_rules;
        }
        // If this is not an insert or there are no insert rules, it's time to go.
        if ($type != 'insert'
            || ! is_array($this->insert_validation_rules)
            || empty($this->insert_validation_rules)
        ) {
            return $temp_validation_rules;
        }
        // Update the validation rules with the insert rules.
        // Get the index for each field in the validation rules.
        $fieldIndexes = [];
        foreach ($temp_validation_rules as $key => $validation_rule) {
            $fieldIndexes[$validation_rule['field']] = $key;
        }
        foreach ($this->insert_validation_rules as $key => $rule) {
            if (is_array($rule)) {
                $insert_rule = $rule;
            } else {
                // If $key isn't a field name and $insert_rule isn't an array,
                // there's nothing useful to do, so skip it.
                if (is_numeric($key)) {
                    continue;
                }
                $insert_rule = [
                    'field' => $key,
                    'rules' => $rule,
                ];
            }
            // If the field is already in the validation rules, update the
            // validation rule to merge the insert rule (replace empty rules).
            if (isset($fieldIndexes[$insert_rule['field']])) {
                $fieldKey = $fieldIndexes[$insert_rule['field']];
                if (empty($temp_validation_rules[$fieldKey]['rules'])) {
                    $temp_validation_rules[$fieldKey]['rules'] = $insert_rule['rules'];
                } else {
                    $temp_validation_rules[$fieldKey]['rules'] .= "|{$insert_rule['rules']}";
                }
            } else {
                // Otherwise, add the insert rule to the validation rules
                $temp_validation_rules[] = $insert_rule;
            }
        }
        return $temp_validation_rules;
    }

    //--------------------------------------------------------------------

    /**
     * Adds the 'required' rule to the field's validation rules if exists.
     *
     * @param  string $field The name of the field to require
     * @return void
     */
    public function require_field($field)
    {
        if ( ! is_array($this->validation_rules) || ! count($this->validation_rules) )
        {
            return;
        }

        // If $field is an array, run them all through
        // this same method.
        if (is_array($field))
        {
            foreach ($field as $f)
            {
                $this->require_field($f);
            }

            return;
        }

        if ( ! is_string($field))
        {
            return;
        }

        for ($i = 1; $i < count($this->validation_rules); $i++)
        {
            if ($this->validation_rules[$i]['field'] == $field)
            {
                if (strpos($this->validation_rules[$i]['rules'], 'required'))
                {
                    // Already requiring this field.
                    break;
                }

                $this->validation_rules[$i]['rules'] = 'required|'. $this->validation_rules[$i]['rules'];
                break;
            }
        }
    }

    //--------------------------------------------------------------------

    /**
     * Validates the data passed into it based upon the form_validation rules
     * setup in the $this->validate property.
     *
     * @param  array $data      An array of validation rules
     * @param string $type      Either 'insert' or 'update'
     *
     * @return array/bool       The original data or FALSE
     */
    public function validate($data, $type='update') // x
    {
        if ($this->skip_validation === TRUE)
        {
            return $data;
        }

        if ( ! empty($this->validation_rules))
        {
            // We have to add/override the values to the
            // $_POST vars so that form_validation library
            // can work with them.
            foreach($data as $key => $val)
            {
                $_POST[$key] = $val;
            }

            $this->load->library('form_validation');

            if (is_array($this->validation_rules))
            {
                // If $type == 'insert', then we need to incorporate the
                // $insert_validation_rules.
                if ($type == 'insert'
                    && is_array($this->insert_validation_rules)
                    && count($this->insert_validation_rules))
                {
                    foreach ($this->validation_rules as &$row)
                    {
                        if (isset($this->insert_validation_rules[$row['field']]))
                        {
                            $row['rules'] = $this->insert_validation_rules[$row['field']] .'|'. $row['rules'];
                        }
                    }
                }

                // Now validate!
                $this->form_validation->set_rules($this->validation_rules);

                if ($this->form_validation->run() === TRUE)
                {
                    return $data;
                }
                else
                {
                    return FALSE;
                }
            }
            // It could be a string representing the name of a rule group
            // if you're saving the rules in a config file.
            else
            {
                if ($this->form_validation->run($this->validation_rules) === TRUE)
                {
                    return $data;
                }
                else
                {
                    return FALSE;
                }
            }
        }
        else
        {
            return $data;
        }
    }

    //--------------------------------------------------------------------

    /**
     * Protect attributes by removing them from $row array. Useful for
     * removing id, or submit buttons names if you simply throw your $_POST
     * array at your model. :)
     *
     * @param object/array $row The value pair item to remove.
     */
    public function protect_attributes($row)
    {
        foreach ($this->protected_attributes as $attr)
        {
            if (is_object($row))
            {
                unset($row->$attr);
            }
            else
            {
                unset($row[$attr]);
            }
        }

        return $row;
    }

    //--------------------------------------------------------------------

    /**
     * A utility function to allow child models to use the type of
     * date/time format that they prefer. This is primarily used for
     * setting created_on and modified_on values, but can be used by
     * inheriting classes.
     *
     * The available time formats are:
     * * 'int'      - Stores the date as an integer timestamp.
     * * 'datetime' - Stores the date and time in the SQL datetime format.
     * * 'date'     - Stores teh date (only) in the SQL date format.
     *
     * @param mixed $user_date An optional PHP timestamp to be converted.
     *
     * @access protected
     *
     * @return int|null|string The current/user time converted to the proper format.
     */
    protected function set_date($user_date=NULL)
    {
        // $curr_date = !empty($user_date) ? $user_date : now();//time();
        //if(!$user_date == null)
        //    $curr_date = time();

        switch ($this->date_format)
        {
            case 'int':
                return time();//$curr_date;
                break;
            case 'datetime':
                return date('Y-m-d H:i:s');//, $curr_date);
                break;
            case 'date':
                return date( 'Y-m-d');//, $curr_date);
                break;
        }

    }//end set_date()

    //--------------------------------------------------------------------

    /**
     * Allows you to retrieve error messages from the database
     *
     * @return string
     */
    public function get_db_error_message($db_type)
    {
        switch ($this->{$db_type}->platform())
        {
            case 'cubrid':
                return cubrid_errno($this->{$db_type}->conn_id);
            case 'mssql':
                return mssql_get_last_message();
            case 'mysql':
                return mysql_error($this->{$db_type}->conn_id);
            case 'mysqli':
                return mysqli_error($this->{$db_type}->conn_id);
            case 'oci8':
                // If the error was during connection, no conn_id should be passed
                $error = is_resource($this->{$db_type}->conn_id) ? oci_error($this->{$db_type}->conn_id) : oci_error();
                return $error['message'];
            case 'odbc':
                return odbc_errormsg($this->{$db_type}->conn_id);
            case 'pdo':
                $error_array = $this->{$db_type}->conn_id->errorInfo();
                return $error_array[2];
            case 'postgre':
                return pg_last_error($this->{$db_type}->conn_id);
            case 'sqlite':
                return sqlite_error_string(sqlite_last_error($this->{$db_type}->conn_id));
            case 'sqlsrv':
                $error = array_shift(sqlsrv_errors());
                return !empty($error['message']) ? $error['message'] : null;
            default:
                /*
                 * !WARNING! $this->{$db_type}->_error_message() is supposed to be private and
                 * possibly won't be available in future versions of CI
                 */
                return $this->{$db_type}->_error_message();
        }
    }

    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
    // CI Database  Wrappers
    //--------------------------------------------------------------------
    // To allow for more expressive syntax, we provide wrapper functions
    // for most of the query builder methods here.
    //
    // This allows for calls such as:
    //      $result = $this->model->select('...')
    //                            ->where('...')
    //                            ->having('...')
    //                            ->get();
    //

    public function select ($select = '*', $escape = NULL) { $this->dbr->select($select, $escape); return $this; }
    public function select_max ($select = '', $alias = '') { $this->dbr->select_max($select, $alias); return $this; }
    public function select_min ($select = '', $alias = '') { $this->dbr->select_min($select, $alias); return $this; }
    public function select_avg ($select = '', $alias = '') { $this->dbr->select_avg($select, $alias); return $this; }
    public function select_sum ($select = '', $alias = '') { $this->dbr->select_sum($select, $alias); return $this; }
    public function distinct ($val=TRUE) { $this->dbr->distinct($val); return $this; }
    public function from ($from) { $this->dbr->from($from); return $this; }
    public function join($table, $cond, $type = '') { $this->dbr->join($table, $cond, $type); return $this; }
    public function where($key, $value = NULL, $escape = TRUE) { $this->dbr->where($key, $value, $escape); return $this; }
    public function or_where($key, $value = NULL, $escape = TRUE) { $this->dbr->or_where($key, $value, $escape); return $this; }
    public function where_in($key = NULL, $values = NULL) { $this->dbr->where_in($key, $values); return $this; }
    public function or_where_in($key = NULL, $values = NULL) { $this->dbr->or_where_in($key, $values); return $this; }
    public function where_not_in($key = NULL, $values = NULL) { $this->dbr->where_not_in($key, $values); return $this; }
    public function or_where_not_in($key = NULL, $values = NULL) { $this->dbr->or_where_not_in($key, $values); return $this; }
    public function like($field, $match = '', $side = 'both') { $this->dbr->like($field, $match, $side); return $this; }
    public function not_like($field, $match = '', $side = 'both') { $this->dbr->not_like($field, $match, $side); return $this; }
    public function or_like($field, $match = '', $side = 'both') { $this->dbr->or_like($field, $match, $side); return $this; }
    public function or_not_like($field, $match = '', $side = 'both') { $this->dbr->or_not_like($field, $match, $side); return $this; }
    public function group_by($by) { $this->dbr->group_by($by); return $this; }
    public function having($key, $value = '', $escape = TRUE) { $this->dbr->having($key, $value, $escape); return $this; }
    public function or_having($key, $value = '', $escape = TRUE) { $this->dbr->or_having($key, $value, $escape); return $this; }
    public function order_by($orderby, $direction = '') { $this->dbr->order_by($this->table_name.'.'.$orderby, $direction); return $this; }
    public function limit($value, $offset = '') { $this->dbr->limit($value, $offset); return $this; }
    public function offset($offset) { $this->dbr->offset($offset); return $this; }
    public function set($key, $value = '', $escape = TRUE) { $this->dbw->set($key, $value, $escape); return $this; }
    public function count_all_results() { $this->dbr->count_all_results($this->table_name); return $this; }

}
