

var sbs =   angular.module('sbsApp',['ngRoute']);

sbs.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider){
    $routeProvider.
        when("/", {templateUrl: "views/submit.html"}).
        when("/about", {templateUrl: "views/about.html"}).
        when("/submit", {templateUrl: "views/submit.html"}).
        otherwise({redirectTo:"/"});
}]).
run(function($rootScope, $location) {
    $rootScope.$on( "$routeChangeStart", function(event, next, current) {
        document.getElementById('bt-menu').classList.remove('bt-menu-open');
    });
});

sbs.controller('sbs', function ($scope, $timeout) {
    $scope.playlist =   [
        {name: 'timla', info:'timla was here', addr:'http://file.mp3'},
        {name: 'shimla', info:'shimla is there', addr:'http://file.mp3'},
        {name: 'vimla', info:'vimla is where', addr:'http://file.mp3'},
        {name: 'kamla', info:'kamla is somewhere', addr:'http://file.mp3'}
    ];

    $scope.formation   = function () {

        var sub =   document.getElementById('submiter').getElementsByTagName('i');
        sub[0].style.display = 'inline';

        $.ajax({
            type: 'post',
            url: 'http://dev.chd.miraclestudios.us/hss-php/wp-admin/admin-ajax.php?action=submit',
            data: $('#form').serialize()
        }).success(function( data ) {
            if ( console && console.log ) {
                console.log( "Sample of data:", data.slice( 0, 100 ) );
            }
        }).done(function (donw) {
            console.log('done' + donw);
        }).error(function () {
            console.log('There is some error. Please contact app admin');

            var dan =   document.getElementById('dan');
            dan.innerText    =   'There is some error.\nPlease contact app admin';
            dan.style.display = 'block';

            setTimeout(function(){dan.style.display = 'none'; }, 8000);

        }).always(function () {
            sub[0].style.display = 'none';
        });
    }

    $scope.pop  = function ($index) {
        var popUp   =   $scope.playlist[$index].info;
        alert(popUp);
    }

    $scope.defpop  = function () {
        var popdesc =   "Regular transmission timings:\n\n";
        popdesc +=   "1. Early Morning Transmission start time: 4:00 a.m. IST\n\n";

        popdesc +=   "Asa di Vaar LIVE from Sri Bhaini Sahib\n\n";

        popdesc +=   "Morning Transmission over at 6:15a.m. IST\n\n";

        popdesc +=   "2. Afternoon transmission LIVE start time: 1:00p.m. IST\n\n";

        popdesc +=   "Updesh Sri Satguru Ji 2:00p.m.to 3:00p.m. IST\n\n";

        popdesc +=   "Kirtan 3:00p.m. to 3:45p.m. IST\n\n";

        popdesc +=   "3. Katha.7:30p.m. to 8:30 p.m. IST\n\n";
        alert(popdesc);
    }

    $scope.playlive =   function(path){
//        $scope.playtitle    =   'SBS Live';
        changeMedia(path);
    }

    $scope.playThis =   function(id){
//        $scope.playing =   $scope.channels[id];
        $scope.playtitle    =   $scope.playing.name;
        changeMedia($scope.playing.path);
    }

    function changeMedia(data){
        console.log(data);
        $('#jquery_jplayer_1').jPlayer('setMedia', {mp3:data});
        $('#jquery_jplayer_1').jPlayer('play');
    }

    $("#jquery_jplayer_1").jPlayer({
        ready: function (event) {
            $(this).jPlayer("setMedia", {
                title: "Bubble",
                mp3: "http://ipip.in:8000/vaar"
            });
        },
        volume: 1,
        supplied: "mp3",
        wmode: "window",
        smoothPlayBar: true,
        keyEnabled: true,
        remainingDuration: true,
        toggleDuration: true
    });

});

