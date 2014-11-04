<?php

/**
 * Model class for Newsletters emails.
 *
 * @package default
 * @author 
 **/
class newsletter extends MY_Model
{
	/**
	 * Nome da tabela.
	 *
	 * @var $table_name string
	 **/
	public $table_name = 'newsletter_email';

	/**
	 * Nome do campo que é a chave-primária da tabela.
	 *
	 * @var $primary_key string
	 **/
	public $primary_key = 'id';

} // END class 