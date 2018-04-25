/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-10-31
 * Time: 오후 5:38
 */

//ecmascript 6
// class AjaxSender{
//     constructor(url, asyncOption, dataType, map){
//         this.url=url;
//         this.asyncOption = asyncOption;
//         this.dataType = dataType;
//         this.map = map.map;
//         console.log(map);
//     }
//     send(callback){
//         $.ajax({
//             url: this.url,
//             async: this.asyncOption,
//             cache: false,
//             dataType: this.dataType,
//             data: this.map,
//             success: function (data){
//                 console.log(data);
//                 callback(data);
//             }
//         });
//     }
// }

// ecmascript 5
var AjaxSender = function(url, asyncOption, dataType, map){
    this.url = url;
    this.asyncOption = asyncOption;
    this.dataType = dataType;
    this.map = map.map;
    console.log(map);
};

AjaxSender.prototype = {
    send : function(callback){
        $.ajax({
            url: this.url,
            async: this.asyncOption,
            cache: false,
            dataType: this.dataType,
            data: this.map,
            success: function (data){
                console.log(data);
                callback(data);
            }
        });
    }
};


