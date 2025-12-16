<?php

namespace App\Controller;

use App\Controller\Config;

class Db
{
	public $config;
	public $conn;
	function __construct()
	{
		$Config = new Config();
		$this->config = $Config->get_data();

		$db_servername = "192.168.9.196";
		$db_username = "postgreadmin";
		$db_password = "postgreadmin";
		//$db_name = "backoffice";
		
		$db_name = "bollard_ozon";
		
		$dbPort = '5432';

		$conn = new \PDO("pgsql:host=$db_servername;port=$dbPort;dbname=$db_name", $db_username, $db_password);
		$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		$this->conn = $conn;
	}
	function insert_ozon_product_list($params)
	{
		// @params
		$product_id = $params['product_id'];
		$is_fbo_visible = $this->transformBoolean($params['is_fbo_visible']);
		$is_fbs_visible = $this->transformBoolean($params['is_fbs_visible']);
		$archived = $this->transformBoolean($params['archived']);
		$is_discounted = $this->transformBoolean($params['is_discounted']);

		$sqlstr = sprintf("
        INSERT INTO
          public.ozon_product_list
        (
          product_id,
              is_fbo_visible,
              is_fbs_visible,
              archived,
              is_discounted
        )
        VALUES (
          '%s', -- product_id
              '%s', -- is_fbo_visible
              '%s', -- is_fbs_visible
              '%s', -- archived
              '%s' -- is_discounted
        );
        ", $product_id, $is_fbo_visible, $is_fbs_visible, $archived, $is_discounted);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();

		$stmt = $this->conn->prepare("SELECT currval('ozon_product_list_id_seq')");
		$stmt->execute();
		$fetch = $stmt->fetchAll();

		$last_insert_id = $fetch[0]['currval'];
		return $last_insert_id;
	}
	function delete_ozon_product_list()
	{
		$sqlstr = sprintf("
		TRUNCATE TABLE public.ozon_product_list;
        ", null);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();

		return true;
	}
	function get_ozon_product_list($params)
	{
		// @params
		$sqlstr = sprintf("
			SELECT
              id,
			  product_id,
			  is_fbo_visible,
			  is_fbs_visible,
			  archived,
			  is_discounted
				
			FROM
			  public.ozon_product_list
			
			ORDER BY
			  id
            
				
			", null);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $rows;
	}
	function insert_ozon_product_info($params)
	{
		if (!isset($params['marketing_price']))
		{
			$params['marketing_price'] = 0;
		}

		if (!isset($params['price_with_ozon_card']))
		{
			$params['price_with_ozon_card'] = 0;
		}

		// @params
		$id_product_list = $params['id_product_list'];
		$product_id = $params['product_id'];
		$offer_id = $params['offer_id'];
		$images = $params['images'];
		$barcode = $params['barcode'];
		$name = $params['name'];
		$old_price = $params['old_price'];
		$price = $params['price'];
		$min_price = $params['min_price'];
		$marketing_price = $params['marketing_price'];
		$minimal_price = $params['minimal_price'];
		$price_with_ozon_card = $params['price_with_ozon_card'];
		$price_index_value = $params['price_index_value'];
		$stock_present = $params['stock_present'];
		$fbo_sku = $params['fbo_sku'];
		$fbs_sku = $params['fbs_sku'];
		$created_at = $params['created_at'];

		$sqlstr = sprintf("
        INSERT INTO
          public.ozon_product_info
        (
          id_product_list,
              product_id,
              offer_id,
              images,
              barcode,
              name,
              old_price,
              price,
              min_price,
              marketing_price,
              minimal_price,
              price_with_ozon_card,
              price_index_value,
              stock_present,
              fbo_sku,
              fbs_sku,
              created_at
        )
        VALUES (
          '%s', -- id_product_list
              '%s', -- product_id
              '%s', -- offer_id
              '%s', -- images
              '%s', -- barcode
              '%s', -- name
              '%s', -- old_price
              '%s', -- price
              '%s', -- min_price
              '%s', -- marketing_price
              '%s', -- minimal_price
              '%s', -- price_with_ozon_card
              '%s', -- price_index_value
              '%s', -- stock_present
              '%s', -- fbo_sku
              '%s', -- fbs_sku
              '%s' -- created_at
        );
        ", $id_product_list, $product_id, $offer_id, $images, $barcode, $name, $old_price, $price, $min_price, $marketing_price, $minimal_price, $price_with_ozon_card, $price_index_value, $stock_present, $fbo_sku, $fbs_sku, $created_at);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
	}
	function delete_ozon_product_info()
	{
		$sqlstr = sprintf("
		TRUNCATE TABLE public.ozon_product_info;
        ", null);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();

		return true;
	}
	function get_ozon_product_info($params)
	{
		$id_product_list = $params['id_product_list'];

		/*
		 // @params
		 $id = $params['id'];
		 $id_product_list = $params['id_product_list'];
		 $product_id = $params['product_id'];
		 $offer_id = $params['offer_id'];
		 $images = $params['images'];
		 $barcode = $params['barcode'];
		 $name = $params['name'];
		 $old_price = $params['old_price'];
		 $price = $params['price'];
		 $min_price = $params['min_price'];
		 $marketing_price = $params['marketing_price'];
		 $minimal_price = $params['minimal_price'];
		 $price_with_ozon_card = $params['price_with_ozon_card'];
		 $price_index_value = $params['price_index_value'];
		 $stock_present = $params['stock_present'];
		 $fbo_sku = $params['fbo_sku'];
		 $fbs_sku = $params['fbs_sku'];
		 $created_at = $params['created_at'];
		 */

		$sqlstr = sprintf("
			SELECT
              id,
			  id_product_list,
			  product_id,
			  offer_id,
			  images,
			  barcode,
			  name,
			  old_price,
			  price,
			  min_price,
			  marketing_price,
			  minimal_price,
			  price_with_ozon_card,
			  price_index_value,
			  stock_present,
			  fbo_sku,
			  fbs_sku,
			  created_at
				
			FROM
			  public.ozon_product_info
			WHERE
			  id_product_list = %s
			ORDER BY
			  id
				
			", $id_product_list);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $rows;
	}
	function get_ozon_product_info_only_barcode()
	{
		$sqlstr = sprintf("
							SELECT 
							  id,
							  id_product_list,
							  product_id,
							  offer_id,
							  images,
							  barcode,
							  name,
							  old_price,
							  price,
							  min_price,
							  marketing_price,
							  minimal_price,
							  price_with_ozon_card,
							  price_index_value,
							  stock_present,
							  fbo_sku,
							  fbs_sku,
							  created_at
							FROM
							  public.ozon_product_info
							WHERE
							  barcode IS NOT NULL 
							  AND barcode <> ''
										ORDER BY
										  id
				
			", null);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $rows;
	}
	function get_ozon_products_info_only_not_barcode()
	{
		$sqlstr = sprintf("
							SELECT
							  id,
							  id_product_list,
							  product_id,
							  offer_id,
							  images,
							  barcode,
							  name,
							  old_price,
							  price,
							  min_price,
							  marketing_price,
							  minimal_price,
							  price_with_ozon_card,
							  price_index_value,
							  stock_present,
							  fbo_sku,
							  fbs_sku,
							  created_at
							FROM
							  public.ozon_product_info
							WHERE
							  barcode = ''
							  
										ORDER BY
										  id
				
			", null);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $rows;
	}
	function get_ozon_products_info_price_ozon_card($count)
	{
		$sqlstr = sprintf("
							SELECT
							  id,
							  id_product_list,
							  product_id,
							  offer_id,
							  images,
							  barcode,
							  name,
							  old_price,
							  price,
							  min_price,
							  marketing_price,
							  minimal_price,
							  price_with_ozon_card,
							  price_index_value,
							  stock_present,
							  fbo_sku,
							  fbs_sku,
							  created_at
							FROM
							  public.ozon_product_info
							WHERE
							  price_with_ozon_card > 0
							ORDER BY
							  id
                            LIMIT %s
				
			", $count);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $rows;
	}
	function get_ozon_products_info_price_ozon_card_otbor($count)
	{
		$sqlstr = sprintf("
							SELECT
							  id,
							  id_product_list,
							  product_id,
							  offer_id,
							  images,
							  barcode,
							  name,
							  old_price,
							  price,
							  min_price,
							  marketing_price,
							  minimal_price,
							  price_with_ozon_card,
							  price_index_value,
							  stock_present,
							  fbo_sku,
							  fbs_sku,
							  created_at
							FROM
							  public.ozon_product_info
							WHERE
							  offer_id in (248772, 252450, 263384)
							ORDER BY
							  id
                            LIMIT %s
				
			", $count);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $rows;
	}
	function update_ozon_product_info_($params)
	{
		// @params
		$id = $params['id'];
		$id_product_list = $params['id_product_list'];
		$product_id = $params['product_id'];
		$offer_id = $params['offer_id'];
		$images = $params['images'];
		$barcode = $params['barcode'];
		$name = $params['name'];
		$old_price = $params['old_price'];
		$price = $params['price'];
		$min_price = $params['min_price'];
		$marketing_price = $params['marketing_price'];
		$minimal_price = $params['minimal_price'];
		$price_with_ozon_card = $params['price_with_ozon_card'];
		$price_index_value = $params['price_index_value'];
		$stock_present = $params['stock_present'];
		$fbo_sku = $params['fbo_sku'];
		$fbs_sku = $params['fbs_sku'];
		$created_at = $params['created_at'];
		$sqlstr = sprintf("
        UPDATE
          public.ozon_product_info
        SET
          id_product_list = '%s', --id_product_list
			  product_id = '%s', --product_id
			  offer_id = '%s', --offer_id
			  images = '%s', --images
			  barcode = '%s', --barcode
			  name = '%s', --name
			  old_price = '%s', --old_price
			  price = '%s', --price
			  min_price = '%s', --min_price
			  marketing_price = '%s', --marketing_price
			  minimal_price = '%s', --minimal_price
			  price_with_ozon_card = '%s', --price_with_ozon_card
			  price_index_value = '%s', --price_index_value
			  stock_present = '%s', --stock_present
			  fbo_sku = '%s', --fbo_sku
			  fbs_sku = '%s', --fbs_sku
			  created_at = '%s' --created_at
				
        WHERE
          id = '%s'
        ;
        ", $id_product_list, $product_id, $offer_id, $images, $barcode, $name, $old_price, $price, $min_price, $marketing_price, $minimal_price, $price_with_ozon_card, $price_index_value, $stock_present, $fbo_sku, $fbs_sku, $created_at, $id);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
	}
	function update_ozon_product_info($params)
	{
		// @params
		$product_id = 'OZN' . $params['product_id'];
		$price_with_ozon_card = $params['price_with_ozon_card'];

		$sqlstr = sprintf("
							UPDATE
							  public.ozon_product_info
							SET
							  price_with_ozon_card = '%s' --price_with_ozon_card
							WHERE
							  barcode = '%s'
                           ", $price_with_ozon_card, $product_id);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
	}
	function transformBoolean($value)
	{
		if ($value)
		{
			$tvalue = 'true';
		}
		else
		{
			$tvalue = 'false';
		}
		return $tvalue;
	}

	//@todo	taskp3875 19.11.2025 16:55
	/**
	 *
	 * @author Ionov AV
	 * @дата:    19.11.2025
	 * @время: 16:51
	 * Описание функции
	 *
	 * marketparser формирует xlsx файл с конкурентами
	 * надо его закинуть в таблицу ozon_parser_competitors_config
	 * см  жёлтая (2)
	 *CREATE TABLE ozon_parser_competitors_config (
	 *    id SERIAL PRIMARY KEY,
	 *    artikul VARCHAR(100) NOT NULL,
	 *    naimenovanie TEXT,
	 *    poiskovoe TEXT,
	 *    bs_ozon jsonb,
	 *    chs_ozon jsonb,
	 *    url VARCHAR(500)
	 *);
	 */
	function insert_ozon_parser_competitors_config($params)
	{
		// @params
		$artikul = $params['artikul'];
		$naimenovanie = $params['naimenovanie'];
		$poiskovoe = $params['poiskovoe'];
		$bs_ozon = $params['bs_ozon'];
		$chs_ozon = $params['chs_ozon'];
		$url = $params['url'];

		$sqlstr = sprintf("
        INSERT INTO
          public.ozon_parser_competitors_config
        (
          artikul,
              naimenovanie,
              poiskovoe,
              bs_ozon,
              chs_ozon,
              url
        )
        VALUES (
          '%s', -- artikul
              '%s', -- naimenovanie
              '%s', -- poiskovoe
              '%s', -- bs_ozon
              '%s', -- chs_ozon
              '%s' -- url
        );
        ", $artikul, $naimenovanie, $poiskovoe, $bs_ozon, $chs_ozon, $url);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
	}
	
	/**
	 * @author Ionov AV
	 * @дата:    19.11.2025
	 * @время: 17:24 
	 * Описание функции
	 * marketparser формирует xlsx файл с конкурентами был закинут в эту таблицу
	 * теперь берём отсюда данные  см синяя(3)
	 *
	 */
	function get_ozon_parser_competitors_config($params)
	{
		/*
		// @params
		$id = $params['id'];
		$artikul = $params['artikul'];
		$naimenovanie = $params['naimenovanie'];
		$poiskovoe = $params['poiskovoe'];
		$bs_ozon = $params['bs_ozon'];
		$chs_ozon = $params['chs_ozon'];
		$url = $params['url'];
		*/
		
		$artikul = $params['artikul'];

		$sqlstr = sprintf("
			SELECT
              id,
			  artikul,
			  naimenovanie,
			  poiskovoe,
			  bs_ozon,
			  chs_ozon,
			  url
				
			FROM
			  public.ozon_parser_competitors_config
			WHERE
			  artikul = '%s'
			ORDER BY
			  id
            -- LIMIT 1
				
			", $artikul);

		$stmt = $this->conn->prepare($sqlstr);
		$stmt->execute();
		$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $rows;
	}
}