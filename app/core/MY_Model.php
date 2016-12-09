<?php 
/**
 * WPanel CMS
 *
 * An open source Content Manager System for blogs and websites using CodeIgniter and PHP.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2016, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     WpanelCms
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @copyright   Copyright (c) 2008 - 2016, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanelcms.com.br
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Model Model Class
 *
 * This class maintain the common code for the WpanelCMS Models.
 *
 * @package     WpanelCms
 * @subpackage  Core
 * @category    Core
 * @author      Eliel de Paula <dev@elieldepaula.com.br>
 * @link        https://wpanelcms.com.br
 * @version     0.0.1
 */
class MY_Model extends CI_Model
{
    /**
     * The name of table in the database.
     *
     * @var $table_name string
     **/
    public $table_name;

    /**
     * The name of primary-key of the table.
     *
     * @var $primary_key string
     **/
    public $primary_key;
    
    /**
     * Class constructor.
     */
    function __construct() 
    {
        $this->load->database();
        parent::__construct();
    }

    /**
     * This method returns a list of content.
     *
     * @param $order array Order results: ['field'=>'field name', 'order'=>'asc/desc'].
     * @param $limit array Limit results: ['offset'=>'0', 'limit'=>'10'].
     * @param $select string List of selected fields: "name, email, phone".
     * @return mixed
     */
    public function get_list($order = array(), $limit = array(), $select = null)
    {
        if ($select != null)
            $this->db->select($select);
        
        if ((is_array($order)) and (count($order)!=0)) 
            $this->db->order_by($order['field'], $order['order']);

        if((is_array($limit)) and (count($limit) != 0))
            $this->db->limit($limit['limit'], $limit['offset']);
        
        return $this->db->get($this->table_name);
    }
    
    /**
     * This method returns a record indicated by the primary key.
     * 
     * @param $value int - The primary key value.
     * @param $order array Order results: ['field'=>'field name', 'order'=>'asc/desc'].
     * @param $limit array Limit results: ['offset'=>'0', 'limit'=>'10'].
     * @param $select string List of selected fields: "name, email, phone".
     * @return mixed
     */
    public function get_by_id($value = null, $order = array(), $limit = array(), $select = null) 
    {
        if($value == null)
            return FALSE;
        else
            return $this->get_by_field($this->primary_key, $value, $order, $limit, $select);
    }

    /**
     * This method is similar to get_by_id () except that with 
     * him, we inform the field that will be used as a filter.
     *
     * @param $field string - Field that will be used as a filter.
     * @param $value string - Value to be filtred. If $field is an array(), this param must be null.
     * @param $order array Order results: ['field'=>'field name', 'order'=>'asc/desc'].
     * @param $limit array Limit results: ['offset'=>'0', 'limit'=>'10'].
     * @param $select string List of selected fields: "name, email, phone".
     * @return mixed
     */
    public function get_by_field($field, $value = null, $order = array(), $limit = array(), $select = null)
    {
        if ($select != null) 
            $this->db->select($select);
        
        if (is_array($field))
        {
            foreach ($field as $key => $val) 
            {
                $this->db->where($key, $val);
            }
        } 
        else 
            $this->db->where($field, $value);

        if ((is_array($order)) and (count($order)!=0)) 
            $this->db->order_by($order['field'], $order['order']);

        if((is_array($limit)) and (count($limit) != 0))
            $this->db->limit($limit['limit'], $limit['offset']);

        return $this->db->get($this->table_name);
    }

    /**
     * This method returns the total number of table records.
     *
     * @return int
     */
    public function count_all() 
    {
        return $this->db->count_all($this->table_name);
    }

    /**
     * This method returns the total of an where clausule.
     * 
     * @param string $field
     * @param string $value
     * @return int
     */
    public function count_by($field, $value)
    {
        $this->db->where($field, $value);
        $this->db->from($this->table_name);
        return $this->db->count_all_results();
    }
    
    /**
     * Save a new record.
     *
     * @param $dados array Array data..
     * @return mixed
     */
    public function save($dados)
    {
        $this->db->insert($this->table_name, $dados);
        return $this->db->insert_id();
    }
    
    /**
     * Update a record.
     *
     * @param $id int - Primary-key value.
     * @param $dados array Array data.
     * @return mixed
     **/
    public function update($id, $dados)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->update($this->table_name, $dados);
        return $this->db->affected_rows();
    }

    /**
     * Delete a record.
     *
     * @param $id int Primary-key.
     * @return mixed
     */
    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
    }

    /**
     * Delete a record by some field.
     *
     * @param $field String Field of the table.
     * @param $value int Value of the field.
     * @param $table string Optional table name.
     * @return mixed
     */
    public function delete_by($field, $value, $table = NULL)
    {
        $this->db->where($field, $value);
        if($table == NULL)
            $this->db->delete($this->table_name);
        else
            $this->db->delete($table);
        return $this->db->affected_rows();
    }

    /**
     * Upload a file.
     * 
     * @param $path String Path where the file must be saved.
     * @param $types String File type: gif|jpg|png.
     * @param $fieldname String Field name of the form.
     * @param $filename String Optional file name..
     * @return mixed
     */
    public function upload_media($path, $types = '*', $fieldname = 'userfile', $filename = null)
    {
        $config['upload_path'] = FCPATH.'media/'.$path.'/';
        $config['remove_spaces'] = TRUE;
        $config['file_ext_tolower'] = TRUE;
        $config['allowed_types'] = $types;
        if($filename == null)
            $config['file_name'] = md5(date('YmdHis'));
        else
            $config['file_name'] = $filename;
        
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($fieldname))
        {
            $upload_data = array();
            $upload_data = $this->upload->data();
            return $upload_data['file_name'];
        } else
            return false;
    }

    /**
     * Remove an uploaded file.
     *
     * @param $file String - Full path to the file.
     * @return boolean
     */
    public function remove_media($file)
    {
        $filename = FCPATH.'media/'.$file;
        if(file_exists($filename))
        {
            if(unlink($filename))
                return TRUE;
             else
                return FALSE;
        } else
            return FALSE;
    }
}