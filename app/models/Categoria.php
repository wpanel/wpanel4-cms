<?php

/**
 * WPanel CMS
 *
 * An open source Content Manager System for websites and systems using CodeIgniter.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2008 - 2017, Eliel de Paula.
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
 * @copyright   Copyright (c) 2008 - 2017, Eliel de Paula. (https://elieldepaula.com.br/)
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://wpanel.org
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends MY_Model
{

    public $table_name = 'categories';
    public $primary_key = 'id';

    /**
     * This method return the categories by post.
     * 
     * @param int $post_id Post Id.
     * @param string $order Order sort.
     * @param array $limit Limit array.
     * @return mixed
     */
    public function get_by_post($post_id = 0, $order = 'asc', $limit = array())
    {
        $this->db->select('categories.*, posts_categories.post_id, posts_categories.category_id');
        $this->db->from($this->table_name);
        $this->db->join('posts_categories', 'posts_categories.category_id = categories.id');
        $this->db->where('posts_categories.post_id', $post_id);
        if ((is_array($limit)) and ( count($limit) != 0))
            $this->db->limit($limit['limit'], $limit['offset']);

        return $this->db->get();
    }

    /**
     * this method returns the category title by category Id.
     * 
     * @param int $id category Id.
     * @return mixed
     */
    public function get_title_by_id($id)
    {
        if ($id)
        {
            $query = $this->get_by_id($id, null, null, 'title')->row();
            return $query->title;
        } else
            return false;
    }

    /**
     * This method delete categories by the fathcr' category.
     * 
     * @param int $id Father' category Id.
     * @return mixed
     */
    public function delete_son($id)
    {
        $this->db->where('category_id', $id);
        $this->db->delete($this->table_name);
        return $this->db->affected_rows();
    }

}
