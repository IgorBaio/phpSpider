<?php 
function crawler($url,$depth=2){
   if($depth > 0){

      $html = file_get_contents($url);
      file_put_contents('results.txt',"\n\n".$html."\n\n",FILE_APPEND);
      file_put_contents('html.html',"\n\n".$html."\n\n",FILE_APPEND);
      
      $dom = new DOMDocument();
      $dom->loadHTMLFile("html.html");
      $x = new DOMXPath($dom);
      
      $z = '[{"div":{"div":{';
      $array[] = $z;
      
      foreach($x->query("//div/div[1]/p") as $node) {
         $a = '"p": "' .$node->nodeValue.'",';
         $a = str_replace("\n","",$a);
      
         if(in_array($a, $array)){
            continue;
         }else{
            $array[] = $a;
         }
      }
      
      $array[count($array)-1] = str_replace(",","",$array[count($array)-1]);
      
      $y = '}}}]';
      $array[] = $y;
      
      foreach($array as &$item){
         file_put_contents('results.json',$item,FILE_APPEND);
      }
   }
}

crawler("https://www.mg.gov.br/servico/agendar-visitas-guiadas-na-biblioteca-publica-estadual-de-minas-gerais");