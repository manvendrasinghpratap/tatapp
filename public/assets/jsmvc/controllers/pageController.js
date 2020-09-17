veloapp.controller('pageController', function($scope, $http, $window, $timeout) {

	$scope.regionCodes = {
		'ZH': 'Zürich',
		'BE': 'Bern',
		'LU': 'Luzern',
		'UR': 'Uri',
		'SZ': 'Schwyz',
		'OW': 'Obwalden',
		'NW': 'Nidwalden',
		'GL': 'Glarus',
		'ZG': 'Zug',
		'FR': 'Fribourg',
		'SO': 'Solothurn',
		'BS': 'Basel-Stadt',
		'BL': 'Basel-Landschaft',
		'SH': '	Schaffhausen',
		'AR': 'Appenzell Ausserrhoden',
		'AI': 'Appenzell Innerrhoden',
		'SG': 'St. Gallen',
		'GR': 'Graubünden',
		'AG': 'Aargau',
		'TG': 'Thurgau',
		'TI': 'Ticino',
		'VD': 'Vaud',
		'VS': 'Valais',
		'NE': 'Neuchâtel',
		'GE': 'Geneva',
		'JU': 'Jura',
		'CH': 'Switzerland',
	}

	$scope.myDatetimeRange = {
	    date: {
	        from: new Date(), // start date ( Date object )
	        to: new Date() // end date ( Date object )
	    },
	    time: {
	        from: 480, // default start time (in minutes)
	        to: 1020, // default end time (in minutes)
	        step: 15, // step width
	        minRange: 15, // min range
	        hours24: false // true = 00:00:00 | false = 00:00 am/pm
	    }
	};

	$scope.data = {
      guardians: [
        {
          name: 'Peter Quill',
          dob: null
        },
        {
          name: 'Groot',
          dob: null
        }
      ]
    };
  $scope.init = function() {
  }
});