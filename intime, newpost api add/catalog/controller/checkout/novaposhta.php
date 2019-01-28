<?php class ControllerCheckoutNovaposhta extends Controller {

	public function index() {
	
	$this->load->model('setting/setting');

	$newpost_api = $this->config->get('newpost_api');        

	require 'NovaPoshtaApi2.php';
	$np = new NovaPoshtaApi2($newpost_api);
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])  == 'XMLHttpRequest') {
	    header('Content-Type: text/javascript; charset=utf-8');
	    if (isset($_POST['action'])) {
	        switch ($_POST['action']) {
	        	case 'getAreas':	        	
	                $ar = $np->getAreas();	                    		
	        		foreach ($ar['data'] as $key => $ar) {        			
	                    echo '<option value="' . $ar['Ref'] . '">' . $ar['Description'] . '</option>';
	     			   }  
	                exit;
	                break;
	        	case 'getCities':	        	
	                $ct = $np->getCities();       		
	        		foreach ($ct['data'] as $key => $ct) {     
	        		if ($_POST['ref'] == $ct['Area'])  {		
	                    echo '<option value="' . $ct['Ref'] . '" area="' . $ct['Area'] . '">' . $ct['Description'] . '</option>'; 
	                    } 	
	     			   }
	                exit;
	                break;
	            case 'getWarehouses':
	                $wh = $np->getWarehouses($_POST['ref1']);
	                foreach ($wh['data'] as $key => $wh) {
	                    echo '<option value="' . $wh['Ref'] . '">' . $wh['Description'] . '</option>';
	                }
	                exit;
	                break;
	            default:
	                break;
	        }
	    }
	} 

}
}