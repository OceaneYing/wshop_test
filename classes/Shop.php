<?php
namespace FwTest\Classes;

class Shop
{
    /**
     * The table name
     *
     * @access  protected
     * @var     string
     */
	protected static $table_name = 'shop';

    /**
     * The object datas
     *
     * @access  private
     * @var     array
     */
	private $_array_datas = array();
	
    /**
     * The object id
     *
     * @access  private
     * @var     int
     */
	private $id;

    /**
     * The link to the database
     *
     * @access  public
     * @var     object
     */
	public $db;

    /**
     * Product constructor.
     *
     * @param      $db
     * @param      $datas
     *
     * @throws Class_Exception
     */
	public function __construct($db, $datas)
    {
        if (($datas != intval($datas)) && (!is_array($datas))) {
            throw new Class_Exception('The given datas are not valid.');
        }

        $this->db = $db;

        if (is_array($datas)) {
            $this->_array_datas = array_merge($this->_array_datas, $datas);
        } else {
            $this->_array_datas[self::$pk_name] = $datas;
        }
	}

    /**
     * Get the list of shop.
     *
     * @param      $db
     *
     * @return     array of Magasins
     */
	public static function getList($db, $filter = "")
	{
		$sql_get = "SELECT * FROM " . self::$table_name . (!empty($filter) ? " WHERE $filter" : "");

		$result = $db->fetchAll($sql_get);

		$array_shop = [];

		if (!empty($result)) {
			foreach ($result as $shop) {
                $shopData = new Shop($db, $shop);
				$array_shop[] = $shopData->_array_datas;
			}
		}

		return $array_shop;
	}

    /**
     * Delete a shop
     * 
     * @return bool if succeed
     */
    public static function create($db, $data)
    {
        $headers = implode(',', array_keys($data));
        $values = implode("','", array_values($data));
        $sql_post = "INSERT INTO " . self::$table_name . "(shop_id,$headers) VALUES (NULL,'$values')" ;

        return $db->query($sql_post);
    }

    /**
     * Delete a shop
     *
     * @return bool if succeed
     */
	public static function delete($db, $id) 
	{
		$sql_delete = "DELETE FROM " . self::$table_name . " WHERE shop_id = $id";

		return $db->query($sql_delete);
	}

    /**
     * update a shop
     *
     * @return bool if succeed
     */
    public static function update($db, $data) 
	{
        $id = $data['shop_id'];
        unset($data['shop_id']);

        // oying : préparer les columes à mettre à jour
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = '$value'";
        }

		$sql_update = "UPDATE " . self::$table_name . " SET " . implode(',', $set) . " WHERE shop_id = $id";

		return $db->query($sql_update);
	}
}