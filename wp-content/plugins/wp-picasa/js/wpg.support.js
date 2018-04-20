function updateWPG(urli, params, imgAmount, albLinkParms, txtAlbums, txtImages, txtImage, txtLoading)
{
				var gCont = document.getElementById('myGallerySet');
				var gContFx = new Fx.Tween(gCont, {
					duration: '500',
					property: 'opacity'
				});
				
				gContFx.start(1,0).chain(
					function(){
						gCont.set('html', '<div class="loadingElement"></div>');
						this.start(0,1);
					});

				var jsonReq = new Request.JSON({
					url: urli + params,					
					method: 'post',
					data: {
						json: 'yes'
					},
					onSuccess: function(response) {
						gContFx.start(1,0).chain(
							function(){
								this.start(1,0);
							},
							function(){ 
								gCont.set('html', response);
								switch (imgAmount) {
									case null:
											/* album list - Do not start gallery */
											break;
									case 0:
											/* album list - Do not start gallery */
											break;
									case 1:	
											document.myGallerySet = new gallery($('myGallerySet'), {
												timed: false,
												textGallerySelector: txtAlbums,
												textShowGallerySelector: txtAlbums,
												textGalleryInfo: '{0} ' + txtImages,
												textShowCarousel: txtImage + ' {0}/{1}',
												textPreloadingCarousel: txtLoading + '...',
												carouselMinimizedOpacity: 0.5,
												carouselMaximizedOpacity: 0.95,
												slideInfoZoneOpacity: 0.85,
												thumbIdleOpacity: 0.45,
												embedLinks: false,
												showCarousel: false,
												showArrows: false,
												embedLinks: false
											});
											if ( ( albLinkParms != null ) && ( txtAlbums != null) ) {
												document.myGallerySet.gallerySelectorBtn = new Element('a').addClass('gallerySelectorBtn').setProperties({
														title: txtAlbums
													}).set('html', txtAlbums).addEvent(
														'click',
															function(){
																updateWPG(urli, albLinkParms, null, null, txtAlbums, txtImages, txtImage, txtLoading);
															}.bind(document.myGallerySet)
													).injectInside(document.myGallerySet.galleryElement);
												document.myGallerySet.addEvent('onShowCarousel', function(){document.myGallerySet.gallerySelectorBtn.setStyle('zIndex', 10)}.bind(document.myGallerySet));
												document.myGallerySet.addEvent('onCarouselHidden', function(){document.myGallerySet.gallerySelectorBtn.setStyle('zIndex', 15)}.bind(document.myGallerySet));

											}
											break;
									default:
											document.myGallerySet = new gallery($('myGallerySet'), {
												timed: false,
												textGallerySelector: txtAlbums,
												textShowGallerySelector: txtAlbums,
												textGalleryInfo: '{0} ' + txtImages,
												textShowCarousel: txtImage + ' {0}/{1}',
												textPreloadingCarousel: txtLoading + '...',
												carouselMinimizedOpacity: 0.5,
												carouselMaximizedOpacity: 0.95,
												slideInfoZoneOpacity: 0.85,
												thumbIdleOpacity: 0.45,
												embedLinks: false
											});
											if ( ( albLinkParms != null ) && ( txtAlbums != null) ) {
												document.myGallerySet.gallerySelectorBtn = new Element('a').addClass('gallerySelectorBtn').setProperties({
														title: txtAlbums
													}).set('html', txtAlbums).addEvent(
														'click',
															function(){ 
																updateWPG(urli, albLinkParms, null, null, txtAlbums, txtImages, txtImage, txtLoading);
															}.bind(document.myGallerySet)
													).injectInside(document.myGallerySet.galleryElement);
												document.myGallerySet.addEvent('onShowCarousel', function(){document.myGallerySet.gallerySelectorBtn.setStyle('zIndex', 10)}.bind(document.myGallerySet));
												document.myGallerySet.addEvent('onCarouselHidden', function(){document.myGallerySet.gallerySelectorBtn.setStyle('zIndex', 15)}.bind(document.myGallerySet));
												
											}
											break;
									}
								this.start(0,0);
							},
							function (){
								this.start(0,1);
							});
				}}).get();

}
