<?php
/**
* 	get_info - Récupère des infos / HACK SITE PNE - Normalement RSS ??!!
*	Cette fonction est uniquement utilisée pour le PNE
*	
* 	@access  protected
* 	@return  
* 	@param
*/
protected function get_info()
{
	
	$cacheid = 'actualites';
	//if (isset($this->params['key']) && $this->params['key']!='')
	//{
	$this->smarty->setCacheLifetime(300000);
	
	if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && !$this->smarty->isCached('page_modal.tpl.html',$cacheid)) ||  !$this->smarty->isCached('page.tpl.html',$cacheid)) 
	{ 
	  $sep = config::get('system_separateur');
	  $tpl = 'templates'.$sep.'pages'.$sep.traduction::get_langue().$sep.'info.tpl.html';
	  //echo $tpl;
	  $test = file_get_contents('http://www.ecrins-parcnational.fr/component/search/?searchword=bouquetin&ordering=newest&searchphrase=all&limit=0&areas[0]=content');
	  preg_match_all('$<fieldset>(.+)</fieldset>$isU',  $test, $matches);
	  $content = '';
	  //echo '<pre>'.print_r($matches,true).'</pre>';
	  
	  //on récupère les liens des actu

	  foreach($matches[1] as $article)
	  {
		$html_dom = html_dom::str_get_html($article);
		
		
		$lien = $html_dom->find('a',0)->href;
		$titre = $html_dom->find('a',0)->plaintext;
		$categorie = $html_dom->find('span',1)->plaintext;
		
		//echo '<br />'.$titre;
		
		if (strstr($categorie,'Actualités'))
		{
		
			//echo "<br />On récupère le fichier : ".'http://www.ecrins-parcnational.fr'.$lien;
			
			$articlefull = html_dom::file_get_html('http://www.ecrins-parcnational.fr'.$lien);
			if(is_object($articlefull)){$chapeau = $articlefull->find('h4',0)->innertext;} else{continue;}
			
			if (strstr($titre,'bouquetin') || strstr($titre,'Bouquetin') || strstr($chapeau,'bouquetin') || strstr($chapeau,'Bouquetin'))
			{
				
				//echo '<br />Sélectionné :'.$titre;
				//On va récupérer le chapeau de la news 
				$image = $articlefull->find('h4',0)->find('img',0)->outertext;
				$image = str_replace('src="','src="http://www.ecrins-parcnational.fr',$image);
				$image = str_replace('class="vignette"','class="img-rounded pull-left" style="margin-right:10px"',$image);
				$textechapeau = $articlefull->find('h4',0)->plaintext;
				$content.= '<article class="clearfix"><h4><a href="http://www.ecrins-parcnational.fr'.$lien.'" target="_blank">'.$titre.'</a></h4><p">'.$image.$textechapeau.'</p></article>';
			}
		}
	  
	  }
		//$content.= '<article>'.str_replace('href="','target="_blank" href="http://www.ecrins-parcnational.fr',$article).'</article>';
	  
	 
	  $this->smarty->assign('template',$tpl);
	  
	  $this->smarty->assign('template',$tpl);
	  $this->smarty->assign("content",$content);
	}
	  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			 $this->smarty->display('page_modal.tpl.html',$cacheid);
			//echo $this->smarty->fetch('page_modal.tpl.html');
		}
		else
		{
			$this->smarty->assign("titre_application",config::get('titre_application'));
			 $this->smarty->display('page.tpl.html',$cacheid);
			//echo $this->smarty->fetch('page.tpl.html');
		}
	  //echo $this->smarty->fetch('info.tpl.html');
	/*}
	else
	{
		
	}*/
}
?>