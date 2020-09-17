var veloapp = angular.module('veloApp', ['slickCarousel', 'ui.select2', 'vr.directives.slider', 'rgkevin.datetimeRangePicker', 'ui.bootstrap.datetimepicker'], function($interpolateProvider, $injector) {
		$interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
	}).config(['slickCarouselConfig', function (slickCarouselConfig) {
    slickCarouselConfig.dots = true;
    slickCarouselConfig.autoplay = false;
  }]);