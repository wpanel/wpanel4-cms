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

class Post extends MY_Model
{

    public $table_name = 'posts';
    public $primary_key = 'id';

    /**
     * Este método faz uma consulta retornando as postagens e as suas
     * categorias de acordo com o código da categoria.
     *
     * @return mixed
     * @param $category_id int Código da categoria.
     * @param $order  string Tipo de ordenação do resultado ASC ou DESC.
     * @param $limit array Um array com os detalhes de limite, Ex: array('offset'=>'0', 'limit'=>'10')
     * @author Eliel de Paula <elieldepaula@gmail.com>
     * */
    public function get_by_category($category_id = 0, $order = 'asc', $limit = array())
    {
        $this->db->select('posts.*, posts_categories.post_id, posts_categories.category_id');
        $this->db->from($this->table_name);
        $this->db->join('posts_categories', 'posts_categories.post_id = posts.id');
        $this->db->where('posts_categories.category_id', $category_id);
        $this->db->where('posts.status', '1');
        $this->db->order_by('created', $order);
        if ((is_array($limit)) and ( count($limit) != 0))
            $this->db->limit($limit['limit'], $limit['offset']);
        
        return $this->db->get();
    }

    /**
     * Este método faz a pesquisa de uma palavra ou frase no título
     * e no corpo da postagem.
     *
     * @return mixed
     * @author Eliel de Paula <elieldepaula@gmail.com>
     * */
    public function busca_posts($search = null)
    {
        if ($search)
        {
            $this->db->like('title', $search, 'both');
            $this->db->or_like('content', $search, 'both');
            $this->db->or_like('tags', $search, 'both');
        }

        $this->db->where('status', '1');
        $this->db->order_by('created', 'desc');

        return $this->db->get($this->table_name);
    }

}
