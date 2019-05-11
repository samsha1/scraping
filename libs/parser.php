<?php
namespace Scrape\Libs;

class Parser 
{
	
	public static function parse($o){
			$result = [];
			$linkInfo = $o->find( 'h3 > a' );
			$result[ 'name' ]     = $linkInfo->text();
			$result[ 'address1' ] = $o->find( '.listingItem-details > .pageMeta > .pageMeta-col > .address' )->text();
			$result[ 'phone' ]    = preg_replace("/[A-Za-z\-:\']/","", $o->find( '.listingItem-details >.pageMeta > .pageMeta-col > .pageMeta-item:eq(1)' )->text());
			$result[ 'email' ]    = $o->find( '.listingItem-details >.pageMeta > .pageMeta-col > .pageMeta-item > .faaemail' )->text();
			$result[ 'website' ]  = $o->find( '.listingItem-details >.pageMeta > .pageMeta-col > .pageMeta-item > .exLink' )->text();
			$result[ 'about' ]    = $o->find( '.listingItem-extra > .pageMeta-item > p' )->text();
			foreach ($o->find('.listingItem-thumbnail img') as $image) {
				$result[ 'imageUrl' ]     = urldecode(pq($image)->attr('src'));
			}

			return $result;

		}

	public static function serviceParser($o){
		return $o->find('.articleHeader > .articleHeaderTertiary span.metaBlock-data')->text();
	}
}

?>