<?php class ControllerCheckoutIntime extends Controller {

    public function index(){
        ini_set('memory_limit', '512M');
        $this->load->model('setting/setting');
        $api_key = $this->config->get('intime_api');
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'getAreas':                
                    $areas = $this->getAreas($api_key);
                    foreach ($areas as $key => $areas) {                  
                        echo '<option value="' . $areas['id'] . '">' . $areas['area_name_ua'] . '</option>';
                       }  
                    exit;
                    break;
                case 'getCities':               
                    $cities = $this->getCities($api_key);
                    foreach ($cities as $key => $cities) {  
                    if ($_POST['id'] == $cities['area_id']) {                
                        echo '<option value="' . $cities['id'] . '" area="' . $cities['area_id'] . '" disctrict="' . $cities['district_id'] . '">' . $cities['locality_name_ua'] . '</option>';
                       }  
                    }
                    exit;
                    break;
                case 'getWarehouses':
                    $warehouses = $this->getWarehouses($api_key);
                    foreach ($warehouses as $key => $warehouses) { 
                    if ($_POST['id'] == $warehouses['locality_id']) {              
                        echo '<option value="' . $warehouses['id'] . '">' . $warehouses['branch_name_ua'] . ' ' . $warehouses['address_ua'] . '</option>';  
                    }
                }
                    exit;
                    break;             
            }        
        }
    }

public function sendCurlRequest($request, $soap_request = '') {
    $result = [];
    $headers = array(
        "Content-type: text/xml",
        "SOAPAction: $soap_request",
    );
//    $url = "http://195.13.178.5/services/intime_api_3.0?wsdl";
    $url = "http://esb.intime.ua:8080/services/intime_api_3.0?wsdl";
//    $url = "https://esb.intime.ua:4443/services/intime_api_3.0?wsdl";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
//        header('Content-Type: application/xml');
//        echo $response;
        $xml = preg_replace('/(<\/?)(\w+):([^>]*>)/', '$1$2$3', $response);
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $responseArray = json_decode($json,true);
        if (!isset($responseArray['soapenvBody']['Entries_' . $soap_request])) {
            return [];
        }
        $result = $responseArray['soapenvBody']['Entries_' . $soap_request]['Entry_' . $soap_request];
        if (!isset($result[0]) && !empty($result)) {
            $new_result = [];
            $new_result[] = $result;
            $result = $new_result;
        }
       // echo '<pre>';
       // print_r($result);
    }
//    echo '<pre>';
//    print_r($response);
//    die();
    return $result;
}

function getAreas($api_key) {
    $soap_request = 'get_area_filtered';
    $request = '
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:dat="http://ws.wso2.org/dataservice">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <dat:' . $soap_request . '>
                            <dat:api_key>' . $api_key . '</dat:api_key>
                            <dat:id></dat:id>
                            <dat:country_id>215</dat:country_id>
                            <dat:area_name></dat:area_name>
                        </dat:' . $soap_request . '>
                    </soapenv:Body>
                </soapenv:Envelope>';
    return $this->sendCurlRequest($request, $soap_request);
}

function getCities($api_key) {
    $soap_request = 'get_locality_filtered';
    $request = '
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:dat="http://ws.wso2.org/dataservice">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <dat:' . $soap_request . '>
                            <dat:api_key>' . $api_key . '</dat:api_key>
                            <dat:id></dat:id>
                            <dat:area_id></dat:area_id>
                            <dat:district_id></dat:district_id>
                            <dat:country_id>215</dat:country_id>
                            <dat:locality_name></dat:locality_name>
                        </dat:' . $soap_request . '>
                    </soapenv:Body>
                </soapenv:Envelope>';
    return $this->sendCurlRequest($request, $soap_request);
}

function getWarehouses($api_key) {
    $soap_request = 'get_branch_filtered';
    $request = '
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:dat="http://ws.wso2.org/dataservice">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <dat:' . $soap_request . '>
                            <dat:api_key>' . $api_key . '</dat:api_key>
                            <dat:id></dat:id>
                            <dat:country_id>215</dat:country_id>
                            <dat:area_id></dat:area_id>
                            <dat:district_id></dat:district_id>
                            <dat:locality_id></dat:locality_id>
                            <dat:branch_name></dat:branch_name>
                        </dat:' . $soap_request . '>
                    </soapenv:Body>
                </soapenv:Envelope>';
    return $this->sendCurlRequest($request, $soap_request);
}
}