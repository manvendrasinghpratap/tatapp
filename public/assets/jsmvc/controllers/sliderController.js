veloapp.controller('sliderController', function($scope, $http, $window, $timeout) {

  $scope.appWindow = angular.element($window);

  /* Initialize Slider */
	$scope.sliderImages = [
		'slider-01.jpg',
		'slider-02.jpg',
		'slider-03.jpg',
		'slider-04.jpg',
		'slider-05.jpg',
		'slider-06.jpg',
    'slider-01.jpg',
    'slider-02.jpg',
	];

	$scope.slickConfigLoaded = false;
	$scope.slickCurrentIndex = 0;

  $scope.slidesToShow = 6;
 
	$scope.slickConfig = {
    dots: false,
    autoplay: false,
    slidesToShow: 6,
    infinite: true,
    method: {},
    event: {
      beforeChange: function (event, slick, currentSlide, nextSlide) {
      },
      afterChange: function (event, slick, currentSlide, nextSlide) {
      },
      breakpoint: function (event, slick, breakpoint) {
      },
      destroy: function (event, slick) {
      },
      edge: function (event, slick, direction) {
      },
      reInit: function (event, slick) {
      },
      init: function (event, slick) {
      },
      setPosition: function (evnet, slick) {
      },
      swipe: function (event, slick, direction) {
      }
    }
  };

  $scope.init = function() {
    if($scope.appWindow.width() < 1116) {
      $scope.slidesToShow = parseInt(($scope.appWindow.width() - 60) / 160);
    }

    $scope.slickConfig.slidesToShow = $scope.slidesToShow;
    $scope.slickConfigLoaded = true;
  }

  $scope.appWindow.bind('resize', function() {
    $scope.slidesToShow = 6;
    if($scope.appWindow.width() < 1116) {
      $scope.slidesToShow = parseInt(($scope.appWindow.width() - 60) / 160);
    }
    $scope.slickConfig.slidesToShow = $scope.slidesToShow;
  });

});