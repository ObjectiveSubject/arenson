<?

define('AOF_bindertable', $wpdb->get_blog_prefix() . "aof_binders"); 
define('AOF_bindertable_meta', $wpdb->get_blog_prefix() . "aof_binder_items"); 

define('AOF_bindertable_fields','id,hash,user_id,slug,name,description,date_added,active');
define('AOF_bindertable_meta_fields','product_sku');


define('AOF_userdata_fields','display_name,user_email');
define('AOF_usermetadata_fields','meta_value');


define('AOF_export_fields','Binder Name,User Login,Description,Date Added,Products,User Last Name,User Email,User Joined');


//custom product fields
$product_fields = array(
	"productManufacturer"=>"Manufacturer",
	"productProductLine"=>"Product Line",
	"productManufacturerProductModel"=>"Manufacturer Product Model",
	"productDimensions"=>"Dimensions",
	"productInventory"=>"Quantity in Inventory",
	"productNetPrice"=>"Price",
	"productDesigner"=>"Designer",
	"productYearDesigned"=>"Year Designed",
	"productAwards"=>"Awards",
	"productPricePoint"=>"Price Point",
	"productSpecifiedFinish"=>"Specified Finish",
	"productAvailableFinishes"=>"Available Finishes",
	"productAestheticStyle"=>"Aesthetic Style",
	"productWorkModes"=>"Work Modes",	
	"productErgonomic"=>"Ergonomic",
	"productSustainability"=>"Sustainability",
	"productClientSKU"=>"Client's SKU",
	"productShipsWithin"=>"Lead Times",
	"productQuickShipOptions"=>"Available Options",	
	"productContracts"=>"Contracts",	
	"productAvailableOptions"=>"Downloads",	
	//"productArchitecturalCode"=>"Architectural Code",
	//	"productApplication"=>"Application",

	);

$toplevel_overviews = array(
	'products'	=> 'product_overviews',
	'services'	=> 'service',
	'projects'	=> 'projects',
	'markets'	=> 'market_overview',
);
			
			
$taxonomy_landing_page_translations = array(
	'p_cat'	=> 'product_overviews',
	'markets'	=> 'products',
);
			
$taxonomy_filters = array(
	'p_cat'		=> 'Product Categories',
	'markets'	=> 'Markets',
);
			
			

//page IDS that are only for logged in people.
$protectedPages=array(1026);

//page IDS for working with reload
$dontReload=array(1026, 1024);

//yellow pages
$yellowBackgroundPages=array(1029,1032,2525);

//no footer fancboxes on the userlogins
$popupBlockPages=array(2525,1032);


// misc

?>