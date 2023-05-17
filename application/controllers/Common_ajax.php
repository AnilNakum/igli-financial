<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Common_ajax extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_country_state()
    {
        $CountryID = $this->input->post("id");
        $response = array("status" => "ok", "results" => $this->Common->get_list(TBL_STATES, 'StateID', 'StateName', "CountryID=$CountryID"));
        echo json_encode($response);
        die();
    }

    public function get_state_city()
    {
        $StateID = $this->input->post("id");
        $response = array("status" => "ok", "results" => $this->Common->get_list(TBL_CITYS, 'CityID', 'CityName', "StateID=$StateID"));
        echo json_encode($response);
        die();
    }

    public function get_variant_cat()
    {
        $CatID = $this->input->post("id");
        $response = array("status" => "ok", "results" => $this->Common->get_list(TBL_CATEGORIES, 'CatID', 'Category', "Status = 1 AND VariantCatID=0 AND MainCatID=$CatID"));
        echo json_encode($response);
        die();
    }

    public function get_parent_cat()
    {
        $CatID = $this->input->post("id");
        $response = array("status" => "ok", "results" => $this->Common->get_list(TBL_CATEGORIES, 'CatID', 'Category', "Status = 1 AND ParentCatID=0 AND VariantCatID=$CatID"));
        echo json_encode($response);
        die();
    }

    public function get_sub_cat()
    {
        $CatID = $this->input->post("id");
        $response = array("status" => "ok", "results" => $this->Common->get_list(TBL_CATEGORIES, 'CatID', 'Category', "Status = 1 AND SubCatID=0 AND ParentCatID=$CatID"));
        echo json_encode($response);
        die();
    }

    public function get_cat()
    {
        $CatID = $this->input->post("id");
        $response = array("status" => "ok", "results" => $this->Common->get_list(TBL_CATEGORIES, 'CatID', 'Category', "Status = 1 AND SubCatID=$CatID"));
        echo json_encode($response);
        die();
    }

    public function get_cat_brand()
    {
        $CatID = $this->input->post("id");
        $UserID = $this->tank_auth->get_seller_id();
        $join = array(
            array('table' => TBL_BRANDS_CATEGORIES . ' c', 'on' => "b.id=c.brand_id", 'type' => ''),
        );
        $response = array("status" => "ok", "results" => $this->Common->get_list(TBL_BRANDS . ' as b', 'b.id', 'b.name', "b.status = 'published' AND c.cat_id=$CatID AND b.store_id=$UserID", $join));
        echo json_encode($response);
        die();
    }

    public function get_sub_catlist()
    {
        $CatID = $this->input->post("pro_cat");
        $response = array("status" => "error", 'message' => 'Not found!,You will need to refresh the page to continue working.');
        if ($CatID != '') {
            $select = 'c.*';
            $Cat = $this->Common->get_all_info(TBL_CATEGORIES . ' c', $CatID, 'c.id', " c.Status = 'published'", $select);
            foreach ($Cat as $key => $c) {
                if ($c->parent_id != 0) {
                    $Cat[$key]->sub = getAllSubCategories($c->parent_id);
                }
            }
            $response = array("status" => "ok", "categories" => $Cat);
            echo json_encode($response);
            die;
        }

    }

    public function get_attribute_values_old()
    {

        // [Attributes] => ["3","1"]
        // [ChoiceOptions] => [{"attribute_id":"3","values":["8GB","32GB"]},{"attribute_id":"1","values":["S","M"]}]
        // pr($this->input->post());die;
        $AttributeID = $this->input->post('id');
        $CCode = $this->input->post('catlog_code');
        $ProductID = $this->input->post('product_id');
        $ProductCode = $this->input->post('product_code');
        $UserID = $this->tank_auth->get_user_id();
        $Product = $this->Common->get_info(TBL_PRODUCTS, $ProductCode, 'product_code', '', 'attributes');
        $join = array(
            array('table' => TBL_VARIATION_ITEMS . ' vi', 'on' => "vi.variation_id=v.id", 'type' => ''),
        );
        $Product->ChoiceOptions = $this->Common->get_all_info(TBL_VARIATIONS . ' as v', $ProductID, 'v.configurable_product_id', '', '*', $join);
        $Selected = array();
        if ($Product->ChoiceOptions != '') {
            foreach ($Product->ChoiceOptions as $k => $Opt) {
                array_push($Selected, $Opt->attribute_id);
            }
        }
        // pr($Selected);die;
        $AttributeValue = $this->Common->get_list(TBL_ATTRIBUTES, 'id', 'title', "attribute_set_id = $AttributeID AND status = 'published'");
        $html = '';
        $s = '';
        foreach ($AttributeValue as $k => $v) {
            $Select = '';
            if (in_array($k, $Selected)) {
                $Select = 'selected';
                $s = 'selected';
            }
            $html .= '<option ' . $Select . ' value="' . $k . '">' . $v . '</option>';
        }
        $response = array("status" => "ok", "html" => $html, 'selected' => $s);
        echo json_encode($response);
        die();
    }

    public function get_attribute_values()
    {
        $AttributeID = $this->input->post('id');
        $CCode = $this->input->post('catlog_code');
        $Products = $this->Common->get_all_info(TBL_PRODUCTS, $CCode, 'catlog_code', 'is_variation = 0');
        // $join = array(
        //     array('table' => TBL_VARIATION_ITEMS . ' vi', 'on' => "vi.variation_id=v.id", 'type' => ''),
        // );
        // $Product->ChoiceOptions = $this->Common->get_all_info(TBL_VARIATIONS . ' as v', $ProductID, 'v.configurable_product_id', '', '*', $join);
        $Selected = array();
        foreach ($Products as $k => $P) {
            if ($P->attribute_id != '' || $P->attribute_id != 0) {
                array_push($Selected, $P->attribute_id);
            }
        }
        // pr($Selected);die;
        $AttributeValue = $this->Common->get_list(TBL_ATTRIBUTES, 'id', 'title', "attribute_set_id = $AttributeID AND status = 'published'");
        $html = '';
        $s = '';
        foreach ($AttributeValue as $k => $v) {
            $Select = '';
            if (in_array($k, $Selected)) {
                $Select = 'selected';
                $s = 'selected';
            }
            $html .= '<option ' . $Select . ' value="' . $k . '">' . $v . '</option>';
        }
        $response = array("status" => "ok", "html" => $html, 'selected' => $s);
        echo json_encode($response);
        die();
    }
}