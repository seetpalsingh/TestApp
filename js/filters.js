/**
 * Created by demo on 28-Sep-14.
 */

angular.module('sbsApp').
filter('truncate', function () {
    return function (text, length, end) {

        if (end === undefined)
            end = "...";


        if(text.length >= length){
            return String(text).substring(0, length-end.length) + end;
        }
        else{
            return text;
        }


    };
});