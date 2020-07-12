<?php

namespace Webkul\CMS\Http\Controllers\Admin;

use Codeception\PHPUnit\ResultPrinter\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Psy\Test\Exception\RuntimeExceptionTest;
use Webkul\Category\Models\Category;
use Webkul\CMS\Http\Controllers\Controller;
use Webkul\CMS\Models\HomeCustomizeSection;
use Webkul\CMS\Models\HomeSlider;
use Webkul\CMS\Repositories\CmsRepository;
use Webkul\Product\Models\Product;

class MixSectionController extends Controller
{
    /**
     * To hold the request variables from route file
     * 
     * @var array
     */
    protected $_config;

    /**
     * To hold the CMSRepository instance
     * 
     * @var \Webkul\CMS\Repositories\CmsRepository
     */
    protected $cmsRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\CMS\Repositories\CmsRepository  $cmsRepository
     * @return void
     */
    public function __construct(CmsRepository $cmsRepository)
    {
        $this->middleware('admin');

        $this->cmsRepository = $cmsRepository;

        $this->_config = request('_config');
    }

    /**
     * Loads the index page showing the static pages resources
     * 
     * @return \Illuminate\View\View|\Webkul\Velocity\Repositories\Product\ProductRepository
     */
    public function index()
    {
//        return 1;
        $home_slider =  HomeSlider::get();
        $catalog_object = Product::GetProductsWithCategoryParentRelation();

        $GetSectionData = HomeCustomizeSection::GetSectionData();
        $home_slider_data = [];
        $slider_data = [];
        $slider_name = "";

        foreach ($GetSectionData as $key => $value) {
            $slider_data[$value->master_id]['data'][] = $value;
            $slider_data[$value->master_id]['section_name'] = $value->section_name;
            $slider_data[$value->master_id]['position'] = $value->position;
            $slider_data[$value->master_id]['is_visible'] = $value->is_visible;
            $slider_data[$value->master_id]['display_block_type'] = $value->display_block_type;
        }

        return view($this->_config['view'])->with([
            'catalog_object' => $catalog_object,
            'slider_data' => $slider_data,
            'slider_name' => $slider_name,
            'parent_category' => array_key_exists('categories_parent', $catalog_object) ?
                $catalog_object['categories_parent'] :
                \GuzzleHttp\json_encode([], true)
        ]);
    }

    /**
     * To create a new CMS page
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view($this->_config['view']);
    }

    /**
     * To store a new CMS page in storage
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request->all();

        DB::transaction(function () use ($request) {
            DB::table('mix_customize_section_master')->delete();
            $data = $request->input('data');
            $master_section = [];
            $details_section = [];
            $details_child_section = [];
            $details_child_section_value = [];
            foreach ($data as $key => $value) {
                $master_section[$key]['slug'] = $value['slug'];
                $master_section[$key]['subtitle'] = $value['subtitle'];
                $master_section[$key]['title'] = $value['title'];

                foreach ($value['rows_iterate'] as $key2 => $value2) {
                    $details_section[$value['slug']][$key2]['slug'] = $value2['slug'];
                    $details_section[$value['slug']][$key2]['title'] = $value2['title'];
                    $details_section[$value['slug']][$key2]['parent_slug'] = $value['slug'];
//                    $details_section[$value['slug']][$key2]['image_url'] = $value['image_url'];

                    foreach ($value2['conditions'] as $key3 => $value3) {
                        $details_child_section[$value2['slug']][$key3]['label'] = $value3['rule_type'];
                        $details_child_section[$value2['slug']][$key3]['rule_operator'] = $value3['rule_operator'];
                        $details_child_section[$value2['slug']][$key3]['parent_slug'] = $value2['slug'];
                        $details_child_section[$value2['slug']][$key3]['show_multi_select'] = $value3['show_multi_select'] == true ? 1 : 0;
                        $details_child_section[$value2['slug']][$key3]['rule_value'] = $value3['show_multi_select'] == true ?
                            str_replace('"', '', str_replace('\\', '', json_encode($value3['rule_value_multi']))) : $value3['rule_value'];
                        foreach ($value3['multi'] as $key4 => $value4) {
                            $details_child_section_value[$value2['slug']][$key3][]['multi_value'] = $value4;
                        }
                    }
                }
            }

            $child_val = [];
            $child_val_c = [];
            foreach ($master_section as $key => $value) {
                DB::table('mix_customize_section_master')->insert($master_section[$key]);
                if (array_key_exists($master_section[$key]['slug'], $details_section)) {
                    DB::table('mix_customize_section_details')->insert($details_section[$master_section[$key]['slug']]);
                    foreach ($details_section[$master_section[$key]['slug']] as $key2 => $value2) {
                        if (array_key_exists($value2['slug'], $details_child_section)) {
                            foreach ($details_child_section[$value2['slug']] as $key3 => $value3) {
                                $id = DB::table('mix_customize_section_details_child')->insertGetId($value3);
                                $j = 0;
                                if (array_key_exists($value2['slug'], $details_child_section_value)) {
                                    if (array_key_exists($key3, $details_child_section_value[$value2['slug']])) {
                                        foreach ($details_child_section_value[$value2['slug']][$key3] as $key4 => $value4) {
                                            $child_val[$key3][$j]['child_id'] = $id;
                                            $child_val[$key3][$j]['multi_value'] = $value4['multi_value'];
                                            $j += 1;
                                        }
                                        DB::table('mix_customize_child_multi_value')->insert($child_val[$key3]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        });

        //return $details_section['best-of-electronics'];

    }

    public function getMixSection()
    {
        $sql = "SELECT mix_customize_section_master.id, mix_customize_section_master.title,
        mix_customize_section_master.subtitle, mix_customize_section_master.slug,
        mix_customize_section_master.is_visible,
        mix_customize_section_master.admin_url,
        mix_customize_section_details.master_section_id, 
        mix_customize_section_details.slug details_slug,
        mix_customize_section_details.title details_title,
        mix_customize_section_details_child.details_row_id,
        mix_customize_section_details_child.rule_operator,
        mix_customize_section_details_child.rule_value,
        mix_customize_section_details_child.show_multi_select,
        mix_customize_section_details_child.label rule_type,
        CASE 
            WHEN mix_customize_section_details_child.show_multi_select = 1 THEN
                rule_value
            ELSE
                ''
        END rule_value_multi,
		mix_customize_child_multi_value.multi_value, mix_customize_section_details_child.id child_id
        FROM mix_customize_section_master
        LEFT JOIN mix_customize_section_details on 
        mix_customize_section_details.master_section_id = mix_customize_section_master.id
        LEFT JOIN mix_customize_section_details_child on 
        mix_customize_section_details_child.details_row_id = mix_customize_section_details.id
        LEFT JOIN mix_customize_child_multi_value on mix_customize_child_multi_value.child_id = mix_customize_section_details_child.id
        ORDER BY mix_customize_section_details.master_section_id, 
        mix_customize_section_details_child.details_row_id, mix_customize_section_details_child.id";
        $data = DB::select($sql);
        $master_detail = [];
        $i = -1;
        $map_column = ['rule_operator', 'rule_value', 'show_multi_select', 'rule_type', 'rule_value_multi'];
        $map_column2 = ['multi_value'];
        $in_array_child = [];

        foreach ($data as $key => $value) {
            $master_detail[$value->slug]['is_visible'] = $value->is_visible;
            $master_detail[$value->slug]['admin_url'] = $value->admin_url;
            $master_detail[$value->slug]['slug'] = $value->slug;
            $master_detail[$value->slug]['title'] = $value->title;
            $master_detail[$value->slug]['subtitle'] = $value->subtitle;
            $master_detail[$value->slug]['rows_iterate'][$value->details_slug]['slug'] = $value->details_slug;
            $master_detail[$value->slug]['rows_iterate'][$value->details_slug]['title'] = $value->details_title;
            foreach ($value as $in_key => $in_value) {
                if (!in_array($value->child_id, $in_array_child)) {
                    $i += 1;
                    $in_array_child[] = $value->child_id;
                }
                if (in_array($in_key, $map_column)) {
                    $master_detail[$value->slug]['rows_iterate'][$value->details_slug]['conditions'][$i][$in_key] = $in_value;
                }
                if ($in_key == "rule_type" && $value->show_multi_select == 1) {
                    if ($value->$in_key == "Categories") {
                        $master_detail[$value->slug]['rows_iterate'][$value->details_slug]['conditions'][$i]['data_List'] = $this->GetCategoriesName();
                    } else {
                        $master_detail[$value->slug]['rows_iterate'][$value->details_slug]['conditions'][$i]['data_List'] = $this->GetAttributeOptionsByAttributeName($value->$in_key);
                    }
                } else if ($in_key == "rule_type" && $value->show_multi_select == 0) {
                    $master_detail[$value->slug]['rows_iterate'][$value->details_slug]['conditions'][$i]['data_List'] = [];
                }

                if ($value->show_multi_select == 1) {
                    if (in_array($in_key, $map_column2)) {
                        $master_detail[$value->slug]['rows_iterate'][$value->details_slug]['conditions'][$i]['multi'][] = $in_value;
                    }
                } else {
                    $master_detail[$value->slug]['rows_iterate'][$value->details_slug]['conditions'][$i]['multi'] = [];
                }
            }
//            $master_detail[$value->slug]['rows_iterate'][$value->details_slug]['conditions'][] = $value;
        }

        return $master_detail;
    }

    public function GetAttributeOptionsByAttributeName($attribute_name)
    {
       return DB::select("SELECT attribute_options.id, attribute_options.admin_name FROM attribute_translations
        left join attribute_options on attribute_options.attribute_id = attribute_translations.attribute_id
        WHERE name = '$attribute_name'");
    }

    public function GetCategoriesName()
    {
       return DB::select("SELECT category_id id, name admin_name FROM category_translations");
    }

    /**
     * To edit a previously created CMS page
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $page = $this->cmsRepository->findOrFail($id);

        return view($this->_config['view'], compact('page'));
    }

    /**
     * To update the previously created CMS page in storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $locale = request()->get('locale') ?: app()->getLocale();

        $this->validate(request(), [
            $locale . '.url_key'      => ['required', new \Webkul\Core\Contracts\Validations\Slug, function ($attribute, $value, $fail) use ($id) {
                if (! $this->cmsRepository->isUrlKeyUnique($id, $value)) {
                    $fail(trans('admin::app.response.already-taken', ['name' => 'Page']));
                }
            }],
            $locale . '.page_title'   => 'required',
            $locale . '.html_content' => 'required',
            'channels'                => 'required',
        ]);

        $this->cmsRepository->update(request()->all(), $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Page']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * To delete the previously create CMS page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $page = $this->cmsRepository->findOrFail($id);

        if ($page->delete()) {
            session()->flash('success', trans('admin::app.cms.pages.delete-success'));

            return response()->json(['message' => true], 200);
        } else {
            session()->flash('success', trans('admin::app.cms.pages.delete-failure'));

            return response()->json(['message' => false], 200);
        }
    }

    /**
     * To mass delete the CMS resource from storage
     *
     * @return \Illuminate\Http\Response
     */
    public function massDelete()
    {
        $data = request()->all();

        if ($data['indexes']) {
            $pageIDs = explode(',', $data['indexes']);

            $count = 0;

            foreach ($pageIDs as $pageId) {
                $page = $this->cmsRepository->find($pageId);

                if ($page) {
                    $page->delete();

                    $count++;
                }
            }

            if (count($pageIDs) == $count) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', [
                    'resource' => 'CMS Pages',
                ]));
            } else {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.partial-action', [
                    'resource' => 'CMS Pages',
                ]));
            }
        } else {
            session()->flash('warning', trans('admin::app.datagrid.mass-ops.no-resource'));
        }

        return redirect()->route('admin.cms.index');
    }
}