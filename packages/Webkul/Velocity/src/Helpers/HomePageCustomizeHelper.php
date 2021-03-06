<?php

namespace Webkul\Velocity\Helpers;

use Illuminate\Support\Facades\DB;

class HomePageCustomizeHelper
{
    protected $exist_val = [];
    protected $exist_index = "";
    function GetCategoryString($arr, $index)
    {
        $rule = "";
        $rule_value = [];
        $attr = "";
        foreach ($arr as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $rule = $value2['rule_operator'];
                $rule_value[] = $value2['rule_value'];
            }
            $attr = $key;
        }
        $val = implode(',', $rule_value);

        $data = DB::select("SELECT name FROM category_translations
      WHERE category_id ".($rule == '{}' ? ' in ' : ' not in ')." ($val)");
        $options = "";
        foreach ($data as $key => $value) {
            if ($key == 0)
                $options .= $value->name;
            else
                $options .= ", " . $value->name;

        }
        if ($this->exist_index != $index) {
            $this->exist_index = $index;
            unset($this->exist_val);
            $this->exist_val = array();
        }
        $this->exist_val[] = $val;
        return $attr . ':' . $options;
    }

    function GetAttributeString($arr, $index)
    {
        $list = ['boolean', 'checkbox', 'date', 'datetime', 'file', 'image', 'multiselect', 'price', 'select', 'text', 'textarea'];
        $rule = "";
        $rule_value = [];
        $attr = "";
        foreach ($arr as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $rule = $value2['rule_operator'];
                $rule_value[] = $value2['rule_value'];
            }
            $attr = $key;
        }

        $rule_map = [
            '==' => '=',
            '!=' => '!=',
            '>=' => '>=',
            '<=' => '<=',
            '>' => '>',
            '<' => '<',
            '{}' => 'in',
            '!{}' => 'not in',
        ];

        $val = implode(',', $rule_value);

        $sql_get_type = "SELECT attributes.type FROM attribute_translations
        INNER JOIN attributes on attributes.id = attribute_translations.attribute_id
        WHERE name = '$attr'";
        $sql_get_type_data = DB::select($sql_get_type)[0]->type;

        if ($sql_get_type_data == "checkbox" || $sql_get_type_data == "multiselect"
            || $sql_get_type_data == "select") {
            $data = DB::select("SELECT attribute_options.admin_name FROM attribute_translations
            INNER JOIN attribute_options on 
            attribute_options.attribute_id = attribute_translations.attribute_id
            WHERE  name = '$attr'
            AND attribute_options.id ".($rule == '{}' ? ' in ' : ' not in ')." ($val)");
            $options = "";
            foreach ($data as $key => $value) {
                if ($key == 0)
                    $options .= $value->admin_name;
                else
                    $options .= ", " . $value->admin_name;

            }
            if ($this->exist_index != $index) {
                $this->exist_index = $index;
                unset($this->exist_val);
                $this->exist_val = array();
            }
            $this->exist_val[] = $val;
            return $attr . ':' . $options;
        } else if ($sql_get_type_data == "price") {
            $fb = "";
            if (implode(',', $this->exist_val) != "") {
                $fb = " and product_id in (SELECT product_id FROM product_attribute_values
                WHERE attribute_id in (".implode(',', $this->exist_val)."))";
            }

            $sql_price_product = "SELECT price FROM product_flat
            WHERE 1=1 $fb
            and price $rule_map[$rule] $val AND status = 1
            ORDER BY price ";
//            return $sql_price_product;
            $data = DB::select($sql_price_product);
            $low_price = count($data) > 0 ? $data[0]->price : 0;
            $high_price = count($data) > 0 ? $data[count($data)-1]->price : 0;
            if ($this->exist_index != $index) {
                $this->exist_index = $index;
                unset($this->exist_val);
                $this->exist_val = array();
            }
            if ($low_price == 0 && $high_price == 0)
                return $attr . ': No Product Found';
            else
                return $attr . ': ' . round($low_price) . ' to ' . round($high_price);

        }

    }

    public function GetParseCustomizeSectionLogic($id, $type_id)
    {
        $obj = [];
        $data = [];
        $product = "";
        $name = "";
        $slug = "";
        $image_path = "";
        if ($type_id == 1) {
            $data = DB::select("SELECT name, slug, image image_path, 0 price, 0 special_price FROM category_translations
            INNER JOIN categories on categories.id = category_translations.category_id
            WHERE category_id = $id");
            $name = $data[0]->name;
            $slug = $data[0]->slug;
            $image_path = $data[0]->image_path;
        } else if ($type_id == 2) {

            $product = \Webkul\Product\Models\ProductFlat::select(DB::raw('product_flat.*'))
                ->where('product_id', $id)
                ->first();

            $velocityHelper = app('Webkul\Velocity\Helpers\Helper');
           return $product = $velocityHelper->formatProduct($product);

        }
        $is_product = ($type_id == 2);
// Be the first to write a review
        if (count($data) > 0) {
            $obj['name'] = $name;
            $obj['slug'] = $slug;
            $obj['image_path'] = $image_path;
            $obj['is_product'] = $is_product;
            $obj['product'] = $product;
        }

        return $obj;
    }
}
