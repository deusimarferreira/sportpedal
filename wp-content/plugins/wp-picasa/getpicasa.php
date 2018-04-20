<?php 

	header('Content-type: application/json\r\nConnection: Keep-Alive\r\nKeep-Alive: timeout=300');

	require_once('./common.php');
	
	$albumsonpage = 6;	

	$picasa = array(
	'userid' => $_GET['userid'],
	'albumid' => !isset($_GET['albumid']) ? NULL : $_GET['albumid'],
	'path' => $_GET['path'],
	'albumlist' => !isset($_GET['albumlist']) ? ( $albumid == NULL ? true : false ) : ( $_GET['albumlist'] == 'true' ? true : ( $albumid == NULL ? true : false )),
	'albumpage' => (!isset($_GET['albumpage']) ? 0 : (($_GET['albumpage'] > 0) ? ( $_GET['albumpage']- 1 ) : 0)),
	'albums' => array(),
	'albumcontents' => array(),
	'result' => '');

	// Lingual variables
	$texts = array(
	'Albums' => !isset($_GET['AlbumsTxt']) ? 'Albums' : $_GET['AlbumsTxt'],
	'Image' => !isset($_GET['ImageTxt']) ? 'Image' : $_GET['ImageTxt'],
	'Images' => !isset($_GET['ImagesTxt']) ? 'Images' : $_GET['ImagesTxt'],
	'Loading' => !isset($_GET['LoadingTxt']) ? 'Loading' : $_GET['LoadingTxt'],
	);

	// Kept parameters to be used when forwarding queries..
	$forward_parms = '?userid=' . urlencode($picasa['userid']) . 
						'&path=' . urlencode($picasa['path']) . 
						'&albumlist=' . urlencode($picasa['albumlist'] ? 'true' : 'false' ) .
						'&AlbumsTxt=' . urlencode($texts['Albums']) .
						'&ImageTxt=' . urlencode($texts['Image']) .
						'&ImagesTxt=' . urlencode($texts['Images']) .
						'&LoadingTxt=' . urlencode($texts['Loading']);
	
	function pageLink($num = 1, $active = false, $title = null, $params = null)
	{
		global $picasa, $forward_parms;
	
		$res = '
				<a' . ( $params != null ? ( ' ' . $params ) : '' ) . ( !$active ? ( ' onClick="javascript: updateWPG(\'' . $picasa['path'] .  '\', \'' . $forward_parms . '&albumpage=' . $num . '\', null, null, \'' . $texts['Albums'] . '\', \'' . $texts['Images'] . '\', \'' . $texts['Image'] . '\', \'' . $texts['Loading'] . '\');"' ) : ' class="current"') . '>' . ( $title != null ? $title : $num ) . '</a>';
		return $res;
	}

	function getAlbums()
	{	
		global $picasa, $texts, $forward_parms, $albumsonpage;

		$albumlist = xml_loader('http://picasaweb.google.com/data/feed/api/user/' . $picasa['userid'] . '?kind=album&access=public', './cache/albumlist');
		
		foreach($albumlist->entry as $alb )
			{
				$gphoto = $alb->children('http://schemas.google.com/photos/2007');

				$photolist = xml_loader('http://picasaweb.google.com/data/feed/api/user/' . $picasa['userid'] . '/albumid/' . $gphoto->id . '?imgmax=640&access=public&thumbsize=144c', './cache/album-' . $picasa['userid'] . '.' . $gphoto->id);
			
				$firstphoto = &$photolist->entry;
			
				$media = $firstphoto->children('http://search.yahoo.com/mrss/');
				$gphoto2 = $firstphoto->children('http://schemas.google.com/photos/2007');

				if ( count($photolist->entry) > 0 ) // Disable displaying of empty albums
				$picasa['albums'][] = array(
					'id' => $gphoto->id,
					'title' => $alb->title, 
					'author' => $alb->author->name,
					'photo' => array(
						'title' => $firstphoto->title,
						'description' => $media->group->description,
						'thumbnail' => $media->group->thumbnail->attributes()->{'url'},
						'thumbnail_width' => $media->group->thumbnail->attributes()->{'width'},
						'thumbnail_height' => $media->group->thumbnail->attributes()->{'height'},
						'id' => $gphoto2->id,
						),
					'photocount' => count($photolist->entry),
					);
			}

		if ( $picasa['albumpage'] > ceil(count($picasa['albums']) / $albumsonpage))
			$picasa['albumpage'] = ceil(count($picasa['albums']) / $albumsonpage);

		$alternating = 0;
		$curalbum = 0;

		foreach ($picasa['albums'] as $key=>$album)
			if (( $key+1 > ( $picasa['albumpage'] * $albumsonpage )) & ( $curalbum < $albumsonpage ))
				{
					$curalbum++;
					$picasa['result'] .= '
				<div class="WPGalbumButton" onClick="javascript: updateWPG(\'' . $picasa['path'] .  '\', \'' . $forward_parms . '&albumid=' . urlencode($album['id']) . '\', ' . urlencode($album['photocount']) . ', ' . ( $picasa['albumlist'] ? 
				( '\'' . $forward_parms . '&albumpage=' . ( $picasa['albumpage'] + 1 ). '\', ' ) : 'null, ' ) . 
				'\'' . $texts['Albums'] . '\', \'' . $texts['Images'] . '\', \'' . $texts['Image'] . '\', \'' . $texts['Loading'] . '\');">
					<div class="preview" style="background-image: url(\'' . $album['photo']['thumbnail'] . '\');">
						<div class="mask">
						</div>
					</div>
					<h3 title="' . htmlentities($album['title'], ENT_QUOTES, 'UTF-8') . '">' . htmlentities($album['title'], ENT_QUOTES, 'UTF-8') . '</h3>
					<p class="info">' . $album['photocount'] . ' ' . ( $album['photocount'] == 1 ? $texts['Image'] : $texts['Images'] ) . '</p>
				</div>' . ( $alternating == 2 ? '
				<br style="clear: both;" />' : '' );

					$alternating = $alternating == 2 ? 0 : ( $alternating + 1 );
			
				}
					
		if ( $alternating != 0 )
			$picasa['result'] .= '
				<br style="clear: both;" />';			

		// Display paginator					
		if ( count($picasa['albums']) > $albumsonpage )
			{
				$picasa['result'] .= '
				<div class="WPGpaginator">
					' . ( $picasa['albumpage'] > 0 ? pageLink(1) : '' ) .
					( $picasa['albumpage'] > 1 ? pageLink($picasa['albumpage']) : '' ) .
					pageLink($picasa['albumpage'] + 1, true ) .
					( (ceil(count($picasa['albums']) / $albumsonpage ) >= ($picasa['albumpage'] + 2)) ? pageLink($picasa['albumpage'] + 2) : '' ) .
					( (ceil(count($picasa['albums']) / $albumsonpage ) >= ($picasa['albumpage'] + 3)) ? pageLink(ceil(count($picasa['albums']) / $albumsonpage)) : '' ) . '
				</div>';
				
				$picasa['result'] .= '
			</div>';
			}
	}

	function getAlbum()
	{
		global $picasa, $texts;

		$photolist = xml_loader('http://picasaweb.google.com/data/feed/api/user/' . $picasa['userid'] . '/albumid/' . $picasa['albumid'] . '?imgmax=640&access=public&thumbsize=72u', './cache/album-' . $picasa['userid'] . '.' . $picasa['albumid']);
			
		foreach ( $photolist->entry as $entry ) {
			$media = $entry->children('http://search.yahoo.com/mrss/');
			$gphoto = $entry->children('http://schemas.google.com/photos/2007');
			$album['photos'][] = array(
				'title' => ( $entry->summary != '' ? $entry->summary : $entry->title) ,
				'description' => $media->group->description,
				'url' => $media->group->content->attributes()->{'url'},
				'width' => $media->group->content->attributes()->{'width'},
				'height' => $media->group->content->attributes()->{'height'},
				'type' => 'file',
				'size' => $gphoto->size,
				'sizetext' => ( !$gphoto->size ? '-' : ( 
						$gphoto->size > 1024*1024 ? (( ceil($gphoto->size/(1024*1024)*100)/100) . ' Mb' ) : (
							$gphoto->size > 1024 ? (( ceil($gphoto->size/1024*100)/100) . ' K' ) : ( $ghoto->size . ' bytes' )))),
				'author' => &$album['author'],
				'keywords' => $media->group->keywords,
				'copyright' => $media->group->credit,
				'thumbnail' => $media->group->thumbnail->attributes()->{'url'},
				'thumbnail_width' => $media->group->thumbnail->attributes()->{'width'},
				'thumbnail_height' => $media->group->thumbnail->attributes()->{'height'},
				'id' => $gphoto->id);
			}

			foreach ($album['photos'] as $photo)
				$picasa['result'] .= '
					<div class="imageElement">
						<h3>' . htmlentities($photo['title'], ENT_QUOTES, 'UTF-8') . '</h3>
						<p>' . htmlentities($photo['description'], ENT_QUOTES, 'UTF-8') . '</p>
						<img src="' . $photo['url'] . '" class="full" alt="' . $photo['title'] . '" />
						<img src="' . $photo['thumbnail'] . '" class="thumbnail" alt="' . $photo['title'] . '" />
					</div>';

			// Jon Design's smooth gallery does not work properly with single image. Therefore, album to display - we need to duplicate it and hide everything
			// from user that would tell that there are more than one images in the gallery.
			if (count($album['photos']) < 1 )
				{
					foreach ($album['photos'] as $photo)
						$picasa['result'] .= '
					<div class="imageElement">
						<h3>' . htmlentities($photo['title'], ENT_QUOTES, 'UTF-8') . '</h3>
						<p>' . htmlentities($photo['description'], ENT_QUOTES, 'UTF-8') . '</p>
						<img src="' . $photo['url'] . '" class="full" alt="' . $photo['title'] . '" />
						<img src="' . $photo['thumbnail'] . '" class="thumbnail" alt="' . $photo['title'] . '" />
					</div>';
				}
					$picasa['result'] .= '
				</div>';
		
	}

	if ( $picasa['albumid'] == NULL )
		getAlbums();
	else
		getAlbum();

	echo json_encode($picasa['result']);
?>