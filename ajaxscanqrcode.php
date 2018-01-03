<?php
    if(isset($_GET['sample'])){
        //$path = "http://svc.efaktur.pajak.go.id/validasi/faktur/744936618613000/0181724265658/ae0b45df1498ebf74dce89b04075de0eef61d3b8d160700a3da6afd446ad067e";
        $path = "http://svc.efaktur.pajak.go.id/VALIDASI/FAKTUR/018621854062000/0181700955845/C66ABD52BD278F225EA3E8173963CA1360C96C81E85F6852D27E3C243DD77270"; //not found
    }
    else{
        $path = $_POST['path'];        
    }    
    
    $data = get_json_data($path);
    echo $data;
        
    function get_json_data($path){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$path);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $stringXML = curl_exec($ch);          
        curl_close($ch);
        
        $stringXML = str_replace(array("\n", "\r", "\t"), '', $stringXML);
        $stringXML = trim(str_replace('"', "'", $stringXML));
        $stringXML = simplexml_load_string($stringXML);
        $json_string = json_encode($stringXML);
        
        return $json_string;
    }
?>