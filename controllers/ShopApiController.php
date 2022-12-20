<?php
namespace FwTest\Controller;
use FwTest\Classes as Classes;

class ShopApiController extends AbstractController
{
    /**
     * @Route('/api/shop/list')
     * 
     * Permet d'obtenir la list de magasins avec le filtre suuhaité
     */
    public function list()
    {
    	$db = $this->getDatabaseConnection();

        $type = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : '';
        $value = (isset($_GET['value']) && !empty($_GET['value'])) ? $_GET['value'] : '';

        // traiter le filtre, transformer en requête sql
        switch ($type) {
            case 'all' :
                $filter = "";
                break;
            case 'title' :
                $filter = !empty($value) ? "(shop_title LIKE '%$value%')" : "";
                break;
            case 'ref':
                $filter = !empty($value) ? "(shop_nref LIKE '%$value%')" : "";
                break;
            case 'city':
                $filter = !empty($value) ? "(shop_city LIKE '%$value%')" : "";
                break;
            default :
                $return = [
                    'status' => 'fail',
                    'message' => "Merci de sélectionner un type de valeur à filter : all, name, ref, description ou price."
                ];
        }

        if (isset($return)) {
            echo json_encode($return);
        } else {
            // TODO : catch PDOException
            $list_shop = isset($filter) ? Classes\Shop::getList($db, $filter) : null;
            $return = [
                'status' => 'succes',
                'data' => $list_shop
            ];
    
            echo json_encode($return);
        }
    }

    /**
     * @Route('/api/shop')
     * 
     * Permet d'ajouter, modifier ou supprimer un magasin
     */
    public function dispatch()
    {
        $db = $this->getDatabaseConnection();
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'POST':
                // si shop_id isset => màj du magasin, sans id => création d'un nouveux magasin
                $result = isset($_POST['shop_id']) ? Classes\Shop::update($db, $_POST) : Classes\Shop::create($db, $_POST);
                break;
            case 'DELETE':
                $result = Classes\Shop::delete($db, $_GET['id']);
                break;
        }

        if ($result) {
            $return = [
                'status' => 'success',
                'message' => 'L\'opération s\'est effectuée avec succès'
            ];
        } else {
            $return = [
                'status' => 'fail',
                'message' => 'Un problème est survenu au cours de l\'opération'
            ];
        }

        echo json_encode($return);
    }
}