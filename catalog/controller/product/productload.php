<?php 
class ControllerProductProductload extends Controller {
    /**
     *
     */
    public function index() {




		//error_reporting(E_ALL ^ E_WARNING);
	
		$categoryData = array();
	

        //$this->load->model('account/category');

        $this->load->model('catalog/product');
        $this->load->model('account/category');
//
//        $product_id = $this->model_catalog_product->addProduct($product);
//
//		if($product_id)
//			echo "Product Added with code " + $product_id;
//		else
//			echo "Product Addition Failed";

        $objPHPExcel = PHPExcel_IOFactory::load(DIR_SYSTEM . 'SaffronCatalog.xlsx');

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow  = $worksheet->getHighestRow();
            $highestColumn      = $worksheet->getHighestColumn();
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);


            echo '<br><table border="1"><tr>';
            for ($row = 2; $row <= $highestRow; ++ $row) {
                echo '<tr>';
                $baseCategoryCell = $worksheet->getCellByColumnAndRow(0, $row);
                $baseCategoryIdCell = $worksheet->getCellByColumnAndRow(0, $row);
                $baseSubCategoryIdCell = $worksheet->getCellByColumnAndRow(1, $row);
                $productCellId = $worksheet->getCellByColumnAndRow(2, $row);
                //echo $baseCategoryCell . ' ' . $baseSubCategoryIdCell ;
				if($baseCategoryCell){
                    //echo '<td>'. $baseCategoryCell.'</td>';
                    if($baseCategoryIdCell->getValue() != ""){
                        $baseCategoryVal = $baseCategoryIdCell->getValue();
                        $baseCategoryIdVal = $this->model_account_category->getCategoryIdFromName(trim($baseCategoryVal));
                        if(!$baseCategoryIdVal){
                            $baseCategoryIdVal  =  "New";
                            $category = $this->categoryBuild($baseCategoryIdCell->getValue(), $baseCategoryIdCell->getValue(),$baseCategoryIdCell->getValue());
                            echo print_R($category,TRUE);
                            $baseCategoryIdVal = $this->model_account_category->addCategory($category);
						}
                        echo '<td>'. $baseCategoryCell . '---'. $baseCategoryIdVal.'</td>';
                    }else {
                        echo '<td></td>';
					}
                    if($baseSubCategoryIdCell->getValue() != null){
                        $baseSubCategoryIdVal = $this->model_account_category->getCategoryIdFromName($baseSubCategoryIdCell);
                        if(!$baseSubCategoryIdVal){
                            $baseSubCategoryIdVal =  "New";
                            $category = $this->categoryBuild($baseSubCategoryIdCell->getValue(), $baseSubCategoryIdCell->getValue(),$baseSubCategoryIdCell->getValue(), $baseCategoryIdVal);
                            echo print_R($category,TRUE);
                            $baseSubCategoryIdVal = $this->model_account_category->addCategory($category);

                        }

                        echo '<td>'. $baseSubCategoryIdCell. '---' . $baseSubCategoryIdVal . '</td>';

					}else{
                        echo '<td></td>';
					}
                    if ($productCellId->getValue()!= null){

//                        $baseSubSubCategoryIdVal = $this->model_account_category->getCategoryIdFromName($baseSubSubCategoryIdCell);
//                        if(!$baseSubSubCategoryIdVal){
//                            $baseSubSubCategoryIdVal =  "New";
//                            $category = $this->categoryBuild($baseSubSubCategoryIdCell->getValue(), $baseSubSubCategoryIdCell->getValue(),$baseSubSubCategoryIdCell->getValue(), $baseSubCategoryIdVal);
//                            echo print_R($category,TRUE);
//                            $baseSubSubCategoryIdVal = $this->model_account_category->addCategory($category);
//                        }
                        $pImage = 'data/'. $baseCategoryCell. '/'.$baseSubCategoryIdCell->getValue() . '/'.trim($productCellId->getValue()).'.jpeg';
                        
//                         productBuild($pName, $pCategoryId, $pDescription, $pModel, $pImage, $pQty, $pPrice)sg
                        $pName = $productCellId->getValue();
                        $pDescription = $productCellId->getValue();
                        $pModel = $productCellId->getValue();
                        $pCategoryId = $baseSubCategoryIdVal;
                        $pImage = 'data/'. $baseCategoryCell. '/'.$baseSubCategoryIdCell->getValue() . '/'.trim($productCellId->getValue()).'.jpeg';
                        $product = $this->productBuild($pName,$pDescription, $pModel, $pCategoryId, $pImage, "10","200");
                        echo print_r($product, TRUE);
                        $product_id = $this->model_catalog_product->addProduct($product);
                        echo '<td>'. $productCellId . '--' . $baseSubCategoryIdVal .'</td>';
                    }else{
                        echo '<td></td>';
					}
				}



                $productLCell = $worksheet->getCellByColumnAndRow(2, $row);
				$productPCell = $worksheet->getCellByColumnAndRow(3, $row);
                //echo $productLCell . ' ' . $productLCell ;
                //echo '</tr>';
            }

            echo '</table>';

            //$product = $this->productBuild();
            //echo print_R($product,TRUE);

            //$category = $this->categoryBuild("Soups And Salads", "Soups And Salads","Soups And Salads");
            //echo print_R($category,TRUE);

            //$categoryId = $this->model_account_category->addCategory($category);
            //echo 'Category ' . $categoryId;
        }
		$baseCategoryVal = "";

	}

	public function productBuild($pName, $pDescription, $pModel, $pCategoryId, $pImage, $pQty, $pPrice){
        $product_description = array();

        $product_store = array(
            '0' => 0
        );

        $product_category = array(
            '0' => $pCategoryId
        );


        $product_layout = array(
            '0' => 0
        );

        $product_reward[1] = array(
            'points' => ''
        );

        $product_description[1] = array(
            'name' => $pName,
            'meta_description' => '',
            'meta_keyword' => '',
            'description' => $pDescription,
            'tag' => ''
        );

        $product = array(
            'product_description' => $product_description,
            'model' => $pModel,
            'sku' => '',
            'upc' => '',
            'ean' => '',
            'jan' => '',
            'isbn' => '',
            'mpn' => '',
            'location' => '',
            'price' => $pPrice,
            'tax_class_id' => 0,
            'quantity' => $pQty,
            'minimum' => 1,
            'subtract' => 1,
            'stock_status_id' => 5,
            'shipping' => 1,
            'keyword' => '',
            'image' => $pImage,
            'date_available' => '2016-12-01',
            'length' => '',
            'width' => '',
            'height' => '',
            'length_class_id' => 1,
            'weight' => '',
            'weight_class_id' => 1,
            'status' => 1,
            'sort_order' => 1,
            'manufacturer' => '',
            'manufacturer_id' => 0,
            'category' => 'bud',
            'filter' => '',
            'download' => '',
            'related' => '',
            'option' => '',
            'points' =>  '',
            'vendor' =>  2,
            'product_category' => $product_category,
            'product_store' => $product_store,
            'product_reward' => $product_reward,
            'product_layout' => $product_layout

        );
        return $product;
	}

	public function categoryBuild($cName, $cDescription, $cModel, $cParentId = null)
    {


        $category_description[1] = array(
            'name' => $cName,
            'meta_description' => $cName,
            'meta_keyword' => $cName,
            'description' => $cDescription,
            'tag' => ''
        );

        $category_store = array(
            '0' => 0
        );


        $category_layout = array(
            '0' => ''
        );

        $category = array(
            'category_description' => $category_description,
            'path' => $cModel,
            'parent_id' => $cParentId,
            'filter' => '',
            'keyword' => '',
            'image' => '',
            'column' => 1,
            'sort_order' => '',
            'status' => 1,
        	'top' => 1,
            'category_description' => $category_description,
            'category_layout' => $category_layout,
            'category_store' => $category_store
		);

        return $category;
    }
}
?>		
	