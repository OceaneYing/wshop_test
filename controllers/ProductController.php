<?php
namespace FwTest\Controller;
use FwTest\Classes as Classes;

class ProductController extends AbstractController
{
    /**
     * @Route('/product_list')
     */
    public function index()
    {
    	$db = $this->getDatabaseConnection();

        // oying : changement du nom de la fonction
        $list_product = Classes\Product::getList($db, 0, $this->array_constant['product']['nb_products']);
        
        echo $this->render('product/list.tpl', ['list_product' => $list_product]);

    }

    /**
     * @Route('/product_detail')
     */
    public function detail()
    {
        $db = $this->getDatabaseConnection();

    	$id = (isset($_GET['id']) && !empty($_GET['id']))? $_GET['id']:0;

    	if (!empty($id)) {
            // oying : récupérer la list de produit avec un filtre sur l'id
    		$products = Classes\Product::getList($db, 0, $this->array_constant['product']['nb_products'], "produit_id=$id");

    		if (!empty($products)) {
                // oying : correction du nom du fichier
    			echo $this->render('product/detail.tpl', ['product' => $products[0]]);
    		} else {
    			$this->_redirect('product_list.php');
    		}
    		
    	} else {
    		$this->_redirect('product_list.php');
    	}

    }
}